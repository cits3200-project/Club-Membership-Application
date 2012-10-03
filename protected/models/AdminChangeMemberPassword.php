<?php

/**
 * AdminChangeMemberPassword
 * Model that manages the membership change password
 * form. This encapsulates both the User and Membership
 * models.
 *
 * @author Gregory Collin
 */
class AdminChangeMemberPassword extends CFormModel
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

	public $username;
	public $newPassword;
	public $repeatNewPassword;

	public $succeeded = false;

	public function rules()
	{
		return array (
			array('username, newPassword, repeatNewPassword', 'required'),
			array('username', 'validateUsername'),
			array('newPassword, repeatNewPassword', 'length', 'max' => 40),
			array('repeatNewPassword', 'compare', 'compareAttribute' => 'newPassword'),
		);
	}

	public function validateUsername($attribute,$params)
	{
		echo $this->username;
		$user = User::model()->find("LOWER(username)=?",array(strtolower($this->username)));
		//echo "user = $user->username";
		if ($user == NULL)
		{
			$this->addError('username','User does not exist.');
		}
		else if (!$user->hasRole('member'))
		{
			$this->addError('username',"Only member's passwords may be changed by this form.");
		}
	}

	public function attributeLabels()
	{
		return array (
		);
	}

}
?>
