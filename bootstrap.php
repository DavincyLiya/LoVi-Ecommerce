<?php
// bootstrap.php

// Fix session notice
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Escape output
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

// Login check
function is_logged_in(): bool {
    return isset($_SESSION['user_email']);
}

function require_login(): void {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}

// Demo users (for real apps: use DB + password_hash)
$USERS = [
    'user@example.com' => 'pass123',
];

// Categories
$CATEGORIES = ['electronics', 'fashion', 'beauty', 'furniture'];

// Products
$PRODUCTS = [
    'electronics' => [
        ['id' => 'el1', 'name' => 'Samsung Galaxy S25 Ultra(12 GB/ 512 GB)', 'price' => 121599.00, 'image' => 'images/sam.png'],
        ['id' => 'el2', 'name' => 'boAt Airdopes 125 | Wireless Earbuds with 50 Hours Playback,', 'price' => 1099.00, 'image' => 'images/earpods.jpg'],
        ['id' => 'el3', 'name' => 'Dell 14" Latitude 7450 Laptop - Intel Core Ultra 7-16GB LPDDR5x RAM- 512GB M.2 NVMe SSD -Windows 11 Pro', 'price' => 1949999.00, 'image' => 'images/laptop.jpg'],
        ['id' => 'el4', 'name' => 'URBAN Fit Z - Smart watches Grey', 'price' => 3399.00, 'image' => 'images/watch.webp'],
    ],
    'fashion' => [
        ['id' => 'fa1', 'name' => 'Mens Denim Jacket | Blue | Men Jacket', 'price' => 1499.00, 'image' => 'images/denimjacket.webp'],
        ['id' => 'fa2', 'name' => 'Puma Mens Sneaker', 'price' => 7087.00, 'image' => 'images/sneakers.jpg'],
        ['id' => 'fa3', 'name' => 'Leather Belts for Women Fashion', 'price' => 599.00, 'image' => 'images/belt.jpg'],
        ['id' => 'fa4', 'name' => 'Cotton Stretch T-Shirt ', 'price' => 800.00, 'image' => 'images/cottontshirt.webp'],
    ],
    'beauty' => [
        ['id' => 'be1', 'name' => 'SUGAR Cosmetics Matte Attack Transferproof Lipstick - 01 Boldplay (Cardinal Pink) (2g)', 'price' => 659.00, 'image' => 'images/matte-lip.webp'],
        ['id' => 'be2', 'name' => 'Minimalist 10% Vitamin C Serum For Face For Glowing Skin', 'price' => 299, 'image' => 'images/serum.webp'],
        ['id' => 'be3', 'name' => 'Dot & Key Vitamin C + E Face Sunscreen SPF 50 PA+++ For Glowing Skin, 100% No White Cast (50g)', 'price' => 396, 'image' => 'images/sunscreen.webp'],
        ['id' => 'be4', 'name' => 'Maybelline New York Fit Me Matte + Poreless Liquid Foundation Tube SPF 22 - 128 Warm Nude (18ml)', 'price' => 312.00, 'image' => 'images/maybelline.webp'],
    ],
    'furniture' => [
        ['id' => 'fu1', 'name' => 'Wooden Coffee Table for Living Room', 'price' => 9599.00, 'image' => 'images/coffetable.jpg'],
        ['id' => 'fu2', 'name' => 'Office Chair, Big and Tall 400 Lbs Ergonomic Home Computer Desk Leather Chair ', 'price' => 15822.00, 'image' => 'images/officechair.webp'],
        ['id' => 'fu3', 'name' => 'Modern Book Shelves - Kosmo Willam Bookshelf In Walnut Bronze Finish with 5 Tier', 'price' => 6999.00, 'image' => 'images/bookshelf.webp'],
        ['id' => 'fu4', 'name' => 'Teana 3 Door Wardrobe in Classic Walnut Finish By Nilkamal', 'price' => 12999.00, 'image' => 'images/wardrobe.webp'],
    ],
];

// Find product by ID
function find_product(string $id): ?array {
    global $PRODUCTS;
    foreach ($PRODUCTS as $cat => $items) {
        foreach ($items as $p) {
            if ($p['id'] === $id) return $p + ['category' => $cat];
        }
    }
    return null;
}

// Cart functions
function cart_add(string $id, int $qty = 1): void {
    if ($qty < 1) $qty = 1;
    if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
    if (!isset($_SESSION['cart'][$id])) $_SESSION['cart'][$id] = 0;
    $_SESSION['cart'][$id] += $qty;
}

function cart_remove(string $id): void {
    if (isset($_SESSION['cart'][$id])) unset($_SESSION['cart'][$id]);
}

function cart_clear(): void {
    unset($_SESSION['cart']);
}

function cart_items(): array {
    $items = [];
    if (!isset($_SESSION['cart'])) return $items;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = find_product($id);
        if ($p) {
            $p['qty'] = $qty;
            $p['line_total'] = $qty * $p['price'];
            $items[] = $p;
        }
    }
    return $items;
}

function cart_total(): float {
    $total = 0.0;
    foreach (cart_items() as $item) {
        $total += $item['line_total'];
    }
    return $total;
}
?>
