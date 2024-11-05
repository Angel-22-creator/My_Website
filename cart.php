<?php
session_start();

// Example of using session for a simple cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Sample product data (usually fetched from the database)
$products = [
    1 => ['name' => 'T-Shirt', 'price' => 15.99],
    2 => ['name' => 'Jeans', 'price' => 39.99],
    3 => ['name' => 'Jacket', 'price' => 49.99],
    4 => ['name' => 'Hat', 'price' => 12.99]
];

// Handle adding to the cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    if (isset($products[$product_id])) {
        $_SESSION['cart'][] = $product_id;
    }
}

// Handle removing from the cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $key = array_search($product_id, $_SESSION['cart']);
    if ($key !== false) {
        unset($_SESSION['cart'][$key]);
    }
}

// Calculate total cost
$total = 0;
foreach ($_SESSION['cart'] as $product_id) {
    $total += $products[$product_id]['price'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
</head>
<body>
    <h1>Your Cart</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Your cart is empty!</p>
    <?php else: ?>
        <ul>
            <?php
            foreach ($_SESSION['cart'] as $product_id):
                $product = $products[$product_id];
            ?>
                <li>
                    <?php echo $product['name']; ?> - $<?php echo number_format($product['price'], 2); ?>
                    <form action="cart.php" method="POST" style="display:inline;">
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="submit" name="remove_from_cart" value="Remove">
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>

        <p><strong>Total: $<?php echo number_format($total, 2); ?></strong></p>

        <form action="checkout.php" method="POST">
            <input type="submit" value="Proceed to Checkout">
        </form>
    <?php endif; ?>

    <hr>

    <h2>Available Products</h2>
    <ul>
        <?php foreach ($products as $product_id => $product): ?>
            <li>
                <?php echo $product['name']; ?> - $<?php echo number_format($product['price'], 2); ?>
                <form action="cart.php" method="POST" style="display:inline;">
                    <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                    <input type="submit" name="add_to_cart" value="Add to Cart">
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
