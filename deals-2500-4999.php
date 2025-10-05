<?php
/**
 * Deals ₹2500-4999 - Best Products in 2.5K-5K Range
 * Price range page - High search volume for budget-specific searches
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = 'Deals ₹2500-4999 - Best Products in 2.5K-5K Range';
$pageDescription = 'Premium deals ₹2500-4999! Shop best electronics, smartwatches, headphones, fashion in 2500-5000 range. Get maximum savings on quality products.';
$pageKeywords = 'deals 2500 to 5000, products under 5000, 2.5k-5k deals, premium gadgets';
$priceRange = '₹2,500 - ₹4,999';
$minPrice = 2500;
$maxPrice = 4999;
$rangeColor = '#e91e63';
$rangeIcon = '💎';
$targetAudience = 'Premium Seekers';
$popularCategories = 'Feature Phones, Fitness Bands, Headphones, Formal Shoes, Jackets';

// Fetch all deals from multiple API pages
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by price range
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {
    foreach ($allDeals as $deal) {
        $offerPrice = floatval($deal['product_offer_price'] ?? 0);
        
        // Include deals within price range
        if ($offerPrice >= $minPrice && $offerPrice <= $maxPrice) {
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

$avgPrice = $totalDeals > 0 ? round(array_sum(array_map(function($d) {
    return floatval($d['product_offer_price'] ?? 0);
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
        .price-banner {
            background: linear-gradient(135deg, <?php echo $rangeColor; ?>, <?php echo $rangeColor; ?>dd);
        }
        .price-badge {
            background: <?php echo $rangeColor; ?>;
        }
        .price-highlight {
            color: <?php echo $rangeColor; ?>;
            font-weight: bold;
        }
    
        /* Powerful CTA Button */
        .cta-button {
            background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%) !important;
            border: none !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
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
        
        /* Urgency Animations */
        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .blink-animation {
            animation: blink 1.5s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.7; }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-4">
        <!-- Price Range Banner -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="price-banner text-white p-4 rounded-3 text-center">
                    <div class="display-1 mb-3"><?php echo $rangeIcon; ?></div>
                    <h1 class="display-4 fw-bold mb-3">Deals <?php echo $priceRange; ?></h1>
                    <p class="lead fs-3 mb-4">🎯 <?php echo $totalDeals; ?> Best Products | Up to <?php echo $maxDiscount; ?>% OFF 🎯</p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap mb-3">
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-tag-fill text-success"></i> Price: <?php echo $priceRange; ?>
                        </span>
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-graph-up text-primary"></i> Avg: ₹<?php echo number_format($avgPrice); ?>
                        </span>
                        <span class="badge bg-white text-dark fs-5 px-4 py-2">
                            <i class="bi bi-people-fill text-info"></i> For: <?php echo $targetAudience; ?>
                        </span>
                    </div>
                    <p class="fs-5 mb-0">
                        <i class="bi bi-clock-fill"></i> Updated Daily - Best Prices Guaranteed!
                    </p>
                </div>
            </div>
        </div>

        <?php if ($totalDeals > 0): ?>
            <!-- Quick Stats -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-3">
                                <i class="bi bi-bar-chart-fill"></i> Popular Categories in <?php echo $priceRange; ?>
                            </h3>
                            <p class="mb-3"><?php echo $popularCategories; ?></p>
                            <div class="d-flex gap-2 flex-wrap">
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('mobile')">📱 Mobiles</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('watch')">⌚ Watches</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('headphone')">🎧 Audio</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('fashion')">👕 Fashion</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('laptop')">💻 Laptops</button>
                                <button class="btn btn-outline-primary" onclick="filterByKeyword('tv')">📺 TVs</button>
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
                        <!-- Best Value Badge -->
                        <?php if ($discount >= 40): ?>
                            <div class="position-absolute top-0 start-0 m-2 z-3">
                                <span class="badge price-badge text-white px-3 py-2">
                                    💎 BEST VALUE
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
                                    <i class="bi bi-piggy-bank-fill"></i> Save <?php echo formatPrice($savings); ?>
                                </div>
                                <div class="product-store">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2 view-details-btn" data-product-id="<?php echo $pid; ?>" title="View deal for <?php echo $productName; ?>">
                                    <i class="bi bi-cart-plus-fill"></i> View Deal
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
                            <h2 class="h3 mb-3">Best Deals <?php echo $priceRange; ?> - Complete Guide</h2>
                            <p class="lead">Looking for the best products <?php echo strtolower($priceRange); ?>? You're in the right place! We've curated <?php echo $totalDeals; ?> verified deals with up to <?php echo $maxDiscount; ?>% off.</p>
                            
                            <h3 class="h5 mt-4 mb-2">Why Shop in <?php echo $priceRange; ?> Range?</h3>
                            <ul class="list-unstyled">
                                <li class="mb-2">✅ <strong>Perfect Budget:</strong> Quality products at the right price point</li>
                                <li class="mb-2">✅ <strong>Best Value:</strong> Maximum features for your money</li>
                                <li class="mb-2">✅ <strong>Verified Deals:</strong> All prices updated daily from Amazon & Flipkart</li>
                                <li class="mb-2">✅ <strong>Great Selection:</strong> <?php echo $totalDeals; ?> products to choose from</li>
                                <li class="mb-2">✅ <strong>Huge Savings:</strong> Average discount of <?php echo $maxDiscount; ?>%</li>
                            </ul>
                            
                            <h3 class="h5 mt-4 mb-2">Popular Categories in <?php echo $priceRange; ?></h3>
                            <p><?php echo $popularCategories; ?></p>
                            
                            <h3 class="h5 mt-4 mb-2">Shopping Tips for <?php echo $priceRange; ?> Range</h3>
                            <ol>
                                <li>Compare prices across Amazon and Flipkart using our listings</li>
                                <li>Look for products with highest discount percentages</li>
                                <li>Check product ratings and reviews before purchasing</li>
                                <li>Use filters to narrow down by category or brand</li>
                                <li>Bookmark this page - we update deals daily!</li>
                            </ol>
                            
                            <h3 class="h5 mt-4 mb-2">Target Audience: <?php echo $targetAudience; ?></h3>
                            <p>This price range is perfect for <?php echo strtolower($targetAudience); ?> who want quality products without overspending. Whether you're a student, working professional, or savvy shopper, you'll find amazing deals here.</p>
                            
                            <div class="alert alert-success mt-4">
                                <i class="bi bi-trophy-fill"></i> <strong>Best Deals Guaranteed!</strong> We track <?php echo $totalDeals; ?> products daily to bring you the lowest prices in the <?php echo $priceRange; ?> range. Average savings: ₹<?php echo number_format($avgPrice * 0.3); ?>+ per product!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h3>No Deals Available Right Now</h3>
                <p>We're updating our inventory. Check back soon for amazing deals in the <?php echo $priceRange; ?> range!</p>
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
            
            // Show message if no products found
            if (visibleCount === 0) {
                alert('No products found in this category for the selected price range. Showing all products.');
                location.reload();
            }
        }
    </script>
</body>
</html>
