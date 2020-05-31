<?php
    include('../controller/UsersController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sha_password = sha1($password);

    if ($username != '' && $password != '') {
        
        $usersController = new UsersController($host, $user, $pass, $port, $database);
        $authen = $usersController->authenUser($username, $sha_password);
        if ($authen) {    
            
            setcookie('tickets_username', $username, time()+60*60, "/", NULL);
            setcookie('tickets_password', $sha_password, time()+60*60, "/", NULL);

            echo 'success';
        
        } else {
            echo 'wrong';
        }
        
    } else {
        echo 'empty';
    }
?>