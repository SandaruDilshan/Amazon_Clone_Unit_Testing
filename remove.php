<?php 
    include "config.php";

    if(isset($_GET['product_id'] ,   $_GET['customer_email'])){
            
            $UserID = $_GET['product_id'];
            $customer_email = $_GET['customer_email'];  
            
            $sql = "DELETE FROM `cart` WHERE `product_id`='$UserID' AND `customer_email`='$customer_email' ";
            
            if($conn->query($sql)){
                echo "<script>alert('Successfully Deleted.'); document.location.href='Cart.php';</script>";
            }else{
                echo "<script>alert('Error deleting data.');</script>";
            }
    }
?>