<?php

/**
 * MembersController
 * This controller governs all of the explicit member functionality.
 */
class MembersController extends Controller
{
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
				// allow guests to register (includes captcha),
				// and request password change
				'actions'=>array('register', 'captcha', 'forgotpassword'),
				'expression'=>'$user->isGuest'
			),
			// by default, deny any non-member (i.e. would be a guest)
			array(
				'deny',
				'expression' => '!$user->hasRoles(array("member"))'
			)
		);
	}

	/**
	 * External action classes.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the register page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	public function actionIndex()
	{
		// redirect to the edit details action
		$this->actionEdit();
	}

	/** 
	 * Edit current user's details.
	 */
	public function actionEdit()
	{
		// defines the layout view used
		$this->layout = '//layouts/column2';

		$edit = new MembershipEditForm();
		// get current membership name
		$membership = Membership::model()->find("LOWER(membershipId)=LOWER(?)",array(Yii::app()->user->name));

		// used in the confirmation message
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);

		// if the form has been submitted
		if(isset($_POST['MembershipEditForm']))
		{
			$edit->attributes = $_POST['MembershipEditForm'];
			if ($edit->validate())
			{
				$result['complete'] = true; // successfully validated, but errors may still occur.
				// copy form details into the actual membership
				$membership->attributes = $edit->attributes;
				// commit the changes
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
		else //prefill data
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
		
		// if the user submitted the form and deleted all the members, no MemberEdit POST variable will be set, so manually add it.
		if (isset($_POST['submit']) && !isset($_POST['MemberEdit']))
			$_POST['MemberEdit'] = array();
		
		// process the user input
		if (isset($_POST['MemberEdit']))
		{
			$result['complete'] = true;
			$result['success'] = true;
			
			// build the members array.
			foreach($_POST['MemberEdit'] as $i=>$data)
			{
				$members[$i] = new MemberEdit();
				$members[$i]->attributes = $_POST['MemberEdit'][$i];
				$result['success'] = $members[$i]->validate() && $result['success'];
			}

			if ($result['success'] === true) // all members are valid, can save.
			{
                // delete all existing members
				Member::model()->deleteAll('LOWER(membershipId)=LOWER(?)', array($membership->membershipId));
				foreach($members as $member)
				{
                    // insert each member one-by-one
					$record = new Member();
					$record->attributes = array (
						'membershipId' => $membership->membershipId,
						'firstName' => $member->memberName,
						'dateOfBirth' => implode('-', array_reverse(explode('/', $member->birthDate))),
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

		//render the changepassword view
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

		// if form was submitted
		if(isset($_POST['RegistrationForm']))
		{
			$register->attributes = $_POST['RegistrationForm'];
			if ($register->validate())
			{
				$result['complete'] = true; // successfully validated, but errors may still occur.
			
				$membership = new Membership();
				$user = new User();
				$role = new UserToRoles();
				
				//copy form details into the new membership, and initialise values
				$membership->attributes = array_merge(array(
					'membershipId' => Membership::generateUUID(),
					'expiryDate' => '1920-01-01', // not yet registered. 
					'payMethod' => 'none',
					'status' => 'pending',
					'type' => 'N',
				), $register->attributes);

				//copy user details
				$user->attributes = array (
					'username' => $membership->membershipId,
					'password' => User::hashPassword($register->password)
				);

				//commit the new membership & user
				if ($membership->save() && $user->save())
				{
					// add 'member' to user roles
					$memberRole = UserRole::model()->find('LOWER(role)=?', array('member'));
					if ($memberRole !== NULL && !$user->isNewRecord)
					{
						$role->attributes = array (
							'userId' => $user->userId,
							'roleId' => $memberRole->roleId
						);
						$role->save();
					}
					
					$email = $this->renderPartial('//shared/registertemplate', array(
						'username' => $membership->membershipId,
					), true);
					
					// send the email to the newly registered member.
					// TEMPORARY EMAIL DISABLED
					//Yii::app()->email->send(
						//$membership->emailAddress,
						//'Registration at the Swedish Club of WA',
						//$email,
						//'noreply@svenskaklubben.org.au'
					//);

					$result['message'] = "You have successfully registered with the Swedish Club of WA.<br/>
										  Your unique username is: <strong>{$membership->membershipId}</strong><br/>
										  An email has been sent to the email address you provided with your login details. Please keep a copy of your username as you will need it to login. You may now login to the site using the above username and the password you chose.";
										  
										  
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
	
	/*
	 * Action to handle users resetting their passwords.
	 */
	public function actionForgotPassword()
	{
		$result = array(
			'complete' => false,
			'success' => false,
			'message' => '',
			'heading' => ''
		);
		
		// check if the search has been submitted.
		if (isset($_GET['q']))
		{
			$result['complete'] = true;
			
			$query = strtolower($_GET['q']);
			$member = Membership::model()->find('LOWER(membershipId)=? OR LOWER(emailAddress)=?', array($query,$query));
			
			if ($member && ($user = User::model()->find('LOWER(username) = LOWER(?)', array($member->membershipId)))) // successfully looked up the membership
			{
				$password = substr(hash('sha256', microtime()), 0, rand(5, 7)); // simple password generation. Take 5-7 characters from a SHA256 hash of the current microtime.
				$email = $this->renderPartial('//shared/forgotpasswordtemplate', array(
					'password' => $password,
					'membershipId' => $member->membershipId
				), true);
				
				// attempt to send the email to the primary email address, then to the secondary email address if that one fails.
				if (Yii::app()->email->send(
					$member->emailAddress,
					'Password Reset',
					$email,
					'noreply@svenskaklubben.org.au'
				) || Yii::app()->email->send(
					$member->alternateEmail,
					'Password Reset',
					$email,
					'noreply@svenskaklubben.org.au'
				))	
				{
					// update the user password to the one sent in the email.
					$user->password = User::hashPassword($password);
					$user->save();
					$result['success'] = true;
					$result['heading'] = 'Password reset';
					$result['message'] = 'Your password has been successfully reset, please check your email inbox to find your new password.';
				}
				else
				{
					$result['heading'] = 'Unexpected error';
					$result['message'] = 'There was an unexpected error when sending out your new password, please try again.';
				}
			}
			else
			{
				$result['heading'] = 'No results';
				$result['message'] = 'Unfortunately, there don\'t appear to be any memberships in the database that match your search query. Please double-check the value you entered and try again.';
			}
		}
		$this->render('forgotpassword', array(
			'result' => $result
		));
	}
}
