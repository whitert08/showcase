<?php
session_start();
require_once('config/database.php');

if(!$_SESSION['id'] && !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != TRUE){
    header('location:index.php');
    exit;
}
$user_id_delete = trim($_SESSION['id']);
$link_id_delete = trim($_POST['link_id']);
$sql_right_url = "select * from links where link_id = '$link_id_delete' AND user_id = '$user_id_delete' ";
$handle_right_url = $conn->prepare($sql_right_url);
$handle_right_url->execute();
if($handle_right_url->rowCount() > 0){
        $sql = "delete from links where link_id = '$link_id_delete' AND user_id = '$user_id_delete' ";
        $handle = $conn->prepare($sql);
        $handle->execute();
        //echo json_encode(array("statusCode"=>200));
}
else
{
    //echo json_encode(array("statusCode"=>404));
    header('location:dashboard.php', 404);
    exit;
}
?>
