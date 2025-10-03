<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

// Fetch products
$allDeals = [];
for ($page = 1; $page <= 5; $page++) {
    $deals = fetchEarnPeDeals($page);
    if ($deals && is_array($deals)) {
        $allDeals = array_merge($allDeals, $deals);
    }
}

// Filter Amazon products only
$filteredDeals = array_filter($allDeals, function($deal) {
    return strtolower($deal['store_name']) === 'amazon';
});

usort($filteredDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] - $a['product_offer_price']) / $a['product_sale_price']) * 100;
    $discountB = (($b['product_sale_price'] - $b['product_offer_price']) / $b['product_sale_price']) * 100;
    return $discountB <=> $discountA;
});

$currentYear = date('Y');
$currentDate = date('F j, Y');
$pageTitle = "Amazon Deals Today " . $currentYear . " - Best Amazon Offers & Discounts | " . SITE_NAME;
$pageDescription = "🛍️ Best Amazon deals today with up to 70% OFF! " . count($filteredDeals) . " exclusive offers updated " . $currentDate . ". Save big on genuine products with fast delivery!";
$pageKeywords = "amazon deals, amazon offers, amazon discount, amazon sale " . $currentYear;

// Include header
include 'includes/header.php';
?>

<style>
    .amazon-header {
        background: linear-gradient(135deg, #FF9900 0%, #146EB4 100%);
        color: white;
        padding: 2rem;
        border-radius: 12px;
        margin-bottom: 2rem;
    }
    .amazon-badge {
        background: #FF9900;
        color: #232F3E;
        padding: 0.3rem 0.8rem;
        border-radius: 15px;
        font-weight: 700;
        position: absolute;
        top: 10px;
        right: 10px;
        z-index: 2;
    }
</style>
    <div class="container">
        <nav class="breadcrumb">
            <a href="<?php echo SITE_URL; ?>">Home</a> / <span>Amazon Deals</span>
        </nav>
        
        <div class="amazon-header">
            <h1>🛍️ Amazon Deals Today</h1>
            <p><?php echo count($filteredDeals); ?> Exclusive Offers | Updated <?php echo $currentDate; ?></p>
        </div>
        
        <div class="products-grid">
            <?php foreach ($filteredDeals as $index => $deal): 
                $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
                $savings = $deal['product_sale_price'] - $deal['product_offer_price'];
            ?>
                <div class="product-card">
                    <div class="product-image-section">
                        <div class="amazon-badge">Amazon</div>
                        <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                             alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                             class="product-image" loading="<?php echo $index < 6 ? 'eager' : 'lazy'; ?>">
                    </div>
                    <div class="product-info">
                        <h3 class="product-title"><?php echo sanitizeOutput($deal['product_name']); ?></h3>
                        <div class="product-pricing">
                            <span class="current-price"><?php echo formatPrice($deal['product_offer_price']); ?></span>
                            <span class="original-price"><?php echo formatPrice($deal['product_sale_price']); ?></span>
                            <span class="discount-badge"><?php echo $discountPercent; ?></span>
                        </div>
                        <div class="savings-info">
                            <span class="savings-text">💰 Save ₹<?php echo number_format($savings); ?></span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                           class="view-details-btn">
                            <i class="bi bi-cart-plus"></i> View on Amazon
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="seo-content">
            <h2>Why Shop Amazon Deals on <?php echo SITE_NAME; ?>?</h2>
            <p>Discover the best Amazon deals today with verified offers and maximum savings. All products are genuine Amazon products with fast delivery and easy returns. Updated multiple times daily!</p>
        </div>
    </div>
    <?php include 'includes/footer.php'; ?>