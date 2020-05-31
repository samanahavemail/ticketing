<?php
	include('../controller/UsersController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');
    include('../manage/manage_cookie.php');

    $usersController = new UsersController($host, $user, $pass, $port, $database);
    $username = $_COOKIE['tickets_username'];
    $team_id = $usersController->getTeamID($username);
    echo '<input type="hidden" name="team_id" id="team_id" value="'.$team_id.'">';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Admin - Home</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script src="../js/jquery.cookie.js"></script>

<script>
    function update() {
        team_id = $("#team_id").val();
        status = $("#status").val();
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_tickets.php',
            data: "action=getdata&team_id="+team_id+"&status="+status,
		    success: function(data) {
		      $("#data").html(data); 
              window.setTimeout(update, 10000);
		    }
		});
	}

    function getListStatus(status) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_tickets.php',
            data: "action=getliststatus&status="+status,
		    success: function(data) {
		      $("#status_update").html(data);
		    }
		});
	}

    function getListTeamID(team_id) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_teams.php',
            data: "action=getlistfromid&id="+team_id,
		    success: function(data) {
		      $("#teams").html(data);
		    }
		});
	}

    function getListTeamName(team_name) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_teams.php',
            data: "action=getlistfromname&name="+team_name,
		    success: function(data) {
		      $("#teams").html(data);
		    }
		});
	}

    function getListProducts(ticket_id) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_products.php',
            data: "action=getlistformid&id="+ticket_id,
		    success: function(data) {
		      $("#products").html(data); 
		    }
		});
	}

    function getListCategories(ticket_id) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_categories.php',
            data: "action=getlistformid&id="+ticket_id,
		    success: function(data) {
		      $("#categories").html(data); 
		    }
		});
	}

    function getListCategoriesByProductID(product_id) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_categories.php',
            data: "action=getlistformproductid&product_id="+product_id,
		    success: function(data) {
		      $("#categories").html(data); 
		    }
		});
	}

    function getDescription(ticket_id) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_tickets.php',
            data: "action=getdescription&ticket_id="+ticket_id,
		    success: function(data) {
		      $("#description").val(data); 
		    }
		});
	}

	$(document).ready(function(){
        $("#update_data").hide();

		$("#logout").click(function(){
			$.removeCookie('tickets_username', { path: '/' });
			$.removeCookie('tickets_password', { path: '/' });
			window.location="../admin/login.php";
		});

        $("#status").change(function(){
			update();
		});

        $("#btn_cancel").click(function(){
            $("#update_data").hide();
			$("#view_data").show();
		});

        $("#btn_save").click(function(){
            id = $("#update_id").val();
            topic = $("#topic").val();
            description = $("#description").val();
            product_id = $("#products").val();
            category_id = $("#categories").val();
            team_id = $("#teams").val();
            status = $("#status_update").val();

            $.ajax({
                type: 'POST',
                url: '../manage/manage_tickets.php',
                data: "action=update&id="+id+"&topic="+topic+"&description="+description+"&product_id="+product_id+"&category_id="+category_id+"&team_id="+team_id+"&status="+status,
                success: function(data) {
                    update();
                }
            });

            $("#update_data").hide();
			$("#view_data").show();
            
		});

        update();
	});

    $(document).ajaxComplete(function () {
        $(".row_data").click(function(){
            $("#view_data").hide();
            $("#update_data").show();

            //get data
            id = $(this).children(".row_id").text();
            topic= $(this).children(".row_topic").text();
            status = $(this).children(".row_status").text();
            team_name = $(this).children(".row_team_name").text();
            requester = $(this).children(".row_requester").text();
            tel = $(this).children(".row_tel").text();

            //get lists
            if (team_name=='not assign'){
                team_id = $("#team_id").val();
                getListTeamID(team_id);
            } else {
                getListTeamName(team_name);
            }
            getDescription(id);
            getListProducts(id);
            getListCategories(id);
            getListStatus(status);

            //update value
            $("#update_id").val(id);
            $("#topic").val(topic);
            $("#requester").text(requester);
            $("#tel").text(tel);

            //focus
            $("#description").focus();
        });

        $("#products").change(function(){
            product_id = $("#products").val();
            getListCategoriesByProductID(product_id);
        });

    });
</script>
<body>
    <div class="topbar">
		<table class="topbar" cellspacing="0" cellpadding="0">
			<tr>
                <td align="left" style="padding: 5px;">
                    <img src="../image/ticket.png" style="width: 24px;"/>
                    <b>Ticket System</b>
                </td>
				<td align="center" id="logout" style="width: 50px;">
                    <img src="../image/logout.png"/>
                    <span style="font-size: 10px;">Logout</span>
                </td>
			</tr>
		</table>
	</div>
	<div class="container">
        <table class="container" cellspacing="0" cellpadding="0">
            <tr>
                <td align="left" style="width: 250px;vertical-align: top;background-color: #222;">
                    <div class="menunav">
                        <ul>
                            <li><a class="active" href="index.php">Home</a></li>
                            <li><a href="users.php">Users</a></li>
                            <li><a href="teams.php">Teams</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a href="reports.php">Reports</a></li>
                        </ul>
                    </div>
                </td>
                <td style="width: 80%;">
                    <div class="content" id="update_data">
                        <table cellspacing="10" cellpadding="10">
                            <tr>
                                <td>Product:</td>
                                <td>
                                    <select id="products">
                                    </select>
                                </td>
                                <td>Status:</td>
                                <td>
                                    <select id="status_update">
                                        <option value="open">open</option>
                                        <option value="progress">progress</option>
                                        <option value="close">close</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>Category:</td>
                                <td>
                                    <select id="categories">
                                    </select>
                                </td>
                                <td rowspan="2" style="vertical-align: top;">
                                    <br/>Requester:<br/><br/>Tel:</td>
                                <td rowspan="2" style="vertical-align: top;">
                                    <br/><span id="requester"></span><br/><br/><span id="tel"></span></td></td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea id="topic" rows="10" cols="78">
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">Description:</td>
                                <td colspan="2" rowspan="2" align="right">
                                    <div id="label_err" align="center"></div>
                                    <input type="hidden" id="update_id"/>
                                    <br/><br/>
                                    <input type="button" value="SAVE" class="button" id="btn_save" style="width: 200px;height: 30px;"/>
                                    <br/><br/>
                                    <input type="button" value="CANCEL" class="button" id="btn_cancel" style="width: 200px;height: 30px;"/>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <textarea id="description" rows="10" cols="78">
                                    </textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>Forward:</td>
                                <td>
                                    <select id="teams">
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                
                            </tr>
                        </table>
                    </div>
                    <div class="content" id="view_data">
                        <label for="status">Status:</label>
                        <select id="status">
                            <option value="open" selected>open</option>
                            <option value="progress">progress</option>
                            <option value="close">close</option>
                        </select>
                        <br/><br/>
                        <table class="fl-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">ID</th>
                                    <th width="35%">Topic</th>
                                    <th width="10%">Date</th>
                                    <th width="10%">Status</th>
                                    <th width="20%">Requester</th>
                                    <th width="10%">Tel</th>
                                    <th width="10%">Assign</th>
                                </tr>
                            </thead>
                            <tbody id="data">
                            </tbody>
                        </table>
                    </div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>