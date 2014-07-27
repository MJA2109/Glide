<?php 
	session_start();
	if(!isset($_SESSION["authorized"])){
		header("location:index.php");
	}else{
		require("../templates/head.php");
		require("../templates/navigation.php");
		echo "HOME";
		echo "Congatulations you're in " . $_SESSION["adminEmail"];
		require("../templates/footer.php");
	}
?>
