<?php

class MembersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array(
				'allow',
				'actions'=>array('register'),
				'expression'=>'$user->isGuest'
			),
			array(
				'deny',
				'expression' => '!$user->hasRoles(array("member"))'
			)
		);
	}

	public function actionIndex()
	{
		$this->actionEdit();
	}

	/** 
	 * Edit current user's details.
	 */
	public function actionEdit()
	{
		$edit = new MembershipEditForm();
		$membership = Membership::model()->find("LOWER(membershipId)=LOWER(?)",array(Yii::app()->user->name));

		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);

		if(isset($_POST['MembershipEditForm']))
		{
			$edit->attributes = $_POST['MembershipEditForm'];
			if ($edit->validate())
			{
				$result['complete'] = true;
				$membership->attributes = $edit->attributes;
				
				if ($membership->save())
				{
					$result['success'] = true;
					$result['heading'] = 'Success!';
					$result['message'] = "Your details have successfully been updated.";
				}
				else
				{
					$msg = print_r($membership->errors, true);
					Yii::app()->error->report($msg, __FILE__);
					
					$result['message'] = 'An unforseen error occurred with the application. Please try again. If the problem persists, please contact support at <a href="mailto:support@svenskaklubben.org.au">support@svenskaklubben.org.au</a>';
					$result['heading'] = "Unsuccessful!";
				}
			}
		} 
		else //preload data
		{ 
			$edit->attributes = $membership->attributes;
		}

		$this->render('edit', array(
			'model'=>$edit,
			'result' => $result,
		));
	}
	
	/** 
	 * Edit the current membership's members
	 */
	public function actionEditmembers()
	{
		$membership = Membership::model()->find('LOWER(membershipId)=LOWER(?)', array(Yii::app()->user->name));
		$members = array();
		
		$result = array (
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);
		
		// Assimilate all the AJAX-entered fields into the main model array.
		if (isset($_POST['members']))
		{
			if (!isset($_POST['MemberEdit']))
				$_POST['MemberEdit'] = array();
			
			$_POST['MemberEdit'] = array_merge($_POST['MemberEdit'], $_POST['members']);
		}
		
		// process the user input
		if (isset($_POST['MemberEdit']))
		{
			$result['complete'] = true;
			$result['success'] = true;
			
			foreach($_POST['MemberEdit'] as $i=>$data)
			{
				$members[$i] = new MemberEdit();
				$members[$i]->attributes = $_POST['MemberEdit'][$i];
				$result['success'] = $members[$i]->validate() && $result['success'];
			}

			if ($result['success'] === true) // all members are valid, can save.
			{
				Member::model()->deleteAll('LOWER(membershipId)=LOWER(?)', array($membership->membershipId));
				foreach($members as $member)
				{
					$record = new Member();
					$record->attributes = array (
						'membershipId' => $membership->membershipId,
						'firstName' => $member->memberName,
						'dateOfBirth' => $member->birthDate,
						'type' => $member->memberType,
					);
					$record->save();
				}
				
				$result['heading'] = 'Success!';
				$result['message'] = 'Members have been updated successfully.';
			}
			else
			{
				$result['heading'] = 'Errors in form';
				$result['message'] = 'There were errors found with some of the submitted members. Please rectify the errors below and try again';
			}
		}
		else // No post yet, preload database values
		{
			// Get the existing members from the database:
			$existing = Member::model()->findAll('LOWER(membershipId)=LOWER(?)', array($membership->membershipId));

			foreach($existing as $i=>$record)
			{
				$members[$i] = new MemberEdit();
				$members[$i]->attributes = array (
					'memberName' => $record->firstName,
					'birthDate' => date('d/m/Y', strtotime($record->dateOfBirth)),
					'memberType' => $record->type
				);
		}
		}
		
		$this->render('editmembers', array(
			'members' => $members,
			'result' => $result
		));
	}

	/**
	 * Change current user's password.
	 */
	public function actionChangePassword()
	{
		$form = new MemberChangePasswordForm();
		$user = User::model()->find("LOWER(username)=LOWER(?)",array(Yii::app()->user->name));
		
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);

		if(isset($_POST['MemberChangePasswordForm']))
		{
			$form->attributes = $_POST['MemberChangePasswordForm'];
			if ($form->validate())
			{
				$result['complete'] = true;
				$user->password = User::hashPassword($form->newPassword);
				if ($user->save())
				{
					$result['success'] = true;
					$result['heading'] = 'Success!';
					$result['message'] = "Your password has successfully been updated.";
				}
				else
				{
					$msg = print_r($user->errors, true);
					Yii::app()->error->report($msg, __FILE__);
					
					$result['message'] = 'An unforseen error occurred with the application. Please try again. If the problem persists, please contact support at <a href="mailto:support@svenskaklubben.org.au">support@svenskaklubben.org.au</a>';
					$result['heading'] = "Unsuccessful!";
				}
			}
		}

		$this->render('changepassword',array(
			'model'=>$form,
			'result'=>$result,
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		$register = new RegistrationForm();
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);

		if(isset($_POST['RegistrationForm']))
		{
			$register->attributes = $_POST['RegistrationForm'];
			if ($register->validate())
			{
				$result['complete'] = true; // successfully validated, but errors may still occur.
			
				$membership = new Membership();
				$user = new User();
				$role = new UserToRoles();
				
				$membership->attributes = array_merge(array(
					'membershipId' => Membership::generateUUID(),
					'expiryDate' => '1920-01-01', // not yet registered. 
					'payMethod' => 'none',
					'status' => 'pending',
				), $register->attributes);

				$user->attributes = array (
					'username' => $membership->membershipId,
					'password' => User::hashPassword($register->password)
				);

				if ($membership->save() && $user->save())
				{
					$memberRole = UserRole::model()->find('LOWER(role)=?', array('member'));
					if ($memberRole !== NULL && !$user->isNewRecord)
					{
						$role->attributes = array (
							'userId' => $user->userId,
							'roleId' => $memberRole->roleId
						);
						$role->save();
					}
					
					$result['message'] = "You have successfully registered with the Swedish Club of WA.<br/>
										  Your unique username is: <strong>{$membership->membershipId}</strong><br/>
										  Please save this username somewhere as you will need it to login. You may now login to the site using the above username and the password you chose.";
										  
					$result['success'] = true;
					$result['heading'] = "Success!";
				}
				else
				{
					$msg = '';
					if (!empty($membership->errors))
						$msg .= print_r($membership->errors, true) . "\n";
					if (!empty($user->errors))
						$msg .= print_r($user->errors, true) . "\n";
						
					$result['message'] = 'An unforseen error occurred with the application. Please try again. If the problem persists, please contact support at <a href="mailto:support@svenskaklubben.org.au">support@svenskaklubben.org.au</a>';
					$result['heading'] = "Unsuccessful!";
					// let the developers know about the error
					Yii::app()->error->report($msg, __FILE__);
				}
			}
		}

		$this->render('register',array(
			'model'=>$register,
			'result'=>$result
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Membership::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}
