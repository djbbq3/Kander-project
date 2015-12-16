<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>User</title>
<script type="text/javascript" src="js/script.js">
</script>
<style type="text/css">
body {
	background-color: #00CCFF;
}
</style>
</head>

<body>

<?php	include "./PHP_Classes/MyUser.php";
	session_start();
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
	   $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	   header('Location: ' . $url);
	    //exit;
	}
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]))
		$user_type = $_SESSION["user_type"];
		
	if(isset($user_name))
	{
		// check if it is regular user
		if($user_type == "r")
		{
			echo "<table width='100%' align='center'>";
  			echo "<tr>";
  	 	 	echo "<td align='right' style='color: #C15BAF; font-size: 24px;'>Welcome" . $user_name. "! Press here to <a href='logout.php'>logout!</a></td>";
  			echo "</tr>";
			echo "</table>";
		}
		// check if it is admin user	
		else
			if($user_type == "a")
				header("location: admin.php");
			else
				echo "Login in error";
				
		// show user business plan information
		$myUser = new MyUser(Hostname, DB-username, password, Database-Name);
		$myUser->connect();
		// start with a new line
		// get the number of business plan
		$number_of_business_plan = $myUser->get_number_of_business_plan($user_name);		
		
		
		echo "<table width='80%' align='center'>";
  		echo "<tr>";
    	echo "<td style='text-align: center; font-size: 36px'>You have " . $number_of_business_plan . " Business Plans</td></tr>";
  		echo "<tr>";
    	echo "<td><table width='100%' border='1' cellpadding='1' cellspacing='0'>";
	    echo "<tr style='text-align: center; font-size: 24px;'>";
        echo "<td width='30%'>Name</td>";
        echo "<td>Description</td>";
      	echo "</tr>";
      	
		
		// print out the plan information
		$business_plan = $myUser->get_business_plan_information($user_name);

		
//		echo "<form action='delete_business_plan.php' method='post'>";
		
		for($i = 0; $i < $number_of_business_plan; $i++)
		{			
			echo "<tr>";
        	echo "<td width='30%' style='font-size: 20px; text-align: center;'><a href='BusinessPlan.php?action=" . $business_plan[$i][0] . "'>" . $business_plan[$i][1] . "</a></td>";
       		echo "<td style='font-size: 18px'>" . $business_plan[$i][2] . "</td></tr>";
		}
		
    	echo "</table></td>";
  		echo "</tr>";
		echo "</table>";
		
		
		//disconnect the database;
		$myUser->disconnect();
?>
<form action="add_new_business_plan.php" method="post" >
    	 
	
	
    <table width="80%" align="center">
      <tr>
    	<td style="text-align: center; font-size: 36px;">Add a new Business Plan</td>
  	  </tr>
      <tr>
      	<td><table width="100%">
      	  <tr>
      	    <td width="40%" style="text-align: right; font-size: 24px;">Business Plan Name:</td>
      	    <td><input type="text" name="business_plan_name" style="width: 100;  font-size: 20px" /></td>
   	      </tr>
      	  <tr>
      	    <td width="40%" style="text-align: right; font-size: 24px;">Description:</td>
      	    <td><textarea type='text' name='business_plan_description' cols='45' rows='5'></textarea></td>
   	      </tr>
   	    </table></td>
      </tr>
      <tr>
    	<td style="text-align: center"><input type="submit" value="Sumit" style="width: 20%; height: 50px; font-size: 20px" /></td>
  	  </tr>
    </table>
    </form>
<?php	
	}
	// it must be the wrong login information
	else
	{
		echo "Please enter username and password to login<br />";
		echo "Press here to <a href='login.php'>HomePage!</a>";
	}
?>
</body>
</html>
