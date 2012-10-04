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
				'actions'=>array('changePassword'),
				'expression' => '$user->hasRoles(array("admin"))',
			),
			array(
				'allow',
				'actions'=>array('login','register'),
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
		$edit = new MemberEditForm();
		$name = strtolower(Yii::app()->user->name);
		$membership = Membership::model()->find("LOWER(membershipId)=?",array($name));
		$user = User::model()->find("LOWER(username)=?",array($name));
		$role = UserToRoles::model()->find("LOWER(roleID)=?",array($user->userId));
		$properties = MembershipProperties::model()->find("LOWER(membershipID)=?",array($name));

		if(isset($_POST['MemberEditForm']))
		{
			//var_dump($_POST);
			$edit->attributes = $_POST['MemberEditForm'];
			if ($edit->validate())
			{
				$member = Membership::model()->find("LOWER(membershipId)=?",array($name));
				//$properties = new MembershipProperties();
				$memberRole = UserRole::model()->find("LOWER(role)=?", array("member"));

				$member->attributes = array (
					//'membershipId' => Membership::generateUUID(),
					'name' => $edit->name,
					'familyName' => $edit->familyName,
					'phoneNumber' => $edit->phone,
					'alternatePhone' => $edit->alternatePhone,
					'emailAddress' => $edit->email,
					'alternateEmail' => $edit->alternateEmail,
					'type' => $edit->type,
				);

				//$properties->membershipId = $member->membershipId;
				if (!empty($edit->properties) && is_array($edit->properties))
				{
					foreach($edit->properties as $property)
					{
						$properties->$property = 'Y';
					}
				}

				$user->save();

				/*if ($memberRole !== NULL && !$user->isNewRecord)
				{
					$role->attributes = array (
						'userId' => $user->userId,
						'roleId' => $memberRole->roleId
					);
					$role->save();
				}*/
				$member->save();
				$properties->save();

				$edit->succeeded = true;
			}

		} else { //preload
			$edit->attributes = array(
				'name' => $membership->name,
				'familyName' => $membership->familyName,
				'phone' => $membership->phoneNumber,
				'alternatePhone' => $membership->alternatePhone,
				'email' => $membership->emailAddress,
				'alternateEmail' => $membership->alternateEmail,
				'type' => $membership->type,
				//TODO:?properties not preloading
				'recNews' => $properties->receiveGeneralNews,
				'recExpire' => $properties->receiveEventInvites,
				'recEvents' => $properties->receiveExpiryNotice,
			);
			//TODO:need null check
		}

		$this->render('edit', array(
			'model'=>$edit,
		));
	}

	/**
	 * Change current user's password.
	 */
	public function actionChangePassword()
	{
		$form = new MemberChangePasswordForm;
		$name = strtolower(Yii::app()->user->name);
		$user = User::model()->find("LOWER(username)=?",array($name));

		if(isset($_POST['MemberChangePasswordForm']))
		{
			//var_dump($_POST);
			$form->attributes = $_POST['MemberChangePasswordForm'];
			if ($form->validate())
			{
				$user->password = User::hashPassword($form->newPassword);
				$user->save();
			}
		}

		$this->render('changepassword',array('model'=>$form));

	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		$register = new RegistrationForm();
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['RegistrationForm']))
		{
			var_dump($_POST);
			$register->attributes = $_POST['RegistrationForm'];
			if ($register->validate())
			{
				$member = new Membership();
				$user = new User();
				$role = new UserToRoles();
				$properties = new MembershipProperties();

				$memberRole = UserRole::model()->find("LOWER(role)=?", array("member"));

				$member->attributes = array (
					'membershipId' => Membership::generateUUID(),
					'name' => $register->name,
					'familyName' => $register->familyName,
					'phoneNumber' => $register->phone,
					'alternatePhone' => $register->alternatePhone,
					'emailAddress' => $register->email,
					'alternateEmail' => $register->alternateEmail,
					'type' => $register->type,
					'expiryDate' => '0000-00-00', // not yet registered.
					'payMethod' => 'none',
					'status' => 'pending'
				);

				$properties->membershipId = $member->membershipId;
				if (!empty($register->properties) && is_array($register->properties))
				{
					foreach($register->properties as $property)
					{
						$properties->$property = 'Y';
					}
				}

				$user->attributes = array (
					'username' => $member->membershipId,
					'password' => User::hashPassword($register->password)
				);

				$user->save(); // need to get the user id after this.

				if ($memberRole !== NULL && !$user->isNewRecord)
				{
					$role->attributes = array (
						'userId' => $user->userId,
						'roleId' => $memberRole->roleId
					);
					$role->save();
				}
				$member->save();
				$properties->save();
			}
		/*
			$model->attributes=$_POST['Membership'];
			$model->membershipId = Membership::generateUUID();

			$user->attributes = array (
									'username' => $model->membershipId,
									'password' => User::hashPassword('')
								);
			$user->save();

			$memberRole = UserRole::model()->find("LOWER(role)=?", array("member"));
			if ($memberRole !== NULL) 
			{
				$role->attributes = array (
										'userId' => $user->userId,
										'roleId' => $memberRole->roleId
									);
				$role->save();
			}
			
			if($model->save())
				$this->redirect(array('view','id'=>$model->membershipId));
		*/
		}

		$this->render('register',array(
			'model'=>$register,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Membership']))
		{
			$model->attributes=$_POST['Membership'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->membershipId));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
	*/
	
	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
	*/
	
	/**
	 * Manages all models.
	 
	public function actionAdmin()
	{
		$model=new Membership('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Membership']))
			$model->attributes=$_GET['Membership'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	*/
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

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='membership-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
