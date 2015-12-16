<?php
	class MySql
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
			if($this->m_conection->connect_errno)
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
	}
?>