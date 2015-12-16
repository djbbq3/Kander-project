<?php
	class MyShowUpdateBusinessPlan
	{
		// relative fields about database and connections
		private $m_sever;
		private $m_username;
		private $m_passward;
		private $m_database_name;
		private $m_connection;
		private $m_query;
		private $m_result;
		
		// Constructor 
		public function __construct($_sever, $_username, $_password, $_database_name)
		{
			$this->m_sever = $_sever;
			$this->m_username = $_username;
			$this->m_password = $_password;
			$this->m_database_name = $_database_name;
		}
		
		// connect to the database
		public function connect()
		{	
			// Connect the the database
			$this->m_connection = new mysqli($this->m_sever, $this->m_username, $this->m_password, $this->m_database_name); 
			// Check if it has connect successfully
			if($this->m_connection->connect_errno)
			{
				echo "Unabled to connect to the MySql Sever: " . $con->connect_errno;				
				return false;
			}
			return true;
		}
		
		// Function to set query statement
		public function set_query($_query)
		{
			$this->m_query = $_query;
		}
		
		// do query
		public function do_query()
		{
			if($this->m_result = $this->m_connection->query($this->m_query))
				return true;
			
			return false;
		}
		
		// get the query result
		public function get_result()
		{
			return $this->m_result;
		}
		
		// close the connection
		public function disconnect()
		{
			if($this->m_connection->close())
				return true;
				
			return false;
		}
		
		public function show_update_business_plan_title($business_plan_id)
		{
			// get the business plan name and description
			$query = "select business_name, description from business where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($business_name, $description);
			$stmt->execute();
			$stmt->fetch();
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<table>";
			
			echo "<tr>";
			echo "<td>Business Plan Name</td>";
			echo "<td><input type='text' name='business_plan_name' value='$business_name'/></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td>Description</td>";
			echo "<td><textarea type='text' name='business_plan_description' cols='45' rows='5'>$description</textarea></td>";
			echo "</tr>";
			
			echo "<tr>";
			echo "<td><input type='submit' value='Save Current Block' /></td>";
			echo "</tr>";
			
			echo "</table>";
			
			echo "<input type='hidden' name='block_name' value='business_name_description'/>";
			
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			
			echo "</form>";
		
			$stmt->close();
		}
	
		public function show_update_opportunity($business_plan_id)
		{
			echo "The Opportunity<br />";
			
			// add new opportunity
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<input type='hidden' name='block_name' value='add_new_opportunity'/>";
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			echo "<input type='submit' value='Add New Opportunity' />";
			echo "</form>";
		
			$query = "select opportunity_id, customer_problem, problem_valildated, solution, solution_validated, current_status_of_solution from opportunity where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($oppotunity_id, $customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution);
			$stmt->execute();
			// 是不是改成while fetch？
			while($stmt->fetch())
			{
				echo "<table border='1' cellpadding='1'>";
				echo "<form action='update_business_plan.php' method='post'>";
			
			
				echo "<tr>";
				echo "<td>The Customer/Problem</td>";
				echo "<td><textarea type='text' name='customer_problem' cols='45' rows='5'>$customer_problem</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>How Customer/Problem is Validated</td>";
				echo "<td><textarea type='text' name='problem_valildated' cols='45' rows='5'>$problem_valildated</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>The Solution For the Customer/Problem</td>";
				echo "<td><textarea type='text' name='solution' cols='45' rows='5'>$solution</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>How the Solution is Validated</td>";
				echo "<td><textarea type='text' name='solution_validated' cols='45' rows='5'>$solution_validated</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>Current Status of Solution</td>";
				echo "<td><textarea type='text' name='current_status_of_solution' cols='45' rows='5'>$current_status_of_solution</textarea></td>";
				echo "</tr>";
				
				echo "<input type='hidden' name='block_name' value='update_opportunity'/>";
				echo "<input type='hidden' name='oppotunity_id' value='$oppotunity_id'/>";
								
				echo "<tr>";
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				
				echo "<td>";
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_opportunity'/>";
				echo "<input type='hidden' name='oppotunity_id' value='$oppotunity_id'/>";
				echo "<input type='submit' value='Delete This Opportunity' />";
				echo "</form>";
				echo "</td>";
						
				echo "</tr>";
				echo "</table>";
				
			}
			$stmt->close();
		}
	
		public function show_update_market($business_plan_id)
		{
			echo "The Market<br />";
			
			// add new market
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<input type='hidden' name='block_name' value='add_new_market'/>";
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			echo "<input type='submit' value='Add New Market' />";
			echo "</form>";
			
			$query = "select market_aspect_id, aspect_type from market where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($market_id, $aspect_type);
			$stmt->execute();		
			
			while($stmt->fetch())
			{	
				echo "<table border='1' cellpadding='1'>";	
				echo "<tr>";
				echo "<td>";
				
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<textarea type='text' name='aspect_type' cols='45' rows='5'>$aspect_type</textarea>";
				echo "<input type='hidden' name='block_name' value='update_market'/>";
				echo "<input type='hidden' name='market_id' value='$market_id'/>";
				
				echo "</td>";
				echo "</tr>";
				
				echo "<tr>";
				
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				echo "<td>";
			
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_market'/>";
				echo "<input type='hidden' name='market_id' value='$market_id'/>";
				echo "<input type='submit' value='Delete This Market' />";
				echo "</form>";
								
				echo "</td>";
				echo "</tr>";
				
				echo "</table>";
			}
		
			$stmt->close();
		}
	
		public function show_update_team($business_plan_id)
		{
			echo "The Team<br />";
			
			$query = "select firstname, lastname, title, description from team_member where member_id in (select member_id from business_team_member where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
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
	}
	
		public function show_update_intellectual_property($business_plan_id)
		{
			echo "Sustainable Competitive Advantage/Intellectual Property<br />";
			
			$query = "select description from intellectual_property where intellectual_property_id in (select intellectual_property_id from business_intellectual_property where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
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
		}
	
		public function show_update_competitive_analysis($business_plan_id)
		{
			echo "Competitive Analysis<br />";
			
			// competitive_analysis
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<input type='hidden' name='block_name' value='add_new_competitive_analysis'/>";
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			echo "<input type='submit' value='Add New Competitive Analysis' />";
			echo "</form>";
			
			$query = "select competitive_analysis_id, current_behavior, our_competitive_advantage from competitive_analysis where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($competitive_analysis_id, $current_behavior, $our_competitive_advantage);
			$stmt->execute();
			

			while($stmt->fetch())
			{		
				echo "<table border='1' cellpadding='1'>";
				echo "<form action='update_business_plan.php' method='post'>";
			
			
				echo "<tr>";
				echo "<td>Current Behavior</td>";
				echo "<td><textarea type='text' name='current_behavior' cols='45' rows='5'>$current_behavior</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>Our Competitive Advantage</td>";
				echo "<td><textarea type='text' name='our_competitive_advantage' cols='45' rows='5'>$our_competitive_advantage</textarea></td>";
				echo "</tr>";
				
				
				echo "<input type='hidden' name='block_name' value='update_competitive_analysis'/>";
				echo "<input type='hidden' name='competitive_analysis_id' value='$competitive_analysis_id'/>";
								
				echo "<tr>";
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				
				echo "<td>";
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_competitive_analysis'/>";
				echo "<input type='hidden' name='competitive_analysis_id' value='$competitive_analysis_id'/>";
				echo "<input type='submit' value='Delete This Competitive Analysis' />";
				echo "</form>";
				echo "</td>";
						
				echo "</tr>";
				echo "</table>";
			}
			
			$stmt->close();
		}
	
	
		public function show_update_sales_channels($business_plan_id)
		{
			echo "Sales & Marketing Sales Channels<br />";
			
			$query = "select type_method from sales_channels where sales_channels_id in (select sales_channels_id from business_sales_channels where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
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
		}
	
		function show_update_marketing_efforts($business_plan_id)
		{
			echo "Planned Marketing Efforts<br />";
			
			// competitive_analysis
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<input type='hidden' name='block_name' value='add_new_marketing_efforts'/>";
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			echo "<input type='submit' value='Add New Marketing Efforts' />";
			echo "</form>";
			
			$query = "select effort_id, effort_when, effort_description from market_effort where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($effort_id, $effort_when, $effort_description);
			$stmt->execute();
			
			
			while($stmt->fetch())
			{		
				echo "<table border='1' cellpadding='1'>";
				echo "<form action='update_business_plan.php' method='post'>";
			
			
				echo "<tr>";
				echo "<td>When</td>";
				echo "<td><textarea type='text' name='effort_when' cols='45' rows='5'>$effort_when</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>What</td>";
				echo "<td><textarea type='text' name='effort_description' cols='45' rows='5'>$effort_description</textarea></td>";
				echo "</tr>";
				
				
				echo "<input type='hidden' name='block_name' value='update_marketing_efforts'/>";
				echo "<input type='hidden' name='effort_id' value='$effort_id'/>";
								
				echo "<tr>";
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				
				echo "<td>";
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_marketing_efforts'/>";
				echo "<input type='hidden' name='effort_id' value='$effort_id'/>";
				echo "<input type='submit' value='Delete This Marketing Efforts' />";
				echo "</form>";
				echo "</td>";
						
				echo "</tr>";
				echo "</table>";
			}
			
			$stmt->close();
		}
		
		function show_update_funding($business_plan_id)
		{
			echo "The Numbers<br />";
					
			$query = "select business_id, amount, description from funding where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($business_id, $amount, $description);
			$stmt->execute();
			
			// it can only have one funding
			if($stmt->fetch())
			{
				echo "<table border='1' cellpadding='1'>";
				echo "<form action='update_business_plan.php' method='post'>";
			
			
				echo "<tr>";
				echo "<td>Funding Needed</td>";
				echo "<td><textarea type='text' name='amount' cols='45' rows='5'>$amount</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>What the funds are for</td>";
				echo "<td><textarea type='text' name='description' cols='45' rows='5'>$description</textarea></td>";
				echo "</tr>";
				
				
				echo "<input type='hidden' name='block_name' value='update_funding'/>";
				echo "<input type='hidden' name='business_id' value='$business_id'/>";
								
				echo "<tr>";
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				
				echo "<td>";
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_funding'/>";
				echo "<input type='hidden' name='business_id' value='$business_id'/>";
				echo "<input type='submit' value='Delete Funding' />";
				echo "</form>";
				echo "</td>";
						
				echo "</tr>";
				echo "</table>";
			}
			else
			{
				// funding
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='add_new_funding'/>";
				echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
				echo "<input type='submit' value='Add New Funding' />";
				echo "</form>";
			}
			
			$stmt->close();
		}
	
		function show_update_milestones_post_funding($business_plan_id)
		{
			echo "Milestones Post Funding<br />";
			
			// milestones_post_funding
			echo "<form action='update_business_plan.php' method='post'>";
			echo "<input type='hidden' name='block_name' value='add_new_milestones_post_funding'/>";
			echo "<input type='hidden' name='business_plan_id' value='$business_plan_id'/>";
			echo "<input type='submit' value='Add New Milestones Post Funding' />";
			echo "</form>";
				
			$query = "select funding_id, funding_when, funding_action from milestone_post_funding where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($funding_id, $funding_when, $funding_action);
			$stmt->execute();
			
		
			while($stmt->fetch())
			{		
				echo "<table border='1' cellpadding='1'>";
				echo "<form action='update_business_plan.php' method='post'>";
			
			
				echo "<tr>";
				echo "<td>When</td>";
				echo "<td><textarea type='text' name='funding_when' cols='45' rows='5'>$funding_when</textarea></td>";
				echo "</tr>";
				
				echo "<tr>";
				echo "<td>What</td>";
				echo "<td><textarea type='text' name='funding_action' cols='45' rows='5'>$funding_action</textarea></td>";
				echo "</tr>";
				
				
				echo "<input type='hidden' name='block_name' value='update_milestones_post_funding'/>";
				echo "<input type='hidden' name='funding_id' value='$funding_id'/>";
								
				echo "<tr>";
				echo "<td>";
				echo "<input type='submit' value='Save Current Block' />";
				echo "</form>";
				echo "</td>";
				
				
				echo "<td>";
				echo "<form action='update_business_plan.php' method='post'>";
				echo "<input type='hidden' name='block_name' value='delete_milestones_post_funding'/>";
				echo "<input type='hidden' name='funding_id' value='$funding_id'/>";
				echo "<input type='submit' value='Delete This Milestones Post Funding' />";
				echo "</form>";
				echo "</td>";
						
				echo "</tr>";
				echo "</table>";
			}
		
		
			$stmt->close();
		}
	
		function show_update_financial_projection($business_plan_id)
		{
			echo "Financial Projection at a Glance<br />";
		
			$query = "select projection_time, amount, financial_type_name from financial_projection inner join financial_type using(financial_type_id) where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($projection_time, $amount, $financial_type_name);
			$stmt->execute();
		
			echo "<table border='1' cellpadding='1'>";
	
			while($stmt->fetch())
			{		
				echo "<tr>";
				echo "<td>" . $projection_time . "</td>";
				echo "<td>" . $amount . "</td>";
				echo "<td>" . $financial_type_name . "</td>";
				echo "</tr>";
			}
			
			echo "</table>";
		
			$stmt->close();
		}
	
		function show_update_key_partners($business_plan_id)
		{
			echo "Key Partners<br />";
			
			$query = "select partner_name, title, description from key_partners where key_partner_id in (select key_partner_id from business_key_partners where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($partner_name, $title, $description);
			$stmt->execute();
			
			echo "<table border='1' cellpadding='1'>";
			while($stmt->fetch())
			{		
				echo "<tr>";
				echo "<td>" . $partner_name . "</td>";
				echo "<td>" . $title . "</td>";
				echo "<td>" . $description . "</td>";
				echo "</tr>";
			}
		
			echo "</table>";
		
			$stmt->close();
	}
		
	
		public function show_update_business_plan_for_regular_user($business_plan_id)
		{
			$this->show_update_business_plan_title($business_plan_id);
			$this->show_update_opportunity($business_plan_id);
			$this->show_update_market($business_plan_id);
			$this->show_update_team($business_plan_id);
			$this->show_update_intellectual_property($business_plan_id);
			$this->show_update_competitive_analysis($business_plan_id);
			$this->show_update_sales_channels($business_plan_id);
			$this->show_update_marketing_efforts($business_plan_id);
			$this->show_update_funding($business_plan_id);
			$this->show_update_milestones_post_funding($business_plan_id);
			$this->show_update_financial_projection($business_plan_id);
			$this->show_update_key_partners($business_plan_id);
		}		
		
		function is_business_plan_exists($business_plan_id)
		{
			// get the business plan name and description
			$query = "select * from business where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$stmt->execute();
			// 妈个鸡，这里一fetch，什么都没了
	//		$stmt->fetch();
		
			$stmt->store_result();
			
			$result = $stmt->num_rows;
					
			// close stmt?
			$stmt->close();
		
			return $result != 0;
		}
	
		public function can_user_get_access_to_business_plan($business_plan_id, $user_name)
		{	
			// get the business plan name and description
			$query = "select * from business where business_id = ? && username = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("is", $business_plan_id, $user_name);
			
			$stmt->execute();
	//		$stmt->fetch();
		
			$stmt->store_result();
			
			$result = $stmt->num_rows;
			
			// close stmt?
			$stmt->close();
		
			return $result != 0;
		}
		
		
	}	
?>
