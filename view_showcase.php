<?php 
    session_start();
	require('config/database.php');
?>
<!DOCTYPE html>
<html>
	<head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
<body>
<style>
        body {
          background: #C9E3CC;
        }
        
        .banner {
          background: #a770ef;
          background: -webkit-linear-gradient(to right, #a770ef, #cf8bf3, #fdb99b);
          background: linear-gradient(to right, #a770ef, #cf8bf3, #fdb99b);
        }
</style>
<div class="container-fluid">
  <div class="px-lg-5">

    <!-- For demo purpose -->
    <div class="row py-5">
      <div class="col-lg-12 mx-auto">
        <div class="text-white p-5 shadow-sm rounded banner">
          <h1 class="display-4" style="text-align: center;">SHOWCASE</h1>
        </div>
      </div>
    </div>
    <!-- End -->

    <div class="row">
      <!-- Gallery item -->
<?php 
            $url_custom_page = trim($_GET["interview"]);
			$sql = "select id from users where url_page = '$url_custom_page' ";
			$handle = $conn->prepare($sql);
			$handle->execute();
			if($handle->rowCount() > 0) {
				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
                $user_id = $getRow["id"];
                $sql_select_objects = "select * from links where user_id = '$user_id' ";
                $handle_select_objects = $conn->prepare($sql_select_objects);
                $handle_select_objects->execute();
                if($handle_select_objects->rowCount() > 0) {
                    while ($getRow_select_objects = $handle_select_objects->fetch(PDO::FETCH_ASSOC)){
                        if($getRow_select_objects['active'] == 1){
                        $full_url_image = $_SERVER['HTTP_HOST'] . "/" . $getRow_select_objects['image_url'];		
?>
      <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        <div class="bg-white rounded shadow-sm"><img src="//<?= $full_url_image ?>" alt="Showcase-Image" class="img-fluid card-img-top">
          <div class="p-4">
            <h5> <a href="<?= $getRow_select_objects['customer_url'] ?>" class="text-dark"><?= $getRow_select_objects['title'] ?></a></h5>
            <p class="small text-muted mb-0"><?= $getRow_select_objects['description'] ?></p>
            <div class="d-flex align-items-center justify-content-between rounded-pill bg-light py-2 mt-4">
                <a href="<?= $getRow_select_objects['customer_url'] ?>"><button type="button" class="btn btn-info">Customer's URL</button></a>
            </div>
          </div>
        </div>
      </div>
<?php } } } } ?>
      <!-- End -->
    </div>
  </div>
</div>
</body>
</html>