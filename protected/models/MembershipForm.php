<?php

/**
 * MembershipForm
 * Base class for forms that update the Membership model.
 * Fields in this class my be changed by both the owner of the membership and by admin.
 */
class MembershipForm extends CFormModel
{
	// Membership Properties
	// The owners first name
	public $name;
	public $familyName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;

	/**
	 * Declares the validation rules.
	 * The rules state what fields are required, the maximum size of email
	 * adresses and phone numbers, and the required format of an email address.
	 */
	public function rules()
	{
		return array (
			// required fields
			array ('name, familyName, phoneNumber, emailAddress', 'required'),
			// maximum length of email addreses
			array ('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			// maximum length of phone numbers
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
			// email has to be a valid email address
			array ('emailAddress, alternateEmail', 'email'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array (
			'name' => 'Membership name',
			'familyName' => 'Family name',
			'phoneNumber' => 'Phone number',
			'alternatePhone' => 'Alternate phone number',
			'emailAddress' => 'Primary email address',
			'alternateEmail' => 'Alternate email address',
		);
	}
}
?>
