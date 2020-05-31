<?php
    include('../controller/TicketsController.php');
    include('../controller/TeamsController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');

    $date = date("Y-m-d");

    $ticketsController = new TicketsController($host, $user, $pass, $port, $database);
    $teamController = new TeamsController($host, $user, $pass, $port, $database);

    $action = $_POST['action'];
    if ($action=='add'){
        $product_id = $_POST['product_id'];
        $topic = $_POST['topic'];
        $requester = $_POST['requester'];
        $tel = $_POST['tel'];
        $status = 'open';
        $id = $ticketsController->addTickets($topic,$product_id,$requester,$tel,$status,$date);
        echo 'success';
    } else if ($action=='find'){
        $requester = $_POST['requester'];

        $list = $ticketsController->findTickets($requester);

        $i = 1;
        foreach ($list as $tickets) {
            $id = $tickets->getID();
            $topic = $tickets->getTopic();
            $date = $tickets->getDate();
            $status = $tickets->getStatus();
            $team_id = $tickets->getTeamID();

            if ($team_id==0){
                $team_name='not assign';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_topic">'.$topic.'</td>';
            echo '<td class="row_date">'.$date.'</td>';
            echo '<td class="row_status">'.$status.'</td>';
            echo '<td class="row_team_name">'.$team_name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='getdata'){
        $team_id = $_POST['team_id'];
        $status = $_POST['status'];

        if ($team_id=='0'){
            $list = $ticketsController->getByStatus($status);
        } else {
            $list = $ticketsController->getByStatusAndTeamID($status,$team_id);
        }

        $i = 1;
        foreach ($list as $tickets) {
            $id = $tickets->getID();
            $topic = $tickets->getTopic();
            $date = $tickets->getDate();
            $status = $tickets->getStatus();
            $requester = $tickets->getRequester();
            $tel = $tickets->getTel();
            $team_id = $tickets->getTeamID();

            if ($team_id==0){
                $team_name='not assign';
            } else {
                $team_name = $teamController->getTeamName($team_id);
            }

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_topic">'.$topic.'</td>';
            echo '<td class="row_date">'.$date.'</td>';
            echo '<td class="row_status">'.$status.'</td>';
            echo '<td class="row_requester">'.$requester.'</td>';
            echo '<td class="row_tel">'.$tel.'</td>';
            echo '<td class="row_team_name">'.$team_name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='getdescription'){
        $ticket_id = $_POST['ticket_id'];

        $description = $ticketsController->getDescription($ticket_id);
        echo $description;

    } else if ($action=='update'){
        $id = $_POST['id'];
        $topic = $_POST['topic'];
        $description = $_POST['description'];
        $product_id = $_POST['product_id'];
        $category_id = $_POST['category_id'];
        $team_id = $_POST['team_id'];
        $status = $_POST['status'];

        $id = $ticketsController->updateTickets($id,$topic,$description,$product_id,$category_id,$team_id,$status);
        echo 'success';

    } else if ($action=='getliststatus') {
        $status = $_POST['status'];

        if ($status=='open'){
            echo '<option value="open" selected>open</option>';
            echo '<option value="progress">progress</option>';
            echo '<option value="close">close</option>';
        } else if ($status=='progress'){
            echo '<option value="open">open</option>';
            echo '<option value="progress" selected>progress</option>';
            echo '<option value="close">close</option>';
        } else if ($status=='close'){
            echo '<option value="open">open</option>';
            echo '<option value="progress">progress</option>';
            echo '<option value="close" selected>close</option>';
        }

    } else if ($action=='report') {
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $list = $ticketsController->getReports($start_date,$end_date);

        $i = 1;
        foreach ($list as $report) {
            
            echo '<tr class="row_data">';
            echo '<td>'.$report['pname'].'</td>';
            echo '<td>'.$report['cname'].'</td>';
            echo '<td>'.$report['open'].'</td>';
            echo '<td>'.$report['progress'].'</td>';
            echo '<td>'.$report['close'].'</td>';
            echo '</tr>';
        }

    }
?>