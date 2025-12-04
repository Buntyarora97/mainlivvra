<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Site Configuration
define('SITE_NAME', 'LIVVRA');
define('SITE_TAGLINE', 'Live Better Live Strong');
define('SITE_EMAIL', 'livvraindia@gmail.com');
define('SITE_PHONE', '+91 9876543210');
define('SITE_ADDRESS', 'Dr Tridosha Herbotech Pvt Ltd, Sco no 27, Second Floor, Phase 3, Model Town, Bathinda 151001');
define('CURRENCY_SYMBOL', '₹');

// Google Maps coordinates for Bathinda
define('MAP_LAT', '30.2110');
define('MAP_LNG', '74.9455');

// Initialize cart if not exists
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Helper function to get cart count
function getCartCount() {
    $count = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $count += $item['quantity'];
        }
    }
    return $count;
}

// Helper function to get cart total
function getCartTotal() {
    $total = 0;
    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    }
    return $total;
}

// Products data (in real application, this would come from database)
$products = [
    1 => [
        'id' => 1,
        'name' => 'Pure Shilajit Gold',
        'category' => 'mens-health',
        'price' => 1499,
        'original_price' => 1999,
        'description' => 'Premium Himalayan Shilajit enriched with gold for enhanced energy and vitality. 100% natural and lab tested.',
        'benefits' => ['Boosts Energy', 'Enhances Stamina', 'Improves Immunity', 'Natural Aphrodisiac'],
        'image' => 'shilajit-gold.jpg',
        'rating' => 4.8,
        'reviews' => 256
    ],
    2 => [
        'id' => 2,
        'name' => 'Ashwagandha Capsules',
        'category' => 'daily-wellness',
        'price' => 599,
        'original_price' => 799,
        'description' => 'Organic Ashwagandha root extract capsules for stress relief and improved sleep quality.',
        'benefits' => ['Reduces Stress', 'Better Sleep', 'Muscle Recovery', 'Mental Clarity'],
        'image' => 'ashwagandha.jpg',
        'rating' => 4.7,
        'reviews' => 189
    ],
    3 => [
        'id' => 3,
        'name' => 'Aloe Vera Gel',
        'category' => 'skin-care',
        'price' => 349,
        'original_price' => 499,
        'description' => 'Pure Aloe Vera gel for skin hydration, acne control, and natural glow.',
        'benefits' => ['Deep Hydration', 'Acne Control', 'Anti-Aging', 'Sun Protection'],
        'image' => 'aloe-vera.jpg',
        'rating' => 4.6,
        'reviews' => 342
    ],
    4 => [
        'id' => 4,
        'name' => 'Protein Powder Plus',
        'category' => 'gym-foods',
        'price' => 1899,
        'original_price' => 2499,
        'description' => 'Plant-based protein powder with added vitamins and minerals for muscle building.',
        'benefits' => ['Muscle Building', 'Fast Recovery', 'High Protein', 'No Artificial Flavors'],
        'image' => 'protein-powder.jpg',
        'rating' => 4.9,
        'reviews' => 167
    ],
    5 => [
        'id' => 5,
        'name' => 'Weight Loss Formula',
        'category' => 'weight-management',
        'price' => 899,
        'original_price' => 1299,
        'description' => 'Natural weight management supplement with Garcinia Cambogia and Green Tea extract.',
        'benefits' => ['Burns Fat', 'Appetite Control', 'Boosts Metabolism', 'Natural Ingredients'],
        'image' => 'weight-loss.jpg',
        'rating' => 4.5,
        'reviews' => 298
    ],
    6 => [
        'id' => 6,
        'name' => 'Heart Care Capsules',
        'category' => 'heart-care',
        'price' => 799,
        'original_price' => 1099,
        'description' => 'Ayurvedic formulation for heart health with Arjuna and Omega-3 fatty acids.',
        'benefits' => ['Healthy Heart', 'Blood Pressure', 'Cholesterol Control', 'Circulation'],
        'image' => 'heart-care.jpg',
        'rating' => 4.7,
        'reviews' => 156
    ],
    7 => [
        'id' => 7,
        'name' => 'Amla Juice',
        'category' => 'ayurvedic-juices',
        'price' => 299,
        'original_price' => 399,
        'description' => 'Pure Amla juice rich in Vitamin C for immunity and digestive health.',
        'benefits' => ['Immunity Boost', 'Digestive Health', 'Hair Growth', 'Skin Glow'],
        'image' => 'amla-juice.jpg',
        'rating' => 4.8,
        'reviews' => 423
    ],
    8 => [
        'id' => 8,
        'name' => 'Diabetic Care Plus',
        'category' => 'blood-sugar',
        'price' => 699,
        'original_price' => 999,
        'description' => 'Herbal supplement for blood sugar management with Karela and Jamun extracts.',
        'benefits' => ['Blood Sugar Control', 'Pancreas Health', 'Natural Formula', 'Safe Long-term Use'],
        'image' => 'diabetic-care.jpg',
        'rating' => 4.6,
        'reviews' => 278
    ],
    9 => [
        'id' => 9,
        'name' => 'Immunity Booster',
        'category' => 'daily-wellness',
        'price' => 449,
        'original_price' => 599,
        'description' => 'Powerful immunity booster with Giloy, Tulsi, and Turmeric extracts.',
        'benefits' => ['Strong Immunity', 'Fights Infections', 'Antioxidant Rich', 'Daily Protection'],
        'image' => 'immunity-booster.jpg',
        'rating' => 4.9,
        'reviews' => 512
    ],
    10 => [
        'id' => 10,
        'name' => 'Hair Growth Oil',
        'category' => 'skin-care',
        'price' => 399,
        'original_price' => 549,
        'description' => 'Ayurvedic hair oil with Bhringraj, Amla, and Coconut for healthy hair growth.',
        'benefits' => ['Hair Growth', 'Prevents Hairfall', 'Nourishes Scalp', 'Reduces Dandruff'],
        'image' => 'hair-oil.jpg',
        'rating' => 4.7,
        'reviews' => 367
    ],
    11 => [
        'id' => 11,
        'name' => 'Energy Drink Mix',
        'category' => 'gym-foods',
        'price' => 549,
        'original_price' => 749,
        'description' => 'Natural energy drink powder with electrolytes and B-vitamins for workout performance.',
        'benefits' => ['Instant Energy', 'Electrolyte Balance', 'Pre-Workout', 'No Crash'],
        'image' => 'energy-drink.jpg',
        'rating' => 4.6,
        'reviews' => 198
    ],
    12 => [
        'id' => 12,
        'name' => 'Joint Pain Relief',
        'category' => 'daily-wellness',
        'price' => 649,
        'original_price' => 899,
        'description' => 'Herbal formulation with Boswellia and Turmeric for joint pain and inflammation.',
        'benefits' => ['Pain Relief', 'Reduces Inflammation', 'Joint Mobility', 'Cartilage Support'],
        'image' => 'joint-pain.jpg',
        'rating' => 4.8,
        'reviews' => 234
    ]
];

// Categories
$categories = [
    'skin-care' => ['name' => 'Skin Care', 'icon' => 'fa-spa', 'description' => 'Natural skincare products'],
    'gym-foods' => ['name' => 'Gym Foods', 'icon' => 'fa-dumbbell', 'description' => 'Nutrition for fitness'],
    'mens-health' => ['name' => "Men's Health", 'icon' => 'fa-mars', 'description' => 'Vitality and energy'],
    'weight-management' => ['name' => 'Weight Management', 'icon' => 'fa-weight-scale', 'description' => 'Healthy weight loss'],
    'heart-care' => ['name' => 'Heart Care', 'icon' => 'fa-heart-pulse', 'description' => 'Cardiovascular health'],
    'daily-wellness' => ['name' => 'Daily Wellness', 'icon' => 'fa-leaf', 'description' => 'Everyday health'],
    'ayurvedic-juices' => ['name' => 'Ayurvedic Juices', 'icon' => 'fa-glass-water', 'description' => 'Pure herbal juices'],
    'blood-sugar' => ['name' => 'Blood Sugar & Chronic Care', 'icon' => 'fa-droplet', 'description' => 'Diabetes management']
];

// Function to get products by category
function getProductsByCategory($category, $products) {
    return array_filter($products, function($product) use ($category) {
        return $product['category'] === $category;
    });
}

// Function to get featured products
function getFeaturedProducts($products, $limit = 8) {
    return array_slice($products, 0, $limit);
}
?>
