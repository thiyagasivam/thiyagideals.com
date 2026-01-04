<?php
/**
 * Today's Top Deals
 * Auto-generated specialized deals page
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/todays-deals';

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

$pageTitle = "Today's Top Deals 2026";
$pageDescription = "Fresh deals added today with best discounts - Find Today's Top Deals with massive discounts and offers.";
$pageKeywords = "Today's Top Deals, deals, offers, discounts, online shopping";

// Include header
include 'includes/header.php';
?>

<style>
    /* Modern Today's Deals Styling */
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: rotate 20s linear infinite;
    }
    
    @keyframes rotate {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    .page-header h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }
    
    .page-header .lead {
        font-size: 1.2rem;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 0;
        position: relative;
        z-index: 1;
    }
    
    .breadcrumb a {
        color: white !important;
        text-decoration: none;
        transition: opacity 0.3s;
    }
    
    .breadcrumb a:hover {
        opacity: 0.8;
    }
    
    .stats-badge {
        background: rgba(255,255,255,0.2);
        backdrop-filter: blur(10px);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        position: relative;
        z-index: 1;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    
    .stats-badge h2, .stats-badge h3, .stats-badge h4 {
        font-weight: 900;
        margin-bottom: 0.5rem;
    }
    
    .stats-badge hr {
        border-color: rgba(255,255,255,0.3);
        margin: 1rem 0;
    }
    
    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    
    /* Product Card */
    .product-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        border: none;
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(102, 126, 234, 0.3);
    }
    
    .product-card-link {
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    
    .product-card-link:hover {
        text-decoration: none;
        color: inherit;
    }
    
    .product-image-wrapper {
        position: relative;
        padding-top: 100%;
        background: #f8f9fa;
        overflow: hidden;
    }
    
    .product-image {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 1.5rem;
        transition: transform 0.3s ease;
    }
    
    .product-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .deal-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }
    
    .card-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }
    
    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        line-height: 1.4;
        min-height: 2.8em;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .product-card-link:hover .card-title {
        color: #667eea;
    }
    
    .price-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }
    
    .current-price {
        font-size: 1.5rem;
        font-weight: 900;
        color: #27ae60;
    }
    
    .original-price {
        font-size: 1rem;
        color: #999;
        text-decoration: line-through;
    }
    
    .discount-badge {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 700;
    }
    
    .savings-badge {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 700;
        text-align: center;
        margin-bottom: 1rem;
    }
    
    .store-badge {
        background: #f8f9fa;
        padding: 0.25rem 0.75rem;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
    }
    
    .stock-status {
        font-size: 0.85rem;
        font-weight: 600;
        color: #27ae60;
    }
    
    .view-deal-btn {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        font-weight: 700;
        font-size: 1rem;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        margin-top: auto;
    }
    
    .product-card-link:hover .view-deal-btn {
        background: linear-gradient(135deg, #764ba2, #667eea);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        transform: scale(1.02);
    }
    
    /* SEO Content */
    .seo-content {
        background: white;
        padding: 2rem;
        border-radius: 16px;
        margin-top: 3rem;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .seo-content h2 {
        color: #667eea;
        font-size: 1.8rem;
        margin-bottom: 1rem;
        font-weight: 800;
    }
    
    .seo-content h3 {
        color: #333;
        font-size: 1.3rem;
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 700;
    }
    
    .seo-content ul {
        list-style: none;
        padding-left: 0;
    }
    
    .seo-content li {
        padding: 0.5rem 0;
        padding-left: 2rem;
        position: relative;
    }
    
    .seo-content li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: #27ae60;
        font-weight: bold;
        font-size: 1.2rem;
    }
    
    /* Mobile Responsive */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 1.8rem;
        }
        
        .page-header .lead {
            font-size: 1rem;
        }
        
        .stats-badge {
            padding: 1rem;
            margin-top: 1.5rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }
        
        .product-card:hover {
            transform: none;
        }
        
        .product-card:active {
            transform: scale(0.98);
        }
    }
</style>

<div class="container">
    
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="display-4 mb-3">
                        <span style="font-size: 3rem;">??</span> 
                        Today's Top Deals
                    </h1>
                    <p class="lead mb-4">Fresh deals added today with best discounts</p>
                    
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo SITE_URL; ?>" style="color: white;">Shop</a></li>
                            <li class="breadcrumb-item active" style="color: rgba(255,255,255,0.8);">Today's Top Deals</li>
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
            <div class="products-grid">
                <?php foreach ($filteredDeals as $deal): 
                    $price = floatval($deal['product_sale_price']);
                    $originalPrice = floatval($deal['product_offer_price']);
                    $discount = calculateDiscount($deal['product_offer_price'], $deal['product_sale_price']);
                    $savings = $originalPrice - $price;
                    $pid = $deal['pid'] ?? crc32($deal['product_name'] . $deal['store_name']);
                    $slug = createSlug($deal['product_name']);
                    $productUrl = SITE_URL . "/product/" . $pid . "/" . $slug;
                ?>
                <a href="<?php echo $productUrl; ?>" class="product-card-link" data-product-id="<?php echo $pid; ?>">
                    <div class="product-card">
                        <?php if ($discount >= 40): ?>
                        <div class="deal-badge">
                            🔥 <?php echo number_format($discount); ?>% OFF
                        </div>
                        <?php endif; ?>
                        
                        <div class="product-image-wrapper">
                            <img src="<?php echo htmlspecialchars($deal['product_image']); ?>" 
                                 class="product-image" 
                                 alt="<?php echo htmlspecialchars($deal['product_name']); ?>"
                                 loading="lazy">
                        </div>
                        
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars(substr($deal['product_name'], 0, 80)); ?>
                                <?php echo strlen($deal['product_name']) > 80 ? '...' : ''; ?>
                            </h5>
                            
                            <div class="price-section">
                                <span class="current-price">₹<?php echo number_format($price); ?></span>
                                <?php if ($originalPrice > $price): ?>
                                    <span class="original-price">₹<?php echo number_format($originalPrice); ?></span>
                                    <span class="discount-badge"><?php echo number_format($discount); ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            
                            <?php if ($savings > 0): ?>
                            <div class="savings-badge">
                                💰 Save ₹<?php echo number_format($savings); ?>
                            </div>
                            <?php endif; ?>
                            
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="store-badge">
                                    <i class="bi bi-shop"></i> <?php echo htmlspecialchars($deal['store_name']); ?>
                                </span>
                                <span class="stock-status">
                                    <?php echo $deal['stock_status'] === 'In Stock' ? '✓ In Stock' : '✗ Out of Stock'; ?>
                                </span>
                            </div>
                            
                            <div class="view-deal-btn">
                                <i class="bi bi-eye"></i> View Deal
                            </div>
                        </div>
                    </div>
                </a>
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
                    <h2>Today's Top Deals - Best Offers 2026</h2>
                    <p>Fresh deals added today with best discounts</p>
                    
                    <h3>Why Shop Today's Top Deals?</h3>
                    <ul>
                        <li>?? Verified deals with genuine discounts</li>
                        <li>?? Maximum savings on quality products</li>
                        <li>?? Fast delivery from trusted sellers</li>
                        <li>? Easy returns and customer support</li>
                        <li>?? Secure payment options</li>
                    </ul>
                    
                    <h3>How to Get the Best Deals?</h3>
                    <p>Browse through our curated collection of Today's Top Deals. 
                    Each product is carefully selected to ensure you get the maximum value for your money. 
                    Compare prices, check discounts, and grab the best deals before they expire!</p>
                    
                    <p><strong>Last Updated:</strong> <?php echo date('F d, Y'); ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <script>
    // Product card click tracking
    document.addEventListener('DOMContentLoaded', function() {
        const productCards = document.querySelectorAll('.product-card-link');
        
        productCards.forEach(function(card) {
            // Desktop click tracking
            card.addEventListener('click', function(e) {
                const productId = this.dataset.productId;
                
                // Track click event (analytics)
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'todays_deal_click', {
                        'product_id': productId,
                        'source': 'todays_deals_page'
                    });
                }
                
                // Visual feedback
                this.style.opacity = '0.8';
                setTimeout(() => {
                    this.style.opacity = '1';
                }, 150);
            });
            
            // Mobile touch feedback
            card.addEventListener('touchstart', function() {
                this.querySelector('.product-card').style.transform = 'scale(0.98)';
            }, { passive: true });
            
            card.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.querySelector('.product-card').style.transform = 'scale(1)';
                }, 150);
            }, { passive: true });
        });
    });
    </script>
    
    <?php include 'includes/footer.php'; ?>
