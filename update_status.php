<?php
session_start();
require_once('config/database.php');
if(!$_SESSION['id'] && !isset($_SESSION['loggedin']) && $_SESSION['loggedin'] != TRUE){
    header('location:index.php');
    exit;
}
$user_id_status = trim($_SESSION['id']);
$link_id_status = trim($_POST['link_id']);
$sql_right_url = "select * from links where link_id = '$link_id_status' AND user_id = '$user_id_status' ";
$handle_right_url = $conn->prepare($sql_right_url);
$handle_right_url->execute();
$show_or_unshow = 0;
if($handle_right_url->rowCount() > 0){
    $getRow = $handle_right_url->fetch(PDO::FETCH_ASSOC);
    if($getRow["active"] == 1){
        $sql = "update links set active = 0 where link_id = '$link_id_status' AND user_id = '$user_id_status' ";
        $handle = $conn->prepare($sql);
        $handle->execute();
        //echo json_encode(array("statusCode"=>200));
        $show_or_unshow = 0;
        //var_dump($show_or_unshow);
    }
    else
    {
        $sql = "update links set active = 1 where link_id = '$link_id_status' AND user_id = '$user_id_status' ";
        $handle = $conn->prepare($sql);
        $handle->execute();
        //echo json_encode(array("statusCode"=>200));
        $show_or_unshow = 1;
        //var_dump($show_or_unshow);
    }
    //var_dump($getRow);
}
else
{
    //echo json_encode(array("statusCode"=>404));
    header('location:dashboard.php', 404);
    exit;
}
?>
