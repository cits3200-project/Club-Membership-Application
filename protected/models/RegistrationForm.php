<?php

/**
 * RegistrationForm
 * Model that manages the membership registration
 * form. This encapsulates both the User and Membership
 * models.
 *
 * @author Jason Larke
 * @date 25/08/2012
 */
class RegistrationForm extends MembershipChosenForm
{

	public $password;
	public $repeatPassword;

	// matched against the captcha code
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 * The rules define the compulsory fields, checks formatting, checks that
	 * the passwords match, and verifies the captcha code.
	 */
	public function rules()
	{
		return array_merge(
			//inherit parent class's rules
			parent::rules(),
			array (
				array ('password, repeatPassword', 'required'),
				array ('password, repeatPassword', 'length', 'max' => 40),
				array ('password', 'compare', 'compareAttribute' => 'repeatPassword'),
				array ('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
			)
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array_merge(
			//inherit parent class's labels
			parent::attributeLabels(),
			array(
				'verifyCode'=>'Verification Code',
			)
		);
	}
}
?>
