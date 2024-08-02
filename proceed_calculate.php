<?php 
    include 'config.php';
    session_start();
    
    if (isset($_SESSION['customer_email'])) {
        $email = $_SESSION['customer_email'];
        
        if (isset($_POST['proceed_checkout'])) {
            
            if (isset($_POST['quantity'])) {
                foreach ($_POST['quantity'] as $product_id => $quantity) {

                    $priceQuery = "SELECT price,email FROM items WHERE id = $product_id";
                    $result = mysqli_query($conn, $priceQuery);

                    if ($result && $result->num_rows >0) {
                        $row = $result->fetch_assoc();
                        $price = $row['price'];
                        $sellor_email = $row['email'];

                        if ($price !== null) {
                            $subtotal = $price * $quantity;

                            $insertOrderQuery = "INSERT INTO `order`(`product_id`, `quantity`, `sub_total`, `customer_email`, `sellor_email`) 
                                                VALUES ('$product_id', '$quantity', '$subtotal', '$email', '$sellor_email')";
                            if (mysqli_query($conn, $insertOrderQuery)) {
                                echo "<script>alert('Successfully Added to cart. $email');</script>";
                            } else {
                                echo "<script>alert('Failed to add to cart.$conn->error');</script>";
                            }
                        }
                    }
                }
                // Redirect to a thank you page or order summary

            }
        }
    }
    echo "<script>alert('Hello $email, Thank you'); document.location.href='index.html';</script>";
    exit();
?>
