<?php
	class MyBusinessPlan
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
		
		public function show_business_plan_title($business_plan_id)
		{
			// get the business plan name and description
			$query = "select business_name, description from business where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($business_name, $description);
			$stmt->execute();
			$stmt->fetch();
			echo "<div id='wrapper'>";
			echo "<header id='header'>";
			echo "<div class='logo'><a href='#'><img src='./images/logo.png' alt='logo'></a></div>";
			echo "<div class='holder'>";
			echo "<h1>" . $business_name . "</h1>";
			
			echo "<p>" . $description . "</p>";
			
			echo "</div>";
			echo "</header>";
		
			$stmt->close();
		}
	
		public function show_opportunity($business_plan_id)
		{
			echo "<main id='main' role='main'>";
			echo "<section class='widget opportunity-widget'>";
			echo "<header class='header'>";
			echo "<h2>The Opportunity</h2>";
			echo "</header>";
			
		
			$query = "select customer_problem, problem_valildated, solution, solution_validated, current_status_of_solution from opportunity where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($customer_problem, $problem_valildated, $solution, $solution_validated, $current_status_of_solution);
			$stmt->execute();
			// 是不是改成while fetch？
			while($stmt->fetch())
			{
			
			
			echo "<div class='holder'>";
			echo "<div class='frame'>";
			echo "<div class='col'>";
			echo "<h3>The Customer/Problem</h3>";
			echo "<p>" . $customer_problem . "</p>";
			echo "</div>";
		
			
			
			echo "<div class='col'>";
			echo "<h3>How Validated</h3>";
			echo "<p>" . $problem_valildated . "</p>";
			echo "</div>";
			echo "</div>"; //end div for div frame line 108
			
			
			echo "<div class='frame'>";
			echo "<div class='col'>";
			echo "<h3>The Solution</h3>";
			echo "<p>" . $solution . "</p>";
			
			echo "<h3>Current Status of Solution</h3>";
			echo "<p>" . $current_status_of_solution . "</p>";
			echo "</div>";
			
			echo "<div class='col'>";
			echo "<h3>How Validated</h3>";
			echo "<p>" . $solution_validated . "</p>";
			echo "</div>";
			echo "</div>";// end div for div frame line123
			echo "</div>";//end div for holder line 107
			}
			echo "</section>";
			
			$stmt->close();
		}
	
		public function show_market($business_plan_id)
		{
			
			
			$query = "select aspect_type from market where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($aspect_type);
			$stmt->execute();
			
			
			echo "<aside class='aside'>";
			echo "<section class='widget'>";
			echo "<header class='header'>";
			echo "<h2>The Market</h2>";
			echo "</header>";
			
			while($stmt->fetch())
			{		
				echo "<p> $aspect_type </p>";			
			}
		    
			echo "</section>"; 
			$stmt->close();
		}
	
		public function show_team($business_plan_id)
		{
			echo "<section class='widget teem-widget'>";
			echo "<header class='header'>";
			echo "<h2>The Team</h2>";
			echo "</header>";
			
			$query = "select firstname, lastname, title, description from team_member where member_id in (select member_id from business_team_member where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($firstname, $lastname, $title, $description);
			$stmt->execute();
			
			while($stmt->fetch())
			{		
				echo "<article class='post'>";
				echo "<div class='img-box'>";
				echo "<a href='#'><img src='images/team-img1.jpg' height='71' width='70' alt='image description'></a>";
				echo "</div>";
				echo "<div class='text-boxt'>";
				echo "<h3><a href='#'>$firstname $lastname</a></h3>";
				echo "<h4>" . $title . "</h4>";
				echo "<p>". $description . "</p>";
				echo "</div>";
				echo "</article>";
			}
			$stmt->close();
			
			echo "</section>";
			echo "</aside>";
			
	}
	
	
	
	
	
		public function show_intellectual_property($business_plan_id)
		{
			
			echo "<section class='widget adv-detail'>";
			echo "<h2>Sustainable Competitive Advantage/Intellectual Property</h2>";
			echo "<strong></strong>"; //???
		
			
			$query = "select description from intellectual_property where intellectual_property_id in (select intellectual_property_id from business_intellectual_property where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($description);
			$stmt->execute();
			
			echo "<ul class='list-detail'>";
			while($stmt->fetch())
			{		
				
				echo "<li>" . $description . "</li>";
				
			}
			echo "</ul>";
			echo "</section>";
			$stmt->close();
		}
	
		public function show_competitive_analysis($business_plan_id)
		{
			echo "<section class='widget competitive-widget'>";
			echo "<header class='header'>";
			echo "<h2>Competitive Analysis</h2>";
			echo "</header>";
			
			$query = "select current_behavior, our_competitive_advantage from competitive_analysis where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($current_behavior, $our_competitive_advantage);
			$stmt->execute();
			
			
			echo "<div class='table'>";
			echo "<table class='index-table'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th class='col-1'>Current Behavior</th>";
			echo "<th class='col-2'>Our Competitive Advantage</th>";
			echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			
			while($stmt->fetch())
			{		
			
				
				echo "<tr>";
				echo "<td class='col-1'>" . $current_behavior . "</td>";
				echo "<td class='col-2'>" . $our_competitive_advantage . "</td>";
				echo "</tr>";
				
			}
			echo "</tbody>";
			echo "</table>";
			echo "</div>";
			echo "</section>";
			
			$stmt->close();
		}
	
	
		public function show_sales_channels($business_plan_id)
		{
			echo "<section class='widget planned-widget'>";
			echo "<header class='header purpal'><h2>Planned Marketing Efforts</h2></header>";
			echo "<div class='planned-holder'>";
			echo "<div class='col'>";
			echo "<div class='heading'>";
			echo "<h2>Sales &amp; Marketing Sales Channels</h2>";
			echo "</div>";
			
			$query = "select type_method from sales_channels where sales_channels_id in (select sales_channels_id from business_sales_channels where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($type_method);
			$stmt->execute();
			
			echo "<div class='hold'>";
			
			while($stmt->fetch())
			{		
				echo "<div class='sapphire-circle'>";
				echo "<p>" . $type_method . "</p>";
				echo "</div>";
			}
			
			echo "</div>";
			echo "</div>";
			
			$stmt->close();
		}
	
		function show_marketing_efforts($business_plan_id)
		{
			
			
			
			$query = "select effort_when, effort_description from market_effort where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($effort_when, $effort_description);
			$stmt->execute();
			
			echo "<div class='table'>";
			echo "<table class='index-table'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th class='col-1'>When</th>";
			echo "<th class='col-2'>What</th>";
			echo "</tr>";
			echo "</thead>";
			
			echo "<tbody>";
			
			while($stmt->fetch())
			{		
				echo "<tr>";
				echo "<td class='col-1'>" . $effort_when . "</td>";
				echo "<td class='col-2'>" . $effort_description . "</td>";
				echo "</tr>";
			}
			echo "</tbody>";
			
			echo "</table>";
			echo "</div>";
			echo "</section>";
			$stmt->close();
			echo "</div>";
		}
			
			
		
		function show_funding($business_plan_id)
		{
			echo "<section class='widget milestones-widget'>";
			echo "<header class='header blue'><h2>The Numbers</h2></header>";
					
			$query = "select amount, description from funding where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($amount, $description);
			$stmt->execute();
			$stmt->fetch();
			
			
			
			echo "<div class='milestones-holder'>";
			echo "<div class='col'>";
			echo "<div class='info-text'>";
			echo "<p>Funding Needed: <strong>'$amount'</strong></p>";
			echo "</div>";
			
			$stmt->close();
		}
	
		function show_milestones_post_funding($business_plan_id)
		{
			echo "<div class='header'>";
			echo "<h2>Milestones Post Funding</h2>";
			echo "</div>";
				
			$query = "select funding_when, funding_action from milestone_post_funding where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($funding_when, $action);
			$stmt->execute();
			
			echo "<div class='table'>";
			echo "<table class='index-table'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th class='col-1'>When</th>";
			echo "<th class='col-2'>What</th>";
			echo "</tr>";
			echo "</thead>";
		
			while($stmt->fetch())
			{		
				echo "<tr>";
				echo "<td class='col-1'>" . $funding_when . "</td>";
				echo "<td class='col-2'>" . $action . "</td>";
				echo "</tr>";
			}
		
			echo "</table>";
			echo "</div>";
			echo "</div>";
		
			$stmt->close();
		}
	
		function show_financial_projection($business_plan_id)
		{
			echo "<article class='col'>";
			echo "<p>We will use these funds to cover the operational costs during launch, while also providing capital for future R&amp;D. These intial funds will allow ShotTracker&reg; to place the product in the hands of prominent coaches and teams and establish a full-scale manufacturing contract with suppliers.</p>";
			
			echo "<div class='graph-holder'>";
			echo "<h3>Financial Projections at a Glance</h3>";
			echo "<img src='images/graph.png' height='271' width='445' alt='image description'>";
			echo "</div>";
		
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
			
			echo "<section class='strategy-block'>";
			echo "<div class='heading'>";
			echo "<p>Likely Acquistion Amount <strong>$200 Million</strong></p>";
			echo "</div>";
			echo "<div class='heading-wrap'>";
			echo "<h2>Exit Strategy</h2>";
			echo "</div>";
			echo "<p>ShotTracker&reg;’s exist strategy is to sell the business to a large partner after obtaining enough market share. We anticipate potential acquirers to be Nike, Addidas, Under Armour or Reebok. </p>";
			
			echo "</section>";
		    echo "</article>";
			echo "</div>";
			$stmt->close();
		}
	
		function show_key_partners($business_plan_id)
		{
			echo "<section class='widget partners-widget'>";
			echo "<header class='header'><h2>Key Partners</h2></header>";
			
			$query = "select partner_name, title, description from key_partners where key_partner_id in (select key_partner_id from business_key_partners where business_id = ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			$stmt->bind_result($partner_name, $title, $description);
			$stmt->execute();
			
			echo "<div class='hold'>";
			echo "<article class='column'>";
			while($stmt->fetch())
			{	echo "<td>";	
				echo "<h3>" . $partner_name . "</h3>";
				echo "<h4>" . $title . "</h4>";
				echo "<p>" . $description . "</p>";
				echo "</td>";
			}
		    echo "</article>";
			echo "</div>";
			$stmt->close();
			echo "</div>";// div for wrapper line 75
	}
		
	
		public function show_business_plan_for_regular_user($business_plan_id)
		{
			$this->show_business_plan_title($business_plan_id);
			$this->show_opportunity($business_plan_id);
			$this->show_market($business_plan_id);
			$this->show_team($business_plan_id);
			$this->show_intellectual_property($business_plan_id);
			$this->show_competitive_analysis($business_plan_id);
			$this->show_sales_channels($business_plan_id);
			$this->show_marketing_efforts($business_plan_id);
			$this->show_funding($business_plan_id);
			$this->show_milestones_post_funding($business_plan_id);
			$this->show_financial_projection($business_plan_id);
			$this->show_key_partners($business_plan_id);
		}
		
		function show_business_plan_for_admin_user($business_plan_id)
		{
			$this->show_business_plan_title($business_plan_id);
			$this->show_opportunity($business_plan_id);
			$this->show_market($business_plan_id);
			$this->show_team($business_plan_id);
			$this->show_intellectual_property($business_plan_id);
			$this->show_competitive_analysis($business_plan_id);
			$this->show_sales_channels($business_plan_id);
			$this->show_marketing_efforts($business_plan_id);
			$this->show_funding($business_plan_id);
			$this->show_milestones_post_funding($business_plan_id);
			$this->show_financial_projection($business_plan_id);
			$this->show_key_partners($business_plan_id);
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
		
		
		public function add_new_business_plan($user_name)
		{
			// get the business plan name and description
			$business_plan_name = $_POST["business_plan_name"];
			$business_plan_description = $_POST["business_plan_description"];
			
			$query = "insert into business (business_name, username, description) values(?, ?, ?)";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("sss", $business_plan_name, $user_name, $business_plan_description);
			
			$result = $stmt->execute();
			
			// close stmt?
			$stmt->close();
			
			return $result;
		}
		
		public function delete_business_plan($business_plan_id)
		{
			$query = "delete from business where business_id = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("i", $business_plan_id);
			
			$result = $stmt->execute();
			
			// close stmt?
			$stmt->close();
			
			return $result;
		}
	}	
?>