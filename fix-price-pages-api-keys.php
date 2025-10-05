<?php
/**
 * Fix product_original_price to product_sale_price in all Phase 3 price pages
 */

$pricePages = [
    'deals-under-299.php',
    'deals-under-500.php',
    'deals-under-999.php',
    'deals-under-1000.php',
    'deals-under-2000.php',
    'deals-under-5000.php',
    'deals-500-1000.php',
    'deals-1000-5000.php',
    'deals-5000-10000.php',
    'deals-10000-50000.php',
    'deals-50000-plus.php',
    'budget-friendly-deals.php',
];

$fixed = 0;
$errors = 0;

foreach ($pricePages as $file) {
    if (!file_exists($file)) {
        echo "⚠️  Skipped: $file (not found)\n";
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Replace product_original_price with product_sale_price
    $content = str_replace('product_original_price', 'product_sale_price', $content);
    
    // Add null coalescing operators for safety if not already present
    $content = preg_replace(
        '/\$[ab]\[\'product_sale_price\'\](?!\s*\?\?)/',
        '$0 ?? 0',
        $content
    );
    $content = preg_replace(
        '/\$[ab]\[\'product_offer_price\'\](?!\s*\?\?)/',
        '$0 ?? 0',
        $content
    );
    $content = preg_replace(
        '/\$d\[\'product_sale_price\'\](?!\s*\?\?)/',
        '$0 ?? 0',
        $content
    );
    $content = preg_replace(
        '/\$d\[\'product_offer_price\'\](?!\s*\?\?)/',
        '$0 ?? 0',
        $content
    );
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "✅ Fixed: $file\n";
        $fixed++;
    } else {
        echo "ℹ️  No changes: $file\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 SUMMARY:\n";
echo "   ✅ Fixed: $fixed files\n";
echo "   ℹ️  Unchanged: " . (count($pricePages) - $fixed) . " files\n";
echo str_repeat("=", 60) . "\n";
echo "\n🎉 Done! All price pages should now work without errors.\n";
?>
