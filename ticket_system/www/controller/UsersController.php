<?php
	include('../model/users.php');

	class UsersController {

		private $table="users";

		function __construct($host, $user, $pass, $port, $database){
			$this->db = new DB($host, $user, $pass, $port, $database);
		}

		function getAllUsers(){
			$this->db->open();
			$query = "select * from $this->table";
			$result = $this->db->query($query);
			$this->db->close();
			$list = array();
			while($data = mysqli_fetch_array($result)){
				$id=$data['id'];
				$username=$data['username'];
				$password=$data['password'];
				$email=$data['email'];
                $team_id=$data['team_id'];
                $superadmin=$data['superadmin'];
				$users = new Users($id, $username, $password, $email, $team_id, $superadmin);
				array_push($list, $users);
			}
			return $list;
		}

		function getByUsername($username){
			$this->db->open();
			$query = "select * from $this->table where username = '$username'";
			$result = $this->db->query($query);
			$this->db->close();
			while($data = mysqli_fetch_array($result)){
				$id=$data['id'];
				$username=$data['username'];
				$password=$data['password'];
				$email=$data['email'];
                $team_id=$data['team_id'];
                $superadmin=$data['superadmin'];
				$users = new Users($id, $username, $password, $email, $team_id, $superadmin);
			}
			return $users;
		}

		function getByID($uid){
			$this->db->open();
			$query = "select * from $this->table where id = $id";
			$result = $this->db->query($query);
			$this->db->close();
			while($data = mysqli_fetch_array($result)){
				$id=$data['id'];
				$username=$data['username'];
				$password=$data['password'];
				$email=$data['email'];
                $team_id=$data['team_id'];
                $superadmin=$data['superadmin'];
				$users = new Users($id, $username, $password, $email, $team_id, $superadmin);
			}
			return $users;
		}

		function addUsers($username, $password, $email,$team_id, $superadmin){
			$this->db->open();
			$query = "insert into $this->table (username, password, email, team_id, superadmin) VALUES ('$username','$password','$email','$team_id','$superadmin')";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function updateUsers($id, $password){
			$this->db->open();
			$query = "update $this->table set password = '$password' where id = $id";
			$result = $this->db->query($query);
			$uid = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function updateUsersByUsername($username, $email, $team_id, $superadmin){
			$this->db->open();
			$query = "update $this->table set email = '$email', team_id = $team_id, superadmin = $superadmin where username = '$username'";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function resetUsersByUsername($username, $password, $email, $team_id, $superadmin){
			$this->db->open();
			$query = "update $this->table set password = '$password',email = '$email', team_id = $team_id, superadmin = $superadmin where username = '$username'";
			$result = $this->db->query($query);
			$id = $this->db->lastID();
			$this->db->close();
			return $id;
		}

		function delUsers($id){
			$this->db->open();
			$query = "delete from $this->table where id = $id";
			$result = $this->db->query($query);
			$this->db->close();
		}

		function delUsersByUsername($username){
			$this->db->open();
			$query = "delete from $this->table where username = '$username'";
			$result = $this->db->query($query);
			$this->db->close();
		}

		function authenUser($username, $password){
			$this->db->open();
			$query = "select * from $this->table where username = '$username' and password = '$password'";
			$result = $this->db->query($query);
			$this->db->close();
			$row = mysqli_num_rows($result);
			if ($row > 0){
				return true;
			} else {
				return false;
			}
		}

		function checkUser($username){
			$this->db->open();
			$query = "select * from $this->table where username = '$username'";
			$result = $this->db->query($query);
			$this->db->close();
			$row = mysqli_num_rows($result);
			if ($row > 0){
				return true;
			} else {
				return false;
			}
		}

		function isSuperAdmin($username){
			$this->db->open();
			$query = "select * from $this->table where username = '$username'";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$superadmin=$data['superadmin'];
				return $superadmin;
			}
		}

		function getTeamID($username){
			$this->db->open();
			$query = "select * from $this->table where username = '$username'";
			$result = $this->db->query($query);
			while($data = mysqli_fetch_array($result)){
				$team_id=$data['team_id'];
				return $team_id;
			}
		}
	}
?>