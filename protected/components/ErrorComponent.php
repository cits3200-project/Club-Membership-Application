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
	/**
     * Report an error to the error email address.
     * This function will send an email to the address
     * specified by the 'errorEmail' instance variable
     * containing both the user-supplied message as well
     * as (optionally) a stack trace of where the error occurred
     *
     * @param $msg Custom message to report (i.e Database failure)
     * @param $title Essentially the 'subject' of the email
     * @param $trace whether or not to perform a stack trace (defaults to the value defined by 'stackTrace')
     */
	public function report($msg, $title="", $trace=NULL)
	{
        if ($trace === NULL)
            $trace = $this->stackTrace;
     
		// most of this code is stolen from Yii's "log" function.
        // Just unwind the stack to the desired level and log each
        // location
		if ($this->traceLevel > 0 && $trace)
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