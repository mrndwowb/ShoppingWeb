<?php 
include 'connectDB.php'; 
/** @var mysqli $conn */

include 'priceName.php'; 
/** @var mysqli $orna */
include 'cart_functions.php';

?>

<html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <title>Ornaments</title>
    </head>
    <body>
        <div class="header">
            <h1>Ornaments</h1>
        </div>
        <?php include 'menu.php'; ?>
        <form method="POST" action="" id="purchaseForm">
            <div class="products-column">
                <table class="table">
                    <!-- BROOCH -->
                    <tr class="product-row">
                        <td>
                            <img src="images/brooch.png" alt="brooch" class="product-image">
                        </td>
                        <td>
                            <p class="product">brooch</p>
                            <p class="product">Unit Price: 40</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[brooch]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- CRYSTAL -->
                    <tr class="product-row">
                        <td>
                            <img src="images/crystal.png" alt="crystal" class="product-image">
                        </td>
                        <td >
                            <p class="product">crystal</p>
                            <p class="product">Unit Price: 40</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[crystal]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- EARRING  -->
                    <tr class="product-row">
                        <td>
                            <img src="images/earRings.png" alt="ear rings" class="product-image">
                        </td>
                        <td>
                            <p class="product">ear rings</p>
                            <p class="product">Unit Price: 60</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px; white-space: nowrap;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[earRings]"
                                    class="quantity-input"
                                    min="0"
                                    max="9"
                                    value="0">
                            </div>
                        </td>
                    </tr>
                    <!-- NECKLACE -->
                    <tr class="product-row">
                        <td>
                            <img src="images/necklace.png" alt="necklace" class="product-image">
                        </td>
                        <td>
                            <p class="product">necklace</p>
                            <p class="product">Unit Price: 60</p>
                        </td>
                        <td>
                            <div style="margin-top: 10px; white-space: nowrap;">
                                <span class="quantity-label">Quantity (0 to 9):</span>
                                <input type="number"
                                    name="qty[necklace]"
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
if (isset($_POST['submitOrder'])) {
    // Require login to shop
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Please log in first!'); window.location.href='login.php';</script>";
        exit;
    }

    // to use addToCard() method and other cart logic
    
    // get all quantity value from form
    $qtyList = $_POST['qty']; // array from numeric inputs (name="qty[productName]")
    // track if any product was successfully added to cart
    $added = false;
    // Stores price, image filename, and category for ALL clothing items
    // Matches the product display in HTML table
    $products = [
        'brooch' => ['price'=>40, 'image'=>'brooch.png', 'category'=>'orna'],
        'crystal' => ['price'=>40, 'image'=>'crystal.png', 'category'=>'orna'],
        'earRings' => ['price'=>60, 'image'=>'earRings.png', 'category'=>'orna'],
        'necklace' => ['price'=>60, 'image'=>'necklace.png', 'category'=>'orna'],
    ];
    // Add selected items (with quantity >0) to cart
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
