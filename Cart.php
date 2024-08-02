<?php 
    include 'config.php';
    session_start();
            
    if (isset($_SESSION['customer_email'])) {
        $email = $_SESSION['customer_email'];
            
        $query = "SELECT i.img, i.itemName, i.price, c.product_id, c.customer_email 
                FROM items i 
                JOIN cart c ON i.id = c.product_id 
                 WHERE c.customer_email = '$email'";
            
        $result = mysqli_query($conn, $query);

        $subtotalArr = [];
        $quantityArr = [];
        $total=0;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Amazon</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>

<!-- Account list and order -->
<div class="traingle" id="trainglem"></div>
<div class="hdn-sign" id="hdn-signm">

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
                <li>Account</li>
                <li>Orders</li>
                <li>Recommendations</li>
                <li>Browsing History</li>
                <li>Watch List</li>
                <li>Video Purchases</li>
                <li>Kindle Unlimited</li>
                <li>Content & Devices</li>
                <li>Subscribe & Save Items</li>
                <li>Membership</li>
                <li>Music Library</li>
            </ul>
        </div>
    </div>
</div>
<!-- Navigation bar -->
<nav class="nav-bar">
    
    <a href="/"><img src="assets/amazon_logo.png" width="100" alt="" /></a>
    <div class="nav-country">
        <img src="assets/location_icon.png" height="20" alt="" />
        <div>
            <p style="color:#fff">Deliver to</p>
            <h1 style="color:#fff">United State</h1>
        </div>
    </div>

    <div class="nav-search">
        <div class="nav-search-category">
            <p>All</p>
            <img src="assets/dropdown_icon.png" height="12" alt="" />
        </div>
        <input
            type="text"
            class="nav-search-input"
            placeholder="Search Amazon"
        />
        <img src="assets/search_icon.png" class="nav-search-icon" alt="" />
    </div>

    <div class="nav-language">
        <p style="color:#fff">EN</p>
        <img src="assets/us_flag.png" width="25px" alt="" />
        <img src="assets/dropdown_icon.png" width="8px" alt="" />
    </div>

    <div class="nav-text" id="sign_acc">
        <p style="color:#fff">Hello, Sign In</p>
        <h1 style="color:#fff">
            Account & List
            <img src="assets/dropdown_icon.png" width="8px" alt="" />
        </h1>
    </div>
    <div class="nav-text">
        <p style="color:#fff">Return</p>
        <h1 style="color:#fff">$ Orders</h1>
    </div>

    <a href="" class="nav-cart">
        <img src="assets/cart_icon.png" width="35px" alt="" />
        <h4 style="color:#fff">Cart</h4>
    </a>
</nav>

<form method="post" action="./proceed_calculate.php">
    <div class="cart-container cart-page">
        <table>
            <tr>
                <th>Product</th>
                <th>Quantity</th>
                <th>Subtotal</th>
            </tr>
            <?php     
                if ($result) {
                    if ($result->num_rows > 0) {
                        $total = 0;
                        while ($row = $result->fetch_assoc()) {
                            $quantity = 1;
                            $subtotal = $row['price'] * $quantity;
                            $total += $subtotal;
                            $subtotalArr[$row['product_id']] = $subtotal;
                            $quantityArr[$row['product_id']] = $quantity;
            ?>
                        <tr>
                            <td>
                                <div class="cart-info">
                                    <img src="img/<?php echo htmlspecialchars($row['img']); ?>" alt="Item Image">
                                    <div>
                                        <p><?php echo htmlspecialchars($row['itemName']); ?></p>
                                        <small>price: <?php echo htmlspecialchars($row['price']); ?>$</small>
                                        <br>
                                        <a href="remove.php?product_id=<?php echo $row['product_id']; ?>&customer_email=<?php echo $row['customer_email']; ?>">Remove</a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <!--This /oninput/ property can use for dynamic updates and immediate updates -->
                                <input type="number" 
                                       name="quantity[<?php echo $row['product_id']; ?>]" 
                                       min="0" value="<?php echo $quantity; ?>" 
                                       oninput="updateSubtotal(this, <?php echo $row['price']; ?>, <?php echo $row['product_id']; ?>)"  
                                >

                            </td>
                            <td id="subtotal-<?php echo $row['product_id']; ?>"><?php echo htmlspecialchars($subtotal); ?>$</td>
                        </tr>
            <?php 
                        }
                    } else {
                        echo "<tr><td colspan='3'>Your cart is empty.</td></tr>";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            ?>
        </table>

        <div class="total-price">
            <hr>
            <div>
                <button type="submit" name="proceed_checkout">Proceed to checkout</button>
                <h4>Total</h4>
                <h4 id="total"><?php echo $total; ?>$</h4>
            </div>
        </div>
    </div>
</form>


<footer>
    <img src="assets/amazon_logo.png" width="100" alt="" />
    <p>&copy; 1996-2024, Amazon.com, Inc. or its affiliates</p>
</footer>

<script>
    function updateSubtotal(element, price, productId) {
        let quantity = element.value;
        if (quantity < 0) {
            quantity = 0;
            element.value = 0;
        }
        let subtotal = price * quantity;
        document.getElementById('subtotal-' + productId).innerText = subtotal + '$';

        let subtotals = document.querySelectorAll('td[id^="subtotal-"]');
        let total = 0;
        subtotals.forEach(sub => {
            total += parseFloat(sub.innerText.replace('$', ''));
        });
        document.getElementById('total').innerText = total + '$';
    }
</script>

<script src="script.js"></script>
<script src="https://kit.fontawesome.com/eb9a09f072.js" crossorigin="anonymous"></script>
</body>
</html>
