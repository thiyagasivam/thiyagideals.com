<?php
/**
 * Student Deals & Offers - Best Deals for Students
 * Category: Audience
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/students-deals';

$pageTitle = 'Student Deals & Offers - Best Deals for Students';
$pageDescription = 'Best deals for students! Shop laptops, books, stationery, electronics, backpacks for college and school. Student discount offers.';
$pageKeywords = 'student deals, college offers, student discount, education deals';
$categoryName = 'Audience';
$categoryColor = '#4caf50';
$categoryIcon = '🎓';

// Fetch all deals
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals
$filteredDeals = [];
if ($allDeals && is_array($allDeals)) {

    $brandKeywords = ['student', 'college', 'school', 'study', 'education'];
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
    
        /* Product Title Enhancement - Fix Overlap */
                .product-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem;
            min-height: 2.8em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4em;
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
                /* Product Card Hover Effect */
        .product-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: white;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-color: #ff4757;
        }
        
        /* Discount Badge Enhancement */
                /* Discount Badge Enhancement - Fixed Positioning */
        .discount-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            font-weight: 800;
            font-size: 0.9rem;
            padding: 5px 12px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
            z-index: 10;
            animation: pulse-badge 2s ease-in-out infinite;
        }
        
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
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
                /* Product Image Container - Fix Overlap */
        .product-image {
            position: relative;
            z-index: 1;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        
        /* Product Info Section */
                /* Product Info Section - Fix Overlap */
        .product-info {
            position: relative;
            z-index: 2;
            background: white;
            padding: 12px;
            margin-top: 0;
            border-radius: 0 0 8px 8px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
                    .product-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem;
            min-height: 2.8em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4em;
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
                            $urgencyIndex = crc32($deal['pid']) % count($urgencyMessages);
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
                                $stockIndex = crc32($deal['pid']) % count($stockMessages);
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
