<?php
/**
 * Morning Deals & Offers - Early Bird Special
 * Category: Shopping Pattern
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = 'Morning Deals & Offers - Early Bird Special';
$pageDescription = 'Morning special deals! Early bird offers with best morning prices. Fresh deals updated every morning.';
$pageKeywords = 'morning deals, early bird offers, morning shopping, fresh deals';
$categoryName = 'Shopping Pattern';
$categoryColor = '#ffc107';
$categoryIcon = '🌅';

// Fetch all deals
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {

    foreach ($allDeals as $deal) {
        $originalPrice = floatval($deal['product_sale_price'] ?? 0);
        $offerPrice = floatval($deal['product_offer_price'] ?? 0);
        $discount = getDiscountPercentage($originalPrice, $offerPrice);
        
        if ($discount >= 15) {
            $filteredDeals[] = $deal;
        }
    }
}

// Sort by discount
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
    
    <meta property="og:title" content="<?php echo $pageTitle; ?>">
    <meta property="og:description" content="<?php echo $pageDescription; ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo SITE_URL . '/' . basename(__FILE__); ?>">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/style.css">
    
    <style>
        .category-banner {
            background: linear-gradient(135deg, <?php echo $categoryColor; ?>, <?php echo $categoryColor; ?>dd);
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-4">
        <div class="row mb-4">
            <div class="col-12">
                <div class="category-banner text-white p-4 rounded-3 text-center">
                    <div class="display-1 mb-3"><?php echo $categoryIcon; ?></div>
                    <h1 class="display-4 fw-bold mb-3"><?php echo str_replace(["Deals & Offers - ", "Best "], "", $pageTitle); ?></h1>
                    <p class="lead fs-3 mb-4">🎯 <?php echo $totalDeals; ?> Deals | Up to <?php echo $maxDiscount; ?>% OFF 🎯</p>
                </div>
            </div>
        </div>

        <?php if ($totalDeals > 0): ?>
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
                <div class="col-6 col-md-4 col-lg-3 product-item">
                    <div class="product-card h-100">
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
                                <button class="btn btn-primary btn-sm w-100 mt-2 view-details-btn" data-product-id="<?php echo $pid; ?>" title="View deal">
                                    <i class="bi bi-cart-plus-fill"></i> View Deal
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h3>No Deals Available Right Now</h3>
                <p>Check back soon for amazing offers!</p>
                <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
