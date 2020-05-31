<?php
	include('../model/teams.php');

	class TeamsController {

		private $table="teams";

		function __construct($host, $user, $pass, $port, $database){
			$this->db = new DB($host, $user, $pass, $port, $database);
		}

		function getAllTeams(){
			$this->db->open();
			$query = "select * from $this->table";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
                $id=$data['id'];
                $name=$data['name'];
				$teams = new Teams($id, $name);
				array_push($list, $teams);
			}
			return $list;
		}
		
		function addTeams($name){
			$this->db->open();
			$query = "insert into $this->table (name) VALUES ('$name')";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function checkName($name){
			$this->db->open();
			$query = "select * from $this->table where name = '$name'";
			$result = $this->db->query($query);
			$this->db->close();
			$row = mysqli_num_rows($result);
			if ($row > 0){
				return true;
			} else {
				return false;
			}
		}

		function updateTeams($id, $name){
			$this->db->open();
			$query = "update $this->table set name = '$name' where id = '$id'";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function delTeams($id){
			$this->db->open();
			$query = "delete from $this->table where id = $id";
			$result = $this->db->query($query);
			$this->db->close();
		}

		function getTeamName($team_id){
			$this->db->open();
			$query = "select * from $this->table where id = $team_id";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$name=$data['name'];
				return $name;
			}
		}
    }
?>