<?php 
    include "config.php";

    if(isset($_GET['id'])){
            
            $UserID = $_GET['id'];
            
            $sql = "DELETE FROM `items` WHERE `id`='$UserID' ";
            
            if($conn->query($sql)){
                echo "<script>alert('Successfully Deleted.'); document.location.href='sellor_acc.php';</script>";
            }else{
                echo "<script>alert('Error deleting data.');</script>";
            }
    }
?>