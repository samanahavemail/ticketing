<?php
	
	class DB {

		function __construct($host, $user, $pass, $port, $database){
			$this->host=$host;
	      	$this->user=$user;
	      	$this->pass=$pass;
	      	$this->port=$port;
	      	$this->database=$database;
		}

		function open(){
			$conn = mysqli_connect($this->host, $this->user, $this->pass, $this->database, $this->port);
			if($conn){
				$this->conn=$conn;
			}
		}

		function close(){
			mysqli_close($this->conn);
		}

		function query($query){
			$result = mysqli_query($this->conn, $query);
			return $result;
		}

		function lastID(){
			$result = mysqli_insert_id($this->conn);
			return $result;
		}

	}

?>