<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UpdateBusinessPlan</title>
</head>

<body>
<?php	include "./PHP_Classes/MyShowUpdateBusinessPlan.php";
	session_start();
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]))
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
		$myShowUpdateBusinessPlan = new MyShowUpdateBusinessPlan(Hostname, DB-username, password, Database-Name);
		$myShowUpdateBusinessPlan->connect();
		
		// get the plan ID, and check if it is a number
		$business_plan_id = $_GET["action"];
		if(!is_numeric($business_plan_id))
			echo "Wrong business plan ID";
		else
		{
			// it is the admin user
			if($user_type == 'a')
			{
				echo "Administrator does not have permission to modify the business plan!";
			}
			// it is the regular user
			else
			{
				if(!$myShowUpdateBusinessPlan->is_business_plan_exists($business_plan_id))
				{
					echo "No such business plan";
				}
				else
				{
					// check if the user have access to the business plan
					if($myShowUpdateBusinessPlan->can_user_get_access_to_business_plan($business_plan_id, $user_name))
					{
						$myShowUpdateBusinessPlan->show_update_business_plan_for_regular_user($business_plan_id);
					}
					else
						echo "You do not have permission to access this business plan!";
						
					echo "Press <a href='user.php'>here to return";
				}
			}
		}
		$myShowUpdateBusinessPlan->disconnect();
	}
?>

</body>
</html>