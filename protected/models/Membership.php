<?php

/**
 * This is the model class for table "membership".
 *
 * The followings are the available columns in table 'membership':
 * @property string $membershipId
 * @property string $emailAddress
 * @property string $alternateEmail
 * @property string $familyName
 * @property string $membershipName
 * @property string $address
 * @property string $suburb
 * @property integer $postcode
 * @property string $state
 * @property string $phoneNumber
 * @property string $membershipStatus
 *
 * The followings are the available model relations:
 * @property Member[] $members
 */
class Membership extends CActiveRecord
{
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
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'membership';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membershipId, emailAddress, familyName, membershipName, address, suburb, postcode, state, phoneNumber, membershipStatus', 'required'),
			array('postcode', 'numerical', 'integerOnly'=>true),
			array('membershipId', 'length', 'max'=>64),
			array('emailAddress, alternateEmail', 'length', 'max'=>128),
			array('familyName', 'length', 'max'=>30),
			array('membershipName, suburb', 'length', 'max'=>100),
			array('address', 'length', 'max'=>200),
			array('state, membershipStatus', 'length', 'max'=>10),
			array('phoneNumber', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('membershipId, emailAddress, alternateEmail, familyName, membershipName, address, suburb, postcode, state, phoneNumber, membershipStatus', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'membershipId' => 'Membership',
			'emailAddress' => 'Email Address',
			'alternateEmail' => 'Alternate Email',
			'familyName' => 'Family Name',
			'membershipName' => 'Membership Name',
			'address' => 'Address',
			'suburb' => 'Suburb',
			'postcode' => 'Postcode',
			'state' => 'State',
			'phoneNumber' => 'Phone Number',
			'membershipStatus' => 'Membership Status',
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
		$criteria->compare('emailAddress',$this->emailAddress,true);
		$criteria->compare('alternateEmail',$this->alternateEmail,true);
		$criteria->compare('familyName',$this->familyName,true);
		$criteria->compare('membershipName',$this->membershipName,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('suburb',$this->suburb,true);
		$criteria->compare('postcode',$this->postcode);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('phoneNumber',$this->phoneNumber,true);
		$criteria->compare('membershipStatus',$this->membershipStatus,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}