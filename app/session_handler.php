<?php

class Session
{

	public $user;
	public $authenticated;
	public $userId;
	public $created;
	public $admin;

	function __construct()
	{

		session_start();

		if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
			$this->user = $_SESSION['user'];
		} else {
			$this->user = "";
		}

		if (isset($_SESSION['authenticated'])) {
			if ($_SESSION['authenticated'] == TRUE) {
				$this->authenticated = $_SESSION['authenticated'];
			} else {
				$this->authenticated = FALSE;
			}
		} else {
			$this->authenticated = FALSE;
		}

		if (isset($_SESSION['userId']) && !empty($_SESSION['userId'])) {
			$this->userId = $_SESSION['userId'];
		}

		if (isset($_SESSION['created']) && !empty($_SESSION['created'])) {
			$this->created = $_SESSION['created'];

			if (isset($_SESSION['lastAction']) && !empty($_SESSION['lastAction'])) {
				if (time() - $_SESSION['lastAction'] > 3600) {  // If the last action occured more than 1 hour ago
					$this->destruct();
				}
			}

			$_SESSION['lastAction'] = time();
		}

		if (isset($_SESSION['admin'])) {
			if ($_SESSION['admin'] == TRUE) {
				$this->admin = $_SESSION['admin'];
		 	} else {
				$this->admin = FALSE;
			}
		} else {
			$this->admin = FALSE;
		}


	}


	public function regenerateId()
	{
		session_regenerate_id();
	}

	public function destruct()
	{
		session_destroy();
	}


	public function setUser($user)
	{
		$_SESSION['user'] = $user;
	}

	public function setAuthenticated($bool)
	{
		$_SESSION['authenticated'] = $bool;
	}

	public function setUserId($userId)
	{
		$_SESSION['userId'] = $userId;
	}

	public function setCreated($time)
	{
		$_SESSION['created'] = $time;
	}

	public function setAdmin($bool)
	{
		$_SESSION['admin'] = $bool;
	}
}

?>