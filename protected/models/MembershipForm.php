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
	 * Membership type i.e. Single/Family etc.
	 * Valid types are define by Membership::getMembershipTypes()
	 */
	public $type;

	/**
	 * Declares the validation rules.
	 * The rules state what fields are required, the maximum size of email
	 * adresses and phone numbers, the required format of an email address,
	 * and the valid membership types.
	 */
	public function rules()
	{
		return array (
			// required fields
			array ('name, familyName, phoneNumber, emailAddress, type', 'required'),
			// maximum length of email addreses
			array ('name, emailAddress, alternateEmail', 'length', 'max' => 100),
			// maximum length of phone numbers
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
			// email has to be a valid email address
			array ('emailAddress, alternateEmail', 'email'),
			// membership type needs to be one defined in the Membership model
			array ('type', 'in', 'range' => array_keys(Membership::getMembershipTypes())),
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
			'emailAddress' => 'Email address',
			'alternateEmail' => 'Alternate email address',
			'type' => 'Membership type',
		);
	}
}
?>
