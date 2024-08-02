<?php 
include 'config.php';

if(isset($_GET['id'])){
    
    $UserID = $_GET['id'];
    
    $sql = "SELECT `itemName`,`img`,`description`,`quantity`,`price` FROM `items` WHERE `id`='$UserID' ";
    
    $result = $conn->query($sql);

    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
          $name = $row['itemName'];
          $image = htmlspecialchars($row['img']);
          $description = $row['description'];
          $quantity = $row['quantity'];
          $price = $row['price'];
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add item</title>
  <link rel="stylesheet" href="additem.css">
</head> 
<body>
<div class="form">
    <div class="logo_a">
        <div> <img class="image" src="assets/Amazon_black_logo-removebg-preview.png" width="170" alt=""></div>
        <div><h1>seller central</h1></div>   
    </div>
 
  <div class="container">

    <h1>Start your listing</h1>
    <form action="uphp.php" method="post" enctype="multipart/form-data">
     
      <label for="itemcatogary">SELECT ITEM CATOGARY</label>
       <select name="itemCatogary" id="itemcatogary">
            <option value="">Select</option>
            <option value="Electronics">Electronics</option>
            <option value="Lunar New Year">Lunar New Year</option>
            <option value="Computers">Computers</option>
            <option value="Smart Home">Smart Home</option>
            <option value="Women's Fashion">Women's Fashion</option>
            <option value=">Men's Fation">Men's Fation</option>
            <option value="Girl's Fasion">Girl's Fasion</option>
            <option value="Boy's Fashon">Boy's Fashon</option>
            <option value="Towels">Towels</option>
            <option value="Baby">Baby</option>
            <option value="Toys">Toys</option>
            <option value="For International Returns">For International Returns</option>
            <option value="Grooming Products">Grooming Products</option>
            <option value="Latest Decices">Latest Decices</option>
            <option value="Pets Food">Pets Food</option>
            <option value="Deals in PCs">Deals in PCs</option>
            <option value="Stadinory">Stadinory</option>
            <option value="Laptop for Study">Laptop for Study</option>
            <option value="ffice Chairs">Office Chairs</option>
            <option value="Gaming Monitor">Gaming Monitor</option>
        </select>

        <p >You currently do not have any listing template</p>
        <a href="">Manage your listing templates</a><br><br>
        
        <label for="itemname">ITEM TITLE</label>
        <input type="text" id="itemname" name="itemName" placeholder="Item name" value="<?php echo $name ?>">

        <div class="image-uploader">
            <div class="drop-zone">
              <div class="image-preview"></div>
              <p class="file-text">UPLOAD IMAGE</p>
              <input type="file" name="itemImage" id="image-input" multiple accept="image/*" accept=".jpg, .jpeg, .png">
            </div>
            
        </div><br><br>

       
      <label for="password">DESCRIPTION</label>
      <textarea id="message" name="message"  rows="4" cols="50"  placeholder="Write a detailed description of your item." ><?php echo htmlspecialchars($description); ?></textarea><br><br><br>
      

      <label for="quantity">QUENTITY</label>
      <input type="text" id="quentity" name="Quentity" placeholder="Count" value="<?php echo $quantity ?>"><br><br>

      <label for="price">PRICE</label>
      <input type="text" id="price" name="Price" placeholder="$ price " value="<?php echo $price ?>"><br><br>
      <input type="hidden" id="id" name="id" value="<?php echo $UserID ?>" >

      <input type="submit" name="submit" value="LIST ITEMS" class="btn">
    </form>

    <p id="formtext">Byid="formtext"creating an account, you agree to Amazon's <a href="#">Conditions of Use</a> and <a href="#">Privacy Notice</a>.</p>
  </div>
</div>

<script src="../itemform.js"> </script>
</body>
</html>


<?php
    }else{
        header('Location:sellor_acc.php');
    } 
}
?>