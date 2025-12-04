<?php
require_once '../includes/config.php';

$currentCategory = isset($_GET['category']) ? $_GET['category'] : null;
$searchQuery = isset($_GET['search']) ? $_GET['search'] : null;

// Filter products
$filteredProducts = $products;

if ($currentCategory && isset($categories[$currentCategory])) {
    $filteredProducts = getProductsByCategory($currentCategory, $products);
    $pageTitle = $categories[$currentCategory]['name'];
} elseif ($searchQuery) {
    $filteredProducts = array_filter($products, function($product) use ($searchQuery) {
        return stripos($product['name'], $searchQuery) !== false || 
               stripos($product['description'], $searchQuery) !== false;
    });
    $pageTitle = 'Search Results for "' . htmlspecialchars($searchQuery) . '"';
} else {
    $pageTitle = 'All Products';
}

require_once '../includes/header.php';
?>

<!-- Page Banner -->
<section class="page-banner">
    <div class="page-banner-content">
        <h1><?php echo $pageTitle; ?></h1>
        <div class="breadcrumb">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Products</span>
            <?php if ($currentCategory): ?>
            <span>/</span>
            <span><?php echo $categories[$currentCategory]['name']; ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Products Section -->
<section class="products-section">
    <div class="container">
        <div class="products-layout">
            <!-- Sidebar -->
            <aside class="products-sidebar">
                <div class="filter-card">
                    <h4>Categories</h4>
                    <ul class="filter-list">
                        <li>
                            <a href="products.php" class="<?php echo !$currentCategory ? 'active' : ''; ?>">
                                All Products
                                <span class="filter-count"><?php echo count($products); ?></span>
                            </a>
                        </li>
                        <?php foreach ($categories as $slug => $cat): 
                            $catCount = count(getProductsByCategory($slug, $products));
                        ?>
                        <li>
                            <a href="products.php?category=<?php echo $slug; ?>" class="<?php echo $currentCategory === $slug ? 'active' : ''; ?>">
                                <i class="fas <?php echo $cat['icon']; ?>"></i> <?php echo $cat['name']; ?>
                                <span class="filter-count"><?php echo $catCount; ?></span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="filter-card">
                    <h4>Price Range</h4>
                    <div class="price-range">
                        <input type="range" min="0" max="5000" value="5000" class="price-slider" id="priceRange">
                        <div class="price-inputs">
                            <input type="number" placeholder="Min" id="minPrice">
                            <input type="number" placeholder="Max" id="maxPrice" value="5000">
                        </div>
                    </div>
                </div>
                
                <div class="filter-card">
                    <h4>Customer Rating</h4>
                    <ul class="filter-list">
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="far fa-star" style="color: var(--primary-gold);"></i>
                                    & Up
                                </span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="fas fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="far fa-star" style="color: var(--primary-gold);"></i>
                                    <i class="far fa-star" style="color: var(--primary-gold);"></i>
                                    & Up
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </aside>
            
            <!-- Products Grid -->
            <div class="products-content">
                <div class="products-toolbar">
                    <div class="products-count">
                        Showing <strong><?php echo count($filteredProducts); ?></strong> products
                    </div>
                    <div class="products-sort">
                        <select id="sortProducts">
                            <option value="default">Sort by: Default</option>
                            <option value="price-low">Price: Low to High</option>
                            <option value="price-high">Price: High to Low</option>
                            <option value="rating">Customer Rating</option>
                            <option value="newest">Newest First</option>
                        </select>
                    </div>
                </div>
                
                <?php if (empty($filteredProducts)): ?>
                <div class="empty-cart">
                    <i class="fas fa-search"></i>
                    <h3>No Products Found</h3>
                    <p>Try adjusting your filters or search query</p>
                    <a href="products.php" class="view-all-btn">View All Products</a>
                </div>
                <?php else: ?>
                <div class="products-grid">
                    <?php foreach ($filteredProducts as $product): 
                        $discount = round((($product['original_price'] - $product['price']) / $product['original_price']) * 100);
                    ?>
                    <div class="product-card reveal hover-lift">
                        <?php if ($discount > 0): ?>
                        <span class="product-badge"><?php echo $discount; ?>% OFF</span>
                        <?php endif; ?>
                        <button class="product-wishlist" title="Add to Wishlist">
                            <i class="far fa-heart"></i>
                        </button>
                        <div class="product-image">
                            <img src="assets/images/products/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                            <div class="product-actions">
                                <button class="product-action-btn" onclick="addToCart(<?php echo $product['id']; ?>)" title="Add to Cart">
                                    <i class="fas fa-shopping-cart"></i>
                                </button>
                                <a href="product-detail.php?id=<?php echo $product['id']; ?>" class="product-action-btn" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        <div class="product-info">
                            <span class="product-category"><?php echo $categories[$product['category']]['name']; ?></span>
                            <h3 class="product-name">
                                <a href="product-detail.php?id=<?php echo $product['id']; ?>"><?php echo $product['name']; ?></a>
                            </h3>
                            <div class="product-rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <?php if ($i <= floor($product['rating'])): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($i - 0.5 <= $product['rating']): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                <span>(<?php echo $product['reviews']; ?>)</span>
                            </div>
                            <div class="product-price">
                                <span class="current-price"><?php echo CURRENCY_SYMBOL . number_format($product['price']); ?></span>
                                <?php if ($product['original_price'] > $product['price']): ?>
                                <span class="original-price"><?php echo CURRENCY_SYMBOL . number_format($product['original_price']); ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>
