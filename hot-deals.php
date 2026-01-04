<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/hot-deals';

function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

// Fetch products from multiple pages
$allDeals = [];
for ($page = 1; $page <= 5; $page++) {
    $deals = fetchEarnPeDeals($page);
    if ($deals && is_array($deals)) {
        $allDeals = array_merge($allDeals, $deals);
    }
}

// Filter hot deals (40%+ discount)
$filteredDeals = array_filter($allDeals, function($deal) {
    $discount = (($deal['product_sale_price'] - $deal['product_offer_price']) / $deal['product_sale_price']) * 100;
    return $discount >= 40;
});

// Sort by highest discount first
usort($filteredDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] - $a['product_offer_price']) / $a['product_sale_price']) * 100;
    $discountB = (($b['product_sale_price'] - $b['product_offer_price']) / $b['product_sale_price']) * 100;
    return $discountB <=> $discountA;
});

$currentYear = date('Y');
$currentDate = date('F j, Y');
$avgDiscount = 0;
if (!empty($filteredDeals)) {
    foreach ($filteredDeals as $deal) {
        $avgDiscount += (($deal['product_sale_price'] - $deal['product_offer_price']) / $deal['product_sale_price']) * 100;
    }
    $avgDiscount = round($avgDiscount / count($filteredDeals));
}

$pageTitle = "🔥 Hot Deals 40% OFF or More " . $currentYear . " - Best Discount Offers Today | " . SITE_NAME;
$pageDescription = "🔥 Hottest deals with 40% OFF or more! Massive discounts on quality products from Amazon & Flipkart. Save big today on " . $currentDate . ". Limited time offers!";
$pageKeywords = "hot deals, 40 percent off, best discounts, mega sale, clearance, " . $currentYear;

// Include header
include 'includes/header.php';
?>

    
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?php echo SITE_URL; ?>">Home</a> / 
            <span>Hot Deals (40%+ OFF)</span>
        </nav>
        
        <!-- Hot Deals Header -->
        <div class="hot-deals-header">
            <h1>🔥 HOT DEALS - 40% OFF OR MORE! 🔥</h1>
            <p class="subtitle">Massive Discounts | <?php echo count($filteredDeals); ?> Blazing Hot Offers</p>
            <p style="font-size: 1.2rem; margin-top: 1rem;">⏰ Limited Time Only - Grab Before They're Gone!</p>
        </div>
        
        <!-- Stats Banner -->
        <div class="stats-banner" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
            <div class="stat-box">
                <span class="stat-number"><?php echo count($filteredDeals); ?></span>
                <span class="stat-label">Hot Deals</span>
            </div>
            <div class="stat-box">
                <span class="stat-number"><?php echo $avgDiscount; ?>%</span>
                <span class="stat-label">Avg Discount</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">40%+</span>
                <span class="stat-label">Minimum OFF</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">Today</span>
                <span class="stat-label">Updated <?php echo $currentDate; ?></span>
            </div>
        </div>
        
        <?php if (empty($filteredDeals)): ?>
            <div class="no-deals">
                <h2>No hot deals available right now</h2>
                <p><a href="<?php echo SITE_URL; ?>">View all deals</a></p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($filteredDeals as $index => $deal): 
                    $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
                    $savings = $deal['product_sale_price'] - $deal['product_offer_price'];
                    $discountValue = (int)str_replace(['%', ' OFF'], '', $discountPercent);
                ?>
                    <div class="product-card hot-deal-card">
                        <div class="product-image-section">
                            <div class="fire-badge">
                                🔥 <?php echo $discountValue; ?>% OFF
                            </div>
                            
                            <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                                 alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                                 class="product-image"
                                 loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>">
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo sanitizeOutput($deal['product_name']); ?></h3>
                            
                            <div class="product-pricing">
                                <span class="current-price"><?php echo formatPrice($deal['product_offer_price']); ?></span>
                                <span class="original-price"><?php echo formatPrice($deal['product_sale_price']); ?></span>
                                <span class="discount-badge hot-discount">
                                    <?php echo $discountPercent; ?>
                                </span>
                            </div>
                            
                            <div class="savings-info">
                                <span class="savings-text" style="color: #ff6b6b; font-weight: 700;">
                                    🔥 SAVE ₹<?php echo number_format($savings); ?>!
                                </span>
                            </div>
                            
                            <div class="deal-timer">
                                ⏰ <strong>Deal ends soon!</strong> Hurry up!
                            </div>
                            
                            <div class="product-store">
                                <i class="bi bi-shop"></i> <?php echo sanitizeOutput($deal['store_name']); ?>
                                <span class="delivery-info">
                                    <i class="bi bi-truck"></i> Fast Delivery
                                </span>
                            </div>
                            
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               class="view-details-btn hot-deal-btn"
                               data-product-id="<?php echo $deal['pid']; ?>"
                               title="View details for <?php echo sanitizeOutput($deal['product_name']); ?>">
                                <i class="bi bi-fire"></i>
                                🔥 GRAB THIS HOT DEAL NOW!
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- SEO Content -->
            <div class="seo-content">
                <h2>🔥 Why Are These Deals So Hot?</h2>
                <p>Welcome to the hottest deals section on <?php echo SITE_NAME; ?>! Every product here offers a minimum of 40% discount, with an average discount of <?php echo $avgDiscount; ?>% across all items. These are limited-time offers that won't last long, so grab them while you can!</p>
                
                <h3>What Makes a Deal "Hot"?</h3>
                <ul>
                    <li>🔥 Minimum 40% discount on original price</li>
                    <li>💰 Maximum savings compared to regular prices</li>
                    <li>⏰ Limited time availability</li>
                    <li>✅ Genuine products from trusted sellers</li>
                    <li>🚚 Fast delivery options available</li>
                </ul>
                
                <h3>Shop Smart with Hot Deals</h3>
                <p>Our hot deals are updated daily, featuring the best discounts from Amazon and Flipkart. Whether you're shopping for electronics, fashion, home essentials, or personal care, you'll find incredible savings here. Don't miss out on these limited-time offers!</p>
                
                <h3>Updated: <?php echo $currentDate; ?></h3>
                <p>This page is refreshed multiple times daily to bring you the hottest and latest deals. Bookmark this page and check back often to never miss a great deal!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
