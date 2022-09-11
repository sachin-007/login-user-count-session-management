<?php 
include 'database_connection.php';

session_id($_SESSION['user_session_id']);



session_start();
$_SESSION['initial_cnt']=0;
$initial_cnt=$_SESSION['initial_cnt'];

 $uid=$_SESSION['user_id'];

    $query = "
                    UPDATE user_login 
                    SET session_cnt='".$initial_cnt."' 
                    WHERE user_id = '".$uid."'
                    ";
                    $connect->query($query);


session_destroy();

header('location:index.php');


?>

