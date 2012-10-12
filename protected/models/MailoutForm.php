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
	public $emailList;
	public $type = "email";
	
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			array(
				'emailContent', 
				'length', 'max' => 25000 // max length of an email (may need to extend this limit if the client is sending larger emails)
			),
			array(
				'emailSubject',
				'length', 'max' => 200
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
	
	public function validate($attributes=NULL, $clearErrors=true)
	{
		$parentValid = parent::validate($attributes, $clearErrors);
		if ($parentValid)
		{
			if ($this->emailList === NULL || !is_array($this->emailList) || count($this->emailList) === 0)
			{
				$this->addError('emailList', "The mailout list is empty; cannot process an empty list");
				return false;
			}
		}
		return $parentValid;
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array_merge(
			array (
				'emailSubject' => 'Email Subject',
				'emailContent' => 'Email Message',
				'type' => 'What would you like to do?'
			)
		);
	}
	
	/**
	 * send out a batch email. Consider abstracting this to a static Email class for reuse.
	 */
	private function batchEmail()
	{
		$total = 0;
		$success = 0;
		$mailer = Yii::app()->email;
		
		foreach($this->emailList as $record)
		{
			if (!empty($record->emailAddress) && $mailer->send(
				array( array('email' => $record->emailAddress, 'name' => $record->name) ),
				$this->emailSubject, 
				$this->emailContent, 
				"mail@svenskaklubben.org.au", 
				"Swedish Club of WA", 
				array(Yii::app()->baseUrl . '/docs/2012_AGM_Agenda.pdf'))
			) //mail($record->emailAddress, $this->emailSubject, $this->emailContent, $headers))
				$success++;
			else if (!empty($record->alternateEmail) && $mailer->send(
				array( array('email' => $record->alternateEmail, 'name' => $record->name) ),
				$this->emailSubject, 
				$this->emailContent, 
				"mail@svenskaklubben.org.au", 
				"Swedish Club of WA", 
				array(Yii::app()->baseUrl . '/docs/2012_AGM_Agenda.pdf'))
			)//mail($record->alternateEmail, $this->emailSubject, $this->emailContent, $headers))
				$success++;
			$total++;
		}
	}
	
	private function generateCsv()
	{
		$doc = new CsvDocument(array("Member Name","Email Address","Alternate Email"));
		foreach($this->emailList as $record)
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
		exit; //premature exit so the templates aren't appended to the document
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
	}
}
