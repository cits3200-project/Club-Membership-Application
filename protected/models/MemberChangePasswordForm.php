<?php

/**
 * MemberChangePasswordForm
 * Model that manages the membership change password
 * form.
 *
 * @author Gregory Collin
 */
class MemberChangePasswordForm extends CFormModel
{
	// Membership Properties
	public $name;

	// User password
	public $password;
	public $newPassword;
	public $repeatNewPassword;

	/**
	 * Declares the validation rules.
	 * The rules define the required fields, the password validation method,
	 * the maximum password length,
	 * and that the repeated pasword must be the same.
	 */
	public function rules()
	{
		return array (
			// require all the password fields
			array('password, newPassword, repeatNewPassword', 'required'),
			// call the authenticate method on the password
			array('password', 'authenticate'),
			// maximum length for the passwords
			array('password, newPassword, repeatNewPassword', 'length', 'max' => 40),
			// repeated password must be the same
			array('repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword'),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$name = Yii::app()->user->name;
			$identity=new UserIdentity($name,$this->password);
			if(!$identity->authenticate())
				$this->addError('password','Incorrect password.');
		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array (
			'password' => 'Current Password',
		);
	}

}
?>
