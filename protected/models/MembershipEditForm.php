<?php

/**
 * MembershipEditForm
 * Model that manages the membership editing
 * form. This encapsulates the Membership model.
 *
 * @author Gregory Collin
 */
class MembershipEditForm extends CFormModel
{
	// Membership Properties
	public $name;
	public $familyName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;
	public $type;
	public $receiveGeneralNews;
	public $receiveAdminEmail;
	public $receiveExpiryNotice;
	public $receiveEventInvites;

	public function rules()
	{
		return array (
			array ('name, familyName, phoneNumber, emailAddress, type', 'required'),
			array ('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
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
