<?php 
session_start();
include "config.php";

if (isset($_POST['submit'])) {

    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Prepare and execute SQL query
    $sqlBind = $conn->prepare("SELECT * FROM `sellor` WHERE `email` = ?");
    $sqlBind->bind_param("s", $email);
    $sqlBind->execute();
    $result = $sqlBind->get_result();

    if ($result->num_rows === 1) {
        $raw = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $raw['password'])) {
            $_SESSION['email'] = $email;
            // Redirect after successful login
            header("Location: sellor_acc.php");
            exit();
        } else {
            // Handle invalid password
            echo "Invalid Password..! Try again.";
            exit();
        }
    } else {
        // Handle email not found
        echo "You haven't account yet.. Create account.";
        exit();
    }
}
?>
