<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Business Plan</title>
<link media="all" rel="stylesheet" href="CSS/all.css">
<link href='http://fonts.googleapis.com/css?family=Open+Sans:600italic,400,700,800,600,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=News+Cycle:400,700' rel='stylesheet' type='text/css'>
<script type="text/javascript" src="js/script.js">
</script>
</head>

<body>

<?php	include "./PHP_Classes/MyBusinessPlan.php";
	
	session_start();
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]));
		$user_type = $_SESSION["user_type"];
	
	// user did not login, and come into a wrong page
	if(!isset($user_name))
	{
		echo "You did not login!";
		echo "Press here to <a href='login.php'>login!</a>";
	}
	// then the user has login
	else
	{
		// Instantiate a new class
		$myBusinessPlan = new MyBusinessPlan(Hostname, DB-username, password, Database-Name);
		$myBusinessPlan->connect();
		
		// get the plan ID, and check if it is a number
		$business_plan_id = $_GET["action"];
		if(!is_numeric($business_plan_id))
			echo "Wrong business plan ID";
		else
		{
			if(!$myBusinessPlan->is_business_plan_exists($business_plan_id))
				echo "No such business plan";
			else
				// it is the admin user
				if($user_type == 'a')
				{
					$myBusinessPlan->show_business_plan_for_admin_user($business_plan_id);	
				}
				// it is the regular user
				else
				{
					// check if the user have access to the business plan
					if($myBusinessPlan->can_user_get_access_to_business_plan($business_plan_id, $user_name))
					{
						$myBusinessPlan->show_business_plan_for_regular_user($business_plan_id);
						// print the modify and delete button
						echo "<Button onclick='modify_business_plan(\"$business_plan_id\")'>Modify business plan</button>";
					}
					else
						echo "You do not have permission to access this business plan!";
				}
		}
		$myBusinessPlan->disconnect();
	}
?>
</body>
</html>
