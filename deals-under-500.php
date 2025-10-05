<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Generate SEO-friendly URL slug
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

// Filter products under ₹500
$filteredDeals = array_filter($allDeals, function($deal) {
    return $deal['product_offer_price'] < 500;
});

// Sort by best discount
usort($filteredDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] - $a['product_offer_price']) / $a['product_sale_price']) * 100;
    $discountB = (($b['product_sale_price'] - $b['product_offer_price']) / $b['product_sale_price']) * 100;
    return $discountB <=> $discountA;
});

$currentYear = date('Y');
$currentDate = date('F j, Y');

$pageTitle = "Best Deals Under ₹500 " . $currentYear . " - Budget Shopping Offers Today | " . SITE_NAME;
$pageDescription = "🛍️ Shop the best deals under ₹500! Amazing discounts on quality products. Budget-friendly shopping with up to 70% OFF. Updated " . $currentDate . ". Free delivery available!";
$pageKeywords = "deals under 500, budget shopping, cheap deals, best offers, affordable products, " . $currentYear;

// Include header
include 'includes/header.php';
?>
    
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?php echo SITE_URL; ?>">Home</a> / 
            <span>Deals Under ₹500</span>
        </nav>
        
        <!-- Page Header -->
        <div class="page-header">
            <h1>💰 Best Deals Under ₹500</h1>
            <p class="subtitle">Budget-Friendly Shopping | <?php echo count($filteredDeals); ?> Amazing Deals</p>
        </div>
        
        <!-- Stats Banner -->
        <div class="stats-banner">
            <div class="stat-box">
                <span class="stat-number"><?php echo count($filteredDeals); ?></span>
                <span class="stat-label">Products Available</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">Up to 70%</span>
                <span class="stat-label">Discount</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">Under ₹500</span>
                <span class="stat-label">Budget Range</span>
            </div>
            <div class="stat-box">
                <span class="stat-number">Today</span>
                <span class="stat-label">Updated <?php echo $currentDate; ?></span>
            </div>
        </div>
        
        <?php if (empty($filteredDeals)): ?>
            <div class="no-deals">
                <h2>No deals found under ₹500</h2>
                <p><a href="<?php echo SITE_URL; ?>">View all deals</a></p>
            </div>
        <?php else: ?>
            <div class="products-grid">
                <?php foreach ($filteredDeals as $index => $deal): 
                    $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
                    $savings = $deal['product_sale_price'] - $deal['product_offer_price'];
                    $isHotDeal = (int)str_replace(['%', ' OFF'], '', $discountPercent) > 40;
                ?>
                    <div class="product-card <?php echo $isHotDeal ? 'hot-deal-card' : ''; ?>">
                        <div class="product-image-section">
                            <?php if ($isHotDeal): ?>
                                <div class="product-badge">
                                    <span class="discount-badge-corner">🔥 HOT DEAL</span>
                                </div>
                            <?php endif; ?>
                            
                            <div class="budget-badge">
                                <span>💰 Under ₹500</span>
                            </div>
                            
                            <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                                 alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                                 class="product-image"
                                 loading="<?php echo $index < 6 ? 'eager' : 'lazy'; ?>">
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo sanitizeOutput($deal['product_name']); ?></h3>
                            
                            <div class="product-pricing">
                                <span class="current-price"><?php echo formatPrice($deal['product_offer_price']); ?></span>
                                <span class="original-price"><?php echo formatPrice($deal['product_sale_price']); ?></span>
                                <span class="discount-badge <?php echo $isHotDeal ? 'hot-discount' : ''; ?>">
                                    <?php echo $discountPercent; ?>
                                </span>
                            </div>
                            
                            <div class="savings-info">
                                <span class="savings-text">
                                    💰 You save ₹<?php echo number_format($savings); ?>
                                </span>
                            </div>
                            
                            <div class="product-store">
                                <i class="bi bi-shop"></i> <?php echo sanitizeOutput($deal['store_name']); ?>
                                <span class="delivery-info">
                                    <i class="bi bi-truck"></i> Free Delivery
                                </span>
                            </div>
                            
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               class="view-details-btn <?php echo $isHotDeal ? 'hot-deal-btn' : ''; ?>"
                               data-product-id="<?php echo $deal['pid']; ?>"
                               title="View details for <?php echo sanitizeOutput($deal['product_name']); ?>">
                                <i class="bi bi-cart-plus"></i>
                                <?php echo $isHotDeal ? '🔥 Grab Hot Deal Now!' : 'View Details & Buy Now'; ?>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- SEO Content -->
            <div class="seo-content">
                <h2>Why Shop Deals Under ₹500?</h2>
                <p>Discover amazing budget-friendly deals under ₹500 on <?php echo SITE_NAME; ?>! Our curated collection features quality products at unbeatable prices. Whether you're looking for electronics, fashion, home essentials, or personal care items, we've got you covered with the best discounts in <?php echo $currentYear; ?>.</p>
                
                <h3>Benefits of Budget Shopping</h3>
                <ul>
                    <li>💰 Save money without compromising on quality</li>
                    <li>🎁 Perfect for gifts within budget</li>
                    <li>🛒 Try new products risk-free</li>
                    <li>🚚 Most products qualify for free delivery</li>
                    <li>⭐ Genuine products from trusted stores</li>
                </ul>
                
                <h3>Updated Daily with Fresh Deals</h3>
                <p>Our team updates this page daily to bring you the latest and best deals under ₹500. All products are hand-picked from Amazon and Flipkart, ensuring authenticity and competitive pricing. Shop with confidence!</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php include 'includes/footer.php'; ?>
