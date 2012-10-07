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
class RegistrationForm extends MembershipForm
{

	// user properties.
	public $password;
	public $repeatPassword;

	public function rules()
	{
		return array_merge(
			//inherit parent's rules
			parent::rules(),
			array (
				array ('password, repeatPassword', 'required'),
				array ('password, repeatPassword', 'length', 'max' => 40),
				array ('password', 'compare', 'compareAttribute' => 'repeatPassword'),
			)
		);
	}
}
?>
