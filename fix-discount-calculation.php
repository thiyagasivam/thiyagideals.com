<?php
/**
 * Fix Product Discount Calculation in All Pages
 * Replace product_discount array key with calculated discount
 */

$pagesFixed = 0;
$pagesFailed = 0;
$filesWithIssues = [];

// Get all PHP files in shop directory
$files = glob(__DIR__ . '/*.php');

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip system files
    if (in_array($filename, ['index.php', 'product.php', 'generate-pages-config.php', 'generate-pages-execute.php', 'fix-all-pages.php', 'fix-discount-calculation.php', 'all-pages.php', 'api-analysis.php', 'test_api.php'])) {
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    $changes = 0;
    
    // Pattern 1: Fix in filter function - $discount = floatval($deal['product_discount']);
    if (strpos($content, "\$discount = floatval(\$deal['product_discount']);") !== false) {
        $content = str_replace(
            "\$discount = floatval(\$deal['product_discount']);",
            "\$discount = calculateDiscount(\$deal['product_offer_price'], \$deal['product_sale_price']);",
            $content
        );
        $changes++;
    }
    
    // Pattern 2: Fix in usort - floatval($b['product_discount'])
    if (strpos($content, "floatval(\$b['product_discount'])") !== false) {
        $content = str_replace(
            "floatval(\$b['product_discount'])",
            "calculateDiscount(\$b['product_offer_price'], \$b['product_sale_price'])",
            $content
        );
        $changes++;
    }
    
    // Pattern 3: Fix in usort - floatval($a['product_discount'])
    if (strpos($content, "floatval(\$a['product_discount'])") !== false) {
        $content = str_replace(
            "floatval(\$a['product_discount'])",
            "calculateDiscount(\$a['product_offer_price'], \$a['product_sale_price'])",
            $content
        );
        $changes++;
    }
    
    // Pattern 4: Fix in average calculation - array_column($filteredDeals, 'product_discount')
    if (strpos($content, "array_sum(array_column(\$filteredDeals, 'product_discount'))") !== false) {
        // Need to replace with calculated average
        $content = preg_replace(
            '/\$avgDiscount = \$totalDeals > 0 \? array_sum\(array_column\(\$filteredDeals, \'product_discount\'\)\) \/ \$totalDeals : 0;/',
            '$avgDiscount = 0;
if ($totalDeals > 0) {
    $discountSum = 0;
    foreach ($filteredDeals as $deal) {
        $discountSum += calculateDiscount($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);
    }
    $avgDiscount = $discountSum / $totalDeals;
}',
            $content
        );
        $changes++;
    }
    
    // Pattern 5: Fix discount display in product cards - $deal['product_discount']
    // This is more complex as it appears in multiple contexts
    $content = preg_replace(
        '/\$discount = floatval\(\$deal\[\'product_discount\'\]\);/',
        '$discount = calculateDiscount($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);',
        $content
    );
    
    // If changes were made, save the file
    if ($content !== $originalContent) {
        if (file_put_contents($file, $content)) {
            $pagesFixed++;
            echo "✅ Fixed: {$filename}\n";
        } else {
            $pagesFailed++;
            $filesWithIssues[] = $filename;
            echo "❌ Failed: {$filename}\n";
        }
    } else {
        echo "⏭️  No changes needed: {$filename}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ Pages fixed: {$pagesFixed}\n";
echo "❌ Pages failed: {$pagesFailed}\n";
if (!empty($filesWithIssues)) {
    echo "❌ Files with issues:\n";
    foreach ($filesWithIssues as $file) {
        echo "   - {$file}\n";
    }
}
echo str_repeat("=", 60) . "\n";
echo "\n🎉 Discount calculation fix complete!\n";
?>