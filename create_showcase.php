<?php 
    session_start();
    if(!$_SESSION['id'] && !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE){
        header('location:index.php');
		exit;
    }
?>
<!doctype html>
<html>
<head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>
<body class="bg-dark">
 
<div class="container h-100">
	<div class="row h-100 mt-5 justify-content-center align-items-center">
		<div class="col-md-5 mt-3 pt-2 pb-5 align-self-center border bg-light">
			<h1 class="mx-auto w-10" >CREATE SHOWCASE</h1>
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
			<form method="POST" action="add_showcase.php" enctype="multipart/form-data">
                <div class="form-group">
					<label for="title">Title:</label>
					<input type="text" name="title" placeholder="Title" class="form-control" value="<?php echo ($title_link??'')?>" required>
				</div>
				<div class="form-group">
				<label for="description">Description:</label>
					<input type="text" name="description" placeholder="Description" class="form-control" value="<?php echo ($description_link??'')?>" required>
				</div>
                <div class="form-group">
					<label for="customers_url">Customer's URL:</label>
					<input type="text" name="customers_url" placeholder="https://exemple.com/" class="form-control" value="<?php echo ($customers_url??'')?>" required>
				</div>

                <div class="form-group">
                    <label for="image">Select image to upload:</label>
                    <input type="file" name="fileToUpload" class="form-control" id="fileToUpload" required>
                </div>
                </br>

				<button type="submit" name="submit" class="btn btn-primary">Submit</button>
				<a href="dashboard.php"><button type="button" class="btn btn-warning">Dashboard</button></a>
			</form>
		</div>
	</div>
</div>
</body>
</html>