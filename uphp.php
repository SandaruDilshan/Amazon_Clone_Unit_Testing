<?php
include "config.php";

session_start();

if (isset($_POST["submit"])) {
    $itemCatogary = $_POST['itemCatogary'];
    $name = $_POST['itemName'];
    $description = $_POST['message'];
    $quantity = $_POST['Quentity'];
    $price = $_POST['Price'];
    $email = $_SESSION['email'];
    $id = $_POST['id'];

    if ($_FILES["itemImage"]["error"] === 4) {
        echo "<script>alert('Image does not exist..!')</script>";
    } else {
        $fileName = $_FILES["itemImage"]["name"];
        $fileSize = $_FILES["itemImage"]["size"];
        $tmpName = $_FILES["itemImage"]["tmp_name"];

        $validImageExtension = ['jpg', 'jpeg', 'png'];
        $imageExtension = explode('.', $fileName);
        $imageExtension = strtolower(end($imageExtension));

        if (!in_array($imageExtension, $validImageExtension)) {
            echo "<script>alert('Invalid image extension..!')</script>";
        } else if ($fileSize > 1000000) {
            echo "<script>alert('Image file too large..!')</script>";
        } else {
            $newImageName = uniqid();
            $newImageName .= '.' . $imageExtension;

            $imageFolder = 'img/';
            if (!is_dir($imageFolder)) {
                mkdir($imageFolder, 0777, true);
            }

            move_uploaded_file($tmpName, $imageFolder . $newImageName);

            $query = "UPDATE `items` SET 
                      `catagory`='$itemCatogary', 
                      `itemName`='$name', 
                      `img`='$newImageName', 
                      `description`='$description', 
                      `quantity`='$quantity', 
                      `price`='$price', 
                      `email`='$email' 
                      WHERE `id`='$id'";

            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Successfully Updated.'); document.location.href='sellor_acc.php';</script>";
            } else {
                echo "<script>alert('Error updating data.');</script>";
                echo $conn->error;
            }
        }
    }
}
?>
