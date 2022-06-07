<?php
session_start();
require_once('config/database.php');

if(isset($_SESSION['id'],$_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
	header('location: dashboard.php');
	exit;
}

if(isset($_POST['submit']))
{
	if(isset($_POST['email'],$_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
	{
		$email = trim($_POST['email']);
		$password = md5(trim($_POST['password']));
 
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$sql = "select * from users where email = :email ";
			$handle = $conn->prepare($sql);
			$params = ['email'=>$email];
			$handle->execute($params);
			if($handle->rowCount() > 0)
			{
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
				if($password === $getRow['passwords'])
				{
					unset($getRow['passwords']);
					//unset($_SESSION['passwords']);
					$_SESSION = $getRow;
					$_SESSION['loggedin'] = TRUE;
					//$_SESSION['id'] = $getRow['id'];
					//$_SESSION['url_custom'] = $getRow['url_page'];
					header('location: dashboard.php');
					exit();
				}
				else
				{
					$errors[] = "Wrong Email or Password";
				}
			}
			else
			{
				$errors[] = "Wrong Email or Password";
			}
			
		}
		else
		{
			$errors[] = "Email address is not valid";	
		}
 
	}
	else
	{
		$errors[] = "Email and Password are required";	
	}
 
}
else
{
	header('location: index.php');
	exit;
}
?>