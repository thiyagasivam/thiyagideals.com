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

<style>
    /* Modern Hot Deals Styling */
    .hot-deals-hero {
        background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
        color: white;
        padding: 3rem 2rem;
        border-radius: 16px;
        margin-bottom: 2rem;
        text-align: center;
        box-shadow: 0 10px 40px rgba(255, 107, 107, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .hot-deals-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: pulse 4s ease-in-out infinite;
    }
    
    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 0.5; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
    
    .hot-deals-hero h1 {
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }
    
    .hero-subtitle {
        font-size: 1.3rem;
        margin-bottom: 0.5rem;
        font-weight: 600;
        position: relative;
        z-index: 1;
    }
    
    .hero-timer {
        font-size: 1.1rem;
        background: rgba(255,255,255,0.2);
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        display: inline-block;
        margin-top: 1rem;
        backdrop-filter: blur(10px);
        position: relative;
        z-index: 1;
    }
    
    /* Stats Banner */
    .stats-banner {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
        padding: 2rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        box-shadow: 0 10px 40px rgba(102, 126, 234, 0.3);
    }
    
    .stat-box {
        text-align: center;
        color: white;
    }
    
    .stat-number {
        display: block;
        font-size: 2.5rem;
        font-weight: 900;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    }
    
    .stat-label {
        display: block;
        font-size: 0.9rem;
        opacity: 0.9;
        font-weight: 600;
    }
    
    /* Product Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 2rem;
        margin: 2rem 0;
    }
    
    /* Hot Deal Card */
    .hot-deal-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 2px solid transparent;
        position: relative;
    }
    
    .hot-deal-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        border-radius: 16px;
        padding: 2px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
        -webkit-mask-composite: xor;
        mask-composite: exclude;
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    
    .hot-deal-card:hover::before {
        opacity: 1;
    }
    
    .hot-deal-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(255, 107, 107, 0.3);
    }
    
    .product-card-link {
        text-decoration: none;
        color: inherit;
        display: block;
        height: 100%;
    }
    
    .product-card-link:hover {
        text-decoration: none;
        color: inherit;
    }
    
    .product-image-section {
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
        transition: transform 0.3s ease;
    }
    
    .hot-deal-card:hover .product-image {
        transform: scale(1.05);
    }
    
    .fire-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.9rem;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        z-index: 2;
        animation: fireGlow 2s ease-in-out infinite;
    }
    
    @keyframes fireGlow {
        0%, 100% { box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4); }
        50% { box-shadow: 0 4px 25px rgba(255, 107, 107, 0.8); }
    }
    
    .product-info {
        padding: 1.5rem;
    }
    
    .product-title {
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
    
    .hot-deal-card:hover .product-title {
        color: #ff6b6b;
    }
    
    .product-pricing {
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
    
    .hot-discount {
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 4px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 700;
    }
    
    .savings-info {
        background: linear-gradient(135deg, #fff5f5, #ffe5e5);
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        text-align: center;
    }
    
    .savings-text {
        color: #ff6b6b;
        font-weight: 700;
        font-size: 1rem;
    }
    
    .deal-timer {
        background: #fff3cd;
        border-left: 4px solid #ffc107;
        padding: 0.75rem;
        margin-bottom: 1rem;
        border-radius: 4px;
        font-size: 0.9rem;
        color: #856404;
    }
    
    .product-store {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #666;
        margin-bottom: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }
    
    .delivery-info {
        color: #27ae60;
        font-weight: 600;
    }
    
    .hot-deal-btn {
        display: block;
        width: 100%;
        background: linear-gradient(135deg, #ff6b6b, #ee5a6f);
        color: white;
        padding: 1rem;
        border-radius: 10px;
        text-align: center;
        font-weight: 700;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(255, 107, 107, 0.3);
    }
    
    .product-card-link:hover .hot-deal-btn {
        background: linear-gradient(135deg, #ee5a6f, #ff6b6b);
        box-shadow: 0 6px 20px rgba(255, 107, 107, 0.5);
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
        color: #ff6b6b;
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
        .hot-deals-hero h1 {
            font-size: 1.8rem;
        }
        
        .hero-subtitle {
            font-size: 1rem;
        }
        
        .stats-banner {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            padding: 1rem;
        }
        
        .stat-number {
            font-size: 1.8rem;
        }
        
        .products-grid {
            grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
            gap: 1rem;
        }
        
        .hot-deal-card:hover {
            transform: none;
        }
        
        .hot-deal-card:active {
            transform: scale(0.98);
        }
    }
</style>

<div class="container">
    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?php echo SITE_URL; ?>">Home</a> / 
        <span>Hot Deals (40%+ OFF)</span>
    </nav>
    
    <!-- Hot Deals Hero -->
    <div class="hot-deals-hero">
        <h1>🔥 HOT DEALS - 40% OFF OR MORE! 🔥</h1>
        <p class="hero-subtitle">Massive Discounts | <?php echo count($filteredDeals); ?> Blazing Hot Offers</p>
        <div class="hero-timer">⏰ Limited Time Only - Grab Before They're Gone!</div>
    </div>
    
    <!-- Stats Banner -->
    <div class="stats-banner">
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
                $pid = $deal['pid'] ?? crc32($deal['product_name'] . $deal['store_name']);
                $slug = generateSlug($deal['product_name']);
                $productUrl = SITE_URL . "/product/" . $pid . "/" . $slug;
            ?>
                <a href="<?php echo $productUrl; ?>" class="product-card-link" data-product-id="<?php echo $pid; ?>">
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
                                <span class="hot-discount">
                                    <?php echo $discountPercent; ?>
                                </span>
                            </div>
                            
                            <div class="savings-info">
                                <span class="savings-text">
                                    🔥 SAVE ₹<?php echo number_format($savings); ?>!
                                </span>
                            </div>
                            
                            <div class="deal-timer">
                                ⏰ <strong>Deal ends soon!</strong> Hurry up!
                            </div>
                            
                            <div class="product-store">
                                <span><i class="bi bi-shop"></i> <?php echo sanitizeOutput($deal['store_name']); ?></span>
                                <span class="delivery-info">
                                    <i class="bi bi-truck"></i> Fast Delivery
                                </span>
                            </div>
                            
                            <div class="hot-deal-btn">
                                <i class="bi bi-fire"></i>
                                🔥 GRAB THIS HOT DEAL NOW!
                            </div>
                        </div>
                    </div>
                </a>
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
                    gtag('event', 'hot_deal_click', {
                        'product_id': productId,
                        'source': 'hot_deals_page'
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
                this.querySelector('.hot-deal-card').style.transform = 'scale(0.98)';
            }, { passive: true });
            
            card.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.querySelector('.hot-deal-card').style.transform = 'scale(1)';
                }, 150);
            }, { passive: true });
        });
    });
    </script>
    
    <?php include 'includes/footer.php'; ?>
