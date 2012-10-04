<?php
/**
 * Form model to wrap around the edit fields
 * that an admin has access to when editing 
 * a club member.
 *
 * @author Jason Larke
 * @date 4/10/2012
 */
class AdminEditForm extends CFormModel
{
	//public properties
	public $name;
	public $familyName;
	public $phoneNumber;
	public $alternatePhone;
	public $emailAddress;
	public $alternateEmail;
	public $type;
	public $expiryDate;
	public $payMethod;
	public $status;

	public function rules()
	{
		return array (
			array ('name, familyName, phoneNumber, emailAddress, type, payMethod, status, expiryDate', 'required'),
			array ('name, familyName, emailAddress, alternateEmail', 'length', 'max' => 100),
			array ('expiryDate', 'date', 'format' => 'yyyy-MM-dd'),
			array ('phoneNumber, alternatePhone', 'length', 'max' => 20),
			array ('emailAddress, alternateEmail', 'email'),
			array ('payMethod, status', 'length', 'max'=>15),
			array ('payMethod', 'in', 'range' => array_keys(PaymentMethod::getPaymentMethods())),
			array ('status', 'in', 'range' => array_keys(MembershipStatus::getMembershipStatuses())),
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
			'status' => 'Membership status',
			'payMethod' => 'Payment method'
		);
	}
}
?>