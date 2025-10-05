<?php
/**
 * Noise Smartwatch & Audio Deals
 * Brand-specific deals page - High search volume
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = 'Noise Smartwatch & Audio Deals';
$pageDescription = 'Noise smartwatch and audio deals. Save on Noise smart watches, earbuds, and wearables.';
$pageKeywords = 'noise deals, noise smartwatch deals, noise earbuds offers, noise discount';
$brandName = 'Noise';
$brandKeywords = ['noise'];
$brandColor = '#000000';
$brandIcon = '⌚';

// Fetch all deals from multiple API pages
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by brand keywords
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {
    foreach ($allDeals as $deal) {
        $productName = strtolower($deal['product_name'] ?? '');
        $brandNameLower = strtolower($deal['brand_name'] ?? '');
        
        // Check if product name or brand name contains any brand keyword
        foreach ($brandKeywords as $keyword) {
            if (stripos($productName, $keyword) !== false || stripos($brandNameLower, $keyword) !== false) {
                $filteredDeals[] = $deal;
                break;
            }
        }
    }
}

// Sort by discount percentage
usort($filteredDeals, function($a, $b) {
    $discountA = getDiscountPercentage($a['product_original_price'], $a['product_offer_price']);
    $discountB = getDiscountPercentage($b['product_original_price'], $b['product_offer_price']);
    return $discountB <=> $discountA;
});

$totalDeals = count($filteredDeals);
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
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class="container my-4">
        <!-- Page Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="page-header" style="background: linear-gradient(135deg, <?php echo $brandColor; ?>, <?php echo $brandColor; ?>dd); color: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <h1 class="display-4 mb-2">
                        <span style="font-size: 3rem;"><?php echo $brandIcon; ?></span>
                        <?php echo $pageTitle; ?>
                    </h1>
                    <p class="lead mb-3"><?php echo $pageDescription; ?></p>
                    <div class="d-flex gap-3 flex-wrap">
                        <span class="badge bg-light text-dark fs-6">
                            <i class="bi bi-tags-fill"></i> <?php echo $totalDeals; ?> Deals Available
                        </span>
                        <span class="badge bg-light text-dark fs-6">
                            <i class="bi bi-fire"></i> Updated Today
                        </span>
                        <span class="badge bg-light text-dark fs-6">
                            <i class="bi bi-shield-check"></i> Verified <?php echo $brandName; ?> Products
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($totalDeals > 0): ?>
            <!-- Products Grid -->
            <div class="row g-4" id="products-container">
                <?php foreach ($filteredDeals as $deal): 
                    $pid = $deal['pid'] ?? '';
                    $productName = sanitizeOutput($deal['product_name'] ?? 'Product');
                    $productImage = $deal['product_image'] ?? 'assets/images/placeholder.jpg';
                    $originalPrice = floatval($deal['product_original_price'] ?? 0);
                    $offerPrice = floatval($deal['product_offer_price'] ?? 0);
                    $storeName = sanitizeOutput($deal['store_name'] ?? 'Store');
                    $discount = getDiscountPercentage($originalPrice, $offerPrice);
                    
                    $productUrl = SITE_URL . '/product/' . $pid . '/' . createSlug($productName);
                ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-card h-100">
                        <a href="<?php echo $productUrl; ?>" class="text-decoration-none" data-product-id="<?php echo $pid; ?>" title="View <?php echo $productName; ?> details">
                            <div class="product-image">
                                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" loading="lazy">
                                <?php if ($discount > 0): ?>
                                    <span class="discount-badge"><?php echo round($discount); ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title"><?php echo $productName; ?></h3>
                                <div class="product-price">
                                    <span class="price-current"><?php echo formatPrice($offerPrice); ?></span>
                                    <?php if ($originalPrice > $offerPrice): ?>
                                        <span class="price-original"><?php echo formatPrice($originalPrice); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-store">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                <button class="btn btn-primary btn-sm w-100 mt-2 view-details-btn" data-product-id="<?php echo $pid; ?>" title="View deal for <?php echo $productName; ?>">
                                    <i class="bi bi-eye"></i> View Deal
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
                            <h2 class="h3 mb-3">Why Choose <?php echo $brandName; ?>?</h2>
                            <p>Discover exclusive <?php echo $brandName; ?> deals with up to <?php echo $totalDeals > 0 ? round(max(array_map(function($d) { return getDiscountPercentage($d['product_original_price'], $d['product_offer_price']); }, $filteredDeals))) : 0; ?>% off. We bring you the best <?php echo $brandName; ?> products at unbeatable prices.</p>
                            
                            <h3 class="h5 mt-4 mb-2">How to Find Best <?php echo $brandName; ?> Deals?</h3>
                            <ul>
                                <li>Browse our curated collection of <?php echo $totalDeals; ?> verified <?php echo $brandName; ?> products</li>
                                <li>Compare prices across different sellers to get the best deal</li>
                                <li>Check product ratings and reviews before purchasing</li>
                                <li>Look for additional bank offers and cashback</li>
                                <li>Save your favorite <?php echo $brandName; ?> products for later</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                <h3>No <?php echo $brandName; ?> Deals Available Right Now</h3>
                <p>Check back soon for the latest <?php echo $brandName; ?> deals and offers!</p>
                <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>
