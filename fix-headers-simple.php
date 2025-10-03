<?php
/**
 * Fix Duplicate Header Issue - Simple Version
 */

$pagesDir = __DIR__;
$fixedCount = 0;

// List of pages to fix (manually curated from previous generation)
$pagesToFix = [
    'deals-under-500.php',
    'deals-under-1000.php',
    'deals-under-2000.php',
    'deals-under-5000.php',
    'deals-under-10000.php',
    'luxury-deals.php',
    'budget-deals.php',
    'super-saver-deals.php',
    'mega-discount-deals.php',
    'clearance-deals.php',
    'flash-deals.php',
    'hot-deals.php',
    'amazon-exclusives.php',
    'flipkart-specials.php',
    'today-deals.php',
    'weekend-special.php',
    'weekly-deals.php',
    'month-end-deals.php',
    'best-sellers.php',
    'trending-now.php',
    'editors-choice.php',
    'customer-favorites.php',
    'new-arrivals.php',
    'limited-stock.php',
    'premium-collection.php',
    'value-for-money.php',
    'save-big.php',
    'maximum-savings.php',
    'best-value-deals.php',
    'electronics-deals.php',
    'fashion-deals.php',
    'home-kitchen-deals.php',
    'sports-fitness-deals.php',
    'books-media-deals.php',
    'toys-games-deals.php',
    'health-personal-care-deals.php',
    'grocery-deals.php',
    'automotive-deals.php',
    'festival-offers.php',
    'diwali-special.php',
    'new-year-deals.php',
    'independence-day-sale.php',
    'price-drop-alert.php',
    'lowest-price-ever.php',
    'combo-offers.php',
    'bundle-deals.php',
    'buy-more-save-more.php',
    'seasonal-sale.php',
    'local-sellers.php'
];

// Since beauty-deals.php is already fixed, we can use it as reference
// We'll skip it if it's in the list
$pagesToFix = array_diff($pagesToFix, ['beauty-deals.php']);

echo "Starting to fix " . count($pagesToFix) . " pages...\n\n";

foreach ($pagesToFix as $filename) {
    $filepath = $pagesDir . '/' . $filename;
    
    if (!file_exists($filepath)) {
        echo "Skip: $filename (file not found)\n";
        continue;
    }
    
    echo "Processing: $filename\n";
    
    $content = file_get_contents($filepath);
    
    // Check if it has the duplicate header issue
    if (strpos($content, '<!DOCTYPE html>') === false) {
        echo "  → Already fixed (no duplicate header)\n\n";
        continue;
    }
    
    // Extract key data first
    preg_match('/\$pageTitle = "(.*?)";/', $content, $titleMatch);
    preg_match('/\$metaDescription = "(.*?)";/', $content, $descMatch);
    preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $keywordsMatch);
    
    $pageTitle = $titleMatch[1];
    $metaDescription = $descMatch[1];
    $pageKeywords = isset($keywordsMatch[1]) ? $keywordsMatch[1] : '';
    
    // Use regex to replace the duplicate header section
    $pattern = '/(\$pageTitle = ".*?";\s*\$metaDescription = ".*?";)\s*\?>\s*<!DOCTYPE html>.*?<body>\s*<\?php include \'includes\/header\.php\'; \?>/s';
    
    $replacement = '$1' . "\n" .
                   '$pageDescription = $metaDescription;' . "\n" .
                   '$pageKeywords = "' . $pageKeywords . '";' . "\n\n" .
                   '// Include header' . "\n" .
                   'include \'includes/header.php\';' . "\n" .
                   '?>' . "\n";
    
    $newContent = preg_replace($pattern, $replacement, $content);
    
    if ($newContent && $newContent !== $content) {
        file_put_contents($filepath, $newContent);
        $fixedCount++;
        echo "  ✓ Fixed successfully\n\n";
    } else {
        echo "  ✗ Pattern not matched (manual fix needed)\n\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 60) . "\n";
echo "Successfully fixed: $fixedCount/" . count($pagesToFix) . " pages\n";
echo "Done!\n";
