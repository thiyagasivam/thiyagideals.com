<?php
/**
 * Same Day Delivery Deals - Get It Today
 * Category: Delivery
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

$pageTitle = 'Same Day Delivery Deals - Get It Today';
$pageDescription = 'Same day delivery! Get your products delivered today. Order now for instant same-day delivery.';
$pageKeywords = 'same day delivery, instant delivery, get today, fast shipping';
$categoryName = 'Delivery';
$categoryColor = '#4caf50';
$categoryIcon = '🚀';

// Fetch all deals
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {

    $brandKeywords = ['same day', 'today delivery', 'instant'];
    foreach ($allDeals as $deal) {
        $productName = strtolower($deal['product_name'] ?? '');
        $brandName = strtolower($deal['brand_name'] ?? '');
        $description = strtolower($deal['product_description'] ?? '');
        
        foreach ($brandKeywords as $keyword) {
            if (stripos($productName, $keyword) !== false || 
                stripos($brandName, $keyword) !== false ||
                stripos($description, $keyword) !== false) {
                $filteredDeals[] = $deal;
                break;
            }
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
                                <div class="col-6 col-md-4 col-lg-3 product-item" data-product-name="<?php echo strtolower($productName); ?>">
                    <div class="product-card h-100 position-relative">
                        <!-- Multiple Badges -->
                        <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-between align-items-start p-2 z-3">
                            <!-- Best Value Badge -->
                            <?php if ($discount >= 50): ?>
                                <span class="badge bg-danger text-white px-2 py-1 mb-1 pulse-animation">
                                    🔥 HOT DEAL
                                </span>
                            <?php elseif ($discount >= 40): ?>
                                <span class="badge bg-warning text-dark px-2 py-1 mb-1">
                                    💎 BEST VALUE
                                </span>
                            <?php endif; ?>
                            
                            <!-- Urgency Badge -->
                            <?php 
                            $urgencyMessages = [
                                '⚡ ENDING SOON',
                                '🔥 LIMITED STOCK',
                                '⏰ HURRY UP',
                                '💥 ALMOST GONE',
                                '🎯 GRAB NOW'
                            ];
                            $urgencyIndex = crc32($pid) % count($urgencyMessages);
                            ?>
                            <span class="badge bg-dark text-white px-2 py-1 mb-1 blink-animation">
                                <?php echo $urgencyMessages[$urgencyIndex]; ?>
                            </span>
                        </div>
                        
                        <a href="<?php echo $productUrl; ?>" class="text-decoration-none" data-product-id="<?php echo $pid; ?>" title="View <?php echo $productName; ?> details">
                            <div class="product-image">
                                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" loading="lazy">
                                <span class="discount-badge"><?php echo round($discount); ?>% OFF</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title" title="<?php echo $productName; ?>">
                                    <?php echo $productName; ?>
                                </h3>
                                
                                <!-- Price Section -->
                                <div class="product-price mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="price-current"><?php echo formatPrice($offerPrice); ?></span>
                                        <span class="price-original"><?php echo formatPrice($originalPrice); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Savings Highlight -->
                                <div class="savings-badge text-success fw-bold mb-2">
                                    <i class="bi bi-piggy-bank-fill"></i> Save <?php echo formatPrice($savings); ?>
                                </div>
                                
                                <!-- Urgency Factor -->
                                <?php 
                                $stockMessages = [
                                    ['text' => 'Only 3 left in stock!', 'class' => 'text-danger', 'icon' => 'exclamation-circle-fill'],
                                    ['text' => 'Low stock - order soon!', 'class' => 'text-warning', 'icon' => 'clock-fill'],
                                    ['text' => 'Selling fast!', 'class' => 'text-info', 'icon' => 'fire'],
                                ];
                                $stockIndex = crc32($pid) % count($stockMessages);
                                $stockMsg = $stockMessages[$stockIndex];
                                ?>
                                <div class="urgency-text <?php echo $stockMsg['class']; ?> small mb-2">
                                    <i class="bi bi-<?php echo $stockMsg['icon']; ?>"></i> <?php echo $stockMsg['text']; ?>
                                </div>
                                
                                <!-- Store Badge -->
                                <div class="product-store mb-2">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                
                                <!-- Powerful CTA Button -->
                                <button class="btn btn-danger btn-sm w-100 mt-2 view-details-btn cta-button" 
                                        data-product-id="<?php echo $pid; ?>" 
                                        title="Get this deal now!">
                                    <i class="bi bi-lightning-charge-fill"></i> 
                                    <strong>GRAB THIS DEAL</strong>
                                </button>
                                
                                <!-- Secondary CTA -->
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-eye-fill"></i> 
                                        <?php echo rand(50, 500); ?> people viewing
                                    </small>
                                </div>
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
