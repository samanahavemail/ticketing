<?php
	if (isset($_COOKIE['tickets_username']) && isset($_COOKIE['tickets_password'])) {
	    
	    $usersController = new UsersController($host, $user, $pass, $port, $database);
	    $authen = $usersController->authenUser($_COOKIE['tickets_username'], $_COOKIE['tickets_password']);

	    if (!$authen) {    
	        header('Location: ../admin/login.php');
	    }
	    
	} else {
	    header('Location: ../admin/login.php');
	}
?>