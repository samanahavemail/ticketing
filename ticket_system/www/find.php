<?php
	$today = date("Ymd");
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Search Tickets</title>
</head>
<link rel="stylesheet" href="../css/style.css"/>
<script src="../js/jquery-1.10.2.min.js"></script>
<script>
	function clearFind(){
		$("#requester").val('');
		$("#label_err").html("");
	}

    $(document).ready(function(){
		$(".fl-table").hide();

		$("#btn_cancel").click(function(){
			window.location="index.php";
		});

		$("#btn_find").click(function(){
			requester = $("#requester").val();
			if (requester==''){
				$("#label_err").css('display', 'inline', 'important');
				$("#label_err").html("<span style='color:red;'>กรุณากรอก Email หรือเบอร์โทรศัพท์ !!!</span>");
			} else {
				$.ajax({
                    type: 'POST',
                    url: '../manage/manage_tickets.php',
                    data: "action=find&requester="+requester,
                    success: function(data) {
                        $("#data").html(data); 
                    }
                });
				clearFind();
				$(".fl-table").show();
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
				<td align="center"></td>
			</tr>
		</table>
	</div>
	<div class="container" align="center">
		<div align="center" style="width: 50%">
			<div align="left" style="padding-left: 20%;">
				<br/><br/>
				Requester:
				<br/>
				<br/>
				<input type="text" name="requester" id="requester" placeholder="Enter Email or Tel" style="width: 400px;height: 30px;"/>
				<input type="button" value="FIND" class="button" id="btn_find" style="height: 30px;"/>
				<input type="button" value="CANCEL" class="button" id="btn_cancel" style="height: 30px;"/>
				<br/>
				<div id="label_err" align="center"></div>
			</div>
		</div>
		<br/><br/>
		<div align="center" style="width: 80%">
			<table class="fl-table" width="100%">
				<thead>
					<tr>
						<th width="10%">ID</th>
						<th width="45%">Topic</th>
						<th width="15%">Date</th>
						<th width="15%">Status</th>
						<th width="15%">Assign</th>
					</tr>
				</thead>
				<tbody id="data">
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>