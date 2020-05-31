<?php
    include('../controller/UsersController.php');
    include('../controller/TeamsController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');

    $usersController = new UsersController($host, $user, $pass, $port, $database);
    $teamController = new TeamsController($host, $user, $pass, $port, $database);

    $action = $_POST['action'];
    if ($action=='getdata'){
    
        $list = $usersController->getAllUsers();
        
        $i = 1;
        foreach ($list as $users) {
            $id = $users->getID();
            $username = $users->getUsername();
            $password = $users->getPassword();
            $email = $users->getEmail();
            $team_id = $users->getTeamID();
            $superadmin = $users->getSuperadmin();

            if ($team_id==0){
                $team_name='admin';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_username">'.$username.'</td>';
            echo '<td class="row_team">'.$team_name.'</td>';
            echo '<td class="row_email">'.$email.'</td>';
            if ($superadmin){
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" checked disabled></td>';
            } else {
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" disabled></td>';
            }
            echo '</tr>';
        }

    } else if ($action=='add') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $team_id = $_POST['team_id'];
        $superadmin = $_POST['superadmin'];

        $checkUser = $usersController->checkUser($username);
        if($checkUser){
            echo 'duplicate';
        } else {
            if ($superadmin){
                $superadmin = 1;
            } else {
                $superadmin = 0;
            }
            $id = $usersController->addUsers($username, sha1($password), $email, $team_id, $superadmin);
            $list = $usersController->getAllUsers();
        
            $i = 1;
            foreach ($list as $users) {
                $id = $users->getID();
                $username = $users->getUsername();
                $password = $users->getPassword();
                $email = $users->getEmail();
                $team_id = $users->getTeamID();
                $superadmin = $users->getSuperadmin();

                if ($team_id==0){
                    $team_name='admin';
                } else {
                    $team_name = $teamController->getTeamName($team_id);
                }

                echo '<tr class="row_data">';
                echo '<td class="row_id">'.$id.'</td>';
                echo '<td class="row_username">'.$username.'</td>';
                echo '<td class="row_team">'.$team_name.'</td>';
                echo '<td class="row_email">'.$email.'</td>';
                if ($superadmin){
                    echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" checked disabled></td>';
                } else {
                    echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" disabled></td>';
                }
                echo '</tr>';
            }

        }
    } else if ($action=='update') {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $team_id = $_POST['team_id'];
        $superadmin = $_POST['superadmin'];

        $id = $usersController->updateUsersByUsername($username, $email, $team_id, $superadmin);
        $list = $usersController->getAllUsers();
    
        $i = 1;
        foreach ($list as $users) {
            $id = $users->getID();
            $username = $users->getUsername();
            $password = $users->getPassword();
            $email = $users->getEmail();
            $team_id = $users->getTeamID();
            $superadmin = $users->getSuperadmin();

            if ($team_id==0){
                $team_name='admin';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_username">'.$username.'</td>';
            echo '<td class="row_team">'.$team_name.'</td>';
            echo '<td class="row_email">'.$email.'</td>';
            if ($superadmin){
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" checked disabled></td>';
            } else {
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" disabled></td>';
            }
            echo '</tr>';
        }

    } else if ($action=='reset') {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $team_id = $_POST['team_id'];
        $superadmin = $_POST['superadmin'];

        $id = $usersController->resetUsersByUsername($username, sha1($password), $email, $team_id, $superadmin);
        $list = $usersController->getAllUsers();
    
        $i = 1;
        foreach ($list as $users) {
            $id = $users->getID();
            $username = $users->getUsername();
            $password = $users->getPassword();
            $email = $users->getEmail();
            $team_id = $users->getTeamID();
            $superadmin = $users->getSuperadmin();

            if ($team_id==0){
                $team_name='admin';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_username">'.$username.'</td>';
            echo '<td class="row_team">'.$team_name.'</td>';
            echo '<td class="row_email">'.$email.'</td>';
            if ($superadmin){
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" checked disabled></td>';
            } else {
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" disabled></td>';
            }
            echo '</tr>';
        }

    } else if ($action=='delete') {
        $username = $_POST['username'];

        $usersController->delUsersByUsername($username);
        $list = $usersController->getAllUsers();
    
        $i = 1;
        foreach ($list as $users) {
            $id = $users->getID();
            $username = $users->getUsername();
            $password = $users->getPassword();
            $email = $users->getEmail();
            $team_id = $users->getTeamID();
            $superadmin = $users->getSuperadmin();

            if ($team_id==0){
                $team_name='admin';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_username">'.$username.'</td>';
            echo '<td class="row_team">'.$team_name.'</td>';
            echo '<td class="row_email">'.$email.'</td>';
            if ($superadmin){
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" checked disabled></td>';
            } else {
                echo '<td class="row_superadmin"><input type="checkbox" name="superadmin" disabled></td>';
            }
            echo '</tr>';
        }

    }
?>