<?php
/** 
 * Basic error component, sends an email to the define error email
 * @author Jason Larke
 */
class ErrorComponent extends CApplicationComponent
{
	public $errorEmail;
	public $stackTrace;
	
	public function report($msg, $title="")
	{
		// most of this code is stolen from Yii's "log" function.	
		if (YII_TRACE_LEVEL > 0 && $this->stackTrace)
		{
			$backtrace = debug_backtrace();
			$level = 0;
			foreach($backtrace as $trace)
			{
				if(isset($trace['file'],$trace['line']) && strpos($trace['file'],YII_PATH)!==0)
				{
					$msg .= "\nin {$trace['file']} ({$trace['line']})";
					if(++$level>=YII_TRACE_LEVEL)
						break;
				} 
			}
		}
		
		var_dump($msg);
		@mail($this->errorEmail, "Application Error: {$title}", $msg);
	}
}

?>