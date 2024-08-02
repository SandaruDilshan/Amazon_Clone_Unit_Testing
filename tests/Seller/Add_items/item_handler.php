<?php
include "config.php";

class item_handler {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addItem($itemCatogary, $name, $description, $quantity, $price, $email, $file) {
        if ($file["error"] === 4) {
            return "Image does not exist..!";
        } else {
            $fileName = $file["name"];
            $fileSize = $file["size"];
            $tmpName = $file["tmp_name"];

            $validImageExtension = ['jpg', 'jpeg', 'png'];
            $imageExtension = explode('.', $fileName);
            $imageExtension = strtolower(end($imageExtension));

            if (!in_array($imageExtension, $validImageExtension)) {
                return "Invalid image extension..!";
            } else if ($fileSize > 1000000) {
                return "Image file too large..!";
            } else {
                $newImageName = uniqid() . '.' . $imageExtension;

                $imageFolder = 'img/';
                if (!is_dir($imageFolder)) {
                    mkdir($imageFolder, 0777, true);
                }

                move_uploaded_file($tmpName, $imageFolder . $newImageName);

                $stmt = $this->conn->prepare("INSERT INTO `items`(`catagory`, `itemName`, `img`, `description`, `quantity`, `price`, `email`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssids", $itemCatogary, $name, $newImageName, $description, $quantity, $price, $email);

                if ($stmt->execute()) {
                    $stmt->close();
                    return "Successfully Added.";
                } else {
                    $stmt->close();
                    return "Error adding data: " . $stmt->error;
                }
            }
        }
    }
}
