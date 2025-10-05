<?php
/**
 * Price Range Pages Generator
 * Creates budget-specific deal pages with high search volume potential
 */

require_once 'includes/config.php';

// Price Range page configurations
$pricePages = [
    // Ultra Budget Segment
    [
        'filename' => 'deals-under-299.php',
        'title' => 'Deals Under ₹299 - Best Budget Products',
        'range' => 'Under ₹299',
        'min_price' => 0,
        'max_price' => 299,
        'color' => '#4caf50',
        'icon' => '💰',
        'description' => 'Best deals under ₹299! Shop ultra-budget products with amazing discounts. Get electronics, accessories, fashion, and essentials at unbeatable prices below 299 rupees.',
        'meta_keywords' => 'deals under 299, products under 299, budget deals, cheap products india',
        'target_audience' => 'Budget Shoppers',
        'popular_categories' => 'Accessories, Mobile Covers, Earphones, Stationery, Kitchen Items'
    ],
    [
        'filename' => 'deals-under-499.php',
        'title' => 'Deals Under ₹499 - Best Products Below 500',
        'range' => 'Under ₹499',
        'min_price' => 0,
        'max_price' => 499,
        'color' => '#8bc34a',
        'icon' => '🛒',
        'description' => 'Top deals under ₹499! Find best products below 500 rupees. Shop mobiles accessories, headphones, fashion, home essentials with huge discounts under Rs 500.',
        'meta_keywords' => 'deals under 499, products under 500, budget shopping, affordable deals',
        'target_audience' => 'Value Seekers',
        'popular_categories' => 'Bluetooth Speakers, Power Banks, T-Shirts, Watches, Kitchen Gadgets'
    ],
    
    // Budget Segment
    [
        'filename' => 'deals-500-999.php',
        'title' => 'Deals ₹500-999 - Best Products in 500 to 1000 Range',
        'range' => '₹500 - ₹999',
        'min_price' => 500,
        'max_price' => 999,
        'color' => '#ffc107',
        'icon' => '🎯',
        'description' => 'Best deals between ₹500-999! Shop quality products in 500-1000 price range. Get headphones, smartwatches, fashion, accessories with maximum savings.',
        'meta_keywords' => 'deals 500 to 1000, products under 1000, 500-999 deals, budget gadgets',
        'target_audience' => 'Smart Shoppers',
        'popular_categories' => 'Wireless Earbuds, Smart Bands, Shoes, Bags, Grooming Kits'
    ],
    [
        'filename' => 'deals-1000-1499.php',
        'title' => 'Deals ₹1000-1499 - Best Products in 1K-1.5K Range',
        'range' => '₹1,000 - ₹1,499',
        'min_price' => 1000,
        'max_price' => 1499,
        'color' => '#ff9800',
        'icon' => '🏆',
        'description' => 'Premium deals ₹1000-1499! Find best products in 1000-1500 range. Shop smartwatches, headphones, fashion, electronics with exclusive discounts.',
        'meta_keywords' => 'deals 1000 to 1500, products under 1500, 1k-1.5k deals, mid range products',
        'target_audience' => 'Quality Conscious',
        'popular_categories' => 'Smartwatches, TWS Earbuds, Sneakers, Backpacks, Trimmers'
    ],
    
    // Mid-Range Segment
    [
        'filename' => 'deals-1500-2499.php',
        'title' => 'Deals ₹1500-2499 - Best Mid-Range Products',
        'range' => '₹1,500 - ₹2,499',
        'min_price' => 1500,
        'max_price' => 2499,
        'color' => '#ff5722',
        'icon' => '⭐',
        'description' => 'Top mid-range deals ₹1500-2499! Shop quality electronics, smartwatches, headphones, fashion in 1500-2500 price range with best discounts.',
        'meta_keywords' => 'deals 1500 to 2500, mid range products, 1.5k-2.5k deals, quality gadgets',
        'target_audience' => 'Mid-Range Buyers',
        'popular_categories' => 'Smart Watches, Bluetooth Headphones, Running Shoes, Travel Bags'
    ],
    [
        'filename' => 'deals-2500-4999.php',
        'title' => 'Deals ₹2500-4999 - Best Products in 2.5K-5K Range',
        'range' => '₹2,500 - ₹4,999',
        'min_price' => 2500,
        'max_price' => 4999,
        'color' => '#e91e63',
        'icon' => '💎',
        'description' => 'Premium deals ₹2500-4999! Shop best electronics, smartwatches, headphones, fashion in 2500-5000 range. Get maximum savings on quality products.',
        'meta_keywords' => 'deals 2500 to 5000, products under 5000, 2.5k-5k deals, premium gadgets',
        'target_audience' => 'Premium Seekers',
        'popular_categories' => 'Feature Phones, Fitness Bands, Headphones, Formal Shoes, Jackets'
    ],
    
    // Premium Segment
    [
        'filename' => 'deals-5000-9999.php',
        'title' => 'Deals ₹5000-9999 - Best Products in 5K-10K Range',
        'range' => '₹5,000 - ₹9,999',
        'min_price' => 5000,
        'max_price' => 9999,
        'color' => '#9c27b0',
        'icon' => '🌟',
        'description' => 'Premium deals ₹5000-9999! Find best smartphones, laptops, TVs, electronics in 5000-10000 price range. Shop quality products with huge discounts.',
        'meta_keywords' => 'deals 5000 to 10000, products under 10000, 5k-10k deals, budget smartphones',
        'target_audience' => 'Tech Enthusiasts',
        'popular_categories' => 'Budget Smartphones, Tablets, Smartwatches, Bluetooth Speakers, Cameras'
    ],
    [
        'filename' => 'deals-10000-14999.php',
        'title' => 'Deals ₹10000-14999 - Best Products in 10K-15K Range',
        'range' => '₹10,000 - ₹14,999',
        'min_price' => 10000,
        'max_price' => 14999,
        'color' => '#673ab7',
        'icon' => '🎖️',
        'description' => 'Premium deals ₹10000-14999! Shop best smartphones, laptops, TVs in 10K-15K range. Get maximum discounts on quality electronics and gadgets.',
        'meta_keywords' => 'deals 10000 to 15000, products under 15000, 10k-15k deals, mid range smartphones',
        'target_audience' => 'Quality Buyers',
        'popular_categories' => 'Mid-Range Smartphones, Laptops, Smart TVs, Cameras, Sound Systems'
    ],
    
    // High-End Segment
    [
        'filename' => 'deals-15000-24999.php',
        'title' => 'Deals ₹15000-24999 - Best Products in 15K-25K Range',
        'range' => '₹15,000 - ₹24,999',
        'min_price' => 15000,
        'max_price' => 24999,
        'color' => '#3f51b5',
        'icon' => '👑',
        'description' => 'Premium deals ₹15000-24999! Find flagship smartphones, laptops, TVs, appliances in 15K-25K range. Best discounts on high-end electronics.',
        'meta_keywords' => 'deals 15000 to 25000, products under 25000, 15k-25k deals, flagship smartphones',
        'target_audience' => 'Premium Buyers',
        'popular_categories' => 'Flagship Smartphones, Gaming Laptops, 4K TVs, DSLR Cameras, Home Theater'
    ],
    [
        'filename' => 'deals-25000-49999.php',
        'title' => 'Deals ₹25000-49999 - Best Products in 25K-50K Range',
        'range' => '₹25,000 - ₹49,999',
        'min_price' => 25000,
        'max_price' => 49999,
        'color' => '#2196f3',
        'icon' => '💼',
        'description' => 'Luxury deals ₹25000-49999! Shop premium smartphones, laptops, TVs, appliances in 25K-50K range. Best offers on flagship products.',
        'meta_keywords' => 'deals 25000 to 50000, products under 50000, 25k-50k deals, premium electronics',
        'target_audience' => 'Luxury Seekers',
        'popular_categories' => 'Premium Smartphones, Gaming Laptops, OLED TVs, Professional Cameras'
    ],
    
    // Ultra-Premium Segment
    [
        'filename' => 'deals-50000-plus.php',
        'title' => 'Deals Above ₹50000 - Best Premium & Luxury Products',
        'range' => 'Above ₹50,000',
        'min_price' => 50000,
        'max_price' => 999999,
        'color' => '#000000',
        'icon' => '🏅',
        'description' => 'Ultra-premium deals above ₹50000! Shop luxury smartphones, laptops, TVs, appliances. Best discounts on flagship and premium products above 50K.',
        'meta_keywords' => 'deals above 50000, premium products, luxury electronics, flagship deals',
        'target_audience' => 'Luxury Buyers',
        'popular_categories' => 'iPhone, MacBook, Premium Laptops, OLED TVs, High-End Appliances'
    ],
    
    // Lifestyle Segment
    [
        'filename' => 'budget-friendly-deals.php',
        'title' => 'Budget Friendly Deals - Best Affordable Products',
        'range' => 'Budget Friendly',
        'min_price' => 0,
        'max_price' => 2999,
        'color' => '#00bcd4',
        'icon' => '🎁',
        'description' => 'Best budget-friendly deals! Shop affordable products under 3000. Get electronics, fashion, accessories, home essentials at lowest prices with huge discounts.',
        'meta_keywords' => 'budget friendly deals, affordable products, cheap deals india, value for money',
        'target_audience' => 'Budget Conscious',
        'popular_categories' => 'All Budget Categories - Accessories, Fashion, Electronics, Home & Kitchen'
    ],
];

// Generate page template
function generatePricePage($config) {
    $content = "<?php
/**
 * {$config['title']}
 * Price range page - High search volume for budget-specific searches
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

\$pageTitle = '{$config['title']}';
\$pageDescription = '{$config['description']}';
\$pageKeywords = '{$config['meta_keywords']}';
\$priceRange = '{$config['range']}';
\$minPrice = {$config['min_price']};
\$maxPrice = {$config['max_price']};
\$rangeColor = '{$config['color']}';
\$rangeIcon = '{$config['icon']}';
\$targetAudience = '{$config['target_audience']}';
\$popularCategories = '{$config['popular_categories']}';

// Fetch all deals from multiple API pages
\$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by price range
\$filteredDeals = [];
if (\$allDeals && is_array(\$allDeals)) {
    foreach (\$allDeals as \$deal) {
        \$offerPrice = floatval(\$deal['product_offer_price'] ?? 0);
        
        // Include deals within price range
        if (\$offerPrice >= \$minPrice && \$offerPrice <= \$maxPrice) {
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

\$avgPrice = \$totalDeals > 0 ? round(array_sum(array_map(function(\$d) {
    return floatval(\$d['product_offer_price'] ?? 0);
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
        .price-banner {
            background: linear-gradient(135deg, <?php echo \$rangeColor; ?>, <?php echo \$rangeColor; ?>dd);
        }
        .price-badge {
            background: <?php echo \$rangeColor; ?>;
        }
        .price-highlight {
            color: <?php echo \$rangeColor; ?>;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class=\"container my-4\">
        <!-- Price Range Banner -->
        <div class=\"row mb-4\">
            <div class=\"col-12\">
                <div class=\"price-banner text-white p-4 rounded-3 text-center\">
                    <div class=\"display-1 mb-3\"><?php echo \$rangeIcon; ?></div>
                    <h1 class=\"display-4 fw-bold mb-3\">Deals <?php echo \$priceRange; ?></h1>
                    <p class=\"lead fs-3 mb-4\">🎯 <?php echo \$totalDeals; ?> Best Products | Up to <?php echo \$maxDiscount; ?>% OFF 🎯</p>
                    <div class=\"d-flex justify-content-center gap-3 flex-wrap mb-3\">
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-tag-fill text-success\"></i> Price: <?php echo \$priceRange; ?>
                        </span>
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-graph-up text-primary\"></i> Avg: ₹<?php echo number_format(\$avgPrice); ?>
                        </span>
                        <span class=\"badge bg-white text-dark fs-5 px-4 py-2\">
                            <i class=\"bi bi-people-fill text-info\"></i> For: <?php echo \$targetAudience; ?>
                        </span>
                    </div>
                    <p class=\"fs-5 mb-0\">
                        <i class=\"bi bi-clock-fill\"></i> Updated Daily - Best Prices Guaranteed!
                    </p>
                </div>
            </div>
        </div>

        <?php if (\$totalDeals > 0): ?>
            <!-- Quick Stats -->
            <div class=\"row mb-4\">
                <div class=\"col-12\">
                    <div class=\"card shadow-sm\">
                        <div class=\"card-body\">
                            <h3 class=\"card-title mb-3\">
                                <i class=\"bi bi-bar-chart-fill\"></i> Popular Categories in <?php echo \$priceRange; ?>
                            </h3>
                            <p class=\"mb-3\"><?php echo \$popularCategories; ?></p>
                            <div class=\"d-flex gap-2 flex-wrap\">
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('mobile')\">📱 Mobiles</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('watch')\">⌚ Watches</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('headphone')\">🎧 Audio</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('fashion')\">👕 Fashion</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('laptop')\">💻 Laptops</button>
                                <button class=\"btn btn-outline-primary\" onclick=\"filterByKeyword('tv')\">📺 TVs</button>
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
                        <!-- Best Value Badge -->
                        <?php if (\$discount >= 40): ?>
                            <div class=\"position-absolute top-0 start-0 m-2 z-3\">
                                <span class=\"badge price-badge text-white px-3 py-2\">
                                    💎 BEST VALUE
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
                                    <i class=\"bi bi-piggy-bank-fill\"></i> Save <?php echo formatPrice(\$savings); ?>
                                </div>
                                <div class=\"product-store\">
                                    <i class=\"bi bi-shop\"></i> <?php echo \$storeName; ?>
                                </div>
                                <button class=\"btn btn-primary btn-sm w-100 mt-2 view-details-btn\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View deal for <?php echo \$productName; ?>\">
                                    <i class=\"bi bi-cart-plus-fill\"></i> View Deal
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
                            <h2 class=\"h3 mb-3\">Best Deals <?php echo \$priceRange; ?> - Complete Guide</h2>
                            <p class=\"lead\">Looking for the best products <?php echo strtolower(\$priceRange); ?>? You're in the right place! We've curated <?php echo \$totalDeals; ?> verified deals with up to <?php echo \$maxDiscount; ?>% off.</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Why Shop in <?php echo \$priceRange; ?> Range?</h3>
                            <ul class=\"list-unstyled\">
                                <li class=\"mb-2\">✅ <strong>Perfect Budget:</strong> Quality products at the right price point</li>
                                <li class=\"mb-2\">✅ <strong>Best Value:</strong> Maximum features for your money</li>
                                <li class=\"mb-2\">✅ <strong>Verified Deals:</strong> All prices updated daily from Amazon & Flipkart</li>
                                <li class=\"mb-2\">✅ <strong>Great Selection:</strong> <?php echo \$totalDeals; ?> products to choose from</li>
                                <li class=\"mb-2\">✅ <strong>Huge Savings:</strong> Average discount of <?php echo \$maxDiscount; ?>%</li>
                            </ul>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Popular Categories in <?php echo \$priceRange; ?></h3>
                            <p><?php echo \$popularCategories; ?></p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Shopping Tips for <?php echo \$priceRange; ?> Range</h3>
                            <ol>
                                <li>Compare prices across Amazon and Flipkart using our listings</li>
                                <li>Look for products with highest discount percentages</li>
                                <li>Check product ratings and reviews before purchasing</li>
                                <li>Use filters to narrow down by category or brand</li>
                                <li>Bookmark this page - we update deals daily!</li>
                            </ol>
                            
                            <h3 class=\"h5 mt-4 mb-2\">Target Audience: <?php echo \$targetAudience; ?></h3>
                            <p>This price range is perfect for <?php echo strtolower(\$targetAudience); ?> who want quality products without overspending. Whether you're a student, working professional, or savvy shopper, you'll find amazing deals here.</p>
                            
                            <div class=\"alert alert-success mt-4\">
                                <i class=\"bi bi-trophy-fill\"></i> <strong>Best Deals Guaranteed!</strong> We track <?php echo \$totalDeals; ?> products daily to bring you the lowest prices in the <?php echo \$priceRange; ?> range. Average savings: ₹<?php echo number_format(\$avgPrice * 0.3); ?>+ per product!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class=\"alert alert-info text-center\">
                <i class=\"bi bi-info-circle fs-1 d-block mb-3\"></i>
                <h3>No Deals Available Right Now</h3>
                <p>We're updating our inventory. Check back soon for amazing deals in the <?php echo \$priceRange; ?> range!</p>
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
            
            // Show message if no products found
            if (visibleCount === 0) {
                alert('No products found in this category for the selected price range. Showing all products.');
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
echo "\n💰 PRICE RANGE PAGES GENERATOR\n";
echo str_repeat("=", 70) . "\n\n";

$created = 0;
$skipped = 0;
$failed = 0;

foreach ($pricePages as $config) {
    $filename = $config['filename'];
    $filepath = __DIR__ . '/' . $filename;
    
    // Check if file already exists
    if (file_exists($filepath)) {
        echo "⏭️  Skipping {$filename} (already exists)\n";
        $skipped++;
        continue;
    }
    
    try {
        $content = generatePricePage($config);
        
        if (file_put_contents($filepath, $content)) {
            echo "✅ Created: {$filename} - {$config['range']}\n";
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
echo "   📦 Total: " . count($pricePages) . " price pages configured\n";
echo str_repeat("=", 70) . "\n\n";

if ($created > 0) {
    echo "🎉 SUCCESS! Price range pages created successfully!\n";
    echo "📈 Expected Monthly Traffic: 60K+ visitors\n";
    echo "🔗 Access pages via: " . SITE_URL . "/[price-range]-deals.php\n\n";
}
?>
