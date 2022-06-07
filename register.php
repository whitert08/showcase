<?php
session_start();
require_once('config/database.php');
 
if(isset($_POST['submit']))
{
    if(isset($_POST['url_custom'],$_POST['email'],$_POST['password']) && !empty($_POST['url_custom']) && !empty($_POST['email']) && !empty($_POST['password']))
    {
        $email = trim($_POST['email']);
        $password = md5(trim($_POST['password']));
		$urlCustomUser = trim($_POST['url_custom']);
 
        if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
            $sql = 'select * from users where email = :email';
            $stmt = $conn->prepare($sql);
            $p = ['email'=>$email];
            $stmt->execute($p);
            
            if($stmt->rowCount() == 0)
            {
                $sql = "insert into users (email, `passwords`, url_page) values(:email,:pass,:urlCustom)";
            
                try{
                    $handle = $conn->prepare($sql);
                    $params = [
                        ':email'=>$email,
                        ':pass'=>$password,
						':urlCustom'=>$urlCustomUser
                    ];
                    
                    $handle->execute($params);
                    
                    $success = 'User has been created successfully';
                    
                }
                catch(PDOException $e){
                    $errors[] = $e->getMessage();
                }
            }
            else
            {
                $valEmail = '';
                $valPassword = $password;
				$valUrlCustom = $urlCustomUser;
 
                $errors[] = 'Email address already registered';
            }
        }
        else
        {
            $errors[] = "Email address is not valid";
        }
    }
    else
    {
        if(!isset($_POST['url_custom']) || empty($_POST['url_custom']))
        {
            $errors[] = 'Url custom is required';
        }
        else
        {
            $valUrlCustom = $_POST['url_custom'];
        }
 
        if(!isset($_POST['email']) || empty($_POST['email']))
        {
            $errors[] = 'Email is required';
        }
        else
        {
            $valEmail = $_POST['email'];
        }
 
        if(!isset($_POST['password']) || empty($_POST['password']))
        {
            $errors[] = 'Password is required';
        }
        else
        {
            $valPassword = $_POST['password'];
        }
        
    }
 
}
?>
 
 
<!doctype html>
<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
 
</head>
<body class="bg-dark">
 
<div class="container h-100">
	<div class="row h-100 mt-5 justify-content-center align-items-center">
		<div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
			<h1 class="mx-auto w-25" >Register</h1>
			<?php 
				if(isset($errors) && count($errors) > 0)
				{
					foreach($errors as $error_msg)
					{
						echo '<div class="alert alert-danger">'.$error_msg.'</div>';
					}
                }
                
                if(isset($success))
                {
                    
                    echo '<div class="alert alert-success">'.$success.'</div>';
                }
			?>
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
                <div class="form-group">
					<label for="email">Email:</label>
					<input type="text" name="email" placeholder="Enter Email" class="form-control" value="<?php echo ($valEmail??'')?>">
				</div>
				<div class="form-group">
				<label for="email">Password:</label>
					<input type="password" name="password" placeholder="Enter Password" class="form-control" value="<?php echo ($valPassword??'')?>">
				</div>
                <div class="form-group">
					<label for="email">What url you want to have:</label>
					<input type="text" name="url_custom" placeholder="https://localhost/your-url-custom" class="form-control" value="<?php echo ($valUrlCustom??'')?>">
				</div>
 
				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				<p class="pt-2"> Back to <a href="login.php">Login</a></p>
				
			</form>
		</div>
	</div>
</div>
</body>
</html>