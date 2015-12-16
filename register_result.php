<?php
// 没有关闭数据库...
$name=$_POST['name'];
$password=$_POST['password'];
$pwd_again=$_POST['pwd_again'];

$db = mysqli_connect(Hostname, DB-username, password, Database-Name) 
		or die("Connect Error " . mysqli_error($link));

if($name==""|| $password=="")
{
	echo "username or password cannot be empty";
}
else 
{
    if($password!=$pwd_again)
    {
    	echo "The two password do not match!";
    	echo "<a href='register.php'>register again</a>";
    	
    }
    else
    {
		// 检查是否注册过
		$stmt = $db->prepare("insert into user values(?, ?, ?, 'r')");
//		$sql = "insert into user values('$name', 'haha', '$password')";
//    	$result=mysql_query($sql);
//		$result = mysqli_query($db, $sql);
		
		mt_srand(); // Seed number generator
		$salt = mt_rand();
//		$pwhash = sha1($salt. $password);
		$pwhash = password_hash($salt . $password, PASSWORD_BCRYPT);
//		echo $pwhash;

		$stmt->bind_param("sss", $name, $salt, $pwhash);
		$result = $stmt->execute();
		
    	if(!$result)
    	{
    		echo "register failed!";
    		echo "<a href='admin.php'>return</a>";
    	}
    	else 
    	{
    		echo "register successful!";
			echo "<a href='admin.php'>Home Page</a>";
    	}
		// close the database connection
		$db->close();
    }
}
?>
