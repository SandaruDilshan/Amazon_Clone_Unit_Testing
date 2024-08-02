<?php 
    session_start();

    include "config.php";

    if(isset($_POST['submit'])){
        if(!empty($_FILES["itemImage"]["name"])){
            $fileName = basename($_FILES["itemImage"]["name"]);
            $fileType = pathinfo($fileName,PATHINFO_EXTENSION);

            $allowTypes = array('jpg','png','jpeg','gif');

            if(in_array($fileType,$allowTypes)){
                $image = $_FILES["itemImage"]["name"];
                $imageContent = addslashes(file_get_contents($image));

                $itemCatogary = $_POST['itemCatogary'];
                $name = $_POST['itemName'];
                // $itemImage = $_POST['itemImage'];//
                $descreption = $_POST['message'];
                $Quentity = $_POST['Quentity'];
                $Price = $_POST['Price'];
                $email = $_SESSION['email'];

                $sql = "INSERT INTO `items`(`catagory`,`itemName`,`img`,`description`,`quantity`,`price`,`email`)
                VALUES ('$itemCatogary','$name','$imageContent','$descreption','$Quentity','$Price','$email')";

                $result = $conn->query($sql);
                        
                if($result){
                    echo "New item added successfully.!";
                    header("Location:sellor_acc.php");
                    exit();
                }
                else{
                    echo"Error".$sql."<br>".$conn->error;
                }

            }else{
                echo "Sorry only allowed 'jpg','png','jpeg','gif'";
            }
        }else{
            echo "Please select image file to upload";
        } 
        
    }
?>