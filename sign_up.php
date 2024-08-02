<?php 
include "config.php";

if (isset($_POST["submit"])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $c_Password = $_POST['password_confirmation'];

    if ($password != $c_Password) {
        echo "Your passwords don't match..!";
        exit();
    }

    $check_email_exist = "SELECT * FROM `customer` WHERE `email` = ?";
    $stmt = $conn->prepare($check_email_exist);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $checked_result = $stmt->get_result();

    if ($checked_result->num_rows > 0) {
        echo "Email already exists.";
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO `customer` (`email`, `name`, `password`) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $email, $name, $hashed_password);

    if ($stmt->execute()) {
        echo "New record added successfully.";
        header("Location: sign_in.html");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
