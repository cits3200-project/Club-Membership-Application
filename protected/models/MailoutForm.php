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
	public $attachments;
	
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
			),
			array(
				'attachments',
				'validateAttachments'
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
	 * Custom validator to ensure that all submitted attachments are valid.
	 * This can include rejecting all extensions not on a specified whitelist, 
	 * as well as files that are larger than a certain limit, etc.
	 */
	public function validateAttachments($attribute, $params)
	{
		$validExtensions = explode('|', self::getValidExtensions());
		foreach($this->$attribute as $attach)
		{
			if (($dot = strrpos($attach, '.')) !== FALSE)
			{
				$extension = strtolower(substr($attach, $dot + 1));
				if (!in_array($extension, $validExtensions))
				{
					$this->addError('attachments', 'Some of the attached files had invalid file extensions. Please only upload valid files');
					return false;
				}
			}
		}
		return true;
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
	
	public static function getValidExtensions()
	{
		return 'jpg|gif|png|bmp|jpeg|tiff|pdf|doc|docx|xls|xlsx|csv|txt';
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
	 * Send out a batch email to the current mailing list.
	 * If an email fails to send to a membership's primary email address,
	 * their alternate email address is used before declaring the email a failure.
	 * @param $sender The 'reply-to' field of the email. This can either be a string (email address) or an associative array with an email->value, name->value key pair. For more information on this parameter, see the SimpleMailer component.
	 * @return an associative array with 'count' and 'total' fields, detailing the number of successful emails and the total emails attempted, respectively.
	 */
	public function batchEmail($sender)
	{
		$total = 0;
		$success = 0;
		$mailer = Yii::app()->email;
		
		foreach($this->emailList as $record)
		{
			if (!empty($record->emailAddress) && $mailer->send(
				$record->emailAddress,
				$this->emailSubject, 
				$this->emailContent, 
				$sender,
				$this->attachments
			))
				$success++;
			else if (!empty($record->alternateEmail) && $mailer->send(
				$record->alternateEmail,
				$this->emailSubject, 
				$this->emailContent, 
				$sender,
				$this->attachments
			))
				$success++;
			$total++;
		}
		return array (
			'count' => $success,
			'total' => $total
		);
	}
	
	/**
	 * void generateCsv
	 * Generates a CSV file based on the current mailing list.
	 * The generated CSV file will contain membership names, primary and alternate email address.
	 * The CSV is immediately fed to the browser for downloading by altering the response headers.
	 */
	public function generateCsv()
	{
		$doc = new CsvDocument(array("Member Name","Email Address","Alternate Email"));
		foreach($this->emailList as $record)
		{
			$doc->addRow(array(
				$record->name,
				$record->emailAddress,  
				$record->alternateEmail
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
}
