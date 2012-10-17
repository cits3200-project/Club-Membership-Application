<?php
/**
 * class SimpleMailer
 * Very basic mail wrapper around PHPMailer,
 * helps to abstract some of PHPMailer's huge feature list
 * and keep the complexity as low as possible
 */
class SimpleMailer extends CApplicationComponent
{
	// PHPMailer instance
	private $_client;
	
	/**
	 * bool send(array, string, string, mixed, array)
	 * Send a basic email to a list of recipients
	 *
	 * @param $recipients an array of recipients to this email. Each array entry should be either an email address, or a key-value pair of email=>value and name=>value
	 * @param $subject Email subject string
	 * @param $body Email body string
	 * @param $from mixed, can either be a single email address or an associative array specifying both email and name keys i.e array('email'=>'admin@example.com','name'=>'Example')
	 * @param $attachments An array of file-paths to files that should be attached to the email
	 */
	public function send($recipients, $subject, $body, $from, $attachments=array())
	{
		// sanitize
		$recipients = (array)$recipients;
		$attachments = (array)$attachments;
		
		$_client = new PHPMailer();
		$_client->IsMail(); // use PHP's internal 'mail' function, for simplicity.
		
		$senderEmail = is_array($from) && !empty($from['email']) ? $from['email'] : $from;
		$senderName = is_array($from) && !empty($from['name']) ? $from['name'] : $senderEmail;
		
		$_client->SetFrom($senderEmail, $senderName);
		$_client->Subject = $subject;
		$_client->MsgHTML($body);
		
		foreach($recipients as $to)
		{
			$email = is_array($to) && !empty($to['email']) ? $to['email'] : $to;
			$name = is_array($to) && !empty($to['name']) ? $to['name'] : $email;
			$_client->AddAddress($email, $name);
		}
	
		foreach($attachments as $attach)
			$_client->AddAttachment($attach);

		$result = $_client->Send();
		if (!$result)
			Yii::app()->error->report("Mailing error: \n\n{$_client->ErrorInfo}", __FILE__, false);
		return $result;
	}
}
?>