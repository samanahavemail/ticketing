<?php
	$today = date("Ymd");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Ticket System</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script>
    $(document).ready(function(){
        $("#login").click(function(){
			window.location="./admin/login.php";
		});

		$("#btn_new").click(function(){
			window.location="tickets.php";
		});

		$("#btn_find").click(function(){
			window.location="find.php";
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
				<td align="center" id="login" style="width: 50px;border: 0px;">
                    <img src="../image/logout.png"/>
                    <span style="font-size: 10px;">Login</span>
                </td>
			</tr>
		</table>
	</div>
	<div class="container" align="center">
        <br/><br/><br/><br/>
        <h2>WELCOME !!</h2>
        <br/><br/><br/><br/>
        <input type="button" value="NEW" class="button" id="btn_new" style="width: 300px;height: 50px;"/>
        <input type="button" value="FIND" class="button" id="btn_find" style="width: 300px;height: 50px;"/>
	</div>
</body>
</html>