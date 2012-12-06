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

	/**
	 * Declares the validation rules.
	 * The rules define the compulsory fields, and checks formatting.
	 */
	public function rules()
	{
		return array (
			array ('memberName, birthDate, memberType', 'required'),
			array ('memberType', 'in', 'range' => array_keys(Member::getMemberTypes())),
			array ('birthDate', 'date', 'format' => 'dd/MM/yyyy', 'message' => 'Invalid date format, date must be in the format \'dd/mm/yyyy\''),
			array ('memberName', 'length', 'max' => 100)
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array (
			'memberName' => 'Name',
			'birthDate' => 'Date of birth (dd/mm/yyyy)',
			'memberType' => 'Gender'
		);
	}
}
?>
