<?php 
    include 'config.php';

    session_start();

    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $catagory = $_GET['catagory'];
        $email = $_SESSION['customer_email'];
        
        $query = "SELECT `email` FROM `customer` WHERE `email` = '$email'";
        
        $result = mysqli_query($conn, $query);
        
        if(isset($_SESSION['customer_email'] )){  
            $stmt = $conn->prepare("INSERT INTO `cart`(`product_id`,`customer_email`) VALUES (?,?)");
            $stmt->bind_param("is",$id,$email);
            
            if($stmt->execute()){
                echo "<script>alert('Successfully Added to cart. $email'); document.location.href='Products/products.php?catagory=$catagory';</script>";
                // unset($_SESSION['email']);
            }else{
                echo "<script>alert('Error adding data.');</script>";
                echo $stmt->error;
            }   
        }
        else{
            
            echo "<script>alert('Loging to your account'); document.location.href='sign_in.html';</script>";
        }
    }
    $stmt->close();
?>
