<?php 
include 'connectDB.php'; 
/** @var mysqli $conn */ 

include 'priceName.php'; 
/** @var mysqli $neces */ 
include 'cart_functions.php';

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <title>Necessities</title>
    </head>
    <body>
        <div class="header">
            <h1>Necessities</h1>
        </div>
        <?php include 'menu.php'; ?>
        <form method="POST" action="" id="purchaseForm">
            <div class="products-column">
                <table class="table">
                    <!-- CALENDAR -->
                    <tr class="product-row">
                        <td>
                            <img src="images/calendar.png" alt="calendar" class="product-image">
                        </td>
                        <td>
                            <p class="product">calendar</p>
                            <p class="product">Unit Price: 20</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[calendar]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- FAN -->
                    <tr class="product-row">
                        <td>
                            <img src="images/fan.png" alt="fan" class="product-image">
                        </td>
                        <td >
                            <p class="product">fan</p>
                            <p class="product">Unit Price: 30</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[fan]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- MUG -->
                    <tr class="product-row">
                        <td>
                            <img src="images/mugs.png" alt="mugs" class="product-image">
                        </td>
                        <td>
                            <p class="product">mugs</p>
                            <p class="product">Unit Price: 40</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px; white-space: nowrap;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[mugs]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- UMBRELLA -->
                    <tr class="product-row">
                        <td>
                            <img src="images/umbrella.png" alt="umbrella" class="product-image">
                        </td>
                        <td>
                            <p class="product">umbrella</p>
                            <p class="product">Unit Price: 30</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px; white-space: nowrap;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[umbrella]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-footer">
                <button type="submit" name="submitOrder" class="btn-submit">Submit</button>
                <button type="reset" class="btn-reset">Reset</button>
            </div>
        </form>
    </body>
</html>

<?php
// Triggered ONLY when user clicks the Submit button (isset($_POST['submitOrder']))
if (isset($_POST['submitOrder'])) {
    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
        exit;
    }
    // get all quantity value from form
    
    $qtyList = $_POST['qty']; // array from numeric inputs (name="qty[productName]")
    // track if any product was successfully added to cart
    $added = false;
    // Stores price, image filename, and category for ALL clothing items
    // Matches the product display in HTML table
    $products = [
        'calendar' => ['price'=>20, 'image'=>'calendar.png', 'category'=>'neces'],
        'fan' => ['price'=>30, 'image'=>'fan.png', 'category'=>'neces'],
        'mugs' => ['price'=>40, 'image'=>'mugs.png', 'category'=>'neces'],
        'umbrella' => ['price'=>30, 'image'=>'umbrella.png', 'category'=>'neces'],
    ];

    foreach ($qtyList as $name => $qty) {
        // convert to int
        $qty = (int)$qty;
        // skip item if quantity is 0 or product name is not in the $products array
        if ($qty <= 0 || !isset($products[$name])) 
            continue;
        // add item to session cart
        addToCart(
            $item_id = $name,
            $item_name = $name,
            $price = $products[$name]['price'],
            $category = $products[$name]['category'],
            $image = $products[$name]['image'],
            $quantity = $qty
        );
        // track at least one item added
        $added = true;
    }
    if ($added) {
        // success alert
        echo "<script>alert('Items added to cart!'); window.location.href='cart.php';</script>";
    } else {
        // alert when user selected 0 quantity for all items
        echo "<script>alert('Please select at least 1 item (quantity > 0)!');</script>";
    }
}
?>