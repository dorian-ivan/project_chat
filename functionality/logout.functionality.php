<?php
	if(isset($_POST['submit']))
	{
		session_start();
		session_unset();
		session_destroy(); 
		header("Location: ../layout/login.php");
		exit();
	}
?>