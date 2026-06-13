<?php
session_start();
// Redirect to cart if no order receipt exists (prevent direct access)
if (!isset($_SESSION['order_receipt'])) {
    header('Location: cart.php');
    exit();
}

// Get receipt data from session
$receipt = $_SESSION['order_receipt'];
?>
<html>
    <head>
        <title>Order Confirmed</title>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body>
        <div class="header">
            <h1>Order Confirmed</h1>
        </div>
        <?php include 'menu.php'; ?>
        <div class="success-msg">
            <h2>Order Confirmed!</h2>
            <p class="text" style="text-align: center">Your order has been successfully placed.</p>
        </div>
        <!-- Receipt Container -->
        <div class="receipt-container">
            <div class="receipt-header">
                <h3>Order Receipt</h3>
            </div>
            <!-- Order Info -->
            <div class="receipt-info">
            <p><strong>Order Date:</strong> <?php echo isset($receipt['order_date']) ? $receipt['order_date'] : 'Not Available'; ?></p>                <p><strong>Username:</strong> <?php echo htmlspecialchars($receipt['username']); ?></p>
            </div>
            <!-- Order Items Table -->
            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($receipt['items'] as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['name']); ?></td>
                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                        <td><?php echo (int)$item['quantity']; ?></td>
                        <td>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <!-- Order Total -->
            <div class="receipt-total">
                Total: $<?php echo $receipt['total']; ?>
            </div>
        </div>
        <br>
        <a href="clothes.php" class="back-btn">Continue Shopping</a>
        <?php
        //Clear the receipt session after display (prevents reusing)
        unset($_SESSION['order_receipt']);
        ?>
    </body>
</html>
