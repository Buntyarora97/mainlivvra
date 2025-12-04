<?php
require_once '../includes/config.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if (!isset($products[$productId])) {
    header('Location: products.php');
    exit;
}

$product = $products[$productId];
$pageTitle = $product['name'];
$discount = round((($product['original_price'] - $product['price']) / $product['original_price']) * 100);

// Get related products
$relatedProducts = array_filter($products, function($p) use ($product, $productId) {
    return $p['category'] === $product['category'] && $p['id'] !== $productId;
});
$relatedProducts = array_slice($relatedProducts, 0, 4);

require_once '../includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="page-banner-content">
        <h1><?php echo $product['name']; ?></h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <a href="products.php">Products</a>
            <span>/</span>
            <a href="products.php?category=<?php echo $product['category']; ?>"><?php echo $categories[$product['category']]['name']; ?></a>
            <span>/</span>
            <span><?php echo $product['name']; ?></span>
        </div>
    </div>
</section>

<!-- Product Detail Section -->
<section class="product-detail">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Product Gallery -->
            <div class="product-gallery reveal-left">
                <div class="main-image">
                    <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" id="mainProductImage">
                </div>
                <div class="thumbnail-images">
                    <div class="thumbnail active">
                        <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="thumbnail">
                        <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                    <div class="thumbnail">
                        <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="product-detail-info reveal-right">
                <h1><?php echo $product['name']; ?></h1>
                
                <div class="product-meta">
                    <div class="product-detail-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php if ($i <= floor($product['rating'])): ?>
                                <i class="fas fa-star"></i>
                            <?php elseif ($i - 0.5 <= $product['rating']): ?>
                                <i class="fas fa-star-half-alt"></i>
                            <?php else: ?>
                                <i class="far fa-star"></i>
                            <?php endif; ?>
                        <?php endfor; ?>
                        <span><?php echo $product['rating']; ?> (<?php echo $product['reviews']; ?> reviews)</span>
                    </div>
                    <span class="stock-status"><i class="fas fa-check-circle"></i> In Stock</span>
                </div>
                
                <div class="product-detail-price">
                    <span class="detail-current-price"><?php echo CURRENCY_SYMBOL . number_format($product['price']); ?></span>
                    <?php if ($product['original_price'] > $product['price']): ?>
                    <span class="detail-original-price"><?php echo CURRENCY_SYMBOL . number_format($product['original_price']); ?></span>
                    <span class="discount-badge"><?php echo $discount; ?>% OFF</span>
                    <?php endif; ?>
                </div>
                
                <p class="product-description"><?php echo $product['description']; ?></p>
                
                <div class="product-benefits">
                    <h4>Key Benefits:</h4>
                    <ul class="benefits-list">
                        <?php foreach ($product['benefits'] as $benefit): ?>
                        <li><i class="fas fa-check-circle"></i> <?php echo $benefit; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="quantity-selector">
                    <label>Quantity:</label>
                    <div class="quantity-controls">
                        <button class="minus-btn">-</button>
                        <input type="number" value="1" min="1" id="productQuantity">
                        <button class="plus-btn">+</button>
                    </div>
                </div>
                
                <div class="add-to-cart-section">
                    <button class="add-to-cart-btn" onclick="addToCart(<?php echo $product['id']; ?>)">
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                    <a href="cart.php" class="buy-now-btn" onclick="addToCart(<?php echo $product['id']; ?>)">
                        <i class="fas fa-bolt"></i> Buy Now
                    </a>
                    <button class="wishlist-btn">
                        <i class="far fa-heart"></i>
                    </button>
                </div>
                
                <div style="margin-top: 30px; padding: 20px; background: var(--light-bg); border-radius: 12px;">
                    <div style="display: flex; gap: 25px; flex-wrap: wrap;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-truck" style="color: var(--primary-gold);"></i>
                            <span>Free Delivery</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-undo" style="color: var(--primary-gold);"></i>
                            <span>30 Days Return</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-shield-alt" style="color: var(--primary-gold);"></i>
                            <span>100% Genuine</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php if (!empty($relatedProducts)): ?>
<section class="section section-light">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-badge"><i class="fas fa-th-large"></i> Related Products</span>
            <h2 class="section-title">You May Also <span>Like</span></h2>
        </div>
        <div class="products-grid">
            <?php foreach ($relatedProducts as $relProduct): 
                $relDiscount = round((($relProduct['original_price'] - $relProduct['price']) / $relProduct['original_price']) * 100);
            ?>
            <div class="product-card reveal hover-lift">
                <?php if ($relDiscount > 0): ?>
                <span class="product-badge"><?php echo $relDiscount; ?>% OFF</span>
                <?php endif; ?>
                <button class="product-wishlist" title="Add to Wishlist">
                    <i class="far fa-heart"></i>
                </button>
                <div class="product-image">
                    <img src="assets/images/products/<?php echo $relProduct['image']; ?>" alt="<?php echo $relProduct['name']; ?>">
                    <div class="product-actions">
                        <button class="product-action-btn" onclick="addToCart(<?php echo $relProduct['id']; ?>)" title="Add to Cart">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                        <a href="product-detail.php?id=<?php echo $relProduct['id']; ?>" class="product-action-btn" title="View Details">
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </div>
                <div class="product-info">
                    <span class="product-category"><?php echo $categories[$relProduct['category']]['name']; ?></span>
                    <h3 class="product-name">
                        <a href="product-detail.php?id=<?php echo $relProduct['id']; ?>"><?php echo $relProduct['name']; ?></a>
                    </h3>
                    <div class="product-rating">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i class="fas fa-star"></i>
                        <?php endfor; ?>
                        <span>(<?php echo $relProduct['reviews']; ?>)</span>
                    </div>
                    <div class="product-price">
                        <span class="current-price"><?php echo CURRENCY_SYMBOL . number_format($relProduct['price']); ?></span>
                        <?php if ($relProduct['original_price'] > $relProduct['price']): ?>
                        <span class="original-price"><?php echo CURRENCY_SYMBOL . number_format($relProduct['original_price']); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once '../includes/footer.php'; ?>
