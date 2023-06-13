<?php
session_start();
require_once('config/database.php');
if(!$_SESSION['id'] && !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != TRUE){
    header('location:index.php');
exit;
}
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
//$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$user_id = trim($_SESSION['id']);
$sql = "insert into links (user_id, image_url, customer_url, title, description, active) values (:user_id,:image_url,:customer_url,:title,:description, 1)";
$succesUploadImage = 0;

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  if(isset($_POST['title'],$_POST['description'],$_POST['customers_url'],$_FILES['fileToUpload']) && !empty($_POST['title']) && !empty($_POST['description']) && !empty($_POST['customers_url']) && !empty($_FILES['fileToUpload']))
  {
      $photos_file_extension = explode('.', $_FILES['fileToUpload']['name']);
      $photos_file_extension = strtolower(end($photos_file_extension));
      $photos_file_temp = $_FILES['fileToUpload']['tmp_name'];
      $check = getimagesize($photos_file_temp);
      if($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        $error_msg = "File is not an image.";
        $uploadOk = 0;
        header('location: dashboard.php', 404);
      }


      // Check if file already exists
      if (file_exists($target_file)) {
        $error_msg = "Sorry, file already exists.";
        $uploadOk = 0;
        header('location: dashboard.php', 404);
      }

      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
        $error_msg = "Sorry, your file is too large.";
        $uploadOk = 0;
        header('location: dashboard.php', 404);
      }

      // Allow certain file formats
      if($photos_file_extension != "jpg" && $photos_file_extension != "png" && $photos_file_extension != "jpeg"&& $photos_file_extension != "gif" ) {
        $error_msg = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        header('location: dashboard.php', 404);
      }

      $photos_new_name = md5(time() . rand()) . '.' . $photos_file_extension;

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
        $error_msg = "Sorry, your file was not uploaded.";
        header('location: dashboard.php', 404);
      // if everything is ok, try to upload file
      } else {
        if (move_uploaded_file($photos_file_temp, $target_dir . $photos_new_name)) {
          //echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
          $succesUploadImage = 1;
          $target_file = $target_dir . $photos_new_name;
        } else {
          $error_msg = "Sorry, there was an error uploading your file.";
          header('location: dashboard.php', 404);
        }
      }
      if($succesUploadImage == 1)
      {
        $title_link = trim($_POST['title']);
        $description_link = trim($_POST['description']);
        $customers_url = trim($_POST['customers_url']);
        try{
            $handle = $conn->prepare($sql);
            $params = [
                ':user_id'=>$user_id,
                ':image_url'=>trim($target_file),
                ':customer_url'=>$customers_url,
                ':title'=>$title_link,
                ':description'=>$description_link
            ];

            $handle->execute($params);

            header('location: dashboard.php', 200);

        }
        catch(PDOException $e){
            $errors[] = $e->getMessage();
        }
      }
  }
  else
  {
    header('location: dashboard.php', 404);
  }
}
else
{
  header('location: dashboard.php', 404);
}


?>