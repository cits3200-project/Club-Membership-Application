<?php
/**
 * Form model to wrap around the edit fields
 * that an admin has access to when editing
 * a club member.
 *
 * @author Jason Larke
 * @date 4/10/2012
 */
class AdminEditForm extends MembershipForm
{
	//public properties
	public $expiryDate;
	public $payMethod;
	public $status;

	/**
	 * Declares the validation rules.
	 * The rules define the compulsory fields, and checks formatting.
	 */
	public function rules()
	{
		return array_merge(
			parent::rules(),
			array (
				array ('payMethod, status, expiryDate', 'required'),
				array ('expiryDate', 'date', 'format' => 'yyyy-MM-dd'),
				array ('payMethod, status', 'length', 'max'=>15),
				array ('payMethod', 'in', 'range' => array_keys(PaymentMethod::getPaymentMethods())),
				array ('status', 'in', 'range' => array_keys(MembershipStatus::getMembershipStatuses())),
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
			parent::attributeLabels(),
			array (
				'status' => 'Membership status',
				'payMethod' => 'Payment method'
			)
		);
	}
}
?>
