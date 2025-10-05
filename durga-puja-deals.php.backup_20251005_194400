<?php
/**
 * Durga Puja Sale 2025 - Best Festive Deals
 * Seasonal event page - High search volume during festival season
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = 'Durga Puja Sale 2025 - Best Festive Deals';
$pageDescription = 'Biggest Durga Puja sale 2025! Celebrate Navratri with exclusive deals on sarees, jewelry, electronics, home decor, and festive essentials.';
$pageKeywords = 'durga puja deals, navratri sale, pujo offers, festive deals 2025';
$eventName = 'Durga Puja';
$eventColor = '#d32f2f';
$eventIcon = '🙏';
$discountThreshold = 30;

// Fetch all deals from multiple API pages
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by discount threshold for festival offers
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {
    foreach ($allDeals as $deal) {
        $originalPrice = floatval($deal['product_sale_price'] ?? 0);
        $offerPrice = floatval($deal['product_offer_price'] ?? 0);
        $discount = getDiscountPercentage($originalPrice, $offerPrice);
        
        // Include deals with discount above threshold
        if ($discount >= $discountThreshold) {
            $filteredDeals[] = $deal;
        }
    }
}

// Sort by discount percentage (highest first)
usort($filteredDeals, function($a, $b) {
    $discountA = getDiscountPercentage($a['product_sale_price'], $a['product_offer_price']);
    $discountB = getDiscountPercentage($b['product_sale_price'], $b['product_offer_price']);
    return $discountB <=> $discountA;
});

$totalDeals = count($filteredDeals);
$maxDiscount = $totalDeals > 0 ? round(max(array_map(function($d) {
    return getDiscountPercentage($d['product_sale_price'], $d['product_offer_price']);
}, $filteredDeals))) : 0;
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
        .festival-banner {
            background: linear-gradient(135deg, <?php echo $eventColor; ?>, <?php echo $eventColor; ?>dd);
            animation: festiveGlow 3s ease-in-out infinite;
        }
        @keyframes festiveGlow {
            0%, 100% { box-shadow: 0 4px 20px rgba(255,107,0,0.3); }
            50% { box-shadow: 0 8px 30px rgba(255,107,0,0.6); }
        }
        .deal-badge {
            background: <?php echo $eventColor; ?>;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-4">
        <!-- Festival Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="festival-banner text-white p-4 rounded-3 text-center">
                    <div class="display-1 mb-3"><?php echo $eventIcon; ?></div>
                    <h1 class="display-4 fw-bold mb-3"><?php echo $eventName; ?> Sale 2025</h1>
                    <p class="lead fs-3 mb-4">🎉 Up to <?php echo $maxDiscount; ?>% OFF on Everything! 🎉</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-lightning-charge-fill text-warning"></i> <?php echo $totalDeals; ?> Hot Deals
                        </span>
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-fire text-danger"></i> Best Prices
                        </span>
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-truck text-success"></i> Fast Delivery
                        </span>
                    </div>
                    <p class="fs-5 mb-0">
                        <i class="bi bi-clock-fill"></i> Limited Time Offer - Grab Now!
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
                                <i class="bi bi-grid-3x3-gap-fill"></i> Shop by Category
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
                        <!-- Festival Badge -->
                        <?php if ($discount >= 50): ?>
                            <div class="position-absolute top-0 start-0 m-2 z-3">
                                <span class="badge deal-badge text-white px-3 py-2">
                                    🔥 <?php echo $eventName; ?> SPECIAL
                                </span>
                            </div>
                        <?php endif; ?>
                        
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
                                    <i class="bi bi-tag-fill"></i> Save <?php echo formatPrice($savings); ?>
                                </div>
                                <div class="product-store">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2 view-details-btn" data-product-id="<?php echo $pid; ?>" title="View deal for <?php echo $productName; ?>">
                                    <i class="bi bi-lightning-charge-fill"></i> Grab Deal
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
                            <h2 class="h3 mb-3"><?php echo $eventName; ?> Sale 2025 - Best Deals & Offers</h2>
                            <p class="lead">Welcome to the biggest <?php echo $eventName; ?> sale of 2025! Get up to <?php echo $maxDiscount; ?>% off on <?php echo $totalDeals; ?>+ verified deals across all categories.</p>
                            
                            <h3 class="h5 mt-4 mb-2">Why Shop <?php echo $eventName; ?> Deals Here?</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ <strong>Verified Deals:</strong> All <?php echo $eventName; ?> offers are verified and updated daily</li>
                                <li class="mb-2">✅ <strong>Best Prices:</strong> Compare prices across Amazon & Flipkart</li>
                                <li class="mb-2">✅ <strong>Huge Discounts:</strong> Up to <?php echo $maxDiscount; ?>% off on top brands</li>
                                <li class="mb-2">✅ <strong>Fast Delivery:</strong> Get products delivered before <?php echo $eventName; ?></li>
                                <li class="mb-2">✅ <strong>Easy Returns:</strong> Hassle-free returns on all products</li>
                            </ul>
                            
                            <h3 class="h5 mt-4 mb-2">Top Categories in <?php echo $eventName; ?> Sale</h3>
                            <p>📱 Mobiles & Accessories | 💻 Laptops & Computers | 📺 TVs & Appliances | ⌚ Watches & Wearables | 🎧 Audio Devices | 👕 Fashion & Clothing | 🏠 Home & Kitchen | 🎁 Gifts & More</p>
                            
                            <h3 class="h5 mt-4 mb-2">How to Get Best <?php echo $eventName; ?> Deals?</h3>
                            <ol>
                                <li>Browse our curated collection of <?php echo $totalDeals; ?> <?php echo $eventName; ?> deals</li>
                                <li>Filter by category or brand to find what you need</li>
                                <li>Compare prices and discounts across different sellers</li>
                                <li>Click 'Grab Deal' to get the offer before it expires</li>
                                <li>Complete your purchase and enjoy <?php echo $eventName; ?> savings!</li>
                            </ol>
                            
                            <div class="alert alert-warning mt-4">
                                <i class="bi bi-exclamation-triangle-fill"></i> <strong>Hurry!</strong> <?php echo $eventName; ?> deals are limited time only. Stock may run out fast. Grab your favorite products now!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h3><?php echo $eventName; ?> Deals Coming Soon!</h3>
                <p>Get ready for the biggest <?php echo $eventName; ?> sale! Check back soon for exclusive offers and mega discounts.</p>
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
            products.forEach(product => {
                const productName = product.getAttribute('data-product-name');
                if (productName.includes(keyword.toLowerCase())) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    </script>
</body>
</html>
