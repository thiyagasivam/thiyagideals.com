<?php
/**
 * This Week's Best Deals
 * Auto-generated specialized deals page
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Fetch all deals from multiple API pages
$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Helper function for keyword matching
function matchesKeywords($text, $keywords) {
    $text = strtolower($text);
    foreach ($keywords as $keyword) {
        if (strpos($text, strtolower($keyword)) !== false) {
            return true;
        }
    }
    return false;
}

// Filter deals based on criteria
$filteredDeals = array_filter($allDeals, function($deal) {
    $price = floatval($deal['product_sale_price']);
    $discount = getDiscountPercentage($deal['product_offer_price'], $deal['product_sale_price']);
    
    return $discount >= 35;
});

// Sort by discount (highest first)
usort($filteredDeals, function($a, $b) {
    return getDiscountPercentage($b['product_offer_price'], $b['product_sale_price']) - getDiscountPercentage($a['product_offer_price'], $a['product_sale_price']);
});

$totalDeals = count($filteredDeals);
$avgDiscount = 0;
if ($totalDeals > 0) {
    $discountSum = 0;
    foreach ($filteredDeals as $deal) {
        $discountSum += getDiscountPercentage($deal['product_offer_price'], $deal['product_sale_price']);
    }
    $avgDiscount = $discountSum / $totalDeals;
}

// Calculate total savings
$totalSavings = 0;
foreach ($filteredDeals as $deal) {
    $savings = floatval($deal['product_offer_price']) - floatval($deal['product_sale_price']);
    $totalSavings += $savings;
}

$pageTitle = "This Week's Best Deals 2025";
$metaDescription = "Top deals of the week with huge savings - Find This Week's Best Deals with massive discounts and offers.";
$pageDescription = $metaDescription;
$pageKeywords = "This Week's Best Deals, deals, offers, discounts, online shopping";

// Include header
include 'includes/header.php';
?>

    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 mb-3">
                        <span style="font-size: 3rem;">??</span> 
                        This Week's Best Deals
                    </h1>
                    <p class="lead mb-4">Top deals of the week with huge savings</p>
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Shop</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">This Week's Best Deals</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-4">
                    <div class="stats-badge text-center">
                        <h2 class="mb-0"><?php echo $totalDeals; ?></h2>
                        <small>Amazing Deals</small>
                        <hr style="border-color: rgba(255,255,255,0.3); margin: 10px 0;">
                        <h3 class="mb-0"><?php echo number_format($avgDiscount, 1); ?>%</h3>
                        <small>Avg Discount</small>
                        <?php if ($totalSavings > 0): ?>
                        <hr style="border-color: rgba(255,255,255,0.3); margin: 10px 0;">
                        <h4 class="mb-0">?<?php echo number_format($totalSavings); ?></h4>
                        <small>Total Savings</small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Deals Grid -->
    <div class="container mb-5">
        <?php if ($totalDeals > 0): ?>
            <div class="row g-4" id="deals-grid">
                <?php foreach ($filteredDeals as $deal): 
                    $price = floatval($deal['product_sale_price']);
                    $originalPrice = floatval($deal['product_offer_price']);
                    $discount = calculateDiscount($deal['product_offer_price'], $deal['product_sale_price']);
                    $savings = $originalPrice - $price;
                ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 product-card">
                        <?php if ($discount >= 40): ?>
                        <div class="deal-badge" style="position: absolute; top: 10px; left: 10px; z-index: 1;">
                            ?? <?php echo number_format($discount); ?>% OFF
                        </div>
                        <?php endif; ?>
                        
                        <img src="<?php echo htmlspecialchars($deal['product_image']); ?>" 
                             class="card-img-top" 
                             alt="<?php echo htmlspecialchars($deal['product_name']); ?>"
                             style="height: 200px; object-fit: contain; padding: 20px;">
                        
                        <div class="card-body">
                            <h5 class="card-title" style="font-size: 14px; min-height: 60px; overflow: hidden;">
                                <?php echo htmlspecialchars(substr($deal['product_name'], 0, 80)); ?>
                                <?php echo strlen($deal['product_name']) > 80 ? '...' : ''; ?>
                            </h5>
                            
                            <div class="price-section mb-2">
                                <span class="current-price">?<?php echo number_format($price); ?></span>
                                <?php if ($originalPrice > $price): ?>
                                    <span class="original-price">?<?php echo number_format($originalPrice); ?></span>
                                    <span class="discount-badge"><?php echo number_format($discount); ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($savings > 0): ?>
                            <div class="savings-badge mb-2">
                                ?? Save ?<?php echo number_format($savings); ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="store-badge">
                                    <?php echo htmlspecialchars($deal['store_name']); ?>
                                </span>
                                <span class="stock-status">
                                    <?php echo $deal['stock_status'] === 'In Stock' ? '? In Stock' : '? Out of Stock'; ?>
                                </span>
                            </div>
                            
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo createSlug($deal['product_name']); ?>" data-product-id="<?php echo $deal['pid']; ?>" title="View details for <?php echo sanitizeOutput($deal['product_name']); ?>" class="btn btn-primary w-100">
                                View Deal
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <h4>No deals found matching this criteria</h4>
                <p>Check back later for new deals or <a href="<?php echo SITE_URL; ?>">browse all deals</a></p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- SEO Content -->
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="seo-content" style="background: #f8f9fa; padding: 30px; border-radius: 10px;">
                    <h2>This Week's Best Deals - Best Offers 2025</h2>
                    <p>Top deals of the week with huge savings</p>
                    
                    <h3>Why Shop This Week's Best Deals?</h3>
                    <ul>
                        <li>?? Verified deals with genuine discounts</li>
                        <li>?? Maximum savings on quality products</li>
                        <li>?? Fast delivery from trusted sellers</li>
                        <li>? Easy returns and customer support</li>
                        <li>?? Secure payment options</li>
                    </ul>
                    
                    <h3>How to Get the Best Deals?</h3>
                    <p>Browse through our curated collection of This Week's Best Deals. 
                    Each product is carefully selected to ensure you get the maximum value for your money. 
                    Compare prices, check discounts, and grab the best deals before they expire!</p>
                    
                    <p><strong>Last Updated:</strong> <?php echo date('F d, Y'); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <?php include 'includes/footer.php'; ?>
