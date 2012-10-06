<?php

/**
 * MemberEditForm
 * Form validation model to allow for
 * a Membership to edit their members.
 *
 * @author Jason Larke
 */
class MemberEdit extends CFormModel
{
	// Membership Properties
	public $memberName;
	public $birthDate;
	public $memberType;

	public function rules()
	{
		return array (
			array ('memberName, birthDate, memberType', 'required'),
			array ('memberType', 'in', 'range' => array_keys(Member::getMemberTypes())),
			array ('birthDate', 'date', 'format' => 'dd/MM/yyyy'),
			array ('memberName', 'length', 'max' => 100)
		);
	}

	public function attributeLabels()
	{
		return array (
			'memberName' => 'Name',
			'birthDate' => 'Date of birth',
			'memberType' => 'Gender'
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
