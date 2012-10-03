<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property string $userId
 * @property string $username
 * @property string $password
 *
 * The followings are the available model relations:
 * @property userRole[] $userRoles
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * Returns an array of the publicly accessible user role names
	 * @return array(string) array of the role names for the current user
	 */
	public function getRoleNames()
	{
		$roleNames = array();
		foreach($this->userRoles as $ur)
			$roleNames[] = $ur->role;

		return $roleNames;
	}

	public function hasRole($role)
	{
		return in_array($role, $this->getRoleNames());
	}
	
	/**
	 * Validates a given password against the user's password, using the stored salt.
	 * @param string $password Password to validate
	 * @return boolean Whether the $password parameter was valid for this user.	
	 */
	public function validatePassword($password)
    {
        return strtoupper(User::hashPassword($password)) === strtoupper($this->password);
    }
	
	/**
	 * Performs the forward-only password hashing required to compare stored
	 * password to the provided, plaintext, password.
	 * @param string $password plain-text password to hash
	 * @return string the hashed password
	 */
    public static function hashPassword($password)
    {
        return hash("sha512", $password);
    }
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('username, password', 'length', 'max'=>128),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('userId, username, password', 'safe', 'on'=>'search'),
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
			'userRoles' => array(self::MANY_MANY, 'UserRole', '{{user_to_roles}}(userId, roleId)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'userId' => 'User',
			'username' => 'Username',
			'password' => 'Password',
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

		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
