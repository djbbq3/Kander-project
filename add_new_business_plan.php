<?php	include "./PHP_Classes/MyBusinessPlan.php";
	session_start();
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]))
		$user_type = $_SESSION["user_type"];
	
	// check if user has login, and the user type is regular user
	if(isset($user_name) && $user_type = "r")
	{		
		$myBusinessPlan = new MyBusinessPlan(Hostname, DB-username, password, Database-Name);
		$myBusinessPlan->connect();
		
		$result = $myBusinessPlan->add_new_business_plan($user_name);
		
		$myBusinessPlan->disconnect();
		
		if($result)
			echo "Business Plan Add Successfully!";
		else
			echo "Business Plan Add Failed!";
			
		echo "Press <a href='user.php'>here to return";
	}
?>