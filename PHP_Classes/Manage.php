<?php
	class Manage
	{
		// relative fields about database and connections
		private $m_sever;
		private $m_username;
		private $m_passward;
		private $m_database_name;
		private $m_connection;
		private $m_query;
		private $m_result;
		private $m_user_name;
		
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
		
		public function show_users()
		{
			$query = "select username from user where user_type = 'r'";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_result($user_name);			
			$stmt->execute();
			
			// Drop down list
			// 弄懂select
			
			echo "<br>";
			
			echo "Username:";			
			echo "<form action='admin.php' method='post'>";
			
			echo "<select name='user_list_select' id='query_selections'>";
			
			while($stmt->fetch())
			{
//				echo "<option value='0'>1</option>";			
				if($_POST['user_list_select'] == $user_name)
				{
					echo "<option value='" . $user_name . "' selected='selected'>" . $user_name . "</option>";
				}
				else
				{
					echo "<option value='" . $user_name . "' >" . $user_name . "</option>";
				}
			}
	
			echo "</select>";
			echo "<input type='submit' value='Refresh' />";
			
			echo "</form>";
			
			$stmt->close();
		}
		
		public function get_user_name()
		{
			if(isset($_POST['user_list_select']))
			{
				$this->m_user_name = $_POST['user_list_select'];
			}
			else
			{
				$query = "select username from user where user_type = 'r'";
				$stmt = $this->m_connection->prepare($query);
				$stmt->bind_result($user_name);			
				$stmt->execute();
				$stmt->fetch();
				$this->m_user_name = $user_name;
			}
		}
		
		public function show_user_business_plan_information()
		{
			// get how many business plans the user have, and each busiiness_plan_name
			$query = "select business_id, business_name, description from business where username = ?";
			$stmt = $this->m_connection->prepare($query);
			$stmt->bind_param("s", $this->m_user_name);
			$stmt->bind_result($business_plan_id, $business_plan_name, $description);		
			$stmt->execute();
			
			echo "<table width='80%' align='center'>";
   		 	echo "<td><table width='100%' border='1' cellpadding='1' cellspacing='0'>";
		    echo "<tr style='text-align: center; font-size: 24px;'>";
   		    echo "<td width='30%'>Name</td>";
   	     	echo "<td>Description</td>";
      		echo "</tr>";
			while($stmt->fetch())
			{
				
				
				echo "<tr>";
        		echo "<td width='30%' style='font-size: 20px; text-align: center;'><a href='BusinessPlan.php?action=" . $business_plan_id . "'>" . $business_plan_name . "</a></td>";
       			echo "<td style='font-size: 18px'>" . $description . "</td></tr>";
			}
			echo "</table></td>";
  			echo "</tr>";
			echo "</table>";
			
			$stmt->close();
		}
		
	}	
?>
