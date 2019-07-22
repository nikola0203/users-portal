<?php
class Database_Connection {
	
	private $host     = "localhost";
	private $database = "usersportal";
	private $username = "root";
	private $password = "root";
	
	public $connection;
	
	function get_connection() {
		$this->connection = null;

		try {
			$this->connection = new PDO( "mysql:host=" . $this->host . ";dbname=" . $this->database, $this->username, $this->password );
			$this->connection->exec( "set names utf8" );
		} catch( PDOException $exception ) {
			echo "Connection error: " . $exception->getMessage();
		}

		return $this->connection;
	}

}
?>