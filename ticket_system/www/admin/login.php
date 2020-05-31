<?php
	$today = date("Ymd");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Login</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script>
	$(document).ready(function(){
		$('#username').focus();

		 $("#login_form").submit(function(){	
			  username=$("#username").val();
			  password=$("#password").val();
			  $.ajax({
			   type: "POST",
			   url: "../manage/manage_login.php",
			   data: "username="+username+"&password="+password,
			   success: function(data){  
				if (data=='success') {
					window.location="index.php";
				} else if (data=='wrong') {
					$("#label_err").css('display', 'inline', 'important');
					$("#label_err").html("<span style='color:red;'>กรอก Username หรือ Password ไม่ถูกต้อง</span>");
				} else if (data=='empty') {
					$("#label_err").css('display', 'inline', 'important');
					$("#label_err").html("<span style='color:red;'>กรุณากรอก Username และ Password</span>");
				}
			   }
			  });
			return false;
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
				<td align="center"></td>
			</tr>
		</table>
	</div>
	<div class="container" align="center">
		<br/><br/><br/><br/>
		<div class="main_login">
			<form class="form" method="post" action="#" id="login_form">
				<h2>Login</h2>
				</br>
				<table style="width: 100%" cellspacing="10" cellpadding="10">
					<tr>
						<td align="left" style="width: 30%"><label>Username:</label></td>
						<td><input type="text" name="username" id="username" placeholder="Enter Username" style="width: 100%;height: 30px;"/></td>
					</tr>
					<tr>
						<td align="left" style="width: 30%"><label>Password:</label></td>
						<td><input type="password" name="password" id="password" placeholder="Enter Password" style="width: 100%;height: 30px;"/></td>
					</tr>
					<tr>
						<td colspan="2" align="center">
							<div id="label_err" align="center"></div></br>
							<input type="submit" name="submit" value="LOGIN" id="login"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</body>
</html>