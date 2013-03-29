<?php
/**
Model Class, created for interaction with database, self tests
 */


class Model
{

	public $conn; // Holds PDO database connection object

	function __construct()
	{
		// Database Initilization

		try {
			$this->conn = new PDO('mysql:host=localhost;dbname=' . DBNAME, USERNAME, PASS);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Throw exceptions if an error occurs
		} catch (PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
		}

		/* Checking if our tables exist. If not, we create them. More self tests inc */
		$tables = array('users', 'reviews');
		// Move tables to a CONSTANT
		$this->checkIfTablesExist($tables);
	}

	private function checkIfTablesExist($tables) // Only used inside the class for self tests
	{
		foreach ($tables as $value) {
			$query = "SELECT * FROM $value";
			try {
				$STH = $this->conn->prepare($query); // Self tests to see if every table exists
				$STH->execute();
			} catch (PDOException $e) {
				echo 'Database Error: ' . $e->getMessage();
				$this->createTable($value);
			}
		}
	}

	private function createTable($value)
	{
		$query = "";
		// I'll create an if case, where every $value missing creates the appropriate table
		// Also inserting some placeholder data, since if tables do not exist then having them created empty will be useless
	}


	/* Database abstraction for inserting data into our database */
	// Using prepared statements, so no need for mysql escaping

	public function insert($table, $arr)
	{
		foreach (array_keys($arr) as $value) {
			$pdo_placeholders[] = ":" . $value; // Creating an array of our keys, concatenated with :
		}

		$query = "INSERT INTO " . $table . " (";
		$query .= implode(",", array_keys($arr));
		$query .= ") VALUES (";
		$query .= implode(",", $pdo_placeholders);
		$query .= ")";

		try {
			$STH = $this->conn->prepare($query);
			$STH->execute($arr); /* executing it with our array */
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}


		if (!empty($STH)) { // Not sure if correct error checking
			return TRUE;
		} else {
			return FALSE;
		}

	}

	/* Database abstraction for selecting data */
	public function select($table, $param = NULL, $limit = NULL)
	{

		if (isset($param) && is_array($param)) { // If we have a WHERE statement, for example in categories or specific reviews

			$keys = array_keys($param);
			foreach ($keys as $value) {
				$pdo_placeholders[] = ':' . $value;
			}

			if (count($param) == 1) { // If we got 1 WHERE statement
				$query = "SELECT * FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0];
			} elseif (count($param) == 2) { // If we got 2 WHERE statements
				$query = "SELECT * FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0] . " AND " . $keys[1] . " = " . $pdo_placeholders[1];
			}
			// To be expanded with 3 and 4 WHERE/AND statements. There will be enough
			// Also, consided array_key_exists('order_by'), to change the order of results

			if ($table == 'reviews' || $table == 'articles') {

				$query .= " ORDER BY date DESC";
			}


			if (!empty($limit) && is_int($limit)) { // If a Limit is given
				$query .= " LIMIT " . $limit; // just add LIMIT int
			}
		} elseif ($param == NULL) { // If we had no parameters given
			if (!empty($limit) && is_int($limit)) { // If a Limit is given
				$query = 'SELECT * FROM ' . $table;
				if ($table == 'reviews' || $table = 'articles') {
					$query .= " ORDER BY date DESC ";
				}
				$query .= " LIMIT " . $limit;
			} elseif ($limit == NULL) {
				$query = "SELECT * FROM " . $table;

				if ($table == 'reviews' || $table = 'articles') {
					$query .= " ORDER BY date DESC";
				}
			}
		}

		try {
			$STH = $this->conn->prepare($query);
			$STH->execute($param);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}

		$data = $STH->fetchAll();
		// Returning the results
		if (!empty($data) && is_array($data)) {
			return $data;
		} else {
			return FALSE;
		}
	}


	// method for abstracting update statements.
	// Accepts the table, and an array which the first element is the set column=>value and the rest are WHERE statements
	public function update($table, $param = NULL)
	{

		if (isset($param) && is_array($param)) { // If we have a WHERE statement, for example in categories or specific reviews

			$keys = array_keys($param);
			foreach ($keys as $value) {
				$pdo_placeholders[] = ':' . $value;
			}

			if (count($param) == 2) { // If we got 1 WHERE statement
				$query = "UPDATE " . $table . " SET " . $keys[0] . " = " . $pdo_placeholders[0] . " WHERE " . $keys[1] . " = " . $pdo_placeholders[1];
			} elseif (count($param) == 3) { // If we got 2 WHERE statements
				$query = "UPDATE " . $table . " SET " . $keys[0] . " = " . $pdo_placeholders[0] . " WHERE " . $keys[1] . " = " . $pdo_placeholders[1] . " AND " . $keys[2] . " = " . $pdo_placeholders[2];
			}
		}

		try {
			$STH = $this->conn->prepare($query);
			$STH->execute($param);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}

		// Returning the results
		if (!empty($STH)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	// method for abstracting delete statements. Delete is a php keyword so changed the name to remove
	// Accepts the table, and an array with the columns=>values matching the  WHERE statements
	public function remove($table, $param = NULL)
	{

		if (isset($param) && is_array($param)) { // If we have a WHERE statement, for example in categories or specific reviews

			$keys = array_keys($param);
			foreach ($keys as $value) {
				$pdo_placeholders[] = ':' . $value;
			}

			if (count($param) == 1) { // If we got 1 WHERE statement
				$query = "DELETE FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0];
			} elseif (count($param) == 2) { // If we got 2 WHERE statements
				$query = "DELETE FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0] . " AND " . $keys[1] . " = " . $pdo_placeholders[1];

			}
		}

		try {
			$STH = $this->conn->prepare($query);
			$STH->execute($param);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}

		// Returning the results
		if (!empty($STH)) {
			return TRUE;
		} else {
			return FALSE;
		}
	}


	/* checkUser(); recieves the email & password given, finds the salt of the specific user, hashes the password given
	with the selected hash, and then compares the two hashes. If they're the same, it returns the users registered name  */

	public function checkUser($param)
	{
		$arr = Array("email" => $param['email']);
		$data = $this->select("users", $arr); // Getting the details of the users account, because we need the salt

		if (!empty($data[0])) { // If the user's email is found
			extract($data[0]); // e mails are unique so only one result will be returned
			if ((crypt($param['password'], $salt)) == $password) {
				// hashing user's given password with database stored salt, and if they're the same with the hash already saved..

				return $data[0]; // if a correct password is given return the users name
			}
		}

		return FALSE; // If users email not found
	}


	public function search($table, $param = NULL, $limit = NULL)
	{

		if (isset($param) && is_array($param)) { // If we have a WHERE statement, for example in categories or specific reviews

			$keys = array_keys($param);
			foreach ($keys as $value) {
				$pdo_placeholders[] = ':' . $value;
			}

			if (!empty($param)) { // If a search query is given
				$query = "SELECT * FROM " . $table . " WHERE " . $keys[0] . " LIKE " . $pdo_placeholders[0];
			}

			if ($table == 'reviews') {
				$query .= " ORDER BY date DESC";
			}


			try {
				$STH = $this->conn->prepare($query);
				$STH->execute($param);
			} catch (PDOException $e) {
				echo 'Error: ' . $e->getMessage();
			}

			// Returning the results
			$data = $STH->fetchAll();
			if (!empty($data) && is_array($data)) {
				return $data;
			}
		}

		return FALSE;
	}


	public function sidebarData($table, $param = NULL, $limit = NULL)
	{

		if (isset($param) && is_array($param)) { // If we have a WHERE statement, for example in categories or specific reviews

			$keys = array_keys($param);
			foreach ($keys as $value) {
				$pdo_placeholders[] = ':' . $value;
			}

			if (count($param) == 1) { // If we got 1 WHERE statement
				$query = "SELECT * FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0];
			} elseif (count($param) == 2) { // If we got 2 WHERE statements
				$query = "SELECT * FROM " . $table . " WHERE " . $keys[0] . " = " . $pdo_placeholders[0] . " AND " . $keys[1] . " = " . $pdo_placeholders[1];
			}
			// To be expanded with 3 and 4 WHERE/AND statements. There will be enough
			// Also, consided array_key_exists('order_by'), to change the order of results

			if ($table == 'reviews') {

				$query .= " ORDER BY rating DESC";
			}


			if (!empty($limit) && is_int($limit)) { // If a Limit is given
				$query .= " LIMIT " . $limit; // just add LIMIT int
			}
		} elseif ($param == NULL) { // If we had no parameters given
			if (!empty($limit) && is_int($limit)) { // If a Limit is given
				$query = 'SELECT * FROM ' . $table;
				if ($table == 'reviews') {
					$query .= " ORDER BY rating DESC ";
				}
				$query .= " LIMIT " . $limit;
			} elseif ($limit == NULL) {
				$query = "SELECT * FROM " . $table;

				if ($table == 'reviews' || $table = 'articles') {
					$query .= " ORDER BY date DESC";
				}
			}
		}

		try {
			$STH = $this->conn->prepare($query);
			$STH->execute($param);
		} catch (PDOException $e) {
			echo 'Error: ' . $e->getMessage();
		}

		// Returning the results
		$data = $STH->fetchAll();

		if (!empty($data) && is_array($data)) {
			return $data;
		} else {
			return FALSE;
		}
	}


}