<?php
/**
 * MailoutForm class.
 * MailoutForm is the class for filtering and searching 
 * the database for users who satisfy set conditions and retrieving their emails.
 * Also handles the task of sending batch emails to the found users' emails.
 * 
 * @author Jason Larke
 * @date 24/08/2012
 */
class MailoutForm extends CFormModel
{
	public $emailSubject;
	public $emailContent;
	public $type = "email";
	
	/**
	 * $filters is the core component of this class.
	 * each filter represents a queryable filter on the members list.
	 * Filters can specify a 'label', which is their display text when presented in a view,
	 * also a 'condition' which is the queryable SQL command that indicates the condition under which the filter is TRUE  <- important
	 * finally, they can also specify a 'value', which is their default value.
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
	
	/** 
	 * PHP's magic __get function. Do not explicitly call this method. Used to dynamically
	 * grab 'properties' from the $filters variable. This allows for variable centralization. 
	 * Each key in the $filters array corresponds to a form property and has an associative 
	 * sub-array which can contain, amongst other things, a 'value'. This is the only
	 * value that should be returned from the getter.
	 * @param $name name of the property to access
	 * @return current value of the named filter if found, otherwise returns parent::__get
	 */
	public function __get($name)
	{
		if (isset($this->filters[$name]))
			return isset($this->filters[$name]['value']) ? $this->filters[$name]['value'] : NULL;
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
		if (isset($this->filters[$name]))
			$this->filters[$name]['value'] = $value;
		else
			parent::__set($name,$value);	
	}
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		$allFilters = implode(', ', array_keys($this->filters));
		return array(
			array( //validate required fields
				$allFilters . ", type",
				'required'
			),
			array(
				'emailContent', 
				'length', 'max' => 25000 // max length of an email (may need to extend this limit if the client is sending larger emails)
			),
			array(
				'emailSubject',
				'length', 'max' => 200
			),
			array(
				$allFilters, //validate the filters contain only appropriate filter values
				'in',
				'range' => array('Y','N','I'),
				'message' => 'Invalid value specified for {attribute}'
			),
			array( //validate that the type matches the current acceptable types
				'type', 'in', 'range'=>array('csv','email'), 'message' => 'Invalid value specified for desired action'
			),
			array( //validate the emailContent is set if type==email
				'type',
				'validateSelection'
			)
		);
	}
	
	/** 
	 * Perform validation on the 'type' attribute. Depending on the value there can
	 * be different validation needed (dynamic requirements). This function performs
	 * all of the conditional validation
	 */
	public function validateSelection($attribute, $params)
	{
		if ($this->type === "email")
		{
			if (empty($this->emailContent))
				$this->addError('emailContent', "An email message must be specified for the email");
			if (empty($this->emailSubject))
				$this->addError('emailSubject', "A subject must be specified for the email");
		}
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		$labels = array();
		foreach ($this->filters as $filter=>$data)
			$labels[$filter] = self::getAttributeLabel($attribute);
		return $labels;
	}
	
	public function getAttributeLabel($attribute)
	{
		return isset($this->filters[$attribute]) && isset($this->filters[$attribute]['label']) 
				? $this->filters[$attribute]['label'] 
				: parent::generateAttributeLabel($attribute);
	}
	
	/**
	 * Declares the filtering options for the mailout model
	 */
	public function getFilters()
	{
		return $this->filters;
	}
	
	private function getEmailList()
	{
		$ma = 'membership'; //membershipAlias. Truncated for brevity.
		$pa = MembershipProperties::model()->tableName(); //propertiesAlias. Truncated for brevity.
		
		$conditions = array();
		
		foreach($this->filters as $property=>$data)
		{
			if (isset($data['condition']))
			{
				$sql = '(' . str_replace(array('{membership}','{properties}'), array($ma,$pa), $data['condition']) . ')';
				switch($this->$property)
				{
					case 'N': // 'N' will have the same sql as 'Y', but with a negation operator (allow fall-through deliberately)
						$sql = "NOT {$sql}";
					case 'Y':
						$conditions[] = $sql; //append a new condition
						break;
					default: //ignore;
						break;
				}	
			}
		}
		
		// Build a Yii-compatible criteria list for the email query.
		$criteria = new CDbCriteria();
		$criteria->alias = $ma;
		$criteria->join = "LEFT JOIN {$pa} ON {$pa}.membershipId = {$ma}.membershipId";
		$criteria->select = "{$ma}.emailAddress,{$ma}.alternateEmail,{$ma}.name,{$ma}.membershipId";
		$criteria->condition = implode(" AND ", $conditions);

		return Membership::model()->findAll($criteria);
	}
	
	/**
	 * send out a batch email. Consider abstracting this to a static Email class for reuse.
	 */
	private function batchEmail()
	{
		$emailList = $this->getEmailList();
		
		$crlf = "\r\n";
		$total = 0;
		$success = 0;
		
		$rawHeaders = array (
			"From: Swedish Club of WA <mail@svenskaklubben.org.au>",
			"Reply-To: mail@svenskaklubben.org.au",
			"MIME-Version: 1.0",
			"Content-Type: text/html; charset=iso-8859-1"
		);
		$headers = implode($crlf, $rawHeaders);
		
		foreach($emailList as $record)
		{
			if (!empty($record->emailAddress) && mail($record->emailAddress, $this->emailSubject, $this->emailContent, $headers))
				$success++;
			else if (!empty($record->alternateEmail) && mail($record->alternateEmail, $this->emailSubject, $this->emailContent, $headers))
				$success++;
			$total++;
		}
	}
	
	private function generateCsv()
	{
		$emailList = $this->getEmailList();
		$doc = new CsvDocument(array("Member Name","Email Address","Alternate Email"));
		foreach($emailList as $record)
		{
			$doc->addRow(array(
				$record->name,
				$record->emailAddress,  //(!empty($record->emailAddress) ? "=HYPERLINK(\"mailto:{$record->emailAddress}\")" : ""),
				$record->alternateEmail //(!empty($record->alternateEmail) ? "=HYPERLINK(\"mailto:{$record->alternateEmail}\")" : ""),
			));
		}
		
		$filename = "svenskaklubben_maillist_" . date("d-m-Y_G-i");
		header("Content-type: application/csv");
		header("Content-Disposition: attachment; filename={$filename}.csv");
		header("Pragma: no-cache");
		header("Expires: 0");

		echo $doc->getDocument();
		exit;//Yii::app()->end(); //premature exit so the templates aren't appended to the document
	}
	
	/**
	 * Processes the current model.
	 *
	 */
	public function process()
	{
		if ($this->type == "email")
			$this->batchEmail();
		else
			$this->generateCsv();
	/*
		foreach($this->getEmailList() as $result)
		{?>
			<div style="border: 1px solid black; display: block; padding: 5px">
				<span style="display:block;"><?php echo "Email address: {$result->emailAddress}"; ?></span>
			</div>
		<?php
		}*/
	}
}
