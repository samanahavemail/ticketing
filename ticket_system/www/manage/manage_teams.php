<?php
    include('../controller/TeamsController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');

    $teamsController = new TeamsController($host, $user, $pass, $port, $database);

    $action = $_POST['action'];
    if ($action=='getdata'){
    
        $list = $teamsController->getAllTeams();
        
        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='add') {
        $name = $_POST['name'];
        $checkName = $teamsController->checkName($name);
        if($checkName){
            echo 'duplicate';
        } else {
            $id = $teamsController->addTeams($name);
            $list = $teamsController->getAllTeams();
        
            $i = 1;
            foreach ($list as $teams) {
                $id = $teams->getID();
                $name = $teams->getName();

                echo '<tr class="row_data">';
                echo '<td class="row_id">'.$id.'</td>';
                echo '<td class="row_name">'.$name.'</td>';
                echo '</tr>';
            }

        }
    } else if ($action=='update') {
        $id = $_POST['id'];
        $name = $_POST['name'];

        $id = $teamsController->updateTeams($id, $name);
        $list = $teamsController->getAllTeams();
    
        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='delete') {
        $id = $_POST['id'];

        $teamsController->delTeams($id);
        $list = $teamsController->getAllTeams();
    
        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='getlist') {

        $list = $teamsController->getAllTeams();

        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            echo '<option value="'.$id.'">'.$name.'</option>';
        }

    } else if ($action=='getlistfromname') {
        $team_name = $_POST['name'];

        $list = $teamsController->getAllTeams();

        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            if ($name==$team_name){
                echo '<option value="'.$id.'" selected>'.$name.'</option>';
            } else {
                echo '<option value="'.$id.'">'.$name.'</option>';
            }
        }

    } else if ($action=='getlistfromid') {
        $team_id = $_POST['id'];

        $list = $teamsController->getAllTeams();

        $i = 1;
        foreach ($list as $teams) {
            $id = $teams->getID();
            $name = $teams->getName();

            if ($id==$team_id){
                echo '<option value="'.$id.'" selected>'.$name.'</option>';
            } else {
                echo '<option value="'.$id.'">'.$name.'</option>';
            }
        }

    }
?>