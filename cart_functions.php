<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'connectDB.php';
// Initialize cart if not exists
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart (with validation)
function addToCart($item_id, $item_name, $price, $category, $image, $quantity = 1) {
    $quantity = max(1, min(9, (int)$quantity)); // Enforce 1-9 quantity limit
    $price = (float)$price;

    if (isset($_SESSION['cart'][$item_id])) {
        // Update quantity (max 9)
        $_SESSION['cart'][$item_id]['quantity'] = min(9, $_SESSION['cart'][$item_id]['quantity'] + $quantity);
    } else {
        $_SESSION['cart'][$item_id] = [
            'name' => htmlspecialchars($item_name), // Sanitize
            'price' => $price,
            'category' => htmlspecialchars($category),
            'image' => htmlspecialchars($image),
            'quantity' => $quantity
        ];
    }
    return true;
}

// Remove item from cart
function removeFromCart($item_id) {
    if (isset($_SESSION['cart'][$item_id])) {
        unset($_SESSION['cart'][$item_id]);
        return true;
    }
    return false;
}

// Get cart total
function getCartTotal() {
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }
    return number_format($total, 2); // Format to 2 decimal places
}

// Clear cart (for post-checkout)
function clearCart() {
    $_SESSION['cart'] = [];
    return true;
}
?>