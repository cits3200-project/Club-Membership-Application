<?php

/**
 * MemberEditForm
 * Model that manages the membership editing
 * form. This encapsulates both the User and Membership
 * models.
 *
 * @author Gregory Collin
 */
class MemberEditForm extends CFormModel
{
	// Membership Properties
	public $name;
	public $familyName;
	public $phone;
	public $alternatePhone;
	public $email;
	public $alternateEmail;
	public $type;

	/*// user properties.
	public $password;
	public $repeatPassword;*/

	// Membership_Properties Properties
	//public $recEvents;
	//public $recExpire;
	//public $recNews;

	public $properties;

	public $succeeded;

	public function rules()
	{
		return array (
			array ('name, familyName, phone, email, type, properties', 'required'),
			array ('name, email, alternateEmail', 'length', 'max' => 100),
			//array ('password, repeatPassword', 'length', 'max' => 40),
			array ('phone, alternatePhone', 'length', 'max' => 20),
			//array ('password', 'compare', 'compareAttribute' => 'repeatPassword'),
			array ('email, alternateEmail', 'email'),
			array ('type', 'in', 'range' => array('F','PC','C','S')),
			array ('properties', 'safe'),
			array ('properties', 'validateProperties'),
			
			//array ('recEvents, recExpire, recNews', 'in', 'range' => array('Y','N'))
		);
	}

	public function validateProperties($attr,$params)
	{
		// Sanitization masquerading as validation.
		if (is_array($this->$attr))
		{
			$accept = $this->getPropertyList();
			foreach($this->$attr as $prop)
				if (!isset($accept[$prop]))
					unset($this->$attr[$prop]);
		}
	}

	public function attributeLabels()
	{
		return array (
			'name' => 'Membership name',
			'familyName' => 'Family name',
			'phone' => 'Phone number',
			'alternatePhone' => 'Alternate phone number',
			'email' => 'Email address',
			'alternateEmail' => 'Alternate email address',
			'type' => 'Membership type',
			'recNews' => 'Receive general news emails',
			'recExpire' => 'Receive expiry notice',
			'recEvents' => 'Receive event invites'
		);
	}

	public function getPropertyList()
	{
		$model = MembershipProperties::model();
		$properties = array();
		foreach($model->attributeNames() as $attr)
		{
			if ($attr !== $model->tableSchema->primaryKey)
				$properties[$attr] = $model->getAttributeLabel($attr);
		}
		return $properties;
	}
}
?>
