<?php
/**
 * Fix Product Discount Calculation - Round 2
 * Replace calculateDiscount with getDiscountPercentage for numeric operations
 */

$pagesFixed = 0;
$pagesFailed = 0;

// Get all PHP files in shop directory
$files = glob(__DIR__ . '/*.php');

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip system files
    if (in_array($filename, [
        'index.php', 'product.php', 'generate-pages-config.php', 'generate-pages-execute.php', 
        'fix-all-pages.php', 'fix-discount-calculation.php', 'fix-discount-calculation-v2.php',
        'all-pages.php', 'api-analysis.php', 'test_api.php'
    ])) {
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Replace calculateDiscount with getDiscountPercentage in numeric contexts
    
    // Pattern 1: In filter comparisons
    $content = preg_replace(
        '/calculateDiscount\(\$deal\[\'product_offer_price\'\], \$deal\[\'product_sale_price\'\]\);(\s*return .* >= \d+;)/s',
        'getDiscountPercentage($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);$1',
        $content
    );
    
    // Pattern 2: In usort for sorting
    $content = str_replace(
        'calculateDiscount($b[\'product_offer_price\'], $b[\'product_sale_price\']) - calculateDiscount($a[\'product_offer_price\'], $a[\'product_sale_price\'])',
        'getDiscountPercentage($b[\'product_offer_price\'], $b[\'product_sale_price\']) - getDiscountPercentage($a[\'product_offer_price\'], $a[\'product_sale_price\'])',
        $content
    );
    
    // Pattern 3: In average calculation loop
    $content = str_replace(
        'calculateDiscount($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);
    }
    $avgDiscount = $discountSum / $totalDeals;',
        'getDiscountPercentage($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);
    }
    $avgDiscount = $discountSum / $totalDeals;',
        $content
    );
    
    // Pattern 4: Assignment to $discount variable in filter function
    $content = str_replace(
        '$discount = calculateDiscount($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);
    
    return',
        '$discount = getDiscountPercentage($deal[\'product_offer_price\'], $deal[\'product_sale_price\']);
    
    return',
        $content
    );
    
    // If changes were made, save the file
    if ($content !== $originalContent) {
        if (file_put_contents($file, $content)) {
            $pagesFixed++;
            echo "✅ Fixed: {$filename}\n";
        } else {
            $pagesFailed++;
            echo "❌ Failed: {$filename}\n";
        }
    } else {
        echo "⏭️  No changes needed: {$filename}\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✅ Pages fixed: {$pagesFixed}\n";
echo "❌ Pages failed: {$pagesFailed}\n";
echo str_repeat("=", 60) . "\n";
echo "\n🎉 Discount percentage calculation fix complete!\n";
?>