<?php
/**
 * Festival & Occasion Pages Generator
 * Creates seasonal event-based deal pages with high search volume potential
 */

require_once 'includes/config.php';

// Festival & Occasion page configurations
$festivalPages = [
    // Major Indian Festivals
    [
        'filename' => 'diwali-deals.php',
        'title' => 'Diwali Sale 2025 - Best Diwali Deals & Offers',
        'event' => 'Diwali',
        'keywords' => ['diwali', 'deepavali', 'festival of lights'],
        'color' => '#ff6f00',
        'icon' => '🪔',
        'description' => 'Biggest Diwali sale 2025! Get exclusive Diwali deals, offers, and discounts on electronics, fashion, home decor, gifts, and more. Celebrate with amazing savings.',
        'meta_keywords' => 'diwali deals, diwali sale 2025, diwali offers, diwali shopping, festival offers',
        'discount_threshold' => 30
    ],
    [
        'filename' => 'holi-deals.php',
        'title' => 'Holi Sale 2025 - Best Holi Deals & Offers',
        'event' => 'Holi',
        'keywords' => ['holi', 'festival of colors', 'rangwali'],
        'color' => '#ff1744',
        'icon' => '🎨',
        'description' => 'Celebrate Holi with colorful deals! Get best Holi offers on colors, water guns, ethnic wear, sweets, and gifts. Biggest Holi sale 2025.',
        'meta_keywords' => 'holi deals, holi sale, holi offers 2025, holi shopping, festival deals',
        'discount_threshold' => 25
    ],
    [
        'filename' => 'rakhi-deals.php',
        'title' => 'Raksha Bandhan Sale 2025 - Rakhi Deals & Gifts',
        'event' => 'Raksha Bandhan',
        'keywords' => ['rakhi', 'raksha bandhan', 'rakshabandhan'],
        'color' => '#e91e63',
        'icon' => '🎁',
        'description' => 'Best Raksha Bandhan deals 2025! Shop rakhi gifts for brothers and sisters. Exclusive rakhi sale on electronics, fashion, jewelry, and more.',
        'meta_keywords' => 'rakhi deals, raksha bandhan sale, rakhi gifts, rakhi offers 2025',
        'discount_threshold' => 25
    ],
    [
        'filename' => 'durga-puja-deals.php',
        'title' => 'Durga Puja Sale 2025 - Best Festive Deals',
        'event' => 'Durga Puja',
        'keywords' => ['durga puja', 'navratri', 'pujo'],
        'color' => '#d32f2f',
        'icon' => '🙏',
        'description' => 'Biggest Durga Puja sale 2025! Celebrate Navratri with exclusive deals on sarees, jewelry, electronics, home decor, and festive essentials.',
        'meta_keywords' => 'durga puja deals, navratri sale, pujo offers, festive deals 2025',
        'discount_threshold' => 30
    ],
    [
        'filename' => 'onam-deals.php',
        'title' => 'Onam Sale 2025 - Best Onam Deals & Offers',
        'event' => 'Onam',
        'keywords' => ['onam', 'onam festival', 'kerala'],
        'color' => '#ffb300',
        'icon' => '🌺',
        'description' => 'Happy Onam! Get best Onam deals on traditional wear, home appliances, jewelry, and gifts. Exclusive Onam sale 2025 with amazing discounts.',
        'meta_keywords' => 'onam deals, onam sale 2025, onam offers, kerala festival deals',
        'discount_threshold' => 25
    ],
    [
        'filename' => 'pongal-deals.php',
        'title' => 'Pongal Sale 2025 - Best Tamil New Year Deals',
        'event' => 'Pongal',
        'keywords' => ['pongal', 'thai pongal', 'tamil new year'],
        'color' => '#8bc34a',
        'icon' => '🌾',
        'description' => 'Pongal festival sale 2025! Get best deals on electronics, home appliances, traditional wear, and gifts. Celebrate harvest festival with savings.',
        'meta_keywords' => 'pongal deals, pongal sale, tamil festival offers, harvest festival deals',
        'discount_threshold' => 20
    ],
    
    // National Holidays
    [
        'filename' => 'republic-day-deals.php',
        'title' => 'Republic Day Sale 2025 - 26th January Deals',
        'event' => 'Republic Day',
        'keywords' => ['republic day', '26 january', 'indian republic'],
        'color' => '#ff9800',
        'icon' => '🇮🇳',
        'description' => 'Republic Day sale 2025! Celebrate 26th January with patriotic deals on electronics, fashion, home appliances. Best Republic Day offers.',
        'meta_keywords' => 'republic day sale, 26 january deals, republic day offers 2025, independence offers',
        'discount_threshold' => 30
    ],
    [
        'filename' => 'independence-day-deals.php',
        'title' => 'Independence Day Sale 2025 - 15th August Deals',
        'event' => 'Independence Day',
        'keywords' => ['independence day', '15 august', 'indian independence'],
        'color' => '#4caf50',
        'icon' => '🇮🇳',
        'description' => 'Independence Day sale 2025! Celebrate freedom with exclusive 15th August deals on electronics, fashion, mobiles. Best Independence Day offers.',
        'meta_keywords' => 'independence day sale, 15 august deals, independence day offers 2025, freedom sale',
        'discount_threshold' => 30
    ],
    [
        'filename' => 'gandhi-jayanti-deals.php',
        'title' => 'Gandhi Jayanti Sale 2025 - October 2nd Deals',
        'event' => 'Gandhi Jayanti',
        'keywords' => ['gandhi jayanti', '2 october', 'mahatma gandhi'],
        'color' => '#607d8b',
        'icon' => '🕊️',
        'description' => 'Gandhi Jayanti sale 2025! Get best deals on 2nd October. Shop electronics, fashion, and essentials with special Gandhi Jayanti offers.',
        'meta_keywords' => 'gandhi jayanti sale, october 2 deals, gandhi jayanti offers',
        'discount_threshold' => 20
    ],
    
    // Global Shopping Events
    [
        'filename' => 'christmas-deals.php',
        'title' => 'Christmas Sale 2025 - Best Xmas Deals & Offers',
        'event' => 'Christmas',
        'keywords' => ['christmas', 'xmas', 'merry christmas'],
        'color' => '#c62828',
        'icon' => '🎄',
        'description' => 'Merry Christmas! Best Christmas deals 2025 on gifts, electronics, fashion, toys, home decor. Biggest Xmas sale with amazing discounts.',
        'meta_keywords' => 'christmas deals, xmas sale 2025, christmas offers, holiday shopping deals',
        'discount_threshold' => 35
    ],
    [
        'filename' => 'new-year-deals.php',
        'title' => 'New Year Sale 2026 - Best New Year Deals',
        'event' => 'New Year',
        'keywords' => ['new year', 'happy new year', 'new year sale'],
        'color' => '#1976d2',
        'icon' => '🎉',
        'description' => 'Happy New Year 2026! Start the year with best New Year deals on electronics, fashion, mobiles, laptops. Biggest New Year sale.',
        'meta_keywords' => 'new year deals, new year sale 2026, new year offers, january sale',
        'discount_threshold' => 35
    ],
    [
        'filename' => 'valentines-day-deals.php',
        'title' => 'Valentine\'s Day Sale 2025 - Best Gift Deals',
        'event' => 'Valentine\'s Day',
        'keywords' => ['valentine', 'valentines day', 'love day'],
        'color' => '#e91e63',
        'icon' => '❤️',
        'description' => 'Valentine\'s Day deals 2025! Find perfect gifts for your loved ones. Best Valentine offers on jewelry, watches, perfumes, chocolates, flowers.',
        'meta_keywords' => 'valentine deals, valentines day sale, valentine gifts 2025, love day offers',
        'discount_threshold' => 25
    ],
    
    // E-commerce Events
    [
        'filename' => 'black-friday-deals.php',
        'title' => 'Black Friday Sale 2025 - Best Black Friday Deals India',
        'event' => 'Black Friday',
        'keywords' => ['black friday', 'black friday sale', 'friday deals'],
        'color' => '#000000',
        'icon' => '🛍️',
        'description' => 'Black Friday India 2025! Get biggest Black Friday deals on electronics, mobiles, laptops, fashion. Up to 80% off - Best Black Friday sale.',
        'meta_keywords' => 'black friday deals india, black friday sale 2025, black friday offers, november sale',
        'discount_threshold' => 40
    ],
    [
        'filename' => 'cyber-monday-deals.php',
        'title' => 'Cyber Monday Sale 2025 - Best Online Deals',
        'event' => 'Cyber Monday',
        'keywords' => ['cyber monday', 'monday sale', 'online monday'],
        'color' => '#00acc1',
        'icon' => '💻',
        'description' => 'Cyber Monday India 2025! Best online shopping deals on electronics, gadgets, mobiles. Exclusive Cyber Monday offers up to 70% off.',
        'meta_keywords' => 'cyber monday deals india, cyber monday sale 2025, online shopping deals',
        'discount_threshold' => 40
    ],
    [
        'filename' => 'prime-day-deals.php',
        'title' => 'Amazon Prime Day 2025 - Best Prime Deals',
        'event' => 'Prime Day',
        'keywords' => ['prime day', 'amazon prime', 'prime sale'],
        'color' => '#ff9900',
        'icon' => '⚡',
        'description' => 'Amazon Prime Day 2025! Get exclusive Prime member deals on electronics, fashion, home appliances. Biggest Prime Day sale with lightning deals.',
        'meta_keywords' => 'amazon prime day, prime day deals 2025, prime sale, amazon offers',
        'discount_threshold' => 45
    ],
    [
        'filename' => 'big-billion-days.php',
        'title' => 'Flipkart Big Billion Days 2025 - Biggest Sale',
        'event' => 'Big Billion Days',
        'keywords' => ['big billion days', 'flipkart sale', 'bbd'],
        'color' => '#2874f0',
        'icon' => '🎯',
        'description' => 'Flipkart Big Billion Days 2025! India\'s biggest shopping festival. Get up to 80% off on mobiles, electronics, fashion, home appliances.',
        'meta_keywords' => 'flipkart big billion days, bbd sale 2025, flipkart offers, biggest sale',
        'discount_threshold' => 45
    ],
    [
        'filename' => 'great-indian-festival.php',
        'title' => 'Amazon Great Indian Festival 2025 - Biggest Sale',
        'event' => 'Great Indian Festival',
        'keywords' => ['great indian festival', 'amazon sale', 'gif'],
        'color' => '#232f3e',
        'icon' => '🎪',
        'description' => 'Amazon Great Indian Festival 2025! Biggest online shopping festival. Get up to 80% off on electronics, mobiles, fashion, home essentials.',
        'meta_keywords' => 'amazon great indian festival, gif sale 2025, amazon diwali sale, festive offers',
        'discount_threshold' => 45
    ],
];

// Generate page template
function generateFestivalPage($config) {
    $content = "<?php
/**
 * {$config['title']}
 * Seasonal event page - High search volume during festival season
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

\$pageTitle = '{$config['title']}';
\$pageDescription = '{$config['description']}';
\$pageKeywords = '{$config['meta_keywords']}';
\$eventName = '{$config['event']}';
\$eventColor = '{$config['color']}';
\$eventIcon = '{$config['icon']}';
\$discountThreshold = {$config['discount_threshold']};

// Fetch all deals from multiple API pages
\$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by discount threshold for festival offers
\$filteredDeals = [];
if (\$allDeals && is_array(\$allDeals)) {
    foreach (\$allDeals as \$deal) {
        \$originalPrice = floatval(\$deal['product_original_price'] ?? 0);
        \$offerPrice = floatval(\$deal['product_offer_price'] ?? 0);
        \$discount = getDiscountPercentage(\$originalPrice, \$offerPrice);
        
        // Include deals with discount above threshold
        if (\$discount >= \$discountThreshold) {
            \$filteredDeals[] = \$deal;
        }
    }
}

// Sort by discount percentage (highest first)
usort(\$filteredDeals, function(\$a, \$b) {
    \$discountA = getDiscountPercentage(\$a['product_original_price'], \$a['product_offer_price']);
    \$discountB = getDiscountPercentage(\$b['product_original_price'], \$b['product_offer_price']);
    return \$discountB <=> \$discountA;
});

\$totalDeals = count(\$filteredDeals);
\$maxDiscount = \$totalDeals > 0 ? round(max(array_map(function(\$d) {
    return getDiscountPercentage(\$d['product_original_price'], \$d['product_offer_price']);
}, \$filteredDeals))) : 0;
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title><?php echo \$pageTitle; ?> - <?php echo SITE_NAME; ?></title>
    <meta name=\"description\" content=\"<?php echo \$pageDescription; ?>\">
    <meta name=\"keywords\" content=\"<?php echo \$pageKeywords; ?>\">
    
    <!-- Open Graph Meta Tags -->
    <meta property=\"og:title\" content=\"<?php echo \$pageTitle; ?>\">
    <meta property=\"og:description\" content=\"<?php echo \$pageDescription; ?>\">
    <meta property=\"og:type\" content=\"website\">
    <meta property=\"og:url\" content=\"<?php echo SITE_URL . '/' . basename(__FILE__); ?>\">
    
    <link href=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link rel=\"stylesheet\" href=\"https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css\">
    <link rel=\"stylesheet\" href=\"assets/css/style.css\">
    
    <style>
        .festival-banner {
            background: linear-gradient(135deg, <?php echo \$eventColor; ?>, <?php echo \$eventColor; ?>dd);
            animation: festiveGlow 3s ease-in-out infinite;
        }
        @keyframes festiveGlow {
            0%, 100% { box-shadow: 0 4px 20px rgba(255,107,0,0.3); }
            50% { box-shadow: 0 8px 30px rgba(255,107,0,0.6); }
        }
        .deal-badge {
            background: <?php echo \$eventColor; ?>;
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class=\"container my-4\">
        <!-- Festival Banner -->
        <div class=\"row mb-4\">
            <div class=\"col-12\">
                <div class=\"festival-banner text-white p-4 rounded-3 text-center\">
                    <div class=\"display-1 mb-3\"><?php echo \$eventIcon; ?></div>
                    <h1 class=\"display-4 fw-bold mb-3\"><?php echo \$eventName; ?> Sale 2025</h1>
                    <p class=\"lead fs-3 mb-4\">🎉 Up to <?php echo \$maxDiscount; ?>% OFF on Everything! 🎉</p>
                    <div class=\"d-flex justify-content-center gap-3 flex-wrap mb-3\">
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-lightning-charge-fill text-warning\"></i> <?php echo \$totalDeals; ?> Hot Deals
                        </span>
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-fire text-danger\"></i> Best Prices
                        </span>
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-truck text-success\"></i> Fast Delivery
                        </span>
                    </div>
                    <p class=\"fs-5 mb-0\">
                        <i class=\"bi bi-clock-fill\"></i> Limited Time Offer - Grab Now!
                    </p>
                </div>
            </div>
        </div>

        <?php if (\$totalDeals > 0): ?>
            <!-- Category Quick Links -->
            <div class=\"row mb-4\">
                <div class=\"col-12\">
                    <div class=\"card shadow-sm\">
                        <div class=\"card-body\">
                            <h3 class=\"card-title mb-3\">
                                <i class=\"bi bi-grid-3x3-gap-fill\"></i> Shop by Category
                            </h3>
                            <div class=\"d-flex gap-2 flex-wrap\">
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('mobile')\">📱 Mobiles</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('laptop')\">💻 Laptops</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('tv')\">📺 TVs</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('watch')\">⌚ Watches</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('headphone')\">🎧 Audio</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('fashion')\">👕 Fashion</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('home')\">🏠 Home</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"location.reload()\">🔄 Show All</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class=\"row g-4\" id=\"products-container\">
                <?php foreach (\$filteredDeals as \$deal): 
                    \$pid = \$deal['pid'] ?? '';
                    \$productName = sanitizeOutput(\$deal['product_name'] ?? 'Product');
                    \$productImage = \$deal['product_image'] ?? 'assets/images/placeholder.jpg';
                    \$originalPrice = floatval(\$deal['product_original_price'] ?? 0);
                    \$offerPrice = floatval(\$deal['product_offer_price'] ?? 0);
                    \$storeName = sanitizeOutput(\$deal['store_name'] ?? 'Store');
                    \$discount = getDiscountPercentage(\$originalPrice, \$offerPrice);
                    \$savings = \$originalPrice - \$offerPrice;
                    
                    \$productUrl = SITE_URL . '/product/' . \$pid . '/' . createSlug(\$productName);
                ?>
                <div class=\"col-6 col-md-4 col-lg-3 product-item\" data-product-name=\"<?php echo strtolower(\$productName); ?>\">
                    <div class=\"product-card h-100 position-relative\">
                        <!-- Festival Badge -->
                        <?php if (\$discount >= 50): ?>
                            <div class=\"position-absolute top-0 start-0 m-2 z-3\">
                                <span class=\"badge deal-badge text-white px-3 py-2\">
                                    🔥 <?php echo \$eventName; ?> SPECIAL
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <a href=\"<?php echo \$productUrl; ?>\" class=\"text-decoration-none\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View <?php echo \$productName; ?> details\">
                            <div class=\"product-image\">
                                <img src=\"<?php echo \$productImage; ?>\" alt=\"<?php echo \$productName; ?>\" loading=\"lazy\">
                                <span class=\"discount-badge\"><?php echo round(\$discount); ?>% OFF</span>
                            </div>
                            <div class=\"product-info\">
                                <h3 class=\"product-title\"><?php echo \$productName; ?></h3>
                                <div class=\"product-price\">
                                    <span class=\"price-current\"><?php echo formatPrice(\$offerPrice); ?></span>
                                    <span class=\"price-original\"><?php echo formatPrice(\$originalPrice); ?></span>
                                </div>
                                <div class=\"text-success fw-bold mb-2\">
                                    <i class=\"bi bi-tag-fill\"></i> Save <?php echo formatPrice(\$savings); ?>
                                </div>
                                <div class=\"product-store\">
                                    <i class=\"bi bi-shop\"></i> <?php echo \$storeName; ?>
                                </div>
                                <button class=\"btn btn-primary btn-sm w-100 mt-2 view-details-btn\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View deal for <?php echo \$productName; ?>\">
                                    <i class=\"bi bi-lightning-charge-fill\"></i> Grab Deal
                                </button>
                            </div>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- SEO Content Section -->
            <div class=\"row mt-5\">
                <div class=\"col-12\">
                    <div class=\"card shadow-sm\">
                        <div class=\"card-body\">
                            <h2 class=\"h3 mb-3\"><?php echo \$eventName; ?> Sale 2025 - Best Deals & Offers</h2>
                            <p class=\"lead\">Welcome to the biggest <?php echo \$eventName; ?> sale of 2025! Get up to <?php echo \$maxDiscount; ?>% off on <?php echo \$totalDeals; ?>+ verified deals across all categories.</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Why Shop <?php echo \$eventName; ?> Deals Here?</h3>
                            <ul class=\"list-unstyled\">
                                <li class=\"mb-2\">✅ <strong>Verified Deals:</strong> All <?php echo \$eventName; ?> offers are verified and updated daily</li>
                                <li class=\"mb-2\">✅ <strong>Best Prices:</strong> Compare prices across Amazon & Flipkart</li>
                                <li class=\"mb-2\">✅ <strong>Huge Discounts:</strong> Up to <?php echo \$maxDiscount; ?>% off on top brands</li>
                                <li class=\"mb-2\">✅ <strong>Fast Delivery:</strong> Get products delivered before <?php echo \$eventName; ?></li>
                                <li class=\"mb-2\">✅ <strong>Easy Returns:</strong> Hassle-free returns on all products</li>
                            </ul>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Top Categories in <?php echo \$eventName; ?> Sale</h3>
                            <p>📱 Mobiles & Accessories | 💻 Laptops & Computers | 📺 TVs & Appliances | ⌚ Watches & Wearables | 🎧 Audio Devices | 👕 Fashion & Clothing | 🏠 Home & Kitchen | 🎁 Gifts & More</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">How to Get Best <?php echo \$eventName; ?> Deals?</h3>
                            <ol>
                                <li>Browse our curated collection of <?php echo \$totalDeals; ?> <?php echo \$eventName; ?> deals</li>
                                <li>Filter by category or brand to find what you need</li>
                                <li>Compare prices and discounts across different sellers</li>
                                <li>Click 'Grab Deal' to get the offer before it expires</li>
                                <li>Complete your purchase and enjoy <?php echo \$eventName; ?> savings!</li>
                            </ol>
                            
                            <div class=\"alert alert-warning mt-4\">
                                <i class=\"bi bi-exclamation-triangle-fill\"></i> <strong>Hurry!</strong> <?php echo \$eventName; ?> deals are limited time only. Stock may run out fast. Grab your favorite products now!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class=\"alert alert-info text-center\">
                <i class=\"bi bi-info-circle fs-1 d-block mb-3\"></i>
                <h3><?php echo \$eventName; ?> Deals Coming Soon!</h3>
                <p>Get ready for the biggest <?php echo \$eventName; ?> sale! Check back soon for exclusive offers and mega discounts.</p>
                <a href=\"<?php echo SITE_URL; ?>\" class=\"btn btn-primary\">Browse All Deals</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js\"></script>
    <script src=\"assets/js/script.js\"></script>
    <script>
        function filterByKeyword(keyword) {
            const products = document.querySelectorAll('.product-item');
            products.forEach(product => {
                const productName = product.getAttribute('data-product-name');
                if (productName.includes(keyword.toLowerCase())) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
            window.scrollTo({ top: 300, behavior: 'smooth' });
        }
    </script>
</body>
</html>
";
    
    return $content;
}

// Execute generation
echo "\n🎉 FESTIVAL & OCCASION PAGES GENERATOR\n";
echo str_repeat("=", 70) . "\n\n";

$created = 0;
$skipped = 0;
$failed = 0;

foreach ($festivalPages as $config) {
    $filename = $config['filename'];
    $filepath = __DIR__ . '/' . $filename;
    
    // Check if file already exists
    if (file_exists($filepath)) {
        echo "⏭️  Skipping {$filename} (already exists)\n";
        $skipped++;
        continue;
    }
    
    try {
        $content = generateFestivalPage($config);
        
        if (file_put_contents($filepath, $content)) {
            echo "✅ Created: {$filename} - {$config['title']}\n";
            $created++;
        } else {
            echo "❌ Failed: {$filename}\n";
            $failed++;
        }
    } catch (Exception $e) {
        echo "❌ Error creating {$filename}: " . $e->getMessage() . "\n";
        $failed++;
    }
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "📊 GENERATION SUMMARY:\n";
echo "   ✅ Created: {$created} pages\n";
echo "   ⏭️  Skipped: {$skipped} pages (already exist)\n";
echo "   ❌ Failed: {$failed} pages\n";
echo "   📦 Total: " . count($festivalPages) . " festival pages configured\n";
echo str_repeat("=", 70) . "\n\n";

if ($created > 0) {
    echo "🎊 SUCCESS! Festival pages created successfully!\n";
    echo "📈 Expected Seasonal Traffic: 100K+ visitors during events\n";
    echo "🔗 Access pages via: " . SITE_URL . "/[event-name]-deals.php\n\n";
}
?>
