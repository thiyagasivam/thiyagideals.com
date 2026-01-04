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

// Function to sanitize output
function sanitizeOutput($text) {
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

// Fetch deals from multiple pages for better variety
$allDeals = [];
for ($page = 1; $page <= 8; $page++) {
    $pageDeals = fetchEarnPeDeals($page);
    if ($pageDeals && is_array($pageDeals)) {
        $allDeals = array_merge($allDeals, $pageDeals);
    }
    // Add small delay between API calls
    if ($page < 8) {
        usleep(100000); // 0.1 second delay
    }
}

// If no deals fetched, set empty array to prevent errors
if (!is_array($allDeals)) {
    $allDeals = [];
}

// Sort all deals by discount percentage (highest first)
usort($allDeals, function($a, $b) {
    $discountA = (($a['product_sale_price'] - $a['product_offer_price']) / $a['product_sale_price']) * 100;
    $discountB = (($b['product_sale_price'] - $b['product_offer_price']) / $b['product_sale_price']) * 100;
    return $discountB <=> $discountA;
});

// Separate different deal categories with error handling
$flashDeals = [];
$hotDeals = [];
$topDeals = [];
$recentDeals = [];

if (!empty($allDeals) && is_array($allDeals)) {
    $flashDeals = array_slice(array_filter($allDeals, function($deal) {
        if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price'])) {
            return false;
        }
        $salePrice = floatval($deal['product_sale_price']);
        $offerPrice = floatval($deal['product_offer_price']);
        if ($salePrice <= 0) return false;
        $discount = (($salePrice - $offerPrice) / $salePrice) * 100;
        return $discount >= 50; // Flash deals with 50%+ discount
    }), 0, 12);

    $hotDeals = array_slice(array_filter($allDeals, function($deal) {
        if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price'])) {
            return false;
        }
        $salePrice = floatval($deal['product_sale_price']);
        $offerPrice = floatval($deal['product_offer_price']);
        if ($salePrice <= 0) return false;
        $discount = (($salePrice - $offerPrice) / $salePrice) * 100;
        return $discount >= 30 && $discount < 50; // Hot deals with 30-49% discount
    }), 0, 12);

    $topDeals = array_slice($allDeals, 0, 12); // Top 12 deals by highest discount
    $recentDeals = array_slice($allDeals, 12, 8); // Next 8 deals as "recent"
}

$currentYear = date('Y');
$currentDate = date('F j, Y');
$currentTime = date('H:i');

$pageTitle = "Best Deals & Offers " . $currentYear . " - Flash Sales, Hot Deals | " . SITE_NAME;
$pageDescription = "ðŸ”¥ Discover flash deals, hot offers & amazing discounts from top stores. Updated " . $currentDate . " at " . $currentTime . ". Save big on electronics, fashion, home & more!";
$pageKeywords = "flash deals, hot deals, offers today, discounts " . $currentYear . ", shopping, best prices, electronics deals, fashion offers";

// Enhanced SEO Meta
$canonicalUrl = SITE_URL;

// Ensure we have deals data
if (empty($allDeals)) {
    $allDeals = [];
}

// Collection Page Schema
$collectionSchema = [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => "Hot Deals & Offers " . $currentYear,
    "description" => $pageDescription,
    "url" => $canonicalUrl,
    "mainEntity" => [
        "@type" => "ItemList",
        "numberOfItems" => count($allDeals),
        "itemListElement" => []
    ],
    "breadcrumb" => [
        "@type" => "BreadcrumbList",
        "itemListElement" => [
            [
                "@type" => "ListItem",
                "position" => 1,
                "name" => "Home",
                "item" => SITE_URL
            ],
            [
                "@type" => "ListItem",
                "position" => 2,
                "name" => "Deals",
                "item" => $canonicalUrl
            ]
        ]
    ]
];

// Local Business Schema
$localBusinessSchema = [
    "@context" => "https://schema.org",
    "@type" => "LocalBusiness",
    "name" => SITE_NAME,
    "image" => SITE_URL . "/assets/images/logo.png",
    "url" => SITE_URL,
    "telephone" => "+91-XXXXXXXXXX",
    "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => "123 Commerce Street",
        "addressLocality" => "Chennai",
        "addressRegion" => "Tamil Nadu",
        "postalCode" => "600001",
        "addressCountry" => "IN"
    ],
    "geo" => [
        "@type" => "GeoCoordinates",
        "latitude" => 13.0827,
        "longitude" => 80.2707
    ],
    "openingHoursSpecification" => [
        "@type" => "OpeningHoursSpecification",
        "dayOfWeek" => [
            "Monday",
            "Tuesday", 
            "Wednesday",
            "Thursday",
            "Friday",
            "Saturday",
            "Sunday"
        ],
        "opens" => "00:00",
        "closes" => "23:59"
    ],
    "sameAs" => [
        "https://thiyagi.com"
    ]
];

// Add products to collection schema
if (!empty($allDeals) && is_array($allDeals)) {
    foreach (array_slice($allDeals, 0, 20) as $index => $deal) {
        if (!isset($deal['product_name']) || !isset($deal['product_offer_price'])) {
            continue;
        }
        $collectionSchema["mainEntity"]["itemListElement"][] = [
            "@type" => "ListItem",
            "position" => $index + 1,
            "item" => [
                "@type" => "Product",
                "name" => $deal['product_name'],
                "image" => htmlspecialchars_decode($deal['product_image']),
                "url" => SITE_URL . "/product/" . $deal['pid'] . "/" . generateSlug($deal['product_name']),
                "offers" => [
                    "@type" => "Offer",
                    "price" => $deal['product_offer_price'],
                    "priceCurrency" => "INR",
                    "availability" => "https://schema.org/InStock",
                    "seller" => [
                        "@type" => "Organization",
                        "name" => $deal['store_name']
                    ]
                ]
            ]
        ];
    }
}

include 'includes/header.php';
?>

<style>
/* Modern Homepage Styles */
.hero-slider {
    position: relative;
    height: 400px;
    margin-bottom: 2rem;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 0.5s ease-in-out;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    text-align: center;
}

.slide.active {
    opacity: 1;
}

.slide-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.3);
    z-index: 1;
}

.slide-content {
    position: relative;
    z-index: 2;
}

.slide-content h2 {
    font-size: 3rem;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.7);
}

.slide-content p {
    font-size: 1.2rem;
    margin-bottom: 2rem;
    text-shadow: 1px 1px 4px rgba(0,0,0,0.7);
}

.urgency-banner {
    background: linear-gradient(45deg, #ff4757, #ff6b7a);
    color: white;
    padding: 1rem;
    margin-bottom: 2rem;
    border-radius: 10px;
    text-align: center;
    font-weight: bold;
    animation: pulse 2s infinite;
    box-shadow: 0 5px 15px rgba(255, 71, 87, 0.3);
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.02); }
    100% { transform: scale(1); }
}

.live-metrics {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.metric-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    border-left: 4px solid #667eea;
}

.metric-number {
    font-size: 2rem;
    font-weight: bold;
    color: #667eea;
    display: block;
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.section-title {
    font-size: 2rem;
    font-weight: bold;
    color: #333;
    margin: 0;
}

.section-icon {
    font-size: 2.5rem;
    margin-right: 0.5rem;
}

.view-all-btn {
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 25px;
    text-decoration: none;
    font-weight: bold;
    transition: transform 0.3s ease;
}

.view-all-btn:hover {
    transform: translateY(-2px);
    color: white;
}

.deals-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1.5rem;
    margin-bottom: 3rem;
}

.deal-card {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    position: relative;
}

.deal-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.deal-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.deal-image img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 1rem;
    background: #f8f9fa;
}

.deal-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: linear-gradient(45deg, #ff4757, #ff6b7a);
    color: white;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: bold;
    font-size: 0.9rem;
    z-index: 2;
}

.urgency-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #ff9f43;
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: bold;
    animation: blink 1.5s infinite;
}

@keyframes blink {
    0%, 50% { opacity: 1; }
    51%, 100% { opacity: 0.7; }
}

.deal-content {
    padding: 1.5rem;
}

.deal-title {
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 1rem;
    height: 2.5rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    line-clamp: 2;
    -webkit-box-orient: vertical;
}

.price-section {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.current-price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #27ae60;
}

.original-price {
    font-size: 1rem;
    color: #999;
    text-decoration: line-through;
}

.store-badge {
    display: inline-flex;
    align-items: center;
    background: #f8f9fa;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    margin-bottom: 1rem;
}

.deal-btn {
    width: 100%;
    background: linear-gradient(45deg, #667eea, #764ba2);
    color: white;
    border: none;
    padding: 0.75rem;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.deal-btn:hover {
    transform: translateY(-2px);
}

.urgency-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    font-size: 0.85rem;
    border-top: 1px solid #f0f0f0;
    margin-top: 0.5rem;
}

.viewers-count {
    color: #ff4757;
    font-weight: 600;
}

.stock-warning {
    color: #ff6b6b;
    font-weight: 600;
    animation: blink 1.5s infinite;
}

.trending-badge {
    position: absolute;
    top: 50px;
    left: 10px;
    background: linear-gradient(45deg, #f093fb, #f5576c);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: bold;
    z-index: 2;
}

.deal-timer {
    background: #ffe66d;
    color: #333;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: bold;
    display: inline-block;
    margin-top: 0.5rem;
}

.popular-stores {
    background: #f8f9fa;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.stores-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.store-card {
    background: white;
    padding: 1.5rem;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.store-card:hover {
    transform: translateY(-3px);
}

.store-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.countdown-timer {
    background: linear-gradient(45deg, #ff4757, #ff6b7a);
    color: white;
    padding: 1rem;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 2rem;
}

.timer-display {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 1rem;
}

.timer-unit {
    background: rgba(255,255,255,0.2);
    padding: 0.5rem 1rem;
    border-radius: 5px;
    text-align: center;
}

.timer-number {
    font-size: 1.5rem;
    font-weight: bold;
    display: block;
}

.timer-label {
    font-size: 0.8rem;
    opacity: 0.9;
}

@media (max-width: 768px) {
    .deals-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    }
    
    .slide-content h2 {
        font-size: 2rem;
    }
    
    .hero-slider {
        height: 300px;
    }
    
    .timer-display {
        flex-wrap: wrap;
        gap: 0.5rem;
    }
}
</style>

<!-- Hero Slider -->
<div class="hero-slider">
    <div class="slide active" style="background-image: url('https://m.media-amazon.com/images/G/31/IN-Events/Shankhadip/Jupiter25/Jupiter25_T1_Heder_PC_Prime_rec.jpg');">
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <h2>ðŸ”¥ Flash Sale Alert!</h2>
            <p>Up to 90% OFF on Electronics, Fashion & More</p>
            <a href="#flash-deals" class="view-all-btn">Shop Flash Deals</a>
        </div>
    </div>
    <div class="slide" style="background-image: url('https://assets.indiadesire.com/bbd/bbd2026first.png');">
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <h2>âš¡ Hot Deals Today!</h2>
            <p>Limited Time Offers - Don't Miss Out!</p>
            <a href="#hot-deals" class="view-all-btn">View Hot Deals</a>
        </div>
    </div>
    <div class="slide" style="background-image: url('https://m.media-amazon.com/images/G/31/IN-Events/Shankhadip/Jupiter25/Jupiter25_T1_Heder_PC_Prime_rec.jpg');">
        <div class="slide-overlay"></div>
        <div class="slide-content">
            <h2>ðŸ† Top Rated Products</h2>
            <p>Best Quality at Unbeatable Prices</p>
            <a href="#top-deals" class="view-all-btn">Explore Now</a>
        </div>
    </div>
</div>

<div class="container">
    <!-- Urgency Banner -->
    <div class="urgency-banner">
        ðŸš¨ <strong>FLASH SALE ENDING SOON!</strong> Updated <?php echo $currentDate; ?> at <?php echo $currentTime; ?> - <?php echo count($allDeals); ?> Active Deals!
    </div>

    <!-- Live Metrics -->
    <div class="live-metrics">
        <div class="metric-card">
            <span class="metric-number" id="live-viewers">3,247</span>
            <small>ðŸ‘¥ People shopping now</small>
        </div>
        <div class="metric-card">
            <span class="metric-number"><?php echo count($flashDeals); ?></span>
            <small>âš¡ Flash deals available</small>
        </div>
        <div class="metric-card">
            <span class="metric-number">67</span>
            <small>ðŸ”¥ Items sold this hour</small>
        </div>
        <div class="metric-card">
            <span class="metric-number">4.8â˜…</span>
            <small>â­ Customer rating</small>
        </div>
    </div>

    <!-- Countdown Timer -->
    <div class="countdown-timer">
        <h3>â° Flash Sale Ends In:</h3>
        <div class="timer-display" id="countdown">
            <div class="timer-unit">
                <span class="timer-number" id="hours">12</span>
                <span class="timer-label">Hours</span>
            </div>
            <div class="timer-unit">
                <span class="timer-number" id="minutes">34</span>
                <span class="timer-label">Minutes</span>
            </div>
            <div class="timer-unit">
                <span class="timer-number" id="seconds">56</span>
                <span class="timer-label">Seconds</span>
            </div>
        </div>
    </div>

    <!-- Flash Deals Section -->
    <section id="flash-deals" class="mb-5">
        <div class="section-header">
            <h2 class="section-title">
                <span class="section-icon">âš¡</span>Flash Deals
                <small class="text-muted">(50%+ OFF)</small>
            </h2>
            <a href="<?php echo SITE_URL; ?>/flash-sale.php" class="view-all-btn">
                View All Flash Deals <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="deals-grid">
            <?php if (!empty($flashDeals)): ?>
                <?php foreach (array_slice($flashDeals, 0, 8) as $index => $deal): 
                    if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price']) || !isset($deal['product_name'])) {
                        continue;
                    }
                    $salePrice = floatval($deal['product_sale_price']);
                    $offerPrice = floatval($deal['product_offer_price']);
                    if ($salePrice <= 0) continue;
                    
                    $discount = round((($salePrice - $offerPrice) / $salePrice) * 100);
                    $savings = $salePrice - $offerPrice;
                    $urgencyTexts = ['Only 3 left!', 'Limited stock!', 'Almost gone!', 'Last few items!'];
                    $urgencyText = $urgencyTexts[array_rand($urgencyTexts)];
                    $viewersCount = rand(23, 156);
                    $timeLeft = rand(2, 8);
                    $showTrending = ($index % 3 == 0);
                    $soldCount = rand(15, 89)
                ?>
                <div class="deal-card">
                    <div class="deal-image">
                        <div class="urgency-badge"><?php echo $urgencyText; ?></div>
                        <?php if ($showTrending): ?>
                            <div class="trending-badge">🔥 Trending</div>
                        <?php endif; ?>
                        <div class="deal-badge"><?php echo $discount; ?>% OFF</div>
                        <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                             alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                             loading="<?php echo $index < 4 ? 'eager' : 'lazy'; ?>">
                    </div>
                    <div class="deal-content">
                        <h3 class="deal-title">
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput(substr($deal['product_name'], 0, 80)); ?>
                            </a>
                        </h3>
                        <div class="price-section">
                            <span class="current-price">â‚¹<?php echo number_format($offerPrice); ?></span>
                            <span class="original-price">â‚¹<?php echo number_format($salePrice); ?></span>
                        </div>
                        <div class="store-badge">
                            <i class="bi bi-shop"></i> 
                            <a href="<?php echo SITE_URL; ?>/<?php echo strtolower(str_replace(' ', '-', $deal['store_name'])); ?>-deals.php" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput($deal['store_name']); ?>
                            </a>
                        </div>
                        <div class="deal-timer">
                            â° Ends in <?php echo $timeLeft; ?> hours
                        </div>
                        <div class="urgency-info">
                            <span class="viewers-count">
                                <i class="bi bi-eye"></i> <?php echo $viewersCount; ?> viewing
                            </span>
                            <span class="stock-warning">
                                <i class="bi bi-lightning"></i> <?php echo $soldCount; ?> sold
                            </span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" '
                           class="deal-btn"
                           data-product-id="<?php echo $deal['pid']; ?>">
                            <i class="bi bi-lightning-charge"></i> Grab Flash Deal
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h3>âš¡ Flash Deals Loading...</h3>
                    <p>Great deals will appear here soon! Check back in a moment.</p>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Hot Deals Section -->
    <section id="hot-deals" class="mb-5">
        <div class="section-header">
            <h2 class="section-title">
                <span class="section-icon">ðŸ”¥</span>Hot Deals
                <small class="text-muted">(30%+ OFF)</small>
            </h2>
            <a href="<?php echo SITE_URL; ?>/hot-deals.php" class="view-all-btn">
                View All Hot Deals <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="deals-grid">
            <?php if (!empty($hotDeals)): ?>
                <?php foreach (array_slice($hotDeals, 0, 8) as $index => $deal): 
                    if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price']) || !isset($deal['product_name'])) {
                        continue;
                    }
                    $salePrice = floatval($deal['product_sale_price']);
                    $offerPrice = floatval($deal['product_offer_price']);
                    if ($salePrice <= 0) continue;
                    
                    $discount = round((($salePrice - $offerPrice) / $salePrice) * 100);
                    $updateTimes = ['2 mins ago', '5 mins ago', '15 mins ago', '30 mins ago'];
                    $updateTime = $updateTimes[array_rand($updateTimes)];
                    $viewersCount = rand(18, 95);
                    $soldToday = rand(12, 67);
                ?>
                <div class="deal-card">
                    <div class="deal-image">
                        <div class="deal-badge"><?php echo $discount; ?>% OFF</div>
                        <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                             alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="deal-content">
                        <h3 class="deal-title">
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput(substr($deal['product_name'], 0, 80)); ?>
                            </a>
                        </h3>
                        <div class="price-section">
                            <span class="current-price">â‚¹<?php echo number_format($offerPrice); ?></span>
                            <span class="original-price">â‚¹<?php echo number_format($salePrice); ?></span>
                        </div>
                        <div class="store-badge">
                            <i class="bi bi-shop"></i> 
                            <a href="<?php echo SITE_URL; ?>/<?php echo strtolower(str_replace(' ', '-', $deal['store_name'])); ?>-deals.php" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput($deal['store_name']); ?>
                            </a>
                            <small class="text-muted ms-2">Updated <?php echo $updateTime; ?></small>
                        </div>
                        <div class="urgency-info">
                            <span class="viewers-count">
                                <i class="bi bi-eye"></i> <?php echo $viewersCount; ?> viewing
                            </span>
                            <span class="stock-warning">
                                <i class="bi bi-fire"></i> <?php echo $soldToday; ?> sold today
                            </span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                           class="deal-btn"
                           data-product-id="<?php echo $deal['pid']; ?>">
                            <i class="bi bi-fire"></i> Get Hot Deal
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h3>ðŸ”¥ Hot Deals Loading...</h3>
                    <p>Amazing hot deals will appear here soon!</p>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Top Deals Section -->
    <section id="top-deals" class="mb-5">
        <div class="section-header">
            <h2 class="section-title">
                <span class="section-icon">ðŸ†</span>Top Deals
                <small class="text-muted">(Best Discounts)</small>
            </h2>
            <a href="<?php echo SITE_URL; ?>/best-sellers.php" class="view-all-btn">
                View All Top Deals <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="deals-grid">
            <?php if (!empty($topDeals)): ?>
                <?php foreach (array_slice($topDeals, 0, 8) as $index => $deal): 
                    if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price']) || !isset($deal['product_name'])) {
                        continue;
                    }
                    $salePrice = floatval($deal['product_sale_price']);
                    $offerPrice = floatval($deal['product_offer_price']);
                    if ($salePrice <= 0) continue;
                    
                    $discount = round((($salePrice - $offerPrice) / $salePrice) * 100);
                    $ratings = ['4.8â˜…', '4.7â˜…', '4.9â˜…', '4.6â˜…', '4.5â˜…'];
                    $rating = $ratings[array_rand($ratings)];
                    $viewersCount = rand(45, 178);
                    $reviewsCount = rand(120, 850);
                ?>
                <div class="deal-card">
                    <div class="deal-image">
                        <div class="deal-badge"><?php echo $discount; ?>% OFF</div>
                        <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                             alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="deal-content">
                        <h3 class="deal-title">
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput(substr($deal['product_name'], 0, 80)); ?>
                            </a>
                        </h3>
                        <div class="price-section">
                            <span class="current-price">â‚¹<?php echo number_format($offerPrice); ?></span>
                            <span class="original-price">â‚¹<?php echo number_format($salePrice); ?></span>
                        </div>
                        <div class="store-badge">
                            <i class="bi bi-shop"></i> 
                            <a href="<?php echo SITE_URL; ?>/<?php echo strtolower(str_replace(' ', '-', $deal['store_name'])); ?>-deals.php" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput($deal['store_name']); ?>
                            </a>
                            <span class="text-warning ms-2"><?php echo $rating; ?></span>
                        </div>
                        <div class="urgency-info">
                            <span class="viewers-count">
                                <i class="bi bi-eye"></i> <?php echo $viewersCount; ?> viewing
                            </span>
                            <span class="text-muted">
                                <i class="bi bi-chat-dots"></i> <?php echo $reviewsCount; ?> reviews
                            </span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                           class="deal-btn"
                           data-product-id="<?php echo $deal['pid']; ?>">
                            <i class="bi bi-trophy"></i> View Top Deal
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h3>ðŸ† Top Deals Loading...</h3>
                    <p>Our best deals will appear here soon!</p>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Recent Deals Section -->
    <section id="recent-deals" class="mb-5">
        <div class="section-header">
            <h2 class="section-title">
                <span class="section-icon">ðŸ†•</span>Recent Deals
                <small class="text-muted">(Just Added)</small>
            </h2>
            <a href="<?php echo SITE_URL; ?>/new-arrivals.php" class="view-all-btn">
                View All Recent <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        
        <div class="deals-grid">
            <?php if (!empty($recentDeals)): ?>
                <?php foreach ($recentDeals as $index => $deal): 
                    if (!isset($deal['product_sale_price']) || !isset($deal['product_offer_price']) || !isset($deal['product_name'])) {
                        continue;
                    }
                    $salePrice = floatval($deal['product_sale_price']);
                    $offerPrice = floatval($deal['product_offer_price']);
                    if ($salePrice <= 0) continue;
                    
                    $discount = round((($salePrice - $offerPrice) / $salePrice) * 100);
                    $newBadges = ['NEW', 'FRESH', 'JUST IN'];
                    $newBadge = $newBadges[array_rand($newBadges)];
                    $viewersCount = rand(8, 45);
                    $addedTime = ['Just added', 'Added 1h ago', 'Added 2h ago', 'Added today'];
                    $timeAdded = $addedTime[array_rand($addedTime)];
                ?>
                <div class="deal-card">
                    <div class="deal-image">
                        <div class="urgency-badge" style="background: #27ae60;"><?php echo $newBadge; ?></div>
                        <div class="deal-badge"><?php echo $discount; ?>% OFF</div>
                        <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                             alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                             loading="lazy">
                    </div>
                    <div class="deal-content">
                        <h3 class="deal-title">
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput(substr($deal['product_name'], 0, 80)); ?>
                            </a>
                        </h3>
                        <div class="price-section">
                            <span class="current-price">â‚¹<?php echo number_format($offerPrice); ?></span>
                            <span class="original-price">â‚¹<?php echo number_format($salePrice); ?></span>
                        </div>
                        <div class="store-badge">
                            <i class="bi bi-shop"></i> 
                            <a href="<?php echo SITE_URL; ?>/<?php echo strtolower(str_replace(' ', '-', $deal['store_name'])); ?>-deals.php" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput($deal['store_name']); ?>
                            </a>
                        </div>
                        <div class="deal-timer">
                            â° Ends in <?php echo $timeLeft; ?> hours
                        </div>
                        <div class="urgency-info">
                            <span class="viewers-count">
                                <i class="bi bi-eye"></i> <?php echo $viewersCount; ?> viewing
                            </span>
                            <span class="stock-warning">
                                <i class="bi bi-lightning"></i> <?php echo $soldCount; ?> sold
                            </span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" '
                           class="deal-btn"
                           data-product-id="<?php echo $deal['pid']; ?>">
                            <i class="bi bi-plus-circle"></i> Check New Deal
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <h3>ðŸ†• Recent Deals Loading...</h3>
                    <p>Fresh new deals will appear here soon!</p>
                    <a href="<?php echo SITE_URL; ?>" class="btn btn-primary">Browse All Deals</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Popular Stores Section -->
    <section class="popular-stores">
        <div class="section-header">
            <h2 class="section-title">
                <span class="section-icon">ðŸª</span>Popular Stores
            </h2>
        </div>
        
        <div class="stores-grid">
            <div class="store-card">
                <div class="store-icon">ðŸ›’</div>
                <h4>Amazon</h4>
                <p>Great deals & fast delivery</p>
                <a href="<?php echo SITE_URL; ?>/amazon-deals.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
            <div class="store-card">
                <div class="store-icon">ðŸ›ï¸</div>
                <h4>Flipkart</h4>
                <p>Big billion days offers</p>
                <a href="<?php echo SITE_URL; ?>/flipkart-deals.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
            <div class="store-card">
                <div class="store-icon">ðŸ‘•</div>
                <h4>Fashion</h4>
                <p>Myntra, Ajio & more</p>
                <a href="<?php echo SITE_URL; ?>/fashion-deals.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
            <div class="store-card">
                <div class="store-icon">ðŸ“±</div>
                <h4>Electronics</h4>
                <p>Mobiles, laptops & gadgets</p>
                <a href="<?php echo SITE_URL; ?>/electronics-deals.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
            <div class="store-card">
                <div class="store-icon">ðŸ </div>
                <h4>Home & Kitchen</h4>
                <p>Appliances & decor</p>
                <a href="<?php echo SITE_URL; ?>/home-kitchen.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
            <div class="store-card">
                <div class="store-icon">ðŸ’„</div>
                <h4>Beauty</h4>
                <p>Cosmetics & skincare</p>
                <a href="<?php echo SITE_URL; ?>/beauty-deals.php" class="btn btn-sm btn-outline-primary">View Deals</a>
            </div>
        </div>
    </section>

</div>

<script>
// Hero Slider
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const totalSlides = slides.length;

function nextSlide() {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % totalSlides;
    slides[currentSlide].classList.add('active');
}

// Auto slide every 4 seconds
setInterval(nextSlide, 4000);

// Live Metrics Animation
function updateLiveMetrics() {
    const viewers = document.getElementById('live-viewers');
    if (viewers) {
        const currentViewers = parseInt(viewers.textContent);
        const newViewers = currentViewers + Math.floor(Math.random() * 10) - 5;
        viewers.textContent = Math.max(1000, newViewers);
    }
}

// Update metrics every 30 seconds
setInterval(updateLiveMetrics, 30000);

// Countdown Timer
function updateCountdown() {
    const now = new Date().getTime();
    const endTime = now + (12 * 60 * 60 * 1000) + (34 * 60 * 1000) + (56 * 1000); // 12h 34m 56s from now
    
    const distance = endTime - now;
    
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
    document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
    document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
}

// Update countdown every second
setInterval(updateCountdown, 1000);

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Analytics tracking for deal clicks
document.querySelectorAll('[data-product-id]').forEach(link => {
    link.addEventListener('click', function() {
        const productId = this.getAttribute('data-product-id');
        // Track deal click
        if (typeof gtag !== 'undefined') {
            gtag('event', 'deal_click', {
                'product_id': productId,
                'event_category': 'engagement'
            });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>
