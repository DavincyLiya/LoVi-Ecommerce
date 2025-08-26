<?php
require_once __DIR__ . '/bootstrap.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $qty = isset($_POST['qty']) ? (int)$_POST['qty'] : 1;
    cart_add($id, $qty);

    // Redirect back to product page with success flag
    header("Location: product.php?id=" . urlencode($id) . "&added=1");
    exit;
}

// If no id, go home
header("Location: index.php");
exit;
