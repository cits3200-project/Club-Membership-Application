<?php

/**
 * class ActiveFilters
 * This model centralises the common search filters to allow for easy
 * management over multiple forms and controllers. The filters are designed
 * to be applied to the Membership and Properties tables to allow for straightforward
 * search patterns to be abstracted into a common location and used in multiple areas.
 *
 * @author Jason Larke
 * @date 24/09/2012
 */
class ActiveFilters
{
	/**
	 * $filters is the core component of this class.
	 * each filter represents a queryable filter on the members list.
	 * Filters can specify a series of attributes:
	 * 'label', display text when presented in a view,
	 * 'condition', queryable SQL string that indicates the condition under which the filter is TRUE  <- important
	 * 'value', default value of the filter (Y/N/I for Yes/No/Ignore respectively), default value is 'I'
	 *
	 * note: In the 'condition' you can use the following shortcuts for table aliases to avoid hardcoding:
	 * {membership} = Membership table.
	 * {properties} = Membership properties table.
	 */
	private $filters = array(
		'expiringMembers' => array(
			'label' => 'Members who are close to expiring',
			'value' => 'I',
			'condition' => '{membership}.expiryDate < DATE_ADD(SYSDATE(), INTERVAL 10 DAY) AND {membership}.expiryDate > SYSDATE()' // get non-expired members who will expire in the next 10 days.
		),
		'generalNews' => array(
			'label' => 'Member wants to receive general news',
			'value' => 'I',
			'condition' => '{properties}.receiveGeneralNews = \'Y\'' 
		),
		'eventInvite' => array(
			'label' => 'Member wishes to receive event invites',
			'value' => 'I',
			'condition' => '{properties}.receiveEventInvites = \'Y\''
		),
		'expiryNotice' => array(
			'label' => 'Member wants to receive an expiry notice if appropriate',
			'value' => 'I',
			'condition' => '{properties}.receiveExpiryNotice = \'Y\''
		),
		'expiredMembers' => array(
			'label' => 'Members who have already expired',
			'value' => 'I',
			'condition' => '{membership}.expiryDate < SYSDATE()'
		),
	);	
	
	/* Describes the valid range of values that the filters can take. (Y/N/I are Yes/No/Ignore respectively) */
	private static $validRange = array ('Y','N','I');
	/* Default value of the filter */
	private static $defaultValue = 'I';
	
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
		if (isset($this->filters[$name]))
			return isset($this->filters[$name]['value']) 
					? $this->filters[$name]['value'] 
					: $this->defaultValue;
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
		if (isset($this->filters[$name]) && in_array($value, $this->validRange))
			$this->filters[$name]['value'] = $value;
	}
	
	/**
	 * Get the names of all the current filters
	 * @return array containing all of the current filter names
	 */
	public function getFilters()
	{
		return array_keys($this->filters);
	}
	
	/**
	 * Retrieves the label of a specified filter.
	 * @param $filter Unique name of the filter
	 * @return string Label of the filter or NULL if no label was found for the filter
	 */
	public function getFilterLabel($filter)
	{
		return isset($this->filters[$filter]['label']) ? $this->filters[$filter]['label'] : NULL;
	}
	
	/**
	 * Get the validation rules for the filters
	 * @return array containing Yii-compatible validation information
	 */
	public function getRules()
	{
		return array(
			implode(', ', $this->getFilters()), 
			'in',
			'range' => $this->validRange,
			'message' => 'Invalid value specified for {attribute}'
		);
	}
	
	/**
	 * Execute a relational query between Membership and Properties tables
	 * using the current values of the various filters as the criteria of the query.
	 *
	 * @return array of CActiveRecords; one for each row that the filter query returned.
	 */
	public function runFilters()
	{
		$ma = 'membership'; //membershipAlias. Truncated for brevity.
		$pa = 'properties'; //propertiesAlias. Truncated for brevity.
		$propertiesTable = MembershipProperties::model()->tableName(); 
		
		$conditions = array();
		
		foreach($this->filters as $property=>$data)
		{
			if (!empty($data['condition']))
			{
				$sql = '(' . str_replace(array('{membership}','{properties}'), array($ma,$pa), $data['condition']) . ')';
				if ( $this->$property == 'N' || $this->$property == 'Y' )
					$conditions[] = $this->$property == 'N' ? "NOT {$sql}" : "{$sql}";
			}
		}
		
		// Build a Yii-compatible criteria list for the email query.
		$criteria = new CDbCriteria();
		$criteria->alias = $ma;
		$criteria->join = "LEFT JOIN {$propertiesTable} AS {$pa} ON {$pa}.membershipId = {$ma}.membershipId";
		$criteria->select = "{$ma}.emailAddress,{$ma}.alternateEmail,{$ma}.name,{$ma}.membershipId";
		$criteria->condition = implode(" AND ", $conditions);

		return Membership::model()->findAll($criteria);	
	}
}
?>