<?php
/** 
 * Basic error component, sends an email to the defined error email
 * optionally a stack trace can be included to a specified level.
 * @author Jason Larke
 */
class ErrorComponent extends CApplicationComponent
{
	public $errorEmail;
	public $stackTrace;
	public $traceLevel;
	
	public function report($msg, $title="")
	{
		// most of this code is stolen from Yii's "log" function.	
		if ($this->traceLevel > 0 && $this->stackTrace)
		{
			$backtrace = debug_backtrace();
			$level = 0;
			foreach($backtrace as $trace)
			{
				if(isset($trace['file'],$trace['line']) && strpos($trace['file'],YII_PATH)!==0)
				{
					$msg .= "\nin {$trace['file']} ({$trace['line']})";
					if(++$level >= $this->traceLevel)
						break;
				} 
			}
		}

		@mail($this->errorEmail, "Application Error: {$title}", $msg);
	}
}

?>