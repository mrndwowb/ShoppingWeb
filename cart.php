<?php
session_start();
include 'connectDB.php'; 
/** @var mysqli $conn */
include 'cart_functions.php';

// CART ITEM DELETE
// Triggered when user clicks "Remove" link (URL has ?remove=item_id)
if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    // Call cart function to remove item using item ID from URL parameter
    removeFromCart($_GET['remove']);
    // refresh page
    header('Location: cart.php');
    // stop execution
    exit();
}

// ORDER CONFIMATION
// Triggered when user submits the "Confirm Order" form (POST method)
// Validate order, save order to database, store receipt, clear cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_order'])) {
    // user logged in or not
    if (!isset($_SESSION['username'])) {
        header('Location: login.php?redirect=cart.php'); // Redirect back to cart after login
        exit();
    }
    // cart cannot empty
    if (empty($_SESSION['cart'])) {
        echo "<script>alert('Cart is empty!'); window.location.href='cart.php';</script>";
        exit();
    }

    $current_user = $_SESSION['username'];
    $shopCartSql = "INSERT INTO shopCart (
        category, itemN, price, quantity, username
    ) VALUES (?, ?, ?, ?, ?)";
    $stmtShopCart = mysqli_prepare($conn, $shopCartSql);
    foreach ($_SESSION['cart'] as $item) {
        $category = $item['category'];  
        $itemN = $item['name'];         
        $price = $item['price'];        
        $quantity = $item['quantity'];  

        // Bind parameters
        mysqli_stmt_bind_param(
            $stmtShopCart, // for the sql query
            "ssdis", //data type
            $category, // string
            $itemN, // string
            $price, //decimal
            $quantity, // integer
            $current_user //string
        );
        if (!mysqli_stmt_execute($stmtShopCart)) {
        echo "error: " . mysqli_stmt_error($stmtShopCart);
        exit;
    }
}
mysqli_stmt_close($stmtShopCart);


    $update_query = "UPDATE purchase SET quantity = quantity + ? WHERE itemN = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    foreach ($_SESSION['cart'] as $item) {
        $item_name = $item['name'];
        $item_qty = $item['quantity'];
        mysqli_stmt_bind_param($stmt, "is", $item_qty, $item_name);
        mysqli_stmt_execute($stmt);
    }
    mysqli_stmt_close($stmt);

    $_SESSION['order_receipt'] = [
        'username' => $current_user,
        'items' => $_SESSION['cart'],
        'total' => getCartTotal(),
        'order_date' => date('Y-m-d H:i:s') 
    ];
    // clean the cart
    clearCart();
    header('Location: order_done.php');
    exit();
}

$cart_total = getCartTotal();
?>

<html>
    <head>
        <title>Shopping Cart</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="header">
            <h1>Shopping Cart</h1>
        </div>
        <?php include 'menu.php'; 
        // DISPLAY USER INFO
        // ONLY SHOW IF USER IS LOGGED IN
        if (isset($_SESSION['username'])) {
            $currentUser = $_SESSION['username'];
            // Get user data from db
            include 'connectDB.php';
            $query = "SELECT username, password, phone FROM members WHERE username = '$currentUser'";
            $result = mysqli_query($conn, $query);
            $userData = mysqli_fetch_assoc($result);
            $username = $userData['username'];
            $phone    = $userData['phone'];
            $password = $userData['password']; // real password from DB
        ?>
        <div>
            <h2 >Your Account Info</h2>
            <p class="text" style="text-align: center">Username: <?php echo $username; ?></p>
            <p class="text" style="text-align: center">Phone Number: <?php echo $phone; ?></p>
        </div>
    <?php
    } // end if logged in
    ?>
        <!-- SHOPPING CART -->
        <br><br>
        
      
            <table class="cart-table">
                <tr>
                    <th colspan="6"><h2 >Your Shopping Cart</h2>
                        <?php if (empty($_SESSION['cart'])): ?>
                            <div style="text-align: center">
                                <!-- at first, cart is empty -->
                                <p class="text" style="color: crimson"><br>Your shopping cart is empty.<br></p>
                                <a href="clothes.php" class="btn-reset">Continue Shopping</a>
                            </div>
                        <?php else: ?>
                     </th>
                </tr>
                <tr class="text">
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>

                <tbody>
                    <!-- loop through all items in session and display -->
                    <?php foreach ($_SESSION['cart'] as $item_id => $item): ?>
                    <tr class="text_low">
                        <td>
                            <img src="images/<?php echo htmlspecialchars($item['image']); ?>" 
                                alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                class="cart-image">
                        </td>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo (int)$item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                        <td>
                            <!-- remove item from shop cart -->
                            <a href="cart.php?remove=<?php echo htmlspecialchars($item_id); ?>" 
                            class="remove-btn" 
                            onclick="return confirm('Remove this item?');">Remove</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tr>
                    <td colspan="6">
                        <div class="cart-total">
                            <p class="text">Total: $<?php echo $cart_total; ?></p>
                        </div>
                    </td>
                </tr>
            </table>
            <!-- total price -->

            <!-- confirm order. Submits to cart.php via POST -->
            <form method="POST" action="cart.php">
                <button type="submit" name="confirm_order" class="confirm-btn">
                    Confirm Order
                </button>
            </form>
            <!-- get back to clothes.php -->
            <a href="clothes.php" class="back-btn" >Continue Shopping</a>
        <?php endif; ?>
    </body>
</html>