<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to Diana Kander - Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<!-- CSS -->

<link rel="stylesheet" href="css/supersized.css">
<link rel="stylesheet" href="css/login.css">
<link href="css/bootstrap.min.css" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
	<script src="js/html5.js"></script>
<![endif]-->
<script src="js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/tooltips.js"></script>
<script type="text/javascript" src="js/login.js"></script>
</head>
<?php
	$login_information = "Please enter username and password to login";
	$has_login = false;
	// start the session
	session_start();
	if (!isset($_SERVER['HTTPS']) || !$_SERVER['HTTPS']) { // if request is not secure, redirect to secure url
	   $url = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	   header('Location: ' . $url);
	    //exit;
	}
	// 这个地方可以优化一下
	// check the session variable, if exist, get them
	if(isset($_SESSION["user_name"]))
		$user_name = $_SESSION["user_name"];
	if(isset($_SESSION["user_type"]))
		$user_type = $_SESSION["user_type"];
	
	if(isset($user_name))
		$has_login = true;
	
	else
	{
		// check if we have got someting from the html form
		if(isset($_POST['name']) || isset($_POST['password']))
		{
			$user_name = $_POST['name'];
			$password = $_POST['password'];
	
			$db = mysqli_connect(Hostname, DB-username, password, Database-Name) 
				or die("Connect Error " . mysqli_error($link));
		
			$sql_query = 'SELECT salt, hashed_password, user_type FROM user WHERE username = ?';
			if($stmt = $db->prepare($sql_query)) 
			{
				$stmt->bind_param("s", $user_name);
				$stmt->bind_result($salt, $pwhash, $user_type);
				$stmt->execute() or die("execute error");
			}
			// get the result
			$stmt->fetch();
			// chech the password validation
			if(password_verify($salt . $password, $pwhash))
			{ 
				$has_login = true;
				// store the login information to the session
				$_SESSION["user_name"] = $user_name;
				$_SESSION["user_type"] = $user_type;
			}
			else
				// username of password must be wrong
				$login_information = "Wrong username or password!";
			// close the database connection
			$db->close();			
		}
	}
	
	// to determine what part it is going to load
	if($has_login) {
	// check the user type
	if($user_type == "a")
		header("location: admin.php");
	else
		header("location: user.php");
	} else {
?>

<body>
<div class="page-container">
	<div class="main_box">
		<div class="login_box">
			<div class="login_logo">
				<img src="images/logo.png" >
			</div>
		
			<div class="login_form">
				<form action="login.php" id="login_form" method="post">
					<div class="form-group">
						<label for="j_username" class="t">Username:</label> 
						<input id="name" value="" name="name" type="text" class="form-control x319 in" 
						autocomplete="off">
					</div>
					<div class="form-group">
						<label for="j_password" class="t">Password:</label> 
						<input id="password" value="" name="password" type="password" 
						class="password form-control x319 in">
					</div>
                                    			
					
					<div class="form-group space">
						<label class="t"></label>　　　
                        <input type="submit" value="Submit" class="btn btn-primary btn-lg" id="submit_btn"/>
						<input type="reset" value="Reset" class="btn btn-default btn-lg">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Javascript -->

<script src="js/supersized.3.2.7.min.js"></script>
<script src="js/supersized-init.js"></script>
<script src="js/scripts.js"></script>
<?php
	echo $login_information;
}
?>
</body>
</html>
