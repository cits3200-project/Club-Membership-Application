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

	/*// user properties.
	public $password;
	public $repeatPassword;*/

	// Membership_Properties Properties
	//public $recEvents;
	//public $recExpire;
	//public $recNews;

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

	/*public function validateProperties($attr,$params)
	{
		// Sanitization masquerading as validation.
		if (is_array($this->$attr))
		{
			$accept = $this->getPropertyList();
			foreach($this->$attr as $prop)
				if (!isset($accept[$prop]))
					unset($this->$attr[$prop]);
		}
	}*/

	public function attributeLabels()
	{
		return array (
		);
	}

}
?>
