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
	public $postName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;
	public $postalAddress;
	public $postalSuburb;
	public $postalState;
	public $postcode;

	/**
	 * Declares the validation rules.
	 * The rules state what fields are required, the maximum size of email
	 * adresses and phone numbers, and the required format of an email address.
	 */
	public function rules()
	{
		return array(
			// required fields
			array('name, familyName, phoneNumber, emailAddress', 'required'),
			// maimum length
			array('name, familyName', 'length', 'max' => 50),
			array('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			array('postName, postalAddress', 'length', 'max'=>60),
			array('postalSuburb', 'length', 'max'=>40),
			array('postcode', 'length', 'max'=>8),
			array('postalState', 'in', 'range'=>array_keys(Membership::getPostalStates())),
			// maimum length of phone numbers
			array('phoneNumber, alternatePhone', 'length', 'max' => 20),
			// emil has to be a valid email address
			array('emailAddress, alternateEmail', 'email'),
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
