<?php	include "./PHP_Classes/MyBusinessPlan.php";
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
		$myBusinessPlan = new MyBusinessPlan(Hostname, DB-username, password, Database-Name);
		$myBusinessPlan->connect();
		
		// get the plan ID, and check if it is a number
		$business_plan_id = $_GET["action"];
		if(!is_numeric($business_plan_id))
			echo "Wrong business plan ID";
		else
		{
			// it is the admin user
			if($user_type == 'a')
			{
				echo "Administrator does not have permission to delete the business plan!";
			}
			// it is the regular user
			else
			{
				if(!$myBusinessPlan->is_business_plan_exists($business_plan_id))
				{
					echo "No such business plan";
				}
				else
				{
					// check if the user have access to the business plan
					if($myBusinessPlan->can_user_get_access_to_business_plan($business_plan_id, $user_name))
					{
						if($myBusinessPlan->delete_business_plan($business_plan_id))
						{
							echo "Business Plan Delete Successfully!";
						}
						else
						{
							echo "Business Plan Add Failed!";
						}
					}
					else
						echo "You do not have permission to access this business plan!";
						
					echo "Press <a href='user.php'>here to return";
				}
			}
		}
		$myBusinessPlan->disconnect();
	}
?>