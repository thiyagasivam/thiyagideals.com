<?php
/**
 * 70% OFF Deals - Get 70 Percent Discount
 * Discount percentage page - High search volume for discount-specific searches
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = '70% OFF Deals - Get 70 Percent Discount';
$pageDescription = 'Incredible 70% off deals! Get 70 percent discount on electronics, fashion, mobiles, home products. Best 70% OFF offers - super savings!';
$pageKeywords = '70 percent off, 70% discount, deals 70 off, 70 percent discount';
$discountLabel = '70% OFF';
$minDiscount = 70;
$maxDiscount = 74;
$discountColor = '#9c27b0';
$discountIcon = '⚡';
$discountMessage = 'Super Savings! Get 70% off - limited time only!';

// Fetch all deals from multiple API pages
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by discount percentage
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {
    foreach ($allDeals as $deal) {
        $originalPrice = floatval($deal['product_sale_price'] ?? 0);
        $offerPrice = floatval($deal['product_offer_price'] ?? 0);
        $discount = getDiscountPercentage($originalPrice, $offerPrice);
        
        // Include deals within discount range
        if ($discount >= $minDiscount && $discount < $maxDiscount) {
            $filteredDeals[] = $deal;
        }
    }
}

// Sort by offer price (lowest first for best deals)
usort($filteredDeals, function($a, $b) {
    return floatval($a['product_offer_price']) <=> floatval($b['product_offer_price']);
});

$totalDeals = count($filteredDeals);
$avgSavings = $totalDeals > 0 ? round(array_sum(array_map(function($d) {
    return floatval($d['product_sale_price'] ?? 0) - floatval($d['product_offer_price'] ?? 0);
}, $filteredDeals)) / $totalDeals) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - <?php echo SITE_NAME; ?></title>
    <meta name="description" content="<?php echo $pageDescription; ?>">
    <meta name="keywords" content="<?php echo $pageKeywords; ?>">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL . '/' . basename(__FILE__); ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        .discount-banner {
            background: linear-gradient(135deg, <?php echo $discountColor; ?>, <?php echo $discountColor; ?>dd);
            animation: discountPulse 2s ease-in-out infinite;
        }
        @keyframes discountPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .discount-badge {
            background: <?php echo $discountColor; ?>;
        }
    
        /* Product Title Enhancement - Fix Overlap */
        .product-title {
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden !important;
            text-overflow: ellipsis;
            line-height: 1.4;
            max-height: 2.8em;
            min-height: 2.8em;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem;
            white-space: normal !important;
        }
        
        /* Powerful CTA Button */
        .cta-button {
            background: linear-gradient(135deg, #ff4757, #ff6348);
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .cta-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .cta-button:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4);
            background: linear-gradient(135deg, #ff6348, #ff4757);
        }
        
        .cta-button:active {
            transform: translateY(0);
        }
        
        /* Urgency Animations */
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.9; }
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .blink-animation {
            animation: blink 1.5s ease-in-out infinite;
        }
        
        /* Savings Badge Enhancement */
        .savings-badge {
            background: #d4edda;
            border: 2px solid #28a745;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            display: inline-block;
        }
        
        /* Urgency Text Styling */
        .urgency-text {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 8px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 4px;
            display: inline-block;
        }
        
        /* Product Card Hover Effect */
        .product-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-color: #ff4757;
        }
        
        /* Discount Badge Enhancement */
        .discount-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            font-weight: 800;
            font-size: 0.9rem;
            padding: 5px 12px;
            box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
        }
        
        /* Price Display Enhancement */
        .price-current {
            font-size: 1.3rem;
            font-weight: 800;
            color: #27ae60;
        }
        
        .price-original {
            font-size: 0.9rem;
            color: #95a5a6;
            text-decoration: line-through;
        }
        
        /* Product Image Container */
        .product-image {
            position: relative;
            z-index: 1;
        }
        
        /* Product Info Section */
        .product-info {
            position: relative;
            z-index: 2;
            background: white;
            padding: 12px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .product-title {
                font-size: 0.8rem;
                -webkit-line-clamp: 2;
                min-height: 2.4em;
            }
            
            .cta-button {
                font-size: 0.75rem;
                padding: 8px 12px;
            }
            
            .urgency-text {
                font-size: 0.7rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-4">
        <!-- Discount Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="discount-banner text-white p-4 rounded-3 text-center">
                    <div class="display-1 mb-3"><?php echo $discountIcon; ?></div>
                    <h1 class="display-3 fw-bold mb-3"><?php echo $discountLabel; ?> DEALS</h1>
                    <p class="lead fs-3 mb-4"><?php echo $discountMessage; ?></p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                        <span class="badge bg-white text-dark fs-4 px-4 py-3">
                            <i class="bi bi-tag-fill text-danger"></i> <?php echo $totalDeals; ?> Deals
                        </span>
                        <span class="badge bg-white text-dark fs-4 px-4 py-3">
                            <i class="bi bi-piggy-bank-fill text-success"></i> Avg Save: ₹<?php echo number_format($avgSavings); ?>
                        </span>
                        <span class="badge bg-white text-dark fs-4 px-4 py-3">
                            <i class="bi bi-lightning-charge-fill text-warning"></i> Hot Offers
                        </span>
                    </div>
                    <p class="fs-4 mb-0">
                        <i class="bi bi-clock-fill"></i> Limited Time - Grab Before Stock Runs Out!
                    </p>
                </div>
            </div>
        </div>

        <?php if ($totalDeals > 0): ?>
            <!-- Category Quick Links -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-3">
                                <i class="bi bi-funnel-fill"></i> Filter by Category
                            </h3>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('mobile')">📱 Mobiles</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('laptop')">💻 Laptops</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('tv')">📺 TVs</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('watch')">⌚ Watches</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('headphone')">🎧 Audio</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('fashion')">👕 Fashion</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('home')">🏠 Home</button>
                                <button class="btn btn-outline-primary" onclick="location.reload()">🔄 Show All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="row g-4" id="products-container">
                <?php foreach ($filteredDeals as $deal): 
                    $pid = $deal['pid'] ?? '';
                    $productName = sanitizeOutput($deal['product_name'] ?? 'Product');
                    $productImage = $deal['product_image'] ?? 'assets/images/placeholder.jpg';
                    $originalPrice = floatval($deal['product_sale_price'] ?? 0);
                    $offerPrice = floatval($deal['product_offer_price'] ?? 0);
                    $storeName = sanitizeOutput($deal['store_name'] ?? 'Store');
                    $discount = getDiscountPercentage($originalPrice, $offerPrice);
                    $savings = $originalPrice - $offerPrice;
                    
                    $productUrl = SITE_URL . '/product/' . $pid . '/' . createSlug($productName);
                ?>
                <div class="col-6 col-md-4 col-lg-3 product-item" data-product-name="<?php echo strtolower($productName); ?>">
                    <div class="product-card h-100 position-relative">
                        <!-- Discount Badge -->
                        <div class="position-absolute top-0 start-0 m-2 z-3">
                            <span class="badge discount-badge text-white px-3 py-2 fs-6">
                                <?php echo round($discount); ?>% OFF
                            </span>
                        </div>
                        
                        <a href="<?php echo $productUrl; ?>" class="text-decoration-none" data-product-id="<?php echo $pid; ?>" title="View <?php echo $productName; ?> details">
                            <div class="product-image">
                                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" loading="lazy">
                                <span class="discount-badge"><?php echo round($discount); ?>% OFF</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo $productName; ?></h3>
                                <div class="product-price">
                                    <span class="price-current"><?php echo formatPrice($offerPrice); ?></span>
                                    <span class="price-original"><?php echo formatPrice($originalPrice); ?></span>
                                </div>
                                <div class="text-success fw-bold mb-2">
                                    <i class="bi bi-cash-coin"></i> You Save: <?php echo formatPrice($savings); ?>
                                </div>
                                <div class="product-store">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2 view-details-btn" data-product-id="<?php echo $pid; ?>" title="View deal for <?php echo $productName; ?>">
                                    <i class="bi bi-lightning-charge-fill"></i> Get <?php echo $discountLabel; ?>
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- SEO Content Section -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="h3 mb-3"><?php echo $discountLabel; ?> Deals - Complete Shopping Guide</h2>
                            <p class="lead">Get amazing <?php echo $discountLabel; ?> on <?php echo $totalDeals; ?> verified products! Shop electronics, mobiles, fashion, home essentials with huge savings.</p>
                            
                            <h3 class="h5 mt-4 mb-2">Why Shop <?php echo $discountLabel; ?> Deals?</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ <strong>Verified Discounts:</strong> All <?php echo $discountLabel; ?> offers are verified and updated daily</li>
                                <li class="mb-2">✅ <strong>Best Prices:</strong> Compare prices across Amazon & Flipkart</li>
                                <li class="mb-2">✅ <strong>Huge Savings:</strong> Average savings of ₹<?php echo number_format($avgSavings); ?> per product</li>
                                <li class="mb-2">✅ <strong>Quality Products:</strong> <?php echo $totalDeals; ?> top-rated products to choose from</li>
                                <li class="mb-2">✅ <strong>Fast Delivery:</strong> Quick delivery from trusted sellers</li>
                            </ul>
                            
                            <h3 class="h5 mt-4 mb-2">Popular Categories with <?php echo $discountLabel; ?></h3>
                            <p>📱 Mobiles & Accessories | 💻 Laptops & Computers | 📺 TVs & Appliances | ⌚ Watches & Wearables | 🎧 Audio Devices | 👕 Fashion & Clothing | 🏠 Home & Kitchen | 🎮 Gaming & Entertainment</p>
                            
                            <h3 class="h5 mt-4 mb-2">How to Shop <?php echo $discountLabel; ?> Deals?</h3>
                            <ol>
                                <li>Browse our collection of <?php echo $totalDeals; ?> products with <?php echo $discountLabel; ?></li>
                                <li>Use category filters to find what you need quickly</li>
                                <li>Compare prices and check product ratings</li>
                                <li>Click 'Get <?php echo $discountLabel; ?>' to grab the deal</li>
                                <li>Complete your purchase and save big!</li>
                            </ol>
                            
                            <div class="alert alert-success mt-4">
                                <i class="bi bi-lightning-charge-fill"></i> <strong>Hot Tip!</strong> <?php echo $discountLabel; ?> deals are limited time only. Average savings: ₹<?php echo number_format($avgSavings); ?> per product. Don't miss out!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h3>No <?php echo $discountLabel; ?> Deals Available Right Now</h3>
                <p>Check back soon for amazing <?php echo $discountLabel; ?> offers!</p>
                <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function filterByKeyword(keyword) {
            const products = document.querySelectorAll('.product-item');
            let visibleCount = 0;
            products.forEach(product => {
                const productName = product.getAttribute('data-product-name');
                if (productName.includes(keyword.toLowerCase())) {
                    product.style.display = '';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });
            window.scrollTo({ top: 300, behavior: 'smooth' });
            
            if (visibleCount === 0) {
                alert('No products found in this category with the selected discount. Showing all products.');
                location.reload();
            }
        }
    </script>
</body>
</html>
