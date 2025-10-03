<?php
/**
 * Fix All Remaining Pages with Duplicate Headers
 * Fixes the 30 additional pages discovered
 */

$pagesToFix = [
    'automotive.php',
    'best-value.php',
    'books-media.php',
    'buy-1-get-1.php',
    'clearance-sale.php',
    'deal-of-day.php',
    'deals-1000-5000.php',
    'deals-25-percent-off.php',
    'deals-30-percent-off.php',
    'deals-500-1000.php',
    'deals-under-500.php',
    'eco-friendly.php',
    'festival-sale.php',
    'flash-sale.php',
    'free-delivery.php',
    'gift-ideas.php',
    'health-wellness.php',
    'home-kitchen.php',
    'last-chance.php',
    'lowest-prices.php',
    'mega-discounts.php',
    'month-end-sale.php',
    'most-saved.php',
    'payday-special.php',
    'pet-supplies.php',
    'sports-fitness.php',
    'super-saver.php',
    'top-rated.php',
    'toys-kids.php',
    'trending.php'
];

$pagesDir = __DIR__;
$fixedCount = 0;
$errorCount = 0;

echo "Fixing " . count($pagesToFix) . " remaining pages with duplicate headers...\n\n";

foreach ($pagesToFix as $filename) {
    $filepath = $pagesDir . '/' . $filename;
    
    if (!file_exists($filepath)) {
        echo "Skip: $filename (not found)\n";
        continue;
    }
    
    echo "Processing: $filename\n";
    
    $content = file_get_contents($filepath);
    
    // Check if it needs fixing
    if (strpos($content, '<!DOCTYPE html>') === false) {
        echo "  → Already fixed\n\n";
        continue;
    }
    
    // Extract key data
    preg_match('/\$pageTitle = "(.*?)";/', $content, $titleMatch);
    preg_match('/\$metaDescription = "(.*?)";/', $content, $descMatch);
    preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $keywordsMatch);
    
    if (!isset($titleMatch[1]) || !isset($descMatch[1])) {
        echo "  ✗ Could not extract page metadata\n\n";
        $errorCount++;
        continue;
    }
    
    $pageTitle = $titleMatch[1];
    $metaDescription = $descMatch[1];
    $pageKeywords = isset($keywordsMatch[1]) ? $keywordsMatch[1] : '';
    
    // Pattern to match and replace the duplicate header section
    $pattern = '/(\$pageTitle = ".*?";\s*\$metaDescription = ".*?";)\s*\?>\s*<!DOCTYPE html>.*?<\/head>\s*<body>\s*<\?php include \'includes\/header\.php\'; \?>/s';
    
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
        echo "  ✗ Pattern not matched (needs manual fix)\n\n";
        $errorCount++;
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 60) . "\n";
echo "Total pages: " . count($pagesToFix) . "\n";
echo "Successfully fixed: $fixedCount\n";
echo "Errors: $errorCount\n";
echo "\n";

if ($errorCount > 0) {
    echo "Note: Pages with errors may need manual fixing.\n";
}

echo "Done!\n";
