<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin</title>
<style type="text/css">
body {
	background-color: #00CCFF;
}
</style>
</head>

<body>
<?php	include "./PHP_Classes/Manage.php";
	session_start();
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
	   $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	   header('Location: ' . $url);
	    //exit;
	}
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]))
		$user_type = $_SESSION["user_type"];
		
	if(isset($user_name))
	{
		// check if it is regular user
		if($user_type == "a")
		{
			echo "<table width='100%' align='center'>";
  			echo "<tr>";
  	 	 	echo "<td align='right' style='color: #C15BAF; font-size: 24px;'>Welcome Admin! Press here to <a href='logout.php'>logout!</a></td>";
  			echo "</tr>";
			echo "</table>";
			
			
			$manage = new Manage(Hostname, DB-username, password, Database-Name);
			$manage->connect();
			
			$manage->show_users();
			$manage->get_user_name();
			$manage->show_user_business_plan_information();
			
			$manage->disconnect();
			echo "<a href='register.php'>Register a New user</a>";			
		}
		// check if it is admin user
		else
			if($user_type == "r")
				header("location: user.php");
			else
				echo "Login in error";
	}
	else
	{
		echo "Please enter username and password to login<br />";
		echo "Press here to <a href='index.php?'>HomePage!</a>";
	}
?>
</body>
</html>
