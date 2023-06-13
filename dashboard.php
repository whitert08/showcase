<?php 
    session_start();
	require('config/database.php');

  
    if(!$_SESSION['id'] && !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != TRUE){
        header('location:index.php');
		exit;
    }
	//var_dump($_SESSION);

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Showcase Interview</title>
		<link href="styles/style.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body class="loggedin">
		<nav class="navtop">
			<div>
				<h1>Showcase</h1>
				<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
			</div>
		</nav>
		<div class="content">
			<h2>Your showcase</h2>
			<p>Welcome back, <?=strtoupper($_SESSION['url_page'])?>!</p>
		</div>
		
		<div class="content d-flex justify-content-end">
			<a href="create_showcase.php"><button type="button" class="btn btn-primary btn-lg float-right">NEW SHOWCASE</button></a>
		</div>
		</br>

		<div class="content">
			<table class="table table-dark">
			<thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Title</th>
			      <th scope="col">Description</th>
			      <th scope="col">Customer's URL</th>
				  <th scope="col">Status</th>
				  <th scope="col">Action</th>
			    </tr>
			</thead>
			<tbody>
			<?php

			$user_id_session = trim($_SESSION["id"]);
			$sql = "select * from links where user_id = '$user_id_session' ";
			$handle = $conn->prepare($sql);
			$handle->execute();
			$row_number = 0;
			if($handle->rowCount() > 0) {
				while ($getRow = $handle->fetch(PDO::FETCH_ASSOC)){
					$row_number++;

			?>
			    <tr>
			    	<th scope="row"><?= $row_number ?></th>
			    	<td><a href="<?= $_SESSION["url_page"]?>" target="_blank"><?= $getRow["title"]?></a></td>
			    	<td><?= $getRow["description"]?></td>
			    	<td><?= $getRow["customer_url"]?></td>
					<td><?php if($getRow["active"] == 1)
				  		{
							echo "ACTIVE";
						}
						else
						{
							echo "INACTIVE";
						}
						?>
					</td>
					<td>
						<a href="edit_link.php?link_id=<?= $getRow["link_id"]?>"><i id="edit_link" class="fas fa-pen-to-square" value="<?= $getRow["link_id"]?>"></i></a>
						<button id="delete_link" type='button' name="delete_link" style="border:none;background:none;color:red;" value="<?= $getRow["link_id"]?>"><i class="fas fa-x" value="<?= $getRow["link_id"]?>"></i></button>
						<?php if($getRow["active"] == 1) { ?>
						<button id="show_unshow" type='button' name="show_unshow" style="border:none;background:none;color:green;" value="<?= $getRow["link_id"]?>"><i class="fa-solid fa-eye-slash"></i></button>
						<?php } else { ?>
						<button id="show_unshow" type='button' name="show_unshow" style="border:none;background:none;color:red;" value="<?= $getRow["link_id"]?>"><i class="fa-solid fa-eye-slash"></i></button>
						<?php } ?>
					</td>
			    </tr>
			<?php } } ?>
			</tbody>
			</table>
		</div>
	</body>
<script>

$(document).on("click", "#show_unshow", function() { 
	$.ajax({
		type: "POST",
		url: "update_status.php",
		data:{
			link_id: $(this).val(),
		},
		success: function(){
			//var dataResult = JSON.parse(dataResult);
			//if(dataResult.statusCode==200){
			//	//$('#update_country').modal().hide();
			//	alert('Data updated successfully !');
			//	location.reload();					
			//}
			location.reload();
		}
	});
});

$(document).on("click", "#delete_link", function() { 
	$.ajax({
		type: "POST",
		url: "delete_showcase.php",
		data:{
			link_id: $(this).val(),
		},
		success: function(){
			//var dataResult = JSON.parse(dataResult);
			//if(dataResult.statusCode==200){
			//	//$('#update_country').modal().hide();
			//	alert('Data updated successfully !');
			//	location.reload();					
			//}
			location.reload();
		}
	});
});

</script>
</html>