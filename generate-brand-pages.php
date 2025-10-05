<?php
/**
 * Brand Pages Generator
 * Creates brand-specific deal pages with high search volume potential
 */

require_once 'includes/config.php';

// Brand page configurations
$brandPages = [
    // Electronics & Mobile Brands
    [
        'filename' => 'samsung-deals.php',
        'title' => 'Samsung Deals & Offers',
        'brand' => 'Samsung',
        'keywords' => ['samsung', 'galaxy'],
        'color' => '#1428a0',
        'icon' => '📱',
        'description' => 'Best Samsung mobile phones, TVs, appliances deals. Get exclusive discounts on Samsung Galaxy smartphones, tablets, and electronics.',
        'meta_keywords' => 'samsung deals, samsung offers, samsung mobile deals, samsung galaxy deals, samsung discount'
    ],
    [
        'filename' => 'apple-deals.php',
        'title' => 'Apple Deals & Offers',
        'brand' => 'Apple',
        'keywords' => ['apple', 'iphone', 'ipad', 'macbook', 'airpods'],
        'color' => '#000000',
        'icon' => '🍎',
        'description' => 'Exclusive Apple iPhone, iPad, MacBook, AirPods deals. Save big on premium Apple products with best prices and offers.',
        'meta_keywords' => 'apple deals, iphone deals, ipad offers, macbook discount, apple products deals'
    ],
    [
        'filename' => 'oneplus-deals.php',
        'title' => 'OnePlus Deals & Offers',
        'brand' => 'OnePlus',
        'keywords' => ['oneplus', 'one plus'],
        'color' => '#eb0028',
        'icon' => '📱',
        'description' => 'Latest OnePlus smartphone deals. Get best prices on OnePlus mobile phones, TVs, and accessories with amazing discounts.',
        'meta_keywords' => 'oneplus deals, oneplus mobile offers, oneplus discount, oneplus phone deals'
    ],
    [
        'filename' => 'xiaomi-deals.php',
        'title' => 'Xiaomi & Mi Deals',
        'brand' => 'Xiaomi',
        'keywords' => ['xiaomi', 'mi', 'redmi', 'poco'],
        'color' => '#ff6900',
        'icon' => '📱',
        'description' => 'Best Xiaomi, Mi, Redmi, POCO smartphone deals. Save on budget-friendly mobile phones and smart devices.',
        'meta_keywords' => 'xiaomi deals, mi deals, redmi offers, poco deals, xiaomi mobile discount'
    ],
    [
        'filename' => 'realme-deals.php',
        'title' => 'Realme Deals & Offers',
        'brand' => 'Realme',
        'keywords' => ['realme', 'real me'],
        'color' => '#ffcc00',
        'icon' => '📱',
        'description' => 'Realme smartphone deals and offers. Get best prices on Realme mobile phones with exclusive discounts.',
        'meta_keywords' => 'realme deals, realme offers, realme mobile deals, realme phone discount'
    ],
    [
        'filename' => 'oppo-deals.php',
        'title' => 'OPPO Deals & Offers',
        'brand' => 'OPPO',
        'keywords' => ['oppo'],
        'color' => '#00a862',
        'icon' => '📱',
        'description' => 'OPPO smartphone deals with camera excellence. Find best OPPO mobile phone offers and discounts.',
        'meta_keywords' => 'oppo deals, oppo offers, oppo mobile deals, oppo phone discount'
    ],
    [
        'filename' => 'vivo-deals.php',
        'title' => 'Vivo Deals & Offers',
        'brand' => 'Vivo',
        'keywords' => ['vivo'],
        'color' => '#0066cc',
        'icon' => '📱',
        'description' => 'Vivo smartphone deals and offers. Get exclusive discounts on Vivo mobile phones with best features.',
        'meta_keywords' => 'vivo deals, vivo offers, vivo mobile deals, vivo phone discount'
    ],
    
    // Tech & Laptop Brands
    [
        'filename' => 'hp-deals.php',
        'title' => 'HP Laptop & Computer Deals',
        'brand' => 'HP',
        'keywords' => ['hp', 'hewlett'],
        'color' => '#0096d6',
        'icon' => '💻',
        'description' => 'HP laptop deals and computer offers. Save on HP notebooks, desktops, printers with best prices.',
        'meta_keywords' => 'hp deals, hp laptop deals, hp computer offers, hp discount'
    ],
    [
        'filename' => 'dell-deals.php',
        'title' => 'Dell Laptop & Computer Deals',
        'brand' => 'Dell',
        'keywords' => ['dell'],
        'color' => '#007db8',
        'icon' => '💻',
        'description' => 'Dell laptop and desktop deals. Get exclusive discounts on Dell computers, monitors, and accessories.',
        'meta_keywords' => 'dell deals, dell laptop deals, dell computer offers, dell discount'
    ],
    [
        'filename' => 'lenovo-deals.php',
        'title' => 'Lenovo Laptop & Computer Deals',
        'brand' => 'Lenovo',
        'keywords' => ['lenovo'],
        'color' => '#e2231a',
        'icon' => '💻',
        'description' => 'Lenovo laptop deals and ThinkPad offers. Save big on Lenovo computers and tablets.',
        'meta_keywords' => 'lenovo deals, lenovo laptop deals, thinkpad offers, lenovo discount'
    ],
    [
        'filename' => 'asus-deals.php',
        'title' => 'Asus Laptop & Gaming Deals',
        'brand' => 'Asus',
        'keywords' => ['asus'],
        'color' => '#000000',
        'icon' => '🎮',
        'description' => 'Asus laptop and gaming laptop deals. Get best prices on Asus ROG gaming laptops and computers.',
        'meta_keywords' => 'asus deals, asus laptop deals, asus rog deals, asus gaming laptop'
    ],
    [
        'filename' => 'sony-deals.php',
        'title' => 'Sony Electronics Deals',
        'brand' => 'Sony',
        'keywords' => ['sony'],
        'color' => '#000000',
        'icon' => '📺',
        'description' => 'Sony electronics deals - TVs, cameras, headphones, PlayStation. Get exclusive Sony product discounts.',
        'meta_keywords' => 'sony deals, sony tv deals, sony camera offers, sony headphones discount'
    ],
    [
        'filename' => 'lg-deals.php',
        'title' => 'LG Electronics Deals',
        'brand' => 'LG',
        'keywords' => ['lg'],
        'color' => '#a50034',
        'icon' => '📺',
        'description' => 'LG electronics deals - TVs, refrigerators, washing machines. Save on LG home appliances.',
        'meta_keywords' => 'lg deals, lg tv deals, lg appliances offers, lg discount'
    ],
    
    // Fashion & Accessories
    [
        'filename' => 'nike-deals.php',
        'title' => 'Nike Shoes & Sports Deals',
        'brand' => 'Nike',
        'keywords' => ['nike'],
        'color' => '#000000',
        'icon' => '👟',
        'description' => 'Nike shoes and sportswear deals. Get best prices on Nike sneakers, clothing, and sports accessories.',
        'meta_keywords' => 'nike deals, nike shoes deals, nike sneakers offers, nike sportswear discount'
    ],
    [
        'filename' => 'adidas-deals.php',
        'title' => 'Adidas Shoes & Sports Deals',
        'brand' => 'Adidas',
        'keywords' => ['adidas'],
        'color' => '#000000',
        'icon' => '👟',
        'description' => 'Adidas shoes and sportswear deals. Save on Adidas sneakers, clothing, and sports gear.',
        'meta_keywords' => 'adidas deals, adidas shoes deals, adidas sneakers offers, adidas discount'
    ],
    [
        'filename' => 'puma-deals.php',
        'title' => 'Puma Shoes & Sports Deals',
        'brand' => 'Puma',
        'keywords' => ['puma'],
        'color' => '#000000',
        'icon' => '👟',
        'description' => 'Puma shoes and sportswear offers. Get exclusive discounts on Puma sneakers and athletic wear.',
        'meta_keywords' => 'puma deals, puma shoes deals, puma sneakers offers, puma discount'
    ],
    
    // Indian Electronics Brands
    [
        'filename' => 'boat-deals.php',
        'title' => 'boAt Headphones & Audio Deals',
        'brand' => 'boAt',
        'keywords' => ['boat', 'bo at'],
        'color' => '#ff0000',
        'icon' => '🎧',
        'description' => 'boAt headphones, earphones, speakers deals. Get best prices on boAt audio products with exclusive discounts.',
        'meta_keywords' => 'boat deals, boat headphones deals, boat earphones offers, boat audio discount'
    ],
    [
        'filename' => 'noise-deals.php',
        'title' => 'Noise Smartwatch & Audio Deals',
        'brand' => 'Noise',
        'keywords' => ['noise'],
        'color' => '#000000',
        'icon' => '⌚',
        'description' => 'Noise smartwatch and audio deals. Save on Noise smart watches, earbuds, and wearables.',
        'meta_keywords' => 'noise deals, noise smartwatch deals, noise earbuds offers, noise discount'
    ],
    [
        'filename' => 'fire-boltt-deals.php',
        'title' => 'Fire-Boltt Smartwatch Deals',
        'brand' => 'Fire-Boltt',
        'keywords' => ['fire-boltt', 'fireboltt', 'fire boltt'],
        'color' => '#ff4500',
        'icon' => '⌚',
        'description' => 'Fire-Boltt smartwatch deals and offers. Get best prices on Fire-Boltt smart watches with exclusive discounts.',
        'meta_keywords' => 'fire-boltt deals, fire-boltt smartwatch deals, fireboltt offers, fire-boltt discount'
    ],
];

// Generate page template
function generateBrandPage($config) {
    $keywords = implode("', '", $config['keywords']);
    
    $content = "<?php
/**
 * {$config['title']}
 * Brand-specific deals page - High search volume
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

\$pageTitle = '{$config['title']}';
\$pageDescription = '{$config['description']}';
\$pageKeywords = '{$config['meta_keywords']}';
\$brandName = '{$config['brand']}';
\$brandKeywords = ['{$keywords}'];
\$brandColor = '{$config['color']}';
\$brandIcon = '{$config['icon']}';

// Fetch all deals from multiple API pages
\$allDeals = fetchMultipleEarnPeDeals(1, API_PAGES_TO_FETCH);

// Filter deals by brand keywords
\$filteredDeals = [];
if (\$allDeals && is_array(\$allDeals)) {
    foreach (\$allDeals as \$deal) {
        \$productName = strtolower(\$deal['product_name'] ?? '');
        \$brandNameLower = strtolower(\$deal['brand_name'] ?? '');
        
        // Check if product name or brand name contains any brand keyword
        foreach (\$brandKeywords as \$keyword) {
            if (stripos(\$productName, \$keyword) !== false || stripos(\$brandNameLower, \$keyword) !== false) {
                \$filteredDeals[] = \$deal;
                break;
            }
        }
    }
}

// Sort by discount percentage
usort(\$filteredDeals, function(\$a, \$b) {
    \$discountA = getDiscountPercentage(\$a['product_sale_price'], \$a['product_offer_price']);
    \$discountB = getDiscountPercentage(\$b['product_sale_price'], \$b['product_offer_price']);
    return \$discountB <=> \$discountA;
});

\$totalDeals = count(\$filteredDeals);
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
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <div class=\"container my-4\">
        <!-- Page Header -->
        <div class=\"row mb-4\">
            <div class=\"col-12\">
                <div class=\"page-header\" style=\"background: linear-gradient(135deg, <?php echo \$brandColor; ?>, <?php echo \$brandColor; ?>dd); color: white; padding: 2rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);\">
                    <h1 class=\"display-4 mb-2\">
                        <span style=\"font-size: 3rem;\"><?php echo \$brandIcon; ?></span>
                        <?php echo \$pageTitle; ?>
                    </h1>
                    <p class=\"lead mb-3\"><?php echo \$pageDescription; ?></p>
                    <div class=\"d-flex gap-3 flex-wrap\">
                        <span class=\"badge bg-light text-dark fs-6\">
                            <i class=\"bi bi-tags-fill\"></i> <?php echo \$totalDeals; ?> Deals Available
                        </span>
                        <span class=\"badge bg-light text-dark fs-6\">
                            <i class=\"bi bi-fire\"></i> Updated Today
                        </span>
                        <span class=\"badge bg-light text-dark fs-6\">
                            <i class=\"bi bi-shield-check\"></i> Verified <?php echo \$brandName; ?> Products
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <?php if (\$totalDeals > 0): ?>
            <!-- Products Grid -->
            <div class=\"row g-4\" id=\"products-container\">
                <?php foreach (\$filteredDeals as \$deal): 
                    \$pid = \$deal['pid'] ?? '';
                    \$productName = sanitizeOutput(\$deal['product_name'] ?? 'Product');
                    \$productImage = \$deal['product_image'] ?? 'assets/images/placeholder.jpg';
                    \$originalPrice = floatval(\$deal['product_sale_price'] ?? 0);
                    \$offerPrice = floatval(\$deal['product_offer_price'] ?? 0);
                    \$storeName = sanitizeOutput(\$deal['store_name'] ?? 'Store');
                    \$discount = getDiscountPercentage(\$originalPrice, \$offerPrice);
                    
                    \$productUrl = SITE_URL . '/product/' . \$pid . '/' . createSlug(\$productName);
                ?>
                <div class=\"col-6 col-md-4 col-lg-3\">
                    <div class=\"product-card h-100\">
                        <a href=\"<?php echo \$productUrl; ?>\" class=\"text-decoration-none\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View <?php echo \$productName; ?> details\">
                            <div class=\"product-image\">
                                <img src=\"<?php echo \$productImage; ?>\" alt=\"<?php echo \$productName; ?>\" loading=\"lazy\">
                                <?php if (\$discount > 0): ?>
                                    <span class=\"discount-badge\"><?php echo round(\$discount); ?>% OFF</span>
                                <?php endif; ?>
                            </div>
                            <div class=\"product-info\">
                                <h3 class=\"product-title\"><?php echo \$productName; ?></h3>
                                <div class=\"product-price\">
                                    <span class=\"price-current\"><?php echo formatPrice(\$offerPrice); ?></span>
                                    <?php if (\$originalPrice > \$offerPrice): ?>
                                        <span class=\"price-original\"><?php echo formatPrice(\$originalPrice); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class=\"product-store\">
                                    <i class=\"bi bi-shop\"></i> <?php echo \$storeName; ?>
                                </div>
                                <button class=\"btn btn-primary btn-sm w-100 mt-2 view-details-btn\" data-product-id=\"<?php echo \$pid; ?>\" title=\"View deal for <?php echo \$productName; ?>\">
                                    <i class=\"bi bi-eye\"></i> View Deal
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
                            <h2 class=\"h3 mb-3\">Why Choose <?php echo \$brandName; ?>?</h2>
                            <p>Discover exclusive <?php echo \$brandName; ?> deals with up to <?php echo \$totalDeals > 0 ? round(max(array_map(function(\$d) { return getDiscountPercentage(\$d['product_sale_price'], \$d['product_offer_price']); }, \$filteredDeals))) : 0; ?>% off. We bring you the best <?php echo \$brandName; ?> products at unbeatable prices.</p>
                            
                            <h3 class=\"h5 mt-4 mb-2\">How to Find Best <?php echo \$brandName; ?> Deals?</h3>
                            <ul>
                                <li>Browse our curated collection of <?php echo \$totalDeals; ?> verified <?php echo \$brandName; ?> products</li>
                                <li>Compare prices across different sellers to get the best deal</li>
                                <li>Check product ratings and reviews before purchasing</li>
                                <li>Look for additional bank offers and cashback</li>
                                <li>Save your favorite <?php echo \$brandName; ?> products for later</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class=\"alert alert-info text-center\">
                <i class=\"bi bi-info-circle fs-1 d-block mb-3\"></i>
                <h3>No <?php echo \$brandName; ?> Deals Available Right Now</h3>
                <p>Check back soon for the latest <?php echo \$brandName; ?> deals and offers!</p>
                <a href=\"<?php echo SITE_URL; ?>\" class=\"btn btn-primary\">Browse All Deals</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    
    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js\"></script>
    <script src=\"assets/js/script.js\"></script>
</body>
</html>
";
    
    return $content;
}

// Execute generation
echo "\n🚀 BRAND PAGES GENERATOR\n";
echo str_repeat("=", 70) . "\n\n";

$created = 0;
$skipped = 0;
$failed = 0;

foreach ($brandPages as $config) {
    $filename = $config['filename'];
    $filepath = __DIR__ . '/' . $filename;
    
    // Check if file already exists
    if (file_exists($filepath)) {
        echo "⏭️  Skipping {$filename} (already exists)\n";
        $skipped++;
        continue;
    }
    
    try {
        $content = generateBrandPage($config);
        
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
echo "   📦 Total: " . count($brandPages) . " brand pages configured\n";
echo str_repeat("=", 70) . "\n\n";

if ($created > 0) {
    echo "🎉 SUCCESS! Brand pages created successfully!\n";
    echo "📈 Expected Monthly Traffic: 50K+ visitors\n";
    echo "🔗 Access pages via: " . SITE_URL . "/[brand-name]-deals.php\n\n";
}
?>
