<?php
    include('../controller/CategoriesController.php');
    include('../controller/TicketsController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');

    $categoriesController = new CategoriesController($host, $user, $pass, $port, $database);
    $ticketsController = new TicketsController($host, $user, $pass, $port, $database);

    $action = $_POST['action'];
    if ($action=='getdata'){
        $product_id = $_POST['product_id'];
        $list = $categoriesController->getAllCategoriesWithProductID($product_id);
        
        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='add') {
        $product_id = $_POST['product_id'];
        $name = $_POST['name'];
        $checkName = $categoriesController->checkNameWithProductID($name,$product_id);
        if($checkName){
            echo 'duplicate';
        } else {
            $id = $categoriesController->addCategoriesWithProductID($name,$product_id);
            $list = $categoriesController->getAllCategoriesWithProductID($product_id);
        
            $i = 1;
            foreach ($list as $categories) {
                $id = $categories->getID();
                $name = $categories->getName();

                echo '<tr class="row_data">';
                echo '<td class="row_id">'.$id.'</td>';
                echo '<td class="row_name">'.$name.'</td>';
                echo '</tr>';
            }

        }
    } else if ($action=='update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $product_id = $_POST['product_id'];

        $id = $categoriesController->updateCategoriesWithProductID($id, $name, $product_id);
        $list = $categoriesController->getAllCategoriesWithProductID($product_id);
    
        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='delete') {
        $id = $_POST['id'];
        $product_id = $_POST['product_id'];

        $categoriesController->delCategories($id);
        $list = $categoriesController->getAllCategoriesWithProductID($product_id);
    
        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            echo '<tr class="row_data">';
            echo '<td class="row_id">'.$id.'</td>';
            echo '<td class="row_name">'.$name.'</td>';
            echo '</tr>';
        }

    } else if ($action=='getlist') {

        $list = $categoriesController->getAllCategories();

        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            echo '<option value="'.$id.'">'.$name.'</option>';
        }

    } else if ($action=='getlistformid') {
        $ticket_id = $_POST['id'];

        $product_id = $ticketsController->getProductID($ticket_id);
        $category_id = $ticketsController->getCategoryID($ticket_id);
        $list = $categoriesController->getAllCategoriesWithProductID($product_id);

        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            if ($category_id!='0'&&$id==$category_id){
                echo '<option value="'.$id.'" selected>'.$name.'</option>';
            } else {
                echo '<option value="'.$id.'">'.$name.'</option>';
            }
        }

    } else if ($action=='getlistformproductid') {
        $product_id = $_POST['product_id'];

        $list = $categoriesController->getAllCategoriesWithProductID($product_id);

        $i = 1;
        foreach ($list as $categories) {
            $id = $categories->getID();
            $name = $categories->getName();

            echo '<option value="'.$id.'">'.$name.'</option>';
        }

    }
?>