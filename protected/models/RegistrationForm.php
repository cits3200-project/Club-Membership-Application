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
class RegistrationForm extends CFormModel
{
	// Membership Properties
	public $name;
	public $familyName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;
	public $type;
	
	// user properties.
	public $password;
	public $repeatPassword;
	
	// Membership_Properties Properties
	public $receiveGeneralNews;
	public $receiveAdminEmail;	
	public $receiveExpiryNotice;	
	public $receiveEventInvites;
	
	public function rules()
	{
		return array (
			array ('name, familyName, phoneNumber, emailAddress, type, password, repeatPassword', 'required'),
			array ('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			array ('password, repeatPassword', 'length', 'max' => 40),
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
			array ('password', 'compare', 'compareAttribute' => 'repeatPassword'),
			array ('emailAddress, alternateEmail', 'email'),
			array ('type', 'in', 'range' => array_keys(Membership::getMembershipTypes())),
			array (implode(', ', $this->getToggleProperties()), 'in', 'range' => array('Y','N')),
		);
	}
	
	public function attributeLabels()
	{
		return array (
			'name' => 'Membership name',
			'familyName' => 'Family name',
			'phoneNumber' => 'Phone number',
			'alternatePhone' => 'Alternate phone number',
			'emailAddress' => 'Email address',
			'alternateEmail' => 'Alternate email address',
			'type' => 'Membership type',
			'receiveGeneralNews' => 'Receive General News',
			'receiveAdminEmail' => 'Receive Email from Administrators',
			'receiveExpiryNotice' => 'Receive Expiry Notices',
			'receiveEventInvites' => 'Receive Event Invites'
		);
	}
	
	public function getToggleProperties()
	{
		return array(
			'receiveGeneralNews',
			'receiveAdminEmail',
			'receiveExpiryNotice',
			'receiveEventInvites',			
		);
	}
}
?>