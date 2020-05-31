<?php
	include('../controller/UsersController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');
    include('../manage/manage_cookie.php');

    $usersController = new UsersController($host, $user, $pass, $port, $database);
    $username = $_COOKIE['tickets_username'];
    $isSuperAdmin = $usersController->isSuperAdmin($username);
    echo '<input type="hidden" name="isSuperAdmin" id="isSuperAdmin" value="'.$isSuperAdmin.'">';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Admin - Users</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script src="../js/jquery.cookie.js"></script>

<script>
    function update() {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_users.php',
            data: "action=getdata",
		    success: function(data) {
		      $("#data").html(data); 
		    }
		});
	}

    function getListTeams() {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_teams.php',
            data: "action=getlist",
		    success: function(data) {
		      $("#teams").html(data);
		    }
		});
	}

    function getListUpdateTeams(team_name) {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_teams.php',
            data: "action=getlistfromname&name="+team_name,
		    success: function(data) {
              $("#update_teams").html(data);
		    }
		});
	}


    function clearAdd(){
        $("#username").val('');
        $("#password1").val('');
        $("#password2").val('');
        $("#email").val('');
        $("#teams").val('');
        $("#superadmin").prop("checked", false);
        $("label_err_update").val('');
    }

    function clearUpdate(){
        $("#update_username").val('');
        $("#update_password1").val('');
        $("#update_password2").val('');
        $("#update_email").val('');
        $("#update_teams").val('');
        $("#update_superadmin").prop("checked", false);
        $("label_err_update").val('');
    }

	$(document).ready(function(){
        $("#addnew").hide();
        $("#update").hide();

        isSuperAdmin = $("#isSuperAdmin").val();
        if (isSuperAdmin=='1'){
            $("#btn_nav").show();
        } else {
            $("#btn_nav").hide();
        }

        $("#logout").click(function(){
			$.removeCookie('tickets_username', { path: '/' });
			$.removeCookie('tickets_password', { path: '/' });
			window.location="../admin/login.php";
		});

        $("#btn_new").click(function(){
            $("#addnew").show();
            $(".fl-table").hide();
            $("#btn_nav").hide();

            getListTeams();
		});

        $("#btn_cancel").click(function(){
            $("#addnew").hide();
            $(".fl-table").show();
            $("#btn_nav").show();

            clearAdd();
		});

        $("#btn_cancel_update").click(function(){
            $("#update").hide();
            $(".fl-table").show();
            $("#btn_nav").show();

            clearUpdate();
		});

        $("#btn_add").click(function(){
			username = $("#username").val();
            password1 = $("#password1").val();
            password2 = $("#password2").val();
            email = $("#email").val();
            team_id = $("#teams").val();
            superadmin = $("#superadmin").is(':checked');
            if (username==''){
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอก Username !!!</span>");
            } else if (password1=='' || password2=='') {
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอก Password !!!</span>");
            } else if (password1!=password2) {
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>password missmatch !!!</span>");
            } else if (email=='') {
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอก Email !!!</span>");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../manage/manage_users.php',
                    data: "action=add&username="+username+"&password="+password1+"&email="+email+"&team_id="+team_id+"&superadmin="+superadmin,
                    success: function(data) {
                        if (data=='duplicate'){
                            $("#label_err").css('display', 'inline', 'important');
				            $("#label_err").html("<span style='color:red;'>ชื่อนี้มีใช้งานอยู่แล้วครับ !!!</span>");
                        } else {
                            $("#data").html(data); 
                        }
                    }
                });

                $("#addnew").hide();
                $(".fl-table").show();
                $("#btn_nav").show();
                clearAdd();
            }
		});

        $("#btn_edit").click(function(){
            username = $("#update_username").val();

            reset = $("#reset").is(':checked') ? 1 : 0;
            password1 = $("#update_password1").val();
            password2 = $("#update_password2").val();

            email = $("#update_email").val();
            if(username=='admin'){
                team_id = 0;
            } else {
                team_id = $("#update_teams").val();
            }
            superadmin = $("#update_superadmin").is(':checked') ? 1 : 0;
            
            if (username==''){
                $("#label_err_update").css('display', 'inline', 'important');
				$("#label_err_update").html("<span style='color:red;'>กรุณากรอก Username !!!</span>");
            } else if (password1=='' || password2=='') {
                $("#label_err_update").css('display', 'inline', 'important');
				$("#label_err_update").html("<span style='color:red;'>กรุณากรอก Password !!!</span>");
            } else if (password1!=password2) {
                $("#label_err_update").css('display', 'inline', 'important');
				$("#label_err_update").html("<span style='color:red;'>password missmatch !!!</span>");
            } else if (email=='') {
                $("#label_err_update").css('display', 'inline', 'important');
				$("#label_err_update").html("<span style='color:red;'>กรุณากรอก Email !!!</span>");
            } else {
                if (reset) {
                    $.ajax({
                        type: 'POST',
                        url: '../manage/manage_users.php',
                        data: "action=reset&username="+username+"&password="+password1+"&email="+email+"&team_id="+team_id+"&superadmin="+superadmin,
                        success: function(data) {
                            $("#data").html(data); 
                        }
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '../manage/manage_users.php',
                        data: "action=update&username="+username+"&email="+email+"&team_id="+team_id+"&superadmin="+superadmin,
                        success: function(data) {
                            $("#data").html(data); 
                        }
                    });
                }
                $("#update").hide();
                $(".fl-table").show();
                $("#btn_nav").show();
                clearUpdate();
            }
		});

        $("#btn_delete").click(function(){
            if(username=='admin'){
                alert("User admin can't delete !!");
            } else {
                if (confirm("Are you sure?")) {
                    username = $("#update_username").val();
                    $.ajax({
                        type: 'POST',
                        url: '../manage/manage_users.php',
                        data: "action=delete&username="+username,
                        success: function(data) {
                            $("#data").html(data); 
                        }
                    });
                    $("#update").hide();
                    $(".fl-table").show();
                    $("#btn_nav").show();
                    clearUpdate();
                } else {
                    $("#update").hide();
                    $(".fl-table").show();
                    $("#btn_nav").show();
                    clearUpdate();
                }
                return false;
            }
		});

        $("#reset").change(function(){
            reset = $("#reset").is(':checked') ? 1 : 0;
            if (reset){
                $("#update_password1").prop('disabled', false);
                $("#update_password2").prop('disabled', false);
                $("#update_password1").val('');
                $("#update_password2").val('');
            } else {
                $("#update_password1").prop('disabled', true);
                $("#update_password2").prop('disabled', true);
                $("#update_password1").val('xxxxxxxx');
                $("#update_password2").val('xxxxxxxx');
            }
            
        });

        update();
	});

    $(document).ajaxComplete(function () {
        $(".row_data").click(function(){
            isSuperAdmin = $("#isSuperAdmin").val();
            if (isSuperAdmin=='1'){
                $("#update").show();
                $(".fl-table").hide();
                $("#btn_nav").hide();

                //team name
                team_name = $(this).children(".row_team").text();
                getListUpdateTeams(team_name);

                id = $(this).children(".row_id").text();
                username = $(this).children(".row_username").text();
                team_name = $(this).children(".row_team").text();
                email = $(this).children(".row_email").text();
                superadmin = $(this).children(".row_superadmin").children().is(':checked') ? 1 : 0;

                //username
                $("#update_username").val(username);
                $("#update_username").prop('disabled', true);

                $("#update_email").val(email);

                $("#update_password1").prop('disabled', true);
                $("#update_password2").prop('disabled', true);
                $("#update_password1").val('xxxxxxxx');
                $("#update_password2").val('xxxxxxxx');

                if(username=='admin'){
                    $("#update_teams").prop('disabled', true);
                    $("#update_superadmin").prop('disabled', true);
                } else {
                    $("#update_teams").prop('disabled', false);
                    $("#update_superadmin").prop('disabled', false);
                }

                if (superadmin){
                    $("#update_superadmin").prop("checked", true);
                } else {
                    $("#update_superadmin").prop("checked", false);
                }
            }

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
                            <li><a class="active" href="users.php">Users</a></li>
                            <li><a href="teams.php">Teams</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a href="reports.php">Reports</a></li>
                        </ul>
                    </div>
                </td>
                <td style="width: 80%;">
                    <div class="content">
                        <div style="height: 30px;" id="btn_nav">
                            <input type="button" value="NEW" class="button" id="btn_new"/>
                        </div>
                        <br/>
                        <div style="height: 40px;" id="addnew">
                            <table cellspacing="10" cellpadding="10">
                                <tr>
                                    <td>Username:</td>
                                    <td>
                                        <input type="text" name="username" id="username" placeholder="Enter Username" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td>
                                        <input type="password" name="password1" id="password1" placeholder="Enter Password" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Confirm Password:</td>
                                    <td>
                                        <input type="password" name="password2" id="password2" placeholder="Enter Password" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>
                                        <input type="text" name="email" id="email" placeholder="Enter Email" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department:</td>
                                    <td>
                                        <select id="teams">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SuperAdmin:</td>
                                    <td>
                                        <input type="checkbox" name="superadmin" id="superadmin" style="font-size: 30px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="button" value="ADD" class="button" id="btn_add"/>
                                        <input type="button" value="CANCEL" class="button" id="btn_cancel"/>
                                        <div id="label_err" align="center"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div style="height: 40px;" id="update">
                        <table cellspacing="10" cellpadding="10">
                                <tr>
                                    <td>Username:</td>
                                    <td>
                                        <input type="text" name="update_username" id="update_username" placeholder="Enter Username" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Reset Password:</td>
                                    <td>
                                        <input type="checkbox" name="reset" id="reset" style="font-size: 30px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Password:</td>
                                    <td>
                                        <input type="password" name="update_password1" id="update_password1" placeholder="Enter Password" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Confirm Password:</td>
                                    <td>
                                        <input type="password" name="update_password2" id="update_password2" placeholder="Enter Password" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email:</td>
                                    <td>
                                        <input type="text" name="update_email" id="update_email" placeholder="Enter Email" style="width: 400px;height: 30px;"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Department:</td>
                                    <td>
                                        <select id="update_teams">
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>SuperAdmin:</td>
                                    <td>
                                        <input type="checkbox" name="update_superadmin" id="update_superadmin" style="font-size: 30px;">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <input type="button" value="UPDATE" class="button" id="btn_edit"/>
                                        <input type="button" value="DELETE" class="button" id="btn_delete"/>
                                        <input type="button" value="CANCEL" class="button" id="btn_cancel_update"/>
                                        <div id="label_err_update" align="center"></div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <br/>
                        <table class="fl-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">ID</th>
                                    <th width="30%">Username</th>
                                    <th width="20%">Team</th>
                                    <th width="30%">Email</th>
                                    <th width="10%">SuperAdmin</th>
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