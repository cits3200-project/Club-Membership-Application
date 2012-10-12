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
	 * bool send(array, string, string, string, array)
	 * Send a basic email to a list of recipients
	 *
	 * @param $recipients an array of recipients to this email. Each array entry should be either an email address, or a key-value pair of email=>value and name=>value
	 * @param $subject Email subject string
	 * @param $body Email body string
	 * @param $fromEmail Email address of the sender
	 * @param $fromName Name of the sender.
	 * @param $attachments An array of file-paths to files that should be attached to the email
	 */
	public function send($recipients, $subject, $body, $fromEmail, $fromName='', $attachments=array())
	{
		// sanitize
		$recipients = (array)$recipients;
		$attachments = (array)$attachments;
		
		$_client = new PHPMailer();
		$_client->IsMail(); // use PHP's internal 'mail' function, for simplicity.
		
		$_client->SetFrom($fromEmail,$fromName);
		$_client->Subject = $subject;
		$_client->MsgHTML($body);
		
		foreach($recipients as $to)
			$_client->AddAddress(isset($to['email']) ? $to['email'] : $to, isset($to['name']) ? $to['name'] : '');

		foreach($attachments as $attach)
			$_client->AddAttachment($attach);
			
		var_dump($_client);
		$result = $_client->Send();
		if (!$result)
			Yii::app()->error->report("Mailing error: \n\n{$_client->ErrorInfo}", __FILE__, false);
		return $result;
	}
}
?>