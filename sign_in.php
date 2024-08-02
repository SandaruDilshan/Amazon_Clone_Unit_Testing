<?php
    include "config.php";


    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if(isset($_POST["submit"])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $check_email_exist = "SELECT * FROM `customer` WHERE `email` = ?";
        $stmt = $conn->prepare($check_email_exist);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows === 1){
            
                $_SESSION['customer_email'] = $email;
                echo "Login successful.";
                header ("Location:index.html");
        
        } else {
            echo "Email does not exist.";
        }
    }
?>



