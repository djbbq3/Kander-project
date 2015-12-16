<?php
	class MyUpdateBusinessPlan
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
		
	
		public function update_business_plan_title($business_plan_id, $new_business_plan_name, $new_business_plan_description)
		{
			// get the business plan name and description
			$query = "update business set business_name = ?, description = ? where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("ssi", $new_business_plan_name, $new_business_plan_description, $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		
		public function add_new_opportunity($business_plan_id)
		{
			$query = "insert into opportunity (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_opportunity($oppotunity_id)
		{
			$query = "delete from opportunity where opportunity_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $oppotunity_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
	
		public function update_opportunity($oppotunity_id, $customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution)
		{		
			$query = "update opportunity set customer_problem = ?, problem_valildated = ?, solution = ? , solution_validated = ?, current_status_of_solution = ? where opportunity_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("sssssi", $customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution, $oppotunity_id);
			
			$result = $stmt->execute();
						
			$stmt->close();
			
			return $result;
		}
		
		public function add_new_market($business_plan_id)
		{
			$query = "insert into market (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_market($market_id)
		{
			$query = "delete from market where market_aspect_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $market_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
	
		public function update_market($market_id, $aspect_type)
		{			
			$query = "update market set aspect_type = ? where market_aspect_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("si", $aspect_type, $market_id);

			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;
		}
	
		public function update_team($business_plan_id)
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
	
		public function update_intellectual_property($business_plan_id)
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
		
		
		public function add_new_competitive_analysis($business_plan_id)
		{
			$query = "insert into competitive_analysis (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_competitive_analysis($competitive_analysis_id)
		{
			$query = "delete from competitive_analysis where competitive_analysis_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $competitive_analysis_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
	
		public function update_competitive_analysis($competitive_analysis_id, $current_behavior, $our_competitive_advantage)
		{
			$query = "update competitive_analysis set current_behavior = ?, our_competitive_advantage = ? where competitive_analysis_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("ssi", $current_behavior, $our_competitive_advantage, $competitive_analysis_id);

			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;

		}
	
	
		public function update_sales_channels($business_plan_id)
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
		
		public function add_new_marketing_efforts($business_plan_id)
		{
			$query = "insert into market_effort (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_marketing_efforts($effort_id)
		{
			$query = "delete from market_effort where effort_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $effort_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function update_marketing_efforts($effort_id, $effort_when, $effort_description)
		{
			$query = "update market_effort set effort_when = ?, effort_description = ? where effort_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("ssi", $effort_when, $effort_description, $effort_id);

			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;
		}
		
		public function add_new_funding($business_plan_id)
		{
			$query = "insert into funding (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_funding($business_id)
		{
			$query = "delete from funding where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function update_funding($business_id, $amount, $description)
		{
			$query = "update funding set amount = ?, description = ? where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$amount_float = floatval($amount);
			$stmt->bind_param("dsi", $amount_float, $description, $business_id);

			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;
		}
		
		public function add_new_milestones_post_funding($business_plan_id)
		{
			$query = "insert into milestone_post_funding (business_id) values (?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
		
		public function delete_milestones_post_funding($funding_id)
		{
			$query = "delete from milestone_post_funding where funding_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $funding_id);
			
			$result = $stmt->execute();
					
			$stmt->close();
			
			return $result;
		}
	
		public function update_milestones_post_funding($funding_id, $funding_when, $funding_action)
		{
			$funding_action;
			$query = "update milestone_post_funding set funding_when  = ?, funding_action = ? where funding_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("ssi", $funding_when, $funding_action, $funding_id);

			$result = $stmt->execute();
		
			$stmt->close();
			
			return $result;
			
		
		}
	
		function update_financial_projection($business_plan_id)
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
	
		function update_key_partners($business_plan_id)
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
		
	}	
?>
