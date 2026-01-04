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

$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
// Calculate starting page for API based on our pagination
$apiStartPage = (($page - 1) * API_PAGES_TO_FETCH) + 1;
// Fetch multiple pages to show more products per page
$deals = fetchMultipleEarnPeDeals($apiStartPage, API_PAGES_TO_FETCH);
$currentYear = date('Y');
$currentDate = date('F j, Y');

$pageTitle = "Hot Deals & Offer " . $currentYear . " - Best Prices Today | " . SITE_NAME;
$pageDescription = "🔥 Discover amazing deals and discounts on various products from top stores in " . $currentYear . ". Shop today " . $currentDate . " and save big on electronics, fashion, home & more!";
$pageKeywords = "deals " . $currentYear . ", offers today, discounts, shopping, best prices, electronics deals, fashion offers, home deals";

// Enhanced SEO Meta
$canonicalUrl = SITE_URL . ($page > 1 ? "?page=" . $page : "");

// Collection Page Schema
$collectionSchema = [
    "@context" => "https://schema.org",
    "@type" => "CollectionPage",
    "name" => "Hot Deals & Offers " . $currentYear,
    "description" => $pageDescription,
    "url" => $canonicalUrl,
    "mainEntity" => [
        "@type" => "ItemList",
        "numberOfItems" => count($deals),
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
if ($deals && is_array($deals)) {
    foreach ($deals as $index => $deal) {
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

<div class="container">
    <!-- Urgency Banner -->
    <div class="urgency-banner">
        <div class="urgency-content">
            <i class="bi bi-lightning-charge-fill"></i>
            🔥 LIMITED TIME: Flash Sale Ends Today <?php echo $currentDate; ?>! Don't Miss Out on <?php echo $currentYear; ?> Best Deals!
            <i class="bi bi-clock-fill"></i>
        </div>
    </div>

    <!-- Live Metrics Banner -->
    <div class="engagement-metrics">
        <div class="metric-item">
            <i class="bi bi-people-fill"></i>
            <span id="live-viewers">2,847 people viewing now</span>
        </div>
        <div class="metric-item">
            <i class="bi bi-fire"></i>
            <span id="hot-deals">47 deals sold in last hour</span>
        </div>
        <div class="metric-item">
            <i class="bi bi-star-fill"></i>
            <span>4.8★ rated platform with 50K+ happy customers</span>
        </div>
        <div class="metric-item">
            <i class="bi bi-truck"></i>
            <span>Free delivery on orders above ₹499</span>
        </div>
    </div>

    <div class="page-header">
        <h1>🛍️ Hot Deals & Offers <?php echo $currentYear; ?> - Limited Time Only</h1>
        <p class="section-subtitle">⚡ Discover amazing products at unbeatable prices today <?php echo $currentDate; ?>. Shop now before deals expire!</p>
        
        <!-- Deal Counter -->
        <div class="deals-counter">
            <div class="counter-item">
                <span class="counter-number" id="total-deals"><?php echo count($deals); ?></span>
                <span class="counter-label">Active Deals</span>
            </div>
            <div class="counter-item">
                <span class="counter-number">⏰ 24h</span>
                <span class="counter-label">Time Left</span>
            </div>
            <div class="counter-item">
                <span class="counter-number">📦 Free</span>
                <span class="counter-label">Shipping</span>
            </div>
        </div>
        
        <!-- Social Sharing for Deals Page -->
        <div class="social-sharing mt-4">
            <h3 class="h6 fw-bold text-secondary mb-3">📢 Share These Amazing Deals</h3>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <button class="btn btn-facebook share-btn" onclick="shareDealsPage('facebook')">
                    <i class="bi bi-facebook"></i> Facebook
                </button>
                <button class="btn btn-whatsapp share-btn" onclick="shareDealsPage('whatsapp')">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </button>
                <button class="btn btn-twitter share-btn" onclick="shareDealsPage('twitter')">
                    <i class="bi bi-twitter"></i> Twitter
                </button>
                <button class="btn btn-telegram share-btn" onclick="shareDealsPage('telegram')">
                    <i class="bi bi-telegram"></i> Telegram
                </button>
                <button class="btn btn-copy share-btn" onclick="copyDealsLink()">
                    <i class="bi bi-clipboard"></i> Copy Link
                </button>
            </div>
            <p class="text-muted mt-2 small text-center">
                <i class="bi bi-heart-fill text-danger"></i>
                Help friends find the best deals! Share and save together.
            </p>
        </div>
    </div>

    <!-- Quick Stats Section -->
    <?php if ($deals && !empty($deals)): 
        // Calculate stats
        $totalProducts = count($deals);
        $avgDiscount = 0;
        $maxSavings = 0;
        $hotDealsCount = 0;
        
        foreach ($deals as $deal) {
            $discount = (int)str_replace(['%', ' OFF'], '', calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']));
            $avgDiscount += $discount;
            
            $savings = $deal['product_sale_price'] - $deal['product_offer_price'];
            $maxSavings = max($maxSavings, $savings);
            
            if ($discount > 40) {
                $hotDealsCount++;
            }
        }
        $avgDiscount = round($avgDiscount / $totalProducts);
    ?>
    <div class="quick-stats">
        <h3>🔥 Today's Deal Statistic</h3>
        <div class="stats-grid">
            <div class="stat-item">
                <span class="stat-number"><?php echo $totalProducts; ?></span>
                <span class="stat-label">Products Available</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $avgDiscount; ?>%</span>
                <span class="stat-label">Average Discount</span>
            </div>
            <div class="stat-item">
                <span class="stat-number">₹<?php echo number_format($maxSavings); ?></span>
                <span class="stat-label">Maximum Savings</span>
            </div>
            <div class="stat-item">
                <span class="stat-number"><?php echo $hotDealsCount; ?></span>
                <span class="stat-label">Hot Deals (40%+ OFF)</span>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if (!$deals): ?>
        <div class="error">
            <h2>Unable to load deals at the moment</h2>
            <p>Please try again later or check your internet connection.</p>
        </div>
    <?php elseif (empty($deals)): ?>
        <div class="loading">
            <h2>No deals found</h2>
            <p>Check back later for new deals and offers.</p>
        </div>
    <?php else: ?>
        <!-- Product Filters and Sorting -->
        <div class="filters-section">
            <div class="filters-container">
                <div class="filter-group">
                    <label for="sortBy">Sort by:</label>
                    <select id="sortBy" onchange="sortProducts(this.value)">
                        <option value="default">Featured</option>
                        <option value="price-low">Price: Low to High</option>
                        <option value="price-high">Price: High to Low</option>
                        <option value="discount">Highest Discount</option>
                        <option value="savings">Maximum Savings</option>
                        <option value="alphabetical">A-Z</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="priceRange">Price Range:</label>
                    <select id="priceRange" onchange="filterByPrice(this.value)">
                        <option value="all">All Prices</option>
                        <option value="0-500">Under ₹500</option>
                        <option value="500-1000">₹500 - ₹1,000</option>
                        <option value="1000-5000">₹1,000 - ₹5,000</option>
                        <option value="5000-10000">₹5,000 - ₹10,000</option>
                        <option value="10000-plus">Above ₹10,000</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="discountFilter">Minimum Discount:</label>
                    <select id="discountFilter" onchange="filterByDiscount(this.value)">
                        <option value="0">All Discounts</option>
                        <option value="10">10% or more</option>
                        <option value="25">25% or more</option>
                        <option value="40">40% or more</option>
                        <option value="50">50% or more</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <input type="text" id="searchProducts" placeholder="Search products..." onkeyup="searchProducts(this.value)">
                    <button type="button" onclick="clearFilters()" class="clear-filters-btn">
                        <i class="bi bi-x-circle"></i> Clear All
                    </button>
                </div>
            </div>
            
            <div class="results-info">
                <span id="resultsCount"><?php echo count($deals); ?> products</span>
                <span class="filter-tags" id="activeFilters"></span>
            </div>
        </div>

        <div class="products-grid" id="productsGrid">
            <?php foreach ($deals as $index => $deal): 
                // Add urgency indicators
                $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
                $isHotDeal = (int)str_replace(['%', ' OFF'], '', $discountPercent) > 40;
                $isLimitedStock = ($index % 3 == 0); // Simulate limited stock for variety
                $viewerCount = rand(15, 156); // Random viewer count for urgency
            ?>
                <div class="product-card <?php echo $isHotDeal ? 'hot-deal-card' : ''; ?>" data-product-id="<?php echo $deal['pid']; ?>">
                    <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                       class="product-card-link"
                       data-product-id="<?php echo $deal['pid']; ?>"
                       title="View details for <?php echo sanitizeOutput($deal['product_name']); ?>">
                        
                        <div class="product-image-section">
                            <?php if ($isHotDeal): ?>
                                <div class="product-badge">
                                    <span class="discount-badge-corner">🔥 HOT DEAL</span>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($isLimitedStock): ?>
                                <div class="stock-badge">
                                    <span class="limited-stock-badge">⚡ Only 3 left!</span>
                                </div>
                            <?php endif; ?>
                            
                            <img src="<?php echo htmlspecialchars_decode($deal['product_image']); ?>" 
                                 alt="<?php echo sanitizeOutput($deal['product_name']); ?>" 
                                 class="product-image"
                                 loading="<?php echo $index < 3 ? 'eager' : 'lazy'; ?>"
                                 onerror="this.src='https://via.placeholder.com/300x200?text=Product+Image'">
                        </div>
                        
                        <div class="product-info">
                            <h3 class="product-title"><?php echo sanitizeOutput($deal['product_name']); ?></h3>
                            
                            <!-- Urgency Indicators -->
                            <div class="urgency-indicators">
                                <div class="viewer-count">
                                    <i class="bi bi-eye-fill"></i>
                                    <span><?php echo $viewerCount; ?> people viewing</span>
                                </div>
                                <?php if ($isLimitedStock): ?>
                                    <div class="stock-alert">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        <span>Low stock!</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-pricing">
                                <span class="current-price"><?php echo formatPrice($deal['product_offer_price']); ?></span>
                                <span class="original-price"><?php echo formatPrice($deal['product_sale_price']); ?></span>
                                <span class="discount-badge <?php echo $isHotDeal ? 'hot-discount' : ''; ?>">
                                    <?php echo $discountPercent; ?>
                                </span>
                            </div>
                            
                            <!-- Savings Calculator -->
                            <div class="savings-info">
                                <span class="savings-text">
                                    💰 You save ₹<?php echo number_format($deal['product_sale_price'] - $deal['product_offer_price']); ?>
                                </span>
                            </div>
                            
                            <div class="product-store">
                                <i class="bi bi-shop"></i> <?php echo sanitizeOutput($deal['store_name']); ?>
                                <span class="delivery-info">
                                    <i class="bi bi-truck"></i>
                                    <?php echo $deal['product_offer_price'] > 499 ? 'Free Delivery' : 'Fast Delivery'; ?>
                                </span>
                            </div>
                            
                            <!-- Timer for urgency -->
                            <div class="deal-timer">
                                <i class="bi bi-clock"></i>
                                <span>Deal ends in: <strong id="timer-<?php echo $deal['pid']; ?>">23:47:12</strong></span>
                            </div>
                            
                            <div class="view-details-btn <?php echo $isHotDeal ? 'hot-deal-btn' : ''; ?>">
                                <i class="bi bi-cart-plus"></i>
                                <?php echo $isHotDeal ? '🔥 Grab Hot Deal Now!' : 'View Details & Buy Now'; ?>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- SEO-Friendly Pagination -->
        <?php
        // Get total pages (for better pagination, we'll assume API might have total pages info)
        // For now, we'll show a range around current page
        $maxPages = 10; // Maximum pages to show (you can adjust based on API response)
        $showPages = 5; // Number of pages to show around current page
        ?>
        
        <nav class="pagination-wrapper" aria-label="Page navigation">
            <ul class="pagination">
                <!-- First Page Link -->
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a href="?page=1" class="page-link" title="Go to first page" rel="first">
                        <i class="bi bi-chevron-double-left"></i>
                        <span class="sr-only">First</span>
                    </a>
                </li>
                <?php endif; ?>
                
                <!-- Previous Page Link -->
                <?php if ($page > 1): ?>
                <li class="page-item">
                    <a href="?page=<?php echo $page - 1; ?>" class="page-link" title="Go to previous page" rel="prev">
                        <i class="bi bi-chevron-left"></i>
                        Previous
                    </a>
                </li>
                <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">
                        <i class="bi bi-chevron-left"></i>
                        Previous
                    </span>
                </li>
                <?php endif; ?>
                
                <!-- Page Numbers -->
                <?php
                // Calculate page range
                $startPage = max(1, $page - floor($showPages / 2));
                $endPage = min($maxPages, $startPage + $showPages - 1);
                
                // Adjust start if we're near the end
                if ($endPage - $startPage < $showPages - 1) {
                    $startPage = max(1, $endPage - $showPages + 1);
                }
                
                // Show ellipsis before if needed
                if ($startPage > 1): ?>
                    <li class="page-item">
                        <a href="?page=1" class="page-link">1</a>
                    </li>
                    <?php if ($startPage > 2): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <?php endif; ?>
                <?php endif; ?>
                
                <!-- Page number links -->
                <?php for ($i = $startPage; $i <= $endPage; $i++): ?>
                <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                    <?php if ($i == $page): ?>
                        <span class="page-link current" aria-current="page">
                            <?php echo $i; ?>
                            <span class="sr-only">(current)</span>
                        </span>
                    <?php else: ?>
                        <a href="?page=<?php echo $i; ?>" class="page-link" title="Go to page <?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    <?php endif; ?>
                </li>
                <?php endfor; ?>
                
                <!-- Show ellipsis after if needed -->
                <?php if ($endPage < $maxPages): ?>
                    <?php if ($endPage < $maxPages - 1): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                    <?php endif; ?>
                    <li class="page-item">
                        <a href="?page=<?php echo $maxPages; ?>" class="page-link"><?php echo $maxPages; ?></a>
                    </li>
                <?php endif; ?>
                
                <!-- Next Page Link -->
                <?php if ($page < $maxPages): ?>
                <li class="page-item">
                    <a href="?page=<?php echo $page + 1; ?>" class="page-link" title="Go to next page" rel="next">
                        Next
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                <?php else: ?>
                <li class="page-item disabled">
                    <span class="page-link">
                        Next
                        <i class="bi bi-chevron-right"></i>
                    </span>
                </li>
                <?php endif; ?>
                
                <!-- Last Page Link -->
                <?php if ($page < $maxPages): ?>
                <li class="page-item">
                    <a href="?page=<?php echo $maxPages; ?>" class="page-link" title="Go to last page" rel="last">
                        <span class="sr-only">Last</span>
                        <i class="bi bi-chevron-double-right"></i>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            
            <!-- Page Info -->
            <div class="pagination-info">
                <span class="page-info">
                    Page <strong><?php echo $page; ?></strong> of <strong><?php echo $maxPages; ?></strong>
                </span>
            </div>
        </nav>
        
        <!-- Load More Products Button -->
        <div class="load-more-section">
            <button id="loadMoreBtn" class="load-more-btn" onclick="loadMoreProducts()">
                <i class="bi bi-plus-circle"></i>
                <span class="btn-text">Load More Amazing Deals</span>
                <span class="loading-spinner" style="display: none;">
                    <i class="bi bi-arrow-clockwise spinning"></i>
                    Loading...
                </span>
            </button>
            <div class="load-more-info">
                <small>Show more products without refreshing the page</small>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- JavaScript for Enhanced Engagement -->
<script>
// Live viewer counter update
function updateLiveMetrics() {
    const viewerElement = document.getElementById('live-viewers');
    const hotDealsElement = document.getElementById('hot-deals');
    
    if (viewerElement) {
        const currentViewers = parseInt(viewerElement.textContent.match(/\d+/)[0]);
        const newViewers = currentViewers + Math.floor(Math.random() * 10) - 5;
        viewerElement.textContent = Math.max(1500, newViewers) + ' people viewing now';
    }
    
    if (hotDealsElement) {
        const currentDeals = parseInt(hotDealsElement.textContent.match(/\d+/)[0]);
        const newDeals = currentDeals + Math.floor(Math.random() * 5);
        hotDealsElement.textContent = newDeals + ' deals sold in last hour';
    }
}

// Deal countdown timers
function startCountdowns() {
    const timers = document.querySelectorAll('[id^="timer-"]');
    timers.forEach(timer => {
        let hours = 23;
        let minutes = Math.floor(Math.random() * 60);
        let seconds = Math.floor(Math.random() * 60);
        
        setInterval(() => {
            seconds--;
            if (seconds < 0) {
                seconds = 59;
                minutes--;
                if (minutes < 0) {
                    minutes = 59;
                    hours--;
                    if (hours < 0) {
                        hours = 23;
                        minutes = 59;
                        seconds = 59;
                    }
                }
            }
            
            const formattedTime = 
                String(hours).padStart(2, '0') + ':' +
                String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');
            
            timer.textContent = formattedTime;
        }, 1000);
    });
}

// Product click tracking - Non-blocking approach
function initProductTracking() {
    // Listen for clicks on product card links (entire card clickable)
    document.querySelectorAll('.product-card-link').forEach(link => {
        link.addEventListener('click', function(e) {
            // Add immediate visual feedback
            this.style.transform = 'scale(0.98)';
            
            // Don't prevent default - let link work normally
            const productId = this.getAttribute('data-product-id');
            
            // Track in background without blocking navigation
            if (typeof gtag !== 'undefined') {
                gtag('event', 'product_click', {
                    'product_id': productId,
                    'click_source': 'product_card',
                    'timestamp': new Date().toISOString()
                });
            }
            
            // Store for recommendations
            const productCard = this.closest('.product-card');
            if (productCard) {
                const priceText = productCard.querySelector('.current-price').textContent.replace(/[₹,]/g, '');
                const price = parseInt(priceText);
                storeViewedProduct(productId, price);
            }
            
            // Reset transform after a brief moment
            setTimeout(() => {
                this.style.transform = '';
            }, 100);
        }, { passive: true }); // Passive listener for better mobile performance
    });
    
    // Fallback: Listen for clicks on old view details buttons (if any remain)
    document.querySelectorAll('.view-details-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const productId = this.getAttribute('data-product-id');
            
            if (typeof gtag !== 'undefined') {
                gtag('event', 'product_click', {
                    'product_id': productId,
                    'click_source': 'view_details_btn',
                    'timestamp': new Date().toISOString()
                });
            }
            
            const productCard = this.closest('.product-card');
            if (productCard) {
                const priceText = productCard.querySelector('.current-price').textContent.replace(/[₹,]/g, '');
                const price = parseInt(priceText);
                storeViewedProduct(productId, price);
            }
        }, { passive: true });
    });
}

// Initialize tracking when page loads
document.addEventListener('DOMContentLoaded', initProductTracking);

// Mobile touch enhancements
function addTouchEnhancements() {
    const productCards = document.querySelectorAll('.product-card');
    
    productCards.forEach(card => {
        const cardLink = card.querySelector('.product-card-link');
        
        if (cardLink) {
            cardLink.addEventListener('touchstart', function() {
                this.style.transform = 'scale(0.98)';
                card.style.boxShadow = '0 4px 15px rgba(0,0,0,0.2)';
            });
            
            cardLink.addEventListener('touchend', function() {
                setTimeout(() => {
                    this.style.transform = '';
                    card.style.boxShadow = '';
                }, 100);
            });
            
            cardLink.addEventListener('touchcancel', function() {
                this.style.transform = '';
                card.style.boxShadow = '';
            });
        }
    });
}

// Intersection Observer for lazy loading and animations
function initIntersectionObserver() {
    const options = {
        root: null,
        rootMargin: '0px',
        threshold: 0.1
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, options);
    
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
}

// Social Sharing Functions for Deals Page
const dealsPageData = {
    title: "🔥 Hot Deals & Offers <?php echo $currentYear; ?> - Best Prices Today!",
    description: "🛍️ Discover amazing deals and discounts! Save big on electronics, fashion, home & more. Limited time offers - Shop now!",
    url: "<?php echo $canonicalUrl; ?>",
    hashtags: ["deals<?php echo $currentYear; ?>", "shopping", "offers", "discount", "hotdeals"]
};

function shareDealsPage(platform) {
    let url = '';
    
    switch(platform) {
        case 'facebook':
            url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(dealsPageData.url)}&quote=${encodeURIComponent(dealsPageData.description)}`;
            break;
        case 'twitter':
            const text = `${dealsPageData.description} #${dealsPageData.hashtags.join(' #')}`;
            url = `https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(dealsPageData.url)}`;
            break;
        case 'whatsapp':
            const whatsappText = `${dealsPageData.description}\n\n👉 ${dealsPageData.url}`;
            url = `https://wa.me/?text=${encodeURIComponent(whatsappText)}`;
            break;
        case 'telegram':
            url = `https://t.me/share/url?url=${encodeURIComponent(dealsPageData.url)}&text=${encodeURIComponent(dealsPageData.description)}`;
            break;
    }
    
    if (url) {
        openShareWindow(url, platform);
        trackSocialShare(platform, 'deals-page');
    }
}

function copyDealsLink() {
    const textToCopy = `${dealsPageData.description}\n\n${dealsPageData.url}`;
    
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(textToCopy).then(() => {
            showCopySuccess();
        }).catch(() => {
            fallbackCopyTextToClipboard(textToCopy);
        });
    } else {
        fallbackCopyTextToClipboard(textToCopy);
    }
    trackSocialShare('copy', 'deals-page');
}

function openShareWindow(url, platform) {
    const width = 550;
    const height = 420;
    const left = (screen.width - width) / 2;
    const top = (screen.height - height) / 2;
    
    window.open(
        url,
        `share-${platform}`,
        `width=${width},height=${height},left=${left},top=${top},scrollbars=yes,resizable=yes`
    );
}

function trackSocialShare(platform, contentType) {
    console.log(`Shared ${contentType} on ${platform}`);
    
    if (typeof gtag !== 'undefined') {
        gtag('event', 'share', {
            'method': platform,
            'content_type': contentType
        });
    }
}

function showCopySuccess() {
    const originalBtn = event.target.closest('.share-btn');
    const originalContent = originalBtn.innerHTML;
    
    originalBtn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Copied!';
    originalBtn.classList.add('btn-success');
    
    setTimeout(() => {
        originalBtn.innerHTML = originalContent;
        originalBtn.classList.remove('btn-success');
    }, 2000);
}

function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        document.execCommand('copy');
        showCopySuccess();
    } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
        alert('Unable to copy to clipboard. Please copy the URL manually: ' + dealsPageData.url);
    }
    
    document.body.removeChild(textArea);
}

// Load More Products Functionality
let currentLoadMorePage = <?php echo $page + 1; ?>;
let isLoading = false;

function loadMoreProducts() {
    if (isLoading) return;
    
    isLoading = true;
    const btn = document.getElementById('loadMoreBtn');
    const btnText = btn.querySelector('.btn-text');
    const spinner = btn.querySelector('.loading-spinner');
    
    // Show loading state
    btnText.style.display = 'none';
    spinner.style.display = 'inline-block';
    btn.classList.add('loading');
    btn.disabled = true;
    
    // Fetch more products
    fetch(`ajax/load_more_products.php?page=${currentLoadMorePage}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Add new products to the grid
                const productsGrid = document.querySelector('.products-grid');
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = data.html;
                
                // Animate new products in
                const newProducts = tempDiv.querySelectorAll('.product-card');
                newProducts.forEach((product, index) => {
                    product.style.opacity = '0';
                    product.style.transform = 'translateY(20px)';
                    productsGrid.appendChild(product);
                    
                    // Animate in with delay
                    setTimeout(() => {
                        product.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                        product.style.opacity = '1';
                        product.style.transform = 'translateY(0)';
                    }, index * 100);
                });
                
                // Initialize timers for new products
                startCountdowns();
                addTouchEnhancements();
                
                // Update page counter
                currentLoadMorePage++;
                
                // Track analytics
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'load_more_products', {
                        'page': currentLoadMorePage - 1,
                        'products_loaded': data.products_count
                    });
                }
                
                // Show success message
                showLoadMoreSuccess(data.products_count);
                
            } else {
                // No more products available
                btn.innerHTML = '<i class="bi bi-check-circle"></i> All products loaded!';
                btn.disabled = true;
                btn.classList.add('completed');
                
                setTimeout(() => {
                    btn.style.display = 'none';
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Error loading more products:', error);
            // Reset button state
            btnText.textContent = 'Try Again';
            showLoadMoreError();
        })
        .finally(() => {
            isLoading = false;
            btnText.style.display = 'inline-block';
            spinner.style.display = 'none';
            btn.classList.remove('loading');
            btn.disabled = false;
        });
}

function showLoadMoreSuccess(count) {
    const notification = document.createElement('div');
    notification.className = 'load-more-notification success';
    notification.innerHTML = `<i class="bi bi-check-circle"></i> Loaded ${count} more products!`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

function showLoadMoreError() {
    const notification = document.createElement('div');
    notification.className = 'load-more-notification error';
    notification.innerHTML = `<i class="bi bi-exclamation-circle"></i> Failed to load more products. Please try again.`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Product Filtering and Sorting Functions
let originalProducts = [];
let filteredProducts = [];

function initializeProductData() {
    const productCards = document.querySelectorAll('.product-card');
    originalProducts = [];
    
    productCards.forEach(card => {
        const priceText = card.querySelector('.current-price').textContent.replace(/[₹,]/g, '');
        const originalPriceText = card.querySelector('.original-price').textContent.replace(/[₹,]/g, '');
        const discountText = card.querySelector('.discount-badge').textContent.replace(/[%\s]/g, '').replace('OFF', '');
        const title = card.querySelector('.product-title').textContent.toLowerCase();
        const store = card.querySelector('.product-store').textContent.toLowerCase();
        
        originalProducts.push({
            element: card,
            price: parseInt(priceText),
            originalPrice: parseInt(originalPriceText),
            discount: parseInt(discountText) || 0,
            savings: parseInt(originalPriceText) - parseInt(priceText),
            title: title,
            store: store,
            searchText: title + ' ' + store
        });
    });
    
    filteredProducts = [...originalProducts];
    updateResultsCount();
}

function sortProducts(sortBy) {
    let sortedProducts = [...filteredProducts];
    
    switch(sortBy) {
        case 'price-low':
            sortedProducts.sort((a, b) => a.price - b.price);
            break;
        case 'price-high':
            sortedProducts.sort((a, b) => b.price - a.price);
            break;
        case 'discount':
            sortedProducts.sort((a, b) => b.discount - a.discount);
            break;
        case 'savings':
            sortedProducts.sort((a, b) => b.savings - a.savings);
            break;
        case 'alphabetical':
            sortedProducts.sort((a, b) => a.title.localeCompare(b.title));
            break;
        default:
            // Keep original order
            break;
    }
    
    renderProducts(sortedProducts);
    addActiveFilter('sort', `Sorted by: ${getSortDisplayName(sortBy)}`);
}

function filterByPrice(priceRange) {
    let filtered = [...originalProducts];
    
    if (priceRange !== 'all') {
        const [min, max] = priceRange.split('-').map(p => p === 'plus' ? Infinity : parseInt(p));
        filtered = filtered.filter(product => {
            return product.price >= min && (max === Infinity ? true : product.price <= max);
        });
    }
    
    filteredProducts = filtered;
    applyAllFilters();
    addActiveFilter('price', `Price: ${getPriceDisplayName(priceRange)}`);
}

function filterByDiscount(minDiscount) {
    minDiscount = parseInt(minDiscount);
    let filtered = [...originalProducts];
    
    if (minDiscount > 0) {
        filtered = filtered.filter(product => product.discount >= minDiscount);
    }
    
    filteredProducts = filtered;
    applyAllFilters();
    addActiveFilter('discount', `Min ${minDiscount}% discount`);
}

function searchProducts(searchTerm) {
    searchTerm = searchTerm.toLowerCase().trim();
    let filtered = [...originalProducts];
    
    if (searchTerm) {
        filtered = filtered.filter(product => 
            product.searchText.includes(searchTerm)
        );
    }
    
    filteredProducts = filtered;
    applyAllFilters();
    
    if (searchTerm) {
        addActiveFilter('search', `Search: "${searchTerm}"`);
    }
}

function applyAllFilters() {
    const sortValue = document.getElementById('sortBy').value;
    const priceValue = document.getElementById('priceRange').value;
    const discountValue = document.getElementById('discountFilter').value;
    const searchValue = document.getElementById('searchProducts').value;
    
    let filtered = [...originalProducts];
    
    // Apply price filter
    if (priceValue !== 'all') {
        const [min, max] = priceValue.split('-').map(p => p === 'plus' ? Infinity : parseInt(p));
        filtered = filtered.filter(product => {
            return product.price >= min && (max === Infinity ? true : product.price <= max);
        });
    }
    
    // Apply discount filter
    if (discountValue !== '0') {
        const minDiscount = parseInt(discountValue);
        filtered = filtered.filter(product => product.discount >= minDiscount);
    }
    
    // Apply search filter
    if (searchValue.trim()) {
        const searchTerm = searchValue.toLowerCase().trim();
        filtered = filtered.filter(product => 
            product.searchText.includes(searchTerm)
        );
    }
    
    filteredProducts = filtered;
    sortProducts(sortValue);
}

function renderProducts(products) {
    const grid = document.getElementById('productsGrid');
    
    // Hide all products first
    originalProducts.forEach(product => {
        product.element.style.display = 'none';
    });
    
    // Show filtered products
    products.forEach((product, index) => {
        product.element.style.display = 'block';
        product.element.style.order = index;
    });
    
    updateResultsCount();
    
    // Add animation to visible products
    const visibleProducts = products.slice(0, 12); // Animate first 12
    visibleProducts.forEach((product, index) => {
        setTimeout(() => {
            product.element.style.opacity = '1';
            product.element.style.transform = 'translateY(0)';
        }, index * 50);
    });
}

function clearFilters() {
    document.getElementById('sortBy').value = 'default';
    document.getElementById('priceRange').value = 'all';
    document.getElementById('discountFilter').value = '0';
    document.getElementById('searchProducts').value = '';
    
    filteredProducts = [...originalProducts];
    renderProducts(filteredProducts);
    clearActiveFilters();
}

function addActiveFilter(type, text) {
    const activeFilters = document.getElementById('activeFilters');
    
    // Remove existing filter of same type
    const existingFilter = activeFilters.querySelector(`[data-filter-type="${type}"]`);
    if (existingFilter) {
        existingFilter.remove();
    }
    
    // Add new filter tag
    if (text && !text.includes('All') && !text.includes('Featured')) {
        const filterTag = document.createElement('span');
        filterTag.className = 'filter-tag';
        filterTag.setAttribute('data-filter-type', type);
        filterTag.innerHTML = `${text} <i class="bi bi-x" onclick="removeFilter('${type}')"></i>`;
        activeFilters.appendChild(filterTag);
    }
}

function removeFilter(type) {
    switch(type) {
        case 'sort':
            document.getElementById('sortBy').value = 'default';
            break;
        case 'price':
            document.getElementById('priceRange').value = 'all';
            break;
        case 'discount':
            document.getElementById('discountFilter').value = '0';
            break;
        case 'search':
            document.getElementById('searchProducts').value = '';
            break;
    }
    
    applyAllFilters();
    document.querySelector(`[data-filter-type="${type}"]`).remove();
}

function clearActiveFilters() {
    document.getElementById('activeFilters').innerHTML = '';
}

function updateResultsCount() {
    const count = filteredProducts.length;
    document.getElementById('resultsCount').textContent = `${count} product${count !== 1 ? 's' : ''}`;
}

function getSortDisplayName(sortBy) {
    const names = {
        'default': 'Featured',
        'price-low': 'Price Low to High',
        'price-high': 'Price High to Low',
        'discount': 'Highest Discount',
        'savings': 'Maximum Savings',
        'alphabetical': 'A-Z'
    };
    return names[sortBy] || 'Featured';
}

function getPriceDisplayName(priceRange) {
    const names = {
        'all': 'All Prices',
        '0-500': 'Under ₹500',
        '500-1000': '₹500 - ₹1,000',
        '1000-5000': '₹1,000 - ₹5,000', 
        '5000-10000': '₹5,000 - ₹10,000',
        '10000-plus': 'Above ₹10,000'
    };
    return names[priceRange] || 'All Prices';
}

// Infinite Scroll Functionality (Alternative to Load More)
let isInfiniteScrollEnabled = false;
let scrollTimeout;

function enableInfiniteScroll() {
    isInfiniteScrollEnabled = true;
    document.getElementById('loadMoreBtn').style.display = 'none';
    
    window.addEventListener('scroll', handleInfiniteScroll);
    
    // Show notification
    const notification = document.createElement('div');
    notification.className = 'load-more-notification success';
    notification.innerHTML = `<i class="bi bi-infinity"></i> Infinite scroll enabled! Products will load automatically.`;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.classList.add('show');
    }, 100);
    
    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 4000);
}

function handleInfiniteScroll() {
    if (!isInfiniteScrollEnabled || isLoading) return;
    
    clearTimeout(scrollTimeout);
    scrollTimeout = setTimeout(() => {
        const scrollPosition = window.innerHeight + window.scrollY;
        const pageHeight = document.body.offsetHeight;
        
        // Load more when user is 200px from bottom
        if (scrollPosition >= pageHeight - 200) {
            loadMoreProducts();
        }
    }, 100);
}

function disableInfiniteScroll() {
    isInfiniteScrollEnabled = false;
    window.removeEventListener('scroll', handleInfiniteScroll);
    document.getElementById('loadMoreBtn').style.display = 'block';
}

// Performance optimizations
function optimizeImages() {
    const images = document.querySelectorAll('.product-image');
    
    images.forEach(img => {
        // Add loading optimization
        if (!img.hasAttribute('loading')) {
            img.setAttribute('loading', 'lazy');
        }
        
        // Add error handling for broken images
        img.onerror = function() {
            this.src = 'https://via.placeholder.com/300x200?text=Product+Image';
            this.alt = 'Product Image Placeholder';
        };
    });
}

// Advanced Analytics Tracking
function trackAdvancedAnalytics() {
    // Track scroll depth
    let maxScrollDepth = 0;
    
    window.addEventListener('scroll', () => {
        const scrollDepth = Math.round((window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100);
        if (scrollDepth > maxScrollDepth) {
            maxScrollDepth = scrollDepth;
            
            // Track milestone scrolls
            if ([25, 50, 75, 90].includes(scrollDepth)) {
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'scroll_depth', {
                        'scroll_depth': scrollDepth,
                        'page_type': 'products_listing'
                    });
                }
            }
        }
    });
    
    // Track time on page
    const startTime = Date.now();
    
    window.addEventListener('beforeunload', () => {
        const timeOnPage = Math.round((Date.now() - startTime) / 1000);
        
        if (typeof gtag !== 'undefined') {
            gtag('event', 'time_on_page', {
                'time_seconds': timeOnPage,
                'page_type': 'products_listing',
                'products_viewed': originalProducts.length
            });
        }
    });
}

// Product Recommendation Engine (Simple)
function showRecommendations() {
    const viewedProducts = JSON.parse(localStorage.getItem('viewedProducts') || '[]');
    
    if (viewedProducts.length > 0) {
        // Simple recommendation based on price range of viewed products
        const avgPrice = viewedProducts.reduce((sum, price) => sum + price, 0) / viewedProducts.length;
        
        const recommended = originalProducts.filter(product => {
            const priceDiff = Math.abs(product.price - avgPrice);
            return priceDiff <= avgPrice * 0.5; // Within 50% of average viewed price
        }).slice(0, 6);
        
        if (recommended.length > 0) {
            highlightRecommendedProducts(recommended);
        }
    }
}

function highlightRecommendedProducts(recommended) {
    recommended.forEach(product => {
        const badge = document.createElement('div');
        badge.className = 'recommendation-badge';
        badge.innerHTML = '⭐ Recommended for You';
        
        const imageSection = product.element.querySelector('.product-image-section');
        imageSection.appendChild(badge);
    });
}

// Store viewed product for recommendations
function storeViewedProduct(productId, price) {
    let viewedProducts = JSON.parse(localStorage.getItem('viewedProducts') || '[]');
    
    // Add new price and keep only last 10
    viewedProducts.push(price);
    viewedProducts = viewedProducts.slice(-10);
    
    localStorage.setItem('viewedProducts', JSON.stringify(viewedProducts));
}

// Initialize all features
document.addEventListener('DOMContentLoaded', function() {
    // Update metrics every 30 seconds
    updateLiveMetrics();
    setInterval(updateLiveMetrics, 30000);
    
    // Start countdown timers
    startCountdowns();
    
    // Add mobile touch enhancements
    addTouchEnhancements();
    
    // Initialize animations
    initIntersectionObserver();
    
    // Initialize product filtering and sorting
    setTimeout(() => {
        initializeProductData();
        optimizeImages();
        showRecommendations();
    }, 1000);
    
    // Initialize advanced analytics
    trackAdvancedAnalytics();
    
    // Add infinite scroll toggle button
    const loadMoreSection = document.querySelector('.load-more-section');
    if (loadMoreSection) {
        const infiniteScrollToggle = document.createElement('button');
        infiniteScrollToggle.className = 'infinite-scroll-toggle';
        infiniteScrollToggle.innerHTML = '<i class="bi bi-infinity"></i> Enable Infinite Scroll';
        infiniteScrollToggle.onclick = enableInfiniteScroll;
        loadMoreSection.appendChild(infiniteScrollToggle);
    }
    
    // URL fallback handling
    handleURLFallbacks();
});

// URL Fallback Handler
function handleURLFallbacks() {
    // Add click handler to all product links to handle potential URL issues
    const productLinks = document.querySelectorAll('a[href*="/product/"]');
    
    productLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Extract product ID from URL
            const match = href.match(/\/product\/(\d+)\//);
            if (match && match[1]) {
                const productId = match[1];
                
                // Create fallback URL
                const fallbackUrl = 'product.php?id=' + productId;
                
                // Test if the SEO URL works, otherwise use fallback
                fetch(href, { method: 'HEAD' })
                    .catch(() => {
                        // If SEO URL fails, redirect to fallback
                        e.preventDefault();
                        window.location.href = fallbackUrl;
                    });
            }
        });
    });
}

// Page visibility API for engagement tracking
document.addEventListener('visibilitychange', function() {
    if (document.hidden) {
        // User switched tabs/minimized - could track this
        console.log('User left page');
    } else {
        // User returned - could refresh metrics
        updateLiveMetrics();
    }
});
</script>

<?php include 'includes/footer.php'; ?>