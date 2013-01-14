<?php

/**
 * This is the model class for table "{{membership}}".
 *
 * The followings are the available columns in table '{{membership}}':
 * @property string $membershipId
 * @property string $name
 * @property string $familyName
 * @property string $postName
 * @property string $postalAddress
 * @property string $postalSuburb
 * @property string $postalState
 * @property string $postcode
 * @property string $phoneNumber
 * @property string $alternatePhone
 * @property string $emailAddress
 * @property string $alternateEmail
 * @property string $type
 * @property string $expiryDate
 * @property string $payMethod
 * @property string $status
 * @property string $receiveGeneralNews
 * @property string $receiveAdminEmail
 * @property string $receiveExpiryNotice
 *
 * The followings are the available model relations:
 * @property Member[] $members
 * @property PaymentMethod $paymentMethod
 * @property MembershipStatus $membershipStatus
 */
class Membership extends CActiveRecord
{
	const MEMBERSHIP_FORMAT = "xxxxxxxx";

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Membership the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Generates a UUID for a new membership.
	 * @return string UUID which can be safely used as a PK into the membership table
	 */
	public static function generateUUID()
	{
		$uuid = Membership::createUUID(self::MEMBERSHIP_FORMAT);
		while (Membership::model()->find("UPPER(membershipId)=?", array($uuid)) !== NULL)
			$uuid = Membership::createUUID(self::MEMBERSHIP_FORMAT);
		return $uuid;
	}

	public static function getPostalStates()
	{
		return array('WA','ACT','NSW','NT','QLD','SA','TAS','VIC');
	}

	public static function getMembershipTypes()
	{
		return array(
			'N' => 'None',
			'F' => 'Family',
			'C' => 'Couple',
			'S' => 'Single',
			'PC' => 'Pensioner Couple',
			'H' => 'Honorary',
		);
	}

	/**
	 * Creates an identifier based on the input format
	 * @param $format string identifying the format of the identifier (i.e XXXX-XXXX-XXXX-XXXX)
	 * @return a UUID in the given format
	 */
	private static function createUUID($format)
	{
		$raw = strtoupper(hash("sha512", uniqid(rand(), true)));
		$rawlen = strlen($raw);
		$uuid = "";
		
		for($i = 0; $i < strlen($format); $i++)
			$uuid .= ($format[$i] == 'x' 
						? strtolower($raw[rand(0, $rawlen - 1)]) 
						: ($format[$i] == '-' 
							? '-' 
							: $raw[rand(0, $rawlen - 1)]));

		return $uuid;	
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{membership}}';
	}

	/** 
	 * convenience function to generate
	 * an associative array of the available
	 * toggle options
	 */
	public static function getToggleProperties()
	{
		$properties = array('receiveGeneralNews','receiveAdminEmail','receiveExpiryNotice');
		return $properties;
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('membershipId, name, familyName, emailAddress, phoneNumber, type, expiryDate, payMethod, status', 'required'),
			array('expiryDate','date','format' => 'yyyy-MM-dd'),
			array('membershipId', 'length', 'max'=>128),
			array('emailAddress, alternateEmail', 'length', 'max'=>100),
			array('name, familyName', 'length', 'max'=>50),
			array('postName, postalAddress', 'length', 'max'=>60),
			array('postalSuburb', 'length', 'max'=>40),
			array('postcode', 'length', 'max'=>8),
			array('phoneNumber, alternatePhone', 'length', 'max'=>20),
			array('type', 'in', 'range'=>array_keys(Membership::getMembershipTypes())),
			array('postalState', 'in', 'range'=>array_keys(Membership::getPostalStates())),
			array('payMethod, status', 'length', 'max'=>15),
			array('emailAddress, alternateEmail', 'email'),
			array('receiveGeneralNews, receiveAdminEmail, receiveExpiryNotice, receiveEventInvites', 'in', 'range' => array('Y','N')),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'members' => array(self::HAS_MANY, 'Member', 'membershipId'),
			'memberCount' => array(self::STAT, 'Member', 'membershipId'),
			'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payMethod'),
			'membershipStatus' => array(self::BELONGS_TO, 'MembershipStatus', 'status')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'membershipId' => 'Membership Id',
			'name' => 'Name',
			'familyName' => 'Family Name',
			'phoneNumber' => 'Phone Number',
			'alternatePhone' => 'Alternate Phone',
			'emailAddress' => 'Primary Email Address',
			'alternateEmail' => 'Alternate Email Address',
			'type' => 'Type',
			'expiryDate' => 'Expiry Date',
			'payMethod' => 'Pay Method',
			'status' => 'Status',
			'receiveGeneralNews' => 'Receive General News',
			'receiveAdminEmail' => 'Receive Email from Administrators',
			'receiveExpiryNotice' => 'Receive Expiry Notices',
			'receiveEventInvites' => 'Receive Event Invites'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('membershipId',$this->membershipId,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('familyName',$this->familyName,true);
		$criteria->compare('phoneNumber',$this->phoneNumber,true);
		$criteria->compare('alternatePhone',$this->alternatePhone,true);
		$criteria->compare('emailAddress',$this->emailAddress,true);
		$criteria->compare('alternateEmail',$this->alternateEmail,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('expiryDate',$this->expiryDate,true);
		$criteria->compare('payMethod',$this->payMethod,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
