<?php
/**
 * SearchForm
 * Model class to handle common search form aspects.
 * This class was designed to abstract database searching for memberships
 * as multiple forms may need near-identical search modelling and this way
 * the chances of duplication errors are minimized
 *
**/

class SearchForm extends CFormModel
{
	/**
	 * $searchFields is the core component of this class.
	 * Each top-level key in the array represents a queryable
	 * search object on the membership data. Fields are ignored
	 * if they have an empty value (i.e NULL or an empty string).
	 *
	 * Each search field can define the following properties:
	 * label -> Display text for this field when placing it on a form (optional, defaults to CFormModel.getAttributeLabel(fieldName))
	 * active -> Whether the current search field is needed. Value should either be true or false. (optional, defaults to true)
	 * type -> Field type. Valid types include 'standard', 'toggle' and 'required'. More information about these types is below(optional, defaults to 'standard')
	 * condition -> Queryable SQL string. The type modifier will determine how this string is interpreted. Variable aliases can also be used and are detailed below (required)
	 * value -> Value of the search field. Set this property to specify a default value (optional, defaults to an empty string)
	 * rule -> Custom validation rule for the field. Validation rule must be an array and match Yii's validation rule conventions. This field is optional and defaults to NULL. Complex values for 'rule' should be set in the constructor.
	 *
	 * Search Field Types:
	 * standard -> A standard input field. Length is restricted to 200 characters. If the field's value is empty, its condition is not used as part of the criteria (see 'required' for alternatives).
	 * toggle -> A togglable field. Such a field can have the values Y, N or I (Yes, No, Ignore respectively). 'No' negates the condition, 'Ignore' ignores the condition and 'Yes' accepts the condition as-is.
	 * required -> Identical to standard, except that even when the field is empty, its condition will be applied to the search
	 *
	 * Condition Variable Aliases:
	 * {membership} -> Alias of the Membership table
	 * {value} -> Alias of the fields current value
	 * {
	 */
	private $searchFields = array(
		'expiringMembers' => array(
			'label' => 'Members who are close to expiring',
			'type' => 'toggle',
			'value' => 'I',
			'condition' => '{membership}.expiryDate < DATE_ADD(SYSDATE(), INTERVAL 10 DAY) AND {membership}.expiryDate > SYSDATE()' // get non-expired members who will expire in the next 10 days.
		),
		'generalNews' => array(
			'label' => 'Member wants to receive general news',
			'type' => 'toggle',
			'value' => 'I',
			'condition' => '{membership}.receiveGeneralNews = \'Y\'' 
		),
		'eventInvite' => array(
			'label' => 'Member wishes to receive event invites',
			'type' => 'toggle',
			'value' => 'I',
			'condition' => '{membership}.receiveEventInvites = \'Y\''
		),
		'expiryNotice' => array(
			'label' => 'Member wants to receive an expiry notice if appropriate',
			'type' => 'toggle',
			'value' => 'I',
			'condition' => '{membership}.receiveExpiryNotice = \'Y\''
		),
		'expiredMembers' => array(
			'label' => 'Members who have already expired',
			'type' => 'toggle',
			'value' => 'I',
			'condition' => '{membership}.expiryDate < SYSDATE()'
		),
		'membershipStatus' => array(
			'label' => 'Membership status',
			'condition' => 'LOWER({membership}.status) = LOWER({value})'
		),
		'membershipType' => array(
			'label' => 'Membership type',
			'condition' => 'LOWER({membership}.type) = LOWER({value})'
		),
		'paymentMethod' => array(
			'label' => 'Payment method',
			'condition' => 'LOWER({membership}.payMethod) = LOWER({value})'
		),
		'membershipId' => array(
			'label' => 'Membership id',
			'condition' => 'LOWER({membership}.membershipId) LIKE LOWER({value})'
		),
		'familyName' => array(
			'label' => 'Family name',
			'condition' => 'LOWER({membership}.familyName) LIKE LOWER({value})'
		),
		'membershipName' => array(
			'label' => 'Membership name',
			'condition' => 'LOWER({membership}.name) LIKE LOWER({value})'
		),
		'emailAddress' => array(
			'label' => 'Email address',
			'condition' => 'LOWER({membership}.emailAddress) LIKE LOWER({value}) OR LOWER({membership}.alternateEmail) LIKE LOWER({value})'
		),
		'phoneNumber' => array(
			'label' => 'Phone number',
			'condition' => 'LOWER({membership}.phoneNumber) LIKE LOWER({value})'
		)
	);

	/** 
	 * PHP's magic __get function. Do not explicitly call this method. Used to dynamically
	 * grab 'properties' from the $filters variable. This allows for variable centralization. 
	 * Each key in the $filters array corresponds to a form property and has an associative 
	 * sub-array which can contain, amongst other things, a 'value'. This is the only
	 * value that should be returned from the getter (defaults to 'I')
	 * @param $name name of the property to access
	 * @return current value of the named filter if found, otherwise returns parent::__get
	 */
	public function __get($name)
	{
		if (isset($this->searchFields[$name]))
			return isset($this->searchFields[$name]['value']) 
					? $this->searchFields[$name]['value'] 
					: '';
		else
			return parent::__get($name);
	}

	/**
	 * PHP's magic __set function. Do not explicitly call this method.
	 * This is the opposite of the __get function above and will set a filter's current
	 * value to the $value specified in the parameters. If $name does not refer to a current filter, 
	 * parent::__set is called instead.
	 * @param $name name of the property to set.
	 * @param $value value to set the property to
	 */
	public function __set($name,$value)
	{
		if (isset($this->searchFields[$name]))
			$this->searchFields[$name]['value'] = $value;
		else
			parent::__set($name,$value);
	}

	public function __construct()
	{
		// configure rules
		$this->searchFields['paymentMethod']['rule'] = array('paymentMethod', 'in', 'range' => array_keys(SearchForm::getPaymentTypes()));
		$this->searchFields['membershipType']['rule'] = array('membershipType', 'in', 'range' => array_keys(SearchForm::getMembershipTypes()));
		$this->searchFields['membershipStatus']['rule'] = array('membershipStatus', 'in', 'range' => array_keys(SearchForm::getMembershipStatusTypes()));
	}

	public function getSearchFields()
	{
		$fields = array();
		foreach($this->searchFields as $field=>$data)
			if (!isset($data['active']) || $data['active'])
				$fields[] = $field;
		return $fields;
	}

	public function getSearchFieldType($fieldName)
	{
		return isset($this->searchFields[$fieldName])
					? isset($this->searchFields[$fieldName]['type'])
						? strtolower($this->searchFields[$fieldName]['type'])
						: 'standard'
					: NULL;
	}

	public function getSearchFieldState($fieldName)
	{
		return isset($this->searchFields[$fieldName])
					? isset($this->searchFields[$fieldName]['active'])
						? $this->searchFields[$fieldName]['active']
						: true
					: NULL;
	}

	public function setSearchFieldState($fieldName, $state)
	{
		if (isset($this->searchFields[$fieldName]))
			$this->searchFields[$fieldName]['active'] = $state ? true : false;
	}


	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		$defaults = array();
		$toggles = array();
		$custom = array();
		$required = array();

		foreach($this->searchFields as $field=>$data)
		{
			$type = $this->getSearchFieldType($field);
			if ($type == 'toggle')
				$toggles[] = $field;
			elseif ($type == 'required')
				$required[] = $field;
			elseif (empty($data['rule']) || !is_array($data['rule']))
				$defaults[] = $field;

			if (isset($data['rule']) && is_array($data['rule']))
				$custom[] = $data['rule'];
		}

		return array_merge(array(
			array(implode(', ', $required), 'required'),
			array(implode(', ', $toggles), 'in', 'range' => array('Y','N','I')),
			array(implode(', ', $defaults), 'length', 'max'=>200)
		), $custom);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		$labels = array();
		foreach($this->searchFields as $field=>$data)
			$labels[$field] = isset($data['label']) ? $data['label'] : parent::generateAttributeLabel($field);
		return $labels;
	}

	public function getAttributeLabel($field)
	{
		$labels = $this->attributeLabels();
		return isset($labels[$field]) ? $labels[$field] : parent::getAttributeLabel($field);
	}

	// Get valid field values for some of the "combobox" options (paymentMethod, membershipStatus and membershipType)
	public static function getPaymentTypes()
	{
		$types = array('' => 'Any');
		return array_merge($types, PaymentMethod::getPaymentMethods());
	}

	public static function getMembershipStatusTypes()
	{
		$types = array('' => 'Any');
		return array_merge($types, MembershipStatus::getMembershipStatuses());
	}

	public static function getMembershipTypes()
	{
		$types = array('' => 'Any');
		return array_merge($types, Membership::getMembershipTypes());
	}

	public function runSearch()
	{
		return Membership::model()->findAll($this->getSearchCriteria());
	}

	public function getSearchCriteria()
	{
		$ma = 'membership'; //membershipAlias. Truncated for brevity.

		$conditions = array();
		$parameters = array();

		foreach($this->searchFields as $key=>$data) 
		{
			$sql = $this->generateSql($data);
			if (!empty($sql['sql'])) // need to parse this condition
			{
				if (!empty($sql['parameters']))
					$parameters = array_merge($parameters, $sql['parameters']);

				$conditions[] = str_replace(array('{membership}'), array($ma), $sql['sql']);
			}
		}

		$criteria = new CDbCriteria();
		$criteria->alias = $ma;
		$criteria->params = $parameters;
		$criteria->select = "{$ma}.*";
		$criteria->condition = implode(" AND ", $conditions);

		return $criteria;
	}

	private function generateSql($fieldData)
	{
		$sqlData = array(
			'sql' => '',
			'parameters' => array()
		);
		$type = strtolower(isset($fieldData['type']) ? $fieldData['type'] : 'standard');
		if ( (isset($fieldData['active']) && !$fieldData['active']) || empty($fieldData['condition']) || ($type === 'standard' && empty($fieldData['value'])) || ($type === 'toggle' && $fieldData['value'] === 'I') )
			return $sqlData; // don't need to query this field.

		$fieldValue = isset($fieldData['value']) 
									? $fieldData['value'] 
									: '';

		$sqlData['sql'] = '(' . str_replace('{value}','?',$fieldData['condition']) . ')';

		if (($type === 'required' || $type === 'standard') && preg_match('/\bLIKE\b/i', $sqlData['sql']) == 1)
			$fieldValue = "%{$fieldValue}%";
		elseif ($fieldValue === 'N') // $type must logically be 'toggle', and the 'N' value requires a negation
			$sqlData['sql'] = 'NOT ' . $sqlData['sql'];

		for($i = 0; $i < substr_count($sqlData['sql'], '?'); $i++)
			$sqlData['parameters'][] = $fieldValue;

		return $sqlData;
	}
}
?>
