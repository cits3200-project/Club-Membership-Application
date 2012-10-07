<?php

/**
 * MembershipForm
 * Base class for forms that update the Membership model.
 * Fields in this class my be changed by both the owner of the membership and by admin.
 */
class MembershipForm extends CFormModel
{
	// Membership Properties
	public $name;
	public $familyName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;
	public $type;

	public function rules()
	{
		return array (
			array ('name, familyName, phoneNumber, emailAddress, type', 'required'),
			array ('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
			array ('emailAddress, alternateEmail', 'email'),
			array ('type', 'in', 'range' => array_keys(Membership::getMembershipTypes())),
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
		);
	}
}
?>
