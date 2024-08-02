<?php 
   include "config.php";
   session_start();
   $email = $_SESSION['email'];
   $sql = "SELECT * FROM `items` WHERE `email`='$email'";
   $result = $conn->query($sql);
   ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sellor Account</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="seller_acc.css" />
  </head>

  <body>
    
    <!-- Account list and order -->
    <div class="traingle " id="trainglem"></div>
    <div class="hdn-sign "  id="hdn-signm">

      <div class="signin">
        <input type="button" name="submit" value="Sign in">
        <p>New customer? <a href="sign_up.html">Start here.</a></p>
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
    
    <!-- Side bar to the secondary navidgation bar -->
    
    <div class="sidebar" id="sideid">
      
      <div class="hdn-head">
        <h2>Hello, Sign in</h2>
      </div>
      <div class="hdn-content">

            <ul>
                <div class="listitem">
                  <li>Catalog</li>
                  <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                  <li>Inventory</li>
                <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                <li>Pricing</li>
                <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                    <li>Orders</li>
                    <i class="fa-solid fa-greater-than"></i>
                  </div>
                  <div class="listitem">
                    <li>Advertising</li>
                    <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                    <li>Stores</li>
                    <i class="fa-solid fa-greater-than"></i>
                  </div>
                 <div class="listitem">
                <li>Growth</li>
                <i class="fa-solid fa-greater-than"></i>
              </div>
                <div class="listitem">
                    <li>Reposts</li>
                    <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                    <li>Performance</li>
                    <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                    <li>Brands</li>
                    <i class="fa-solid fa-greater-than"></i>
                </div>
                <div class="listitem">
                    <li>Learn</li>
                    <i class="fa-solid fa-greater-than"></i>
                </div>
            </ul>
            </div>
   
        </div>   

          <div class="close-icon " id="xmark">
            <i class="fa-solid fa-xmark"  onclick="CloseSidebar()"></i>
          </div>
          <div id="black" class="on-scroll"></div>


    
    
    <!-- Navigation bar -->
    <nav>
      
      <div class="nav-bottom">
            <div class="all-item" onclick="Opensidebar() " >
              <img src="assets/menu_icon.png" width="25px" alt="" />
            </div>
        </div>
      <div class="imageandh1">
        <a href="/"><img src="assets/amazon_logo.png" width="100" alt="" /></a>
        <h1>seller center</h1>
      </div>
      
      <div class="nav-search"  >
        <div class="nav-search-catogary">
          <p>All</p>
          <img src="assets/dropdown_icon.png" height="12" alt="" />
        </div>
        <input
          type="text"
          class="nav-search-input"
          placeholder="Search Amozon"
        />
        <img src="assets/search_icon.png" class="nav-search-icon" alt="" />
      </div>

    </nav>

    <?php 

        $sql_for_order = "SELECT COUNT(DISTINCT o.id) AS open_orders_count 
        FROM `order` o 
        JOIN items i ON o.product_id = i.id 
        AND o.sellor_email = i.email";

        $order_result = $conn->query($sql_for_order);

        $Open_orders = 0;

        if($order_result->num_rows > 0){
        $order = $order_result->fetch_assoc();
        $Open_orders = $order['open_orders_count'];
        }
    ?>

    <div class="ordercount">
      <div>
        <p>OPEN ORDERS</p>
        <h1><?php echo $Open_orders; ?></h1>
      </div>
      <div>
        <P>TODAY'S SALES</P>
        <h1>$0</h1>
        </div>
        <div>
            <p>TOTAL BALANCE</p>
            <h1>$0</h1>
        </div>
        <div>
          <p>BUYER MASSAGE</p>
            <h1>0</h1>
        </div>
        <?php 
           
           
           if($result->num_rows >0){
             $total = 0 ;
            while($raw = $result->fetch_assoc()) {
              $total += $raw['quantity'];
          }
            
        ?>
        
        <div>
          <p>NUMBER OF ITEMS</p>
            <h1><?php echo $total ?></h1>
        </div>
        <?php } ?>
    </div>

    <div class="sellitems">
        
      <h2>Sell Items</h2>
      <p>Earn money easyly</p>
      <div>
        <a href="itemform.html">Add items</a>
      </div>    
    </div>
    <hr><br>
    
    <div class="tabledive">
      <h1>Your Items</h1>
      <table>
          <thead>
              <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>Mthly Sales</th>
                <th>Unit price</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $result->data_seek(0); 
                if($result->num_rows > 0){
                  while($row = $result->fetch_assoc()){?>
          
                  <tr>
                    <td>
                      <div class="itemdetails">
                        <img src="img/<?php echo htmlspecialchars($row['img']); ?>" alt="Item Image">
                        <p><?php echo htmlspecialchars($row['itemName']); ?></p>
                      </div>
                    </td>
                    <td><?php echo htmlspecialchars($row['catagory']); ?></td>
                    <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                    <td>$17,502.48</td>
                    <td><?php echo htmlspecialchars($row['price']); ?></td>
                  
                    <td style="display:flex;">
                        <a href="update.php?id=<?php echo $row['id']; ?>">
                        <button class="upbtn" name="update" id="update"
                          style="
                            background-color: #009900;
                            color: #fff;
                            padding: 10px;
                            border: none;
                            border-radius: 5px;
                            font-size: 16px;
                            cursor: pointer;
                            text-align: center;
                            width: 100px;"
                        >Update</button>
                      </a>
                      <a href="delete.php?id=<?php echo $row['id'] ?>">
                        <button class="delbtn" id="delete" name="delete"
                          style="
                            background-color: red;
                            color: white;
                            margin-left:10px;
                            padding: 8px 16px;
                            border: none;
                            border-radius: 4px;
                            font-size: 14px;
                            cursor: pointer;"
                        >Delete</button>
                      </a>

                    </td>
                  </tr>
                <?php 
                  
                  }
                }
            ?>
          </tbody>
        </table>
      
  </div>


    <footer>
      <img src="assets/amazon_logo.png" width="100" alt="" />
      <p>&copy; 2024 Amazon.com, Inc. or its affiliates</p>
    </footer>


    <script src="./Sell.js"></script>
    <script
      src="https://kit.fontawesome.com/eb9a09f072.js"
      crossorigin="anonymous"
    ></script>
    
  </body>
</html>
