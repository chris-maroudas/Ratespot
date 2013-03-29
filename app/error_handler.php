<?php

class ErrorHandler
{
	public $errorMsg;
	public $successMsg;

	public function __construct ()
	{
		$this->errorMsg = '';
	}

	public function setErrorMsg($error)
	{
		$this->errorMsg = $error;
	}

	public function setSuccessMsg($success)
	{
		$this->successMsg = $success;
	}
}

?>