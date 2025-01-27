  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title>Amazon</title>
      <link rel="stylesheet" href="../style.css" />
      <link rel="stylesheet" href="style.css">
    </head>

    <body>

    <!-- Account list and order -->
    <div class="traingle " id="trainglem"></div>
    <div class="hdn-sign "  id="hdn-signm">

      <div class="signin">
        <a href="sellor_sign_in.html"><input type="button" name="submit" value="Sign in"></a>
        <p>New sellor? <a href="sellor_sign_up.html">Start here.</a></p>
        <hr>
      </div>
      
      <div class="hdn-table"> 
        <div>
          <h3>Your List</h3>
          <ul>
              <li>Create List</li>
              <li>Find a list & Registry</li>
              <li>Amazon Smile Charity Lists</li>
          </ul>
        </div> 
        <div class="line"></div>
          <div class="hdn-line">
                <h3>Your Account</h3>
                <ul>
                    <li>Aaccount</li>
                    <li>Orders</li>
                    <li>Recommendations</li>
                    <li>Browsing History</li>
                    <li>Watch List</li>
                    <li>Vedio Purchases</li>
                    <li>Kindle Unlimited</li>
                    <li>Content & Devices</li>
                    <li>Subscribe & Save Items</li>
                    <li>Menbership</li>
                    <li>Music Library</li>
                </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Navigation bar -->
    <nav class="nav-bar">
        
        <a href="/"><img src="../assets/amazon_logo.png" width="100" alt="" /></a>
        <div class="nav-country">
          <img src="../assets/location_icon.png" height="20" alt="" />
          <div >
            <p style="color:#fff">Deliver to</p>
            <h1 style="color:#fff">United State</h1>
          </div>
        </div>

        <div class="nav-search"  >
          <div class="nav-search-catogary">
            <p>All</p>
            <img src="../assets/dropdown_icon.png" height="12" alt="" />
          </div>
          <input
            type="text"
            class="nav-search-input"
            placeholder="Search Amozon"
          />
          <img src="../assets/search_icon.png" class="nav-search-icon" alt="" />
        </div>

        <div class="nav-language">
          <p style="color:#fff">EN</p>
          <img src="../ssets/us_flag.png" width="25px" alt="" />
          <img src="../assets/dropdown_icon.png" width="8px" alt="" />
        </div>

        <div class="nav-text" id="sign_acc">
          <p style="color:#fff">Hello, Sign In</p>
          <h1 style="color:#fff">
            Account & List
            <img src="../assets/dropdown_icon.png" width="8px" alt="" />
          </h1>
        </div>
        <div class="nav-text">
          <p style="color:#fff">Return</p>
          <h1 style="color:#fff">$ Orders</h1>
        </div>

        <a href="../Cart.php" class="nav-cart">
          <img src="../assets/cart_icon.png" width="35px" alt="" />
          <h4 style="color:#fff">Cart</h4>
        </a>
    </nav>

    <?php 
        include '../config.php';

        if(isset($_GET['catagory'])){
          $catagory = mysqli_real_escape_string($conn, $_GET['catagory']);  
          
          $sql = "SELECT * FROM `items` WHERE `catagory` = '$catagory'";
          $result = mysqli_query($conn, $sql);
        
        }
    ?>

    <div class="container">
        <?php
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
        ?>  
        <div class="cart">
            <div class="image">
                <img src="../img/<?php echo htmlspecialchars($row['img']); ?>" alt="Item Image">
            </div>
            <div class="caption">
                <p class="rate">
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                    <i class="fa-solid fa-star"></i>
                </p>
                <p class="product_name"><?php echo htmlspecialchars($row['itemName']); ?></p>
                <p class="price"><?php echo htmlspecialchars($row['price']); ?></p>
                <p class="discount">50%</p>
            </div>
            <a href="../add_to_cart.php?id=<?php echo $row['id'] ?>&catagory=<?php echo $_GET['catagory'] ?>">
                <button class="add">Add to cart</button>
            </a>  
        </div>
        <?php
            }
        } else {
            echo "<script> alert('There are no products uploaded'); document.location.href='../index.html'; </script>";
            echo $conn->error;
        }
        ?>
    </div>

          

      <footer>
        <img src="..assets/amazon_logo.png" width="100" alt="" />
        <p>&copy; 1996-2024, Amazon.com, Inc. or its affiliates</p>
      </footer>

      <script src="script.js"></script>
      <script
        src="https://kit.fontawesome.com/eb9a09f072.js"
        crossorigin="anonymous"
      ></script>
    </body>
  </html>
