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

	public function attributeLabels()
	{
		return array (
			'status' => 'Membership status',
			'payMethod' => 'Payment method'
		);
	}
}
?>
