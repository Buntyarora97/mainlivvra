<?php
require_once '../../includes/config.php';

header('Content-Type: application/json');

$response = ['success' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if (isset($products[$productId])) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'id' => $productId,
                'name' => $products[$productId]['name'],
                'price' => $products[$productId]['price'],
                'image' => $products[$productId]['image'],
                'category' => $products[$productId]['category'],
                'quantity' => $quantity
            ];
        }
        
        $response['success'] = true;
        $response['cartCount'] = getCartCount();
        $response['message'] = 'Product added to cart!';
    } else {
        $response['message'] = 'Product not found';
    }
}

echo json_encode($response);
?>
