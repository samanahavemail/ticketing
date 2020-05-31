<?php
    include('../controller/ProductsController.php');
    include('../controller/TicketsController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');

    $productsController = new ProductsController($host, $user, $pass, $port, $database);
    $ticketsController = new TicketsController($host, $user, $pass, $port, $database);

    $action = $_POST['action'];
    if ($action=='getdata'){
    
        $list = $productsController->getAllProducts();
        
        $i = 1;
        foreach ($list as $products) {
            $id = $products->getID();
            $name = $products->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='add') {
        $name = $_POST['name'];
        $checkName = $productsController->checkName($name);
        if($checkName){
            echo 'duplicate';
        } else {
            $id = $productsController->addProducts($name);
            $list = $productsController->getAllProducts();
        
            $i = 1;
            foreach ($list as $products) {
                $id = $products->getID();
                $name = $products->getName();

                echo '<tr class="row_data">';
                echo '<td class="row_id">'.$id.'</td>';
                echo '<td class="row_name">'.$name.'</td>';
                echo '</tr>';
            }

        }
    } else if ($action=='update') {
        $id = $_POST['id'];
        $name = $_POST['name'];

        $id = $productsController->updateProducts($id, $name);
        $list = $productsController->getAllProducts();
    
        $i = 1;
        foreach ($list as $products) {
            $id = $products->getID();
            $name = $products->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='delete') {
        $id = $_POST['id'];

        $productsController->delProducts($id);
        $list = $productsController->getAllProducts();
    
        $i = 1;
        foreach ($list as $products) {
            $id = $products->getID();
            $name = $products->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='getlist') {

        $list = $productsController->getAllProducts();

        $i = 1;
        foreach ($list as $products) {
            $id = $products->getID();
            $name = $products->getName();

            echo '<option value="'.$id.'">'.$name.'</option>';
        }

    } else if ($action=='getlistformid') {
        $ticket_id = $_POST['id'];

        $product_id = $ticketsController->getProductID($ticket_id);
        $list = $productsController->getAllProducts();

        $i = 1;
        foreach ($list as $products) {
            $id = $products->getID();
            $name = $products->getName();

            if ($id==$product_id){
                echo '<option value="'.$id.'" selected>'.$name.'</option>';
            } else {
                echo '<option value="'.$id.'">'.$name.'</option>';
            }
        }

    }
?>