<?php
	include('../controller/UsersController.php');
    include('../controller/DB.php');
    include('../config/config.inc.php');
    include('../manage/manage_cookie.php');

    $today = date("Y-m-d");
    echo '<input type="hidden" name="start_date" id="start_date" value="'.$today.'">';
    echo '<input type="hidden" name="end_date" id="end_date" value="'.$today.'">';
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Admin - Reports</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<link rel="stylesheet" href="../jquery-ui/jquery-ui.css">
<script src="../js/jquery-1.10.2.min.js"></script>
<script src="../js/jquery.cookie.js"></script>
<script src="../jquery-ui/jquery-ui.js"></script>
<script>
    function update() {
        start_date = $("#start_date").val();
        end_date = $("#end_date").val();
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_tickets.php',
            data: "action=report&start_date="+start_date+"&end_date="+end_date,
		    success: function(data) {
		      $("#data").html(data); 
              window.setTimeout(update, 10000);
		    }
		});
	}

	$(document).ready(function(){
        //init date = today
        start_date = $("#start_date").val();
        end_date = $("#end_date").val();
        $("#datepicker_start").val(start_date);
        $("#datepicker_end").val(end_date);

        update();

        $("#datepicker_start").datepicker({
	      //showButtonPanel: true,
	      dateFormat: 'yy-mm-dd'
	    });
        $("#datepicker_end").datepicker({
	      //showButtonPanel: true,
	      dateFormat: 'yy-mm-dd'
	    });

        $("#logout").click(function(){
			$.removeCookie('tickets_username', { path: '/' });
			$.removeCookie('tickets_password', { path: '/' });
			window.location="../admin/login.php";
		});

        $("#btn_find").click(function(){
            start_date = $("#datepicker_start").val();
            end_date = $("#datepicker_end").val();
            $("#start_date").val(start_date);
            $("#end_date").val(end_date);

			update();
            $(this).blur();
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
                            <li><a href="teams.php">Teams</a></li>
                            <li><a href="products.php">Products</a></li>
                            <li><a href="categories.php">Categories</a></li>
                            <li><a class="active" href="reports.php">Reports</a></li>
                        </ul>
                    </div>
                </td>
                <td style="width: 80%;">
                    <div class="content">
                        <div style="height: 30px;">
                            Report Date:
                            <input type="text" id="datepicker_start" style="height: 30px;">
                            to
                            <input type="text" id="datepicker_end" style="height: 30px;">
                            <input type="button" value="FIND" class="button" id="btn_find"/>
                        </div>
                        <br/><br/>
                        <table class="fl-table" width="100%">
                            <thead>
                                <tr>
                                    <th width="35%">Product</th>
                                    <th width="35%">Category</th>
                                    <th width="10%">Open</th>
                                    <th width="10%">Progress</th>
                                    <th width="10%">Close</th>
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