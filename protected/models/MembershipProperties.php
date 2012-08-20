<?php

/**
 * This is the model class for table "{{membership_properties}}".
 *
 * The followings are the available columns in table '{{membership_properties}}':
 * @property string $membershipId
 * @property string $receiveGeneralNews
 * @property string $receiveEventInvites
 * @property string $receiveExpiryNotice
 *
 * The followings are the available model relations:
 * @property Membership $membership
 */
class MembershipProperties extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MembershipProperties the static model class
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
		return '{{membership_properties}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('membershipId', 'required'),
			array('membershipId', 'length', 'max'=>128),
			array('receiveGeneralNews, receiveEventInvites, receiveExpiryNotice', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('membershipId, receiveGeneralNews, receiveEventInvites, receiveExpiryNotice', 'safe', 'on'=>'search'),
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
			'membershipId' => 'Membership',
			'receiveGeneralNews' => 'Receive General News',
			'receiveEventInvites' => 'Receive Event Invites',
			'receiveExpiryNotice' => 'Receive Expiry Notice',
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
		$criteria->compare('receiveGeneralNews',$this->receiveGeneralNews,true);
		$criteria->compare('receiveEventInvites',$this->receiveEventInvites,true);
		$criteria->compare('receiveExpiryNotice',$this->receiveExpiryNotice,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}