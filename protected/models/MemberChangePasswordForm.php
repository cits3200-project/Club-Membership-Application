<?php

/**
 * MemberChangePasswordForm
 * Model that manages the membership change password
 * form. This encapsulates both the User and Membership
 * models.
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

	public function rules()
	{
		return array (
			array('password, newPassword, repeatNewPassword', 'required'),
			array('password', 'authenticate'),
			array('password, newPassword, repeatNewPassword', 'length', 'max' => 40),
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

	public function attributeLabels()
	{
		return array (
			'password' => 'Current Password',
		);
	}

}
?>
