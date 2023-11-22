<?php 
    require "config.php";
    $USER_ID = $_GET['user_id'];
    $s_no = $_GET['s_no'];
    // echo $USER_ID.'<br>'.$s_no;
    $sql = "update orders set Status = 'Rejected' where USER_ID = $USER_ID and s_no = $s_no";
    $result = mysqli_query($conn,$sql);
    $sql = "delete from order_med_list where USER_ID = $USER_ID";
    $result = mysqli_query($conn, $sql);
    header("location: pharm-order-list.php");
?>