<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>

<?php
	function show_business_plan_title($business_plan_id)
	{
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		// get the business plan name and description
		$query = "select business_name, description from business where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($business_name, $description);
		$stmt->execute();
		$stmt->fetch();
		echo "<table>";
		echo "<tr>";
		echo "<td>" . $business_name . "</td>";
		echo "</tr>";
		echo "<tr>";
		echo "<td>" . $description . "</td>";
		echo "</tr>";
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_opportunity($business_plan_id)
	{
		echo "The Opportynity<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		
		$query = "select customer_problem, problem_valildated, solution, solution_validated, current_status_of_solution from opportunity where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution);
		$stmt->execute();
		// 是不是改成while fetch？
		$stmt->fetch();
		echo "<table border='1' cellpadding='1'>";
		
		echo "<tr>";
		echo "<td>The Customer/Problem</td>" . "<td>" . $customer_problem . "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>How Validated</td>" . "<td>" . $problem_valildated . "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>The Solution</td>" . "<td>" . $solution . "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>How Validated</td>" . "<td>" . $solution_validated . "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td>The Solution</td>" . "<td>" . $current_status_of_solution . "</td>";
		echo "</tr>";
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_market($business_plan_id)
	{
		echo "The Market<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select aspect_type from market where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($aspect_type);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $aspect_type . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_team($business_plan_id)
	{
		echo "The Team<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select firstname, lastname, title, description from team_member where member_id in (select member_id from business_team_member where business_id = ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($firstname, $lastname, $title, $description);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $firstname . "</td>";
			echo "<td>" . $lastname . "</td>";
			echo "<td>" . $title . "</td>";
			echo "<td>" . $description . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_intellectual_property($business_plan_id)
	{
		echo "Sustainable Competitive Advantage/Intellectual Property<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select description from intellectual_property where intellectual_property_id in (select intellectual_property_id from business_intellectual_property where business_id = ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($description);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $description . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_competitive_analysis($business_plan_id)
	{
		echo "Competitive Analysis<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select current_behavior, our_competitive_advantage from competitive_analysis where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($current_behavior, $our_competitive_advantage);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		echo "<tr>";
		echo "<td>current_behavior</td>";
		echo "<td>our_competitive_advantage</td>";
		echo "</tr>";
		
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $current_behavior . "</td>";
			echo "<td>" . $our_competitive_advantage . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	
	function show_sales_channels($business_plan_id)
	{
		echo "Sales & Marketing Sales Channels<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select type_method from sales_channels where sales_channels_id in (select sales_channels_id from business_sales_channels where business_id = ?)";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($type_method);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $type_method . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
	
	function show_marketing_efforts($business_plan_id)
	{
		echo "Planned Marketing Efforts<br />";
		
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
		
		$query = "select effort_when, effort_description from market_effort where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		$stmt->bind_result($effort_when, $effort_description);
		$stmt->execute();
		
		echo "<table border='1' cellpadding='1'>";
		echo "<tr>";
		echo "<td>When</td>";
		echo "<td>What</td>";
		echo "</tr>";
		
		while($stmt->fetch())
		{		
			echo "<tr>";
			echo "<td>" . $effort_when . "</td>";
			echo "<td>" . $effort_description . "</td>";
			echo "</tr>";
		}
		
		echo "</table>";
		
		$stmt->close();
		$db->close();
	}
?>

<?php
	function show_business_plan_for_regular_user($business_plan_id)
	{
		show_business_plan_title($business_plan_id);
		show_opportunity($business_plan_id);
		show_market($business_plan_id);
		show_team($business_plan_id);
		show_intellectual_property($business_plan_id);
		show_competitive_analysis($business_plan_id);
		show_sales_channels($business_plan_id);
		show_marketing_efforts($business_plan_id);
	}
	
	function show_business_plan_for_admin_user($business_plan_id)
	{
		show_business_plan_title($business_plan_id);
		show_opportunity($business_plan_id);
		show_market($business_plan_id);
		show_team($business_plan_id);
		show_intellectual_property($business_plan_id);
		show_competitive_analysis($business_plan_id);
		show_sales_channels($business_plan_id);
		show_marketing_efforts($business_plan_id);
	}
	
	function is_business_plan_exists($business_plan_id)
	{
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
	
		// get the business plan name and description
		$query = "select * from business where business_id = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("i", $business_plan_id);
		
		$stmt->execute();
		// 妈个鸡，这里一fetch，什么都没了
//		$stmt->fetch();
		
		$stmt->store_result();
		
		$result = $stmt->num_rows;
				
		// close stmt?
		$stmt->close();
							
		$db->close();
		
		return $result != 0;
	}
	
	function can_user_get_access_to_business_plan($business_plan_id, $user_name)
	{
		// connect to the sever
		$db = mysqli_connect("us-cdbr-azure-central-a.cloudapp.net", "bd47aa1e0e1d87", "a0ad2f54", "dianakanderdatabase") 
			or die("Connect Error " . mysqli_error($link));
	
		// get the business plan name and description
		$query = "select * from business where business_id = ? && username = ?";
		$stmt = $db->prepare($query);
		$stmt->bind_param("is", $business_plan_id, $user_name);
		
		$stmt->execute();
//		$stmt->fetch();
		
		$stmt->store_result();
		
		$result = $stmt->num_rows;
		
		// close stmt?
		$stmt->close();
							
		$db->close();
		
		return $result != 0;
	}
?>

<?php
	
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
		// get the plan ID, and check if it is a number
		$business_plan_id = $_GET["action"];
		if(!is_numeric($business_plan_id))
			echo "Wrong business plan ID";
		else
		{
			if(!is_business_plan_exists($business_plan_id))
				echo "No such business plan";
			else
				// it is the admin user
				if($user_type == 'a')
				{
						show_business_plan_for_admin_user($business_plan_id);	
				}
				// it is the regular user
				else
				{
					// check if the user have access to the business plan
					if(can_user_get_access_to_business_plan($business_plan_id, $user_name))
						show_business_plan_for_regular_user($business_plan_id);
					else
						echo "You do not have permission to access this business plan!";
				}
		}
	}
?>
</body>
</html>