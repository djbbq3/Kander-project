<?php	include "./PHP_Classes/MyUpdateBusinessPlan.php";
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
		$myUpdateBusinessPlan = new MyUpdateBusinessPlan(Hostname, DB-username, password, Database-Name);
		$myUpdateBusinessPlan->connect();
		
		$block = $_POST["block_name"];
		
		$result = false;
		switch($block)
		{
		case "business_name_description":
			$business_plan_id = $_POST["business_plan_id"];
			$new_business_plan_name =  $_POST["business_plan_name"];
			$new_business_plan_description =  $_POST["business_plan_description"];
			$result = $myUpdateBusinessPlan->update_business_plan_title($business_plan_id, $new_business_plan_name, $new_business_plan_description);
			break;
			
		case "add_new_opportunity":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_opportunity($business_plan_id);
			break;
			
		case "delete_opportunity":
			$oppotunity_id = $_POST["oppotunity_id"];
			$result = $myUpdateBusinessPlan->delete_opportunity($oppotunity_id);
			break;
			
		case "update_opportunity":
			$oppotunity_id = $_POST["oppotunity_id"];
			$customer_problem = $_POST["customer_problem"];
			$problem_valildated = $_POST["problem_valildated"];
			$solution = $_POST["solution"];
			$solution_validated= $_POST["solution_validated"];
			$current_status_of_solution= $_POST["current_status_of_solution"];
			$result = $myUpdateBusinessPlan->update_opportunity($oppotunity_id, $customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution);
			break;
			
		case "add_new_market":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_market($business_plan_id);
			break;
			
		case "delete_market":
			$market_id = $_POST["market_id"];
			$result = $myUpdateBusinessPlan->delete_market($market_id);
			break;
			
		case "update_market":
			$market_id = $_POST["market_id"];
			$aspect_type = $_POST["aspect_type"];
			$result = $myUpdateBusinessPlan->update_market($market_id, $aspect_type);
			
		case "add_new_competitive_analysis":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_competitive_analysis($business_plan_id);
			break;
			
		case "delete_competitive_analysis":
			$competitive_analysis_id = $_POST["competitive_analysis_id"];
			$result = $myUpdateBusinessPlan->delete_competitive_analysis($competitive_analysis_id);
			break;
		
		case "update_competitive_analysis":
			$competitive_analysis_id = $_POST["competitive_analysis_id"];
			$current_behavior = $_POST["current_behavior"];
			$our_competitive_advantage = $_POST["our_competitive_advantage"];
			$result = $myUpdateBusinessPlan->update_competitive_analysis($competitive_analysis_id, $current_behavior, $our_competitive_advantage);
			break;
			
		case "add_new_marketing_efforts":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_marketing_efforts($business_plan_id);
			break;
		
		case "delete_marketing_efforts":
			$effort_id = $_POST["effort_id"];
			$result = $myUpdateBusinessPlan->delete_marketing_efforts($effort_id);
			break;
		
		case "update_marketing_efforts":
			$effort_id = $_POST["effort_id"];
			$effort_when = $_POST["effort_when"];
			$effort_description = $_POST["effort_description"];
			$result = $myUpdateBusinessPlan->update_marketing_efforts($effort_id, $effort_when, $effort_description);
			break;
			
		case "add_new_funding":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_funding($business_plan_id);
			break;
			
		case "delete_funding":
			$business_id = $_POST["business_id"];
			$result = $myUpdateBusinessPlan->delete_funding($business_id);
			break;
			
		case "update_funding":
			$business_id = $_POST["business_id"];
			$amount = $_POST["amount"];
			$description = $_POST["description"];
			$result = $myUpdateBusinessPlan->update_funding($business_id, $amount, $description);
			break;
			
		case "add_new_milestones_post_funding":
			$business_plan_id = $_POST["business_plan_id"];
			$result = $myUpdateBusinessPlan->add_new_milestones_post_funding($business_plan_id);
			break;
			
		case "delete_milestones_post_funding":
			$funding_id = $_POST["funding_id"];
			$result = $myUpdateBusinessPlan->delete_milestones_post_funding($funding_id);
			break;
		
		case "update_milestones_post_funding":
			$funding_id = $_POST["funding_id"];
			$funding_when = $_POST["funding_when"];
			$funding_action = $_POST["funding_action"];
			$result = $myUpdateBusinessPlan->update_milestones_post_funding($funding_id, $funding_when, $funding_action);
		}
		
		
		$myUpdateBusinessPlan->disconnect();
		
		if($result)
			echo "Business Plan Update Successfully!";
		else
			echo "Business Plan Update Failed!";
	}
?>