<?php 
    session_start();
	if(isset($_SESSION['id'],$_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
		header('location: dashboard.php');
		exit;
	}
	//require_once('config/database.php');
    //if(isset($_GET['interview']) && $_GET['interview'] == ""){
	//	$get_custom_url = trim($_GET['interview']);
	//	$sql_get_url_custom = "select * from users where url_page = '$get_custom_url' ";
	//	$handle_get_url_custom = $conn->prepare($sql_get_url_custom);
	//	$handle_get_url_custom->execute();
	//	if($handle_get_url_custom->rowCount() > 0) {
	//		include(view_showcase.php);
	//	}
    //}
	//var_dump($_SESSION);

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
		<link href="styles/style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="login">
			<h1>Login</h1>
			<form method="POST" action="login.php" enctype="multipart/form-data">
				<label for="email">
					<i class="fas fa-user"></i>
				</label>
				<input type="text" name="email" placeholder="Email" id="email" required>
				<label for="password">
					<i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" name="submit" value="Login">
			</form>
				<a href="register.php"><button type="button" class="register-button" name="register-button">Register</button></a>
		</div>
	</body>
</html>