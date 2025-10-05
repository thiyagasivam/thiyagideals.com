<?php
/**
 * Discount Percentage Pages Generator - Phase 4
 * Creates discount-specific deal pages with high search volume potential
 */

require_once 'includes/config.php';

// Discount Percentage page configurations
$discountPages = [
    [
        'filename' => 'deals-10-percent-off.php',
        'title' => '10% OFF Deals - Get 10 Percent Discount',
        'discount' => '10% OFF',
        'min_discount' => 10,
        'max_discount' => 19,
        'color' => '#9e9e9e',
        'icon' => '🎫',
        'description' => 'Get 10% off deals on all products! Shop electronics, fashion, home essentials with 10 percent discount. Best 10% OFF offers from Amazon & Flipkart.',
        'meta_keywords' => '10 percent off, 10% discount, deals 10 off, 10 percent discount',
        'message' => 'Small savings add up! Get 10% off on quality products.'
    ],
    [
        'filename' => 'deals-40-percent-off.php',
        'title' => '40% OFF Deals - Get 40 Percent Discount',
        'discount' => '40% OFF',
        'min_discount' => 40,
        'max_discount' => 49,
        'color' => '#ff9800',
        'icon' => '🔥',
        'description' => 'Huge 40% off deals! Shop electronics, mobiles, fashion, home appliances with 40 percent discount. Best 40% OFF offers with maximum savings.',
        'meta_keywords' => '40 percent off, 40% discount, deals 40 off, 40 percent discount',
        'message' => 'Hot deals! Save big with 40% off on top products.'
    ],
    [
        'filename' => 'deals-50-percent-off.php',
        'title' => '50% OFF Deals - Get Half Price Discount',
        'discount' => '50% OFF',
        'min_discount' => 50,
        'max_discount' => 59,
        'color' => '#ff5722',
        'icon' => '💥',
        'description' => 'Amazing 50% off deals! Get half price on electronics, mobiles, fashion, home products. Shop 50 percent discount offers - save 50% today!',
        'meta_keywords' => '50 percent off, half price, 50% discount, deals 50 off',
        'message' => 'Half Price! Save 50% on premium products.'
    ],
    [
        'filename' => 'deals-60-percent-off.php',
        'title' => '60% OFF Deals - Get 60 Percent Discount',
        'discount' => '60% OFF',
        'min_discount' => 60,
        'max_discount' => 69,
        'color' => '#e91e63',
        'icon' => '🎉',
        'description' => 'Massive 60% off deals! Shop electronics, fashion, gadgets with 60 percent discount. Best 60% OFF offers - huge savings guaranteed!',
        'meta_keywords' => '60 percent off, 60% discount, deals 60 off, 60 percent discount',
        'message' => 'Massive Savings! Get 60% off on selected products.'
    ],
    [
        'filename' => 'deals-70-percent-off.php',
        'title' => '70% OFF Deals - Get 70 Percent Discount',
        'discount' => '70% OFF',
        'min_discount' => 70,
        'max_discount' => 74,
        'color' => '#9c27b0',
        'icon' => '⚡',
        'description' => 'Incredible 70% off deals! Get 70 percent discount on electronics, fashion, mobiles, home products. Best 70% OFF offers - super savings!',
        'meta_keywords' => '70 percent off, 70% discount, deals 70 off, 70 percent discount',
        'message' => 'Super Savings! Get 70% off - limited time only!'
    ],
    [
        'filename' => 'deals-75-percent-off.php',
        'title' => '75% OFF Deals - Get 75 Percent Discount',
        'discount' => '75% OFF',
        'min_discount' => 75,
        'max_discount' => 79,
        'color' => '#673ab7',
        'icon' => '🌟',
        'description' => 'Unbelievable 75% off deals! Shop 75 percent discount on electronics, fashion, gadgets. Best 75% OFF offers - extreme savings now!',
        'meta_keywords' => '75 percent off, 75% discount, deals 75 off, 75 percent discount',
        'message' => 'Extreme Savings! Get 75% off on top brands!'
    ],
    [
        'filename' => 'deals-80-percent-off.php',
        'title' => '80% OFF Deals - Get 80 Percent Discount',
        'discount' => '80% OFF',
        'min_discount' => 80,
        'max_discount' => 89,
        'color' => '#3f51b5',
        'icon' => '💎',
        'description' => 'Crazy 80% off deals! Get 80 percent discount on electronics, mobiles, fashion, home essentials. Best 80% OFF offers - maximum savings!',
        'meta_keywords' => '80 percent off, 80% discount, deals 80 off, 80 percent discount',
        'message' => 'Insane Deals! Save 80% - biggest discounts ever!'
    ],
    [
        'filename' => 'deals-90-percent-off.php',
        'title' => '90% OFF Deals - Get 90 Percent Discount',
        'discount' => '90% OFF',
        'min_discount' => 90,
        'max_discount' => 100,
        'color' => '#f44336',
        'icon' => '🚀',
        'description' => 'Unreal 90% off deals! Get 90 percent discount on selected products. Best 90% OFF offers - almost free! Shop clearance deals now.',
        'meta_keywords' => '90 percent off, 90% discount, deals 90 off, clearance sale',
        'message' => 'Almost Free! Get 90% off - clearance deals!'
    ],
];

// Generate page template
function generateDiscountPage($config) {
    $content = "<?php
/**
 * {$config['title']}
 * Discount percentage page - High search volume for discount-specific searches
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

\$pageTitle = '{$config['title']}';
\$pageDescription = '{$config['description']}';
\$pageKeywords = '{$config['meta_keywords']}';
\$discountLabel = '{$config['discount']}';
\$minDiscount = {$config['min_discount']};
\$maxDiscount = {$config['max_discount']};
\$discountColor = '{$config['color']}';
\$discountIcon = '{$config['icon']}';
\$discountMessage = '{$config['message']}';

// Fetch all deals from multiple API pages
\$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by discount percentage
\$filteredDeals = [];
if (\$allDeals && is_array(\$allDeals)) {
    foreach (\$allDeals as \$deal) {
        \$originalPrice = floatval(\$deal['product_original_price'] ?? 0);
        \$offerPrice = floatval(\$deal['product_offer_price'] ?? 0);
        \$discount = getDiscountPercentage(\$originalPrice, \$offerPrice);
        
        // Include deals within discount range
        if (\$discount >= \$minDiscount && \$discount < \$maxDiscount) {
            \$filteredDeals[] = \$deal;
        }
    }
}

// Sort by offer price (lowest first for best deals)
usort(\$filteredDeals, function(\$a, \$b) {
    return floatval(\$a['product_offer_price']) <=> floatval(\$b['product_offer_price']);
});

\$totalDeals = count(\$filteredDeals);
\$avgSavings = \$totalDeals > 0 ? round(array_sum(array_map(function(\$d) {
    return floatval(\$d['product_original_price'] ?? 0) - floatval(\$d['product_offer_price'] ?? 0);
}, \$filteredDeals)) / \$totalDeals) : 0;
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
        .discount-banner {
            background: linear-gradient(135deg, <?php echo \$discountColor; ?>, <?php echo \$discountColor; ?>dd);
            animation: discountPulse 2s ease-in-out infinite;
        }
        @keyframes discountPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.02); }
        }
        .discount-badge {
            background: <?php echo \$discountColor; ?>;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class=\"container my-4\">
        <!-- Discount Banner -->
        <div class=\"row mb-4\">
            <div class=\"col-12\">
                <div class=\"discount-banner text-white p-4 rounded-3 text-center\">
                    <div class=\"display-1 mb-3\"><?php echo \$discountIcon; ?></div>
                    <h1 class=\"display-3 fw-bold mb-3\"><?php echo \$discountLabel; ?> DEALS</h1>
                    <p class=\"lead fs-3 mb-4\"><?php echo \$discountMessage; ?></p>
                    <div class=\"d-flex justify-content-center gap-3 flex-wrap mb-3\">
                        <span class=\"badge bg-white text-dark fs-4 px-4 py-3\">
                            <i class=\"bi bi-tag-fill text-danger\"></i> <?php echo \$totalDeals; ?> Deals
                        </span>
                        <span class=\"badge bg-white text-dark fs-4 px-4 py-3\">
                            <i class=\"bi bi-piggy-bank-fill text-success\"></i> Avg Save: ₹<?php echo number_format(\$avgSavings); ?>
                        </span>
                        <span class=\"badge bg-white text-dark fs-4 px-4 py-3\">
                            <i class=\"bi bi-lightning-charge-fill text-warning\"></i> Hot Offers
                        </span>
                    </div>
                    <p class=\"fs-4 mb-0\">
                        <i class=\"bi bi-clock-fill\"></i> Limited Time - Grab Before Stock Runs Out!
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
                                <i class=\"bi bi-funnel-fill\"></i> Filter by Category
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
                        <!-- Discount Badge -->
                        <div class=\"position-absolute top-0 start-0 m-2 z-3\">
                            <span class=\"badge discount-badge text-white px-3 py-2 fs-6\">
                                <?php echo round(\$discount); ?>% OFF
                            </span>
                        </div>
                        
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
                                    <i class=\"bi bi-cash-coin\"></i> You Save: <?php echo formatPrice(\$savings); ?>
                                </div>
                                <div class=\"product-store\">
                                    <i class=\"bi bi-shop\"></i> <?php echo \$storeName; ?>
                                </div>
                                <button class=\"btn btn-primary btn-sm w-100 mt-2 view-details-btn\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View deal for <?php echo \$productName; ?>\">
                                    <i class=\"bi bi-lightning-charge-fill\"></i> Get <?php echo \$discountLabel; ?>
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
                            <h2 class=\"h3 mb-3\"><?php echo \$discountLabel; ?> Deals - Complete Shopping Guide</h2>
                            <p class=\"lead\">Get amazing <?php echo \$discountLabel; ?> on <?php echo \$totalDeals; ?> verified products! Shop electronics, mobiles, fashion, home essentials with huge savings.</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Why Shop <?php echo \$discountLabel; ?> Deals?</h3>
                            <ul class=\"list-unstyled\">
                                <li class=\"mb-2\">✅ <strong>Verified Discounts:</strong> All <?php echo \$discountLabel; ?> offers are verified and updated daily</li>
                                <li class=\"mb-2\">✅ <strong>Best Prices:</strong> Compare prices across Amazon & Flipkart</li>
                                <li class=\"mb-2\">✅ <strong>Huge Savings:</strong> Average savings of ₹<?php echo number_format(\$avgSavings); ?> per product</li>
                                <li class=\"mb-2\">✅ <strong>Quality Products:</strong> <?php echo \$totalDeals; ?> top-rated products to choose from</li>
                                <li class=\"mb-2\">✅ <strong>Fast Delivery:</strong> Quick delivery from trusted sellers</li>
                            </ul>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Popular Categories with <?php echo \$discountLabel; ?></h3>
                            <p>📱 Mobiles & Accessories | 💻 Laptops & Computers | 📺 TVs & Appliances | ⌚ Watches & Wearables | 🎧 Audio Devices | 👕 Fashion & Clothing | 🏠 Home & Kitchen | 🎮 Gaming & Entertainment</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">How to Shop <?php echo \$discountLabel; ?> Deals?</h3>
                            <ol>
                                <li>Browse our collection of <?php echo \$totalDeals; ?> products with <?php echo \$discountLabel; ?></li>
                                <li>Use category filters to find what you need quickly</li>
                                <li>Compare prices and check product ratings</li>
                                <li>Click 'Get <?php echo \$discountLabel; ?>' to grab the deal</li>
                                <li>Complete your purchase and save big!</li>
                            </ol>
                            
                            <div class=\"alert alert-success mt-4\">
                                <i class=\"bi bi-lightning-charge-fill\"></i> <strong>Hot Tip!</strong> <?php echo \$discountLabel; ?> deals are limited time only. Average savings: ₹<?php echo number_format(\$avgSavings); ?> per product. Don't miss out!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class=\"alert alert-info text-center\">
                <i class=\"bi bi-info-circle fs-1 d-block mb-3\"></i>
                <h3>No <?php echo \$discountLabel; ?> Deals Available Right Now</h3>
                <p>Check back soon for amazing <?php echo \$discountLabel; ?> offers!</p>
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
            let visibleCount = 0;
            products.forEach(product => {
                const productName = product.getAttribute('data-product-name');
                if (productName.includes(keyword.toLowerCase())) {
                    product.style.display = '';
                    visibleCount++;
                } else {
                    product.style.display = 'none';
                }
            });
            window.scrollTo({ top: 300, behavior: 'smooth' });
            
            if (visibleCount === 0) {
                alert('No products found in this category with the selected discount. Showing all products.');
                location.reload();
            }
        }
    </script>
</body>
</html>
";
    
    return $content;
}

// Execute generation
echo "\n🔥 DISCOUNT PERCENTAGE PAGES GENERATOR - PHASE 4\n";
echo str_repeat("=", 70) . "\n\n";

$created = 0;
$skipped = 0;
$failed = 0;

foreach ($discountPages as $config) {
    $filename = $config['filename'];
    $filepath = __DIR__ . '/' . $filename;
    
    // Check if file already exists
    if (file_exists($filepath)) {
        echo "⏭️  Skipping {$filename} (already exists)\n";
        $skipped++;
        continue;
    }
    
    try {
        $content = generateDiscountPage($config);
        
        if (file_put_contents($filepath, $content)) {
            echo "✅ Created: {$filename} - {$config['discount']}\n";
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
echo "📊 PHASE 4 SUMMARY:\n";
echo "   ✅ Created: {$created} pages\n";
echo "   ⏭️  Skipped: {$skipped} pages (already exist)\n";
echo "   ❌ Failed: {$failed} pages\n";
echo "   📦 Total: " . count($discountPages) . " discount pages configured\n";
echo str_repeat("=", 70) . "\n\n";

if ($created > 0) {
    echo "🎉 PHASE 4 SUCCESS! Discount percentage pages created!\n";
    echo "📈 Expected Monthly Traffic: 40K+ visitors\n";
    echo "🔗 Ready for Phase 5!\n\n";
}
?>
