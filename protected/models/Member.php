<?php

/**
 * This is the model class for table "{{member}}".
 *
 * The followings are the available columns in table '{{member}}':
 * @property string $memberId
 * @property string $firstName
 * @property string $dateOfBirth
 * @property string $type
 * @property string $membershipId
 *
 * The followings are the available model relations:
 * @property Membership $membership
 */
class Member extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Member the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getMemberTypes()
	{
		return array (
			'AM' => 'Adult Male',
			'AF' => 'Adult Female',
			'C' => 'Child'
		);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{member}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('firstName, dateOfBirth, membershipId', 'required'),
			array('firstName', 'length', 'max'=>30),
			array('type', 'length', 'max'=>2),
			array('membershipId', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('memberId, firstName, dateOfBirth, type, membershipId', 'safe', 'on'=>'search'),
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
			'membership' => array(self::BELONGS_TO, 'Membership', 'membershipId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'memberId' => 'Member',
			'firstName' => 'First Name',
			'dateOfBirth' => 'Date Of Birth',
			'type' => 'Type',
			'membershipId' => 'Membership',
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

		$criteria->compare('memberId',$this->memberId,true);
		$criteria->compare('firstName',$this->firstName,true);
		$criteria->compare('dateOfBirth',$this->dateOfBirth,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('membershipId',$this->membershipId,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}