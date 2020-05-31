<?php
	include('../controller/UsersController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');
    include('../manage/manage_cookie.php');
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Admin - Teams</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script src="../js/jquery.cookie.js"></script>

<script>
    function update() {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_teams.php',
            data: "action=getdata",
		    success: function(data) {
		      $("#data").html(data); 
		    }
		});
	}

    function clearAdd(){
        $("#addnew").hide();
        $("#add_teamname").val('');
        $("#label_err").css('display', 'inline', 'important');
		$("#label_err").html("<span style='color:black;'></span>");
    }

    function clearUpdate(){
        $("#update").hide();
        $("#team_id").val('');
        $("#update_teamname").val('');
        $("#label_err_update").css('display', 'inline', 'important');
		$("#label_err_update").html("<span style='color:black;'></span>");
    }

	$(document).ready(function(){
        $("#addnew").hide();
        $("#update").hide();

        $("#logout").click(function(){
			$.removeCookie('tickets_username', { path: '/' });
			$.removeCookie('tickets_password', { path: '/' });
			window.location="../admin/login.php";
		});

        $("#btn_new").click(function(){
            clearUpdate();
			$("#addnew").show();
            $("#add_teamname").val('');
            $('#add_teamname').focus();
		});

        $("#btn_cancel").click(function(){
			clearAdd();
		});

        $("#btn_cancel_update").click(function(){
            clearUpdate();
		});

        $("#btn_add").click(function(){
			name = $("#add_teamname").val();
            if (name==''){
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอกชื่อทีม !!!</span>");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../manage/manage_teams.php',
                    data: "action=add&name="+name,
                    success: function(data) {
                        if (data=='duplicate'){
                            $("#label_err").css('display', 'inline', 'important');
				            $("#label_err").html("<span style='color:red;'>ชื่อนี้มีใช้งานอยู่แล้วครับ !!!</span>");
                        } else {
                            $("#data").html(data); 
                        }
                    }
                });
                clearAdd();
            }
		});

        $("#btn_edit").click(function(){
            id = $("#team_id").val();
			name = $("#update_teamname").val();
            if (name==''){
                $("#label_err_update").css('display', 'inline', 'important');
				$("#label_err_update").html("<span style='color:red;'>กรุณากรอกชื่อทีม !!!</span>");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../manage/manage_teams.php',
                    data: "action=update&id="+id+"&name="+name,
                    success: function(data) {
                        $("#data").html(data); 
                    }
                });
                clearUpdate();
            }
		});

        $("#btn_delete").click(function(){
            if (confirm("Are you sure?")) {
                id = $("#team_id").val();
                $.ajax({
                    type: 'POST',
                    url: '../manage/manage_teams.php',
                    data: "action=delete&id="+id,
                    success: function(data) {
                        $("#data").html(data); 
                    }
                });
                clearUpdate();
            } else {
                clearUpdate();
            }
            return false;
		});

        update();
	});

    $(document).ajaxComplete(function () {
        $(".row_data").click(function(){
            clearAdd();

            id = $(this).children(".row_id").text();
            name = $(this).children(".row_name").text();
            $("#team_id").val(id);
            $("#update_teamname").val(name);
            $("#update").show();
            $('#update_teamname').focus();
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
                            <li><a href="index.php">Home</a></li>
                            <li><a href="users.php">Users</a></li>
                            <li><a class="active" href="teams.php">Teams</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a href="reports.php">Reports</a></li>
                        </ul>
                    </div>
                </td>
                <td style="width: 80%;">
                    <div class="content">
                        <div style="height: 30px;">
                            <input type="button" value="NEW" class="button" id="btn_new"/>
                        </div>
                        <br/>
                        <div style="height: 40px;" id="addnew">
                            <span>Team Name: </span>
                            <input type="text" name="add_teamname" id="add_teamname" placeholder="Enter Team Name" style="width: 300px;height: 30px;"/>
                            <input type="button" value="ADD" class="button" id="btn_add"/>
                            <input type="button" value="CANCEL" class="button" id="btn_cancel"/>
                            <div id="label_err" align="left"></div>
                        </div>
                        <div style="height: 40px;" id="update">
                            <span>ID: </span>
                            <input type="text" name="team_id" id="team_id" value="" disabled style="width: 50px;height: 30px;background-color: #ccc;text-align: center;"/>
                            <span>Team Name: </span>
                            <input type="text" name="update_teamname" id="update_teamname" placeholder="Enter Team Name" style="width: 300px;height: 30px;"/>
                            <input type="button" value="UPDATE" class="button" id="btn_edit"/>
                            <input type="button" value="DELETE" class="button" id="btn_delete"/>
                            <input type="button" value="CANCEL" class="button" id="btn_cancel_update"/>
                            <div id="label_err_update" align="left"></div>
                        </div>
                        <br/>
                        <table class="fl-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="90%">Name</th>
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