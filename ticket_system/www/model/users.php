<?php
	class Users {

		function __construct($id, $username, $password, $email, $team_id, $superadmin){
			$this->id=$id;
			$this->username=$username;
            $this->password=$password;
            $this->email=$email;
            $this->team_id=$team_id;
            $this->superadmin=$superadmin;
		}

		function getID(){
			return $this->id;
		}

		function getUsername(){
			return $this->username;
		}

		function getPassword(){
			return $this->password;
		}

		function getEmail(){
			return $this->email;
		}

		function getTeamID(){
			return $this->team_id;
        }
        
        function getSuperadmin(){
            return $this->superadmin;
        }
	}
?>