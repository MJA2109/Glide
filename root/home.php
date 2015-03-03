<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
?>	
	<div id = "ajaxContent" class = 'home'>
	
	</div>

	<div id = "btnNotifications"><span class="glyphicon glyphicon-bell"></span>Notifications<span id = "notificationCounter"></span></div>
<?php
		require("../templates/footer.php");
	}

	//testing deployment
?>
