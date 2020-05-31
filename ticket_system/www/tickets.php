<?php
	$today = date("Ymd");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>New Ticket</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script>
	function getListProducts() {
		$.ajax({
		    type: 'POST',
		    url: '../manage/manage_products.php',
            data: "action=getlist",
		    success: function(data) {
		      $("#products").html(data); 
		    }
		});
	}

    $(document).ready(function(){
		$("#topic").val('');
		$("#topic").focus();

		$("#btn_add").click(function(){
			product_id = $("#products").val();
			topic = $("#topic").val();
			requester = $("#requester").val();
			tel = $("#tel").val();

            if (topic==''){
                $("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอกรายละเอียดของปัญหา !!!</span>");
			} else if (requester==''){
				$("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอก Email !!!</span>");
			} else if (tel==''){
				$("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอกเบอร์โทรศัพท์ !!!</span>");
            } else {
                $.ajax({
                    type: 'POST',
                    url: '../manage/manage_tickets.php',
                    data: "action=add&topic="+topic+"&product_id="+product_id+"&requester="+requester+"&tel="+tel,
                    success: function(data) {
						alert('ระบบได้รับแจ้งปัญหาแล้ว !!');
						window.location="index.php";
                    }
                });
            }
		});

		$("#btn_cancel").click(function(){
			window.location="index.php";
		});

		getListProducts();
	});

	$(document).ajaxComplete(function () {
        
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
	<div class="container" align="center" style="width: 50%">
		<div align="left" style="padding-left: 20%;">
			<br/><br/><br/>
			Product:
			<br/><br/>
			<select id="products">
			</select>
			<br/><br/>
			Topic:
			<br/><br/>
			<textarea id="topic" rows="10" cols="65">
			</textarea>
			<br/><br/>
			Requester:
			<br/><br/>
			<input type="text" name="requester" id="requester" placeholder="Enter Email" style="width: 400px;height: 30px;"/>
			<br/><br/>
			<input type="text" name="tel" id="tel" placeholder="Enter Telephone" style="width: 400px;height: 30px;"/>
			<br/><br/>
			<div id="label_err" align="center"></div><br/><br/>
			<input type="button" value="ADD" class="button" id="btn_add" style="width: 200px;height: 50px;"/>
			<input type="button" value="CANCEL" class="button" id="btn_cancel" style="width: 200px;height: 50px;"/>
		</div>
	</div>
</body>
</html>