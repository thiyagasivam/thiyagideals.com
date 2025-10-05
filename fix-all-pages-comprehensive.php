<?php
/**
 * COMPREHENSIVE FIX: Replace product_original_price with product_sale_price
 * in ALL pages (Phases 2, 3, 4, 5)
 */

// Get all PHP files in the current directory
$allFiles = glob('*.php');

// Exclude system files
$excludeFiles = [
    'index.php',
    'product.php',
    'config.php',
    'functions.php',
    'header.php',
    'footer.php',
    'fix-price-pages-api-keys.php',
    'fix-all-pages-comprehensive.php',
    'generate-festival-pages.php',
    'generate-price-pages.php',
    'generate-discount-pages.php',
    'generate-comprehensive-pages.php',
];

$filesToFix = array_diff($allFiles, $excludeFiles);

$fixed = 0;
$skipped = 0;
$noChanges = 0;

echo "🔧 COMPREHENSIVE API KEY FIX\n";
echo str_repeat("=", 70) . "\n\n";

foreach ($filesToFix as $file) {
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Check if file contains product_original_price
    if (strpos($content, 'product_original_price') === false) {
        $noChanges++;
        continue;
    }
    
    // Replace product_original_price with product_sale_price
    $content = str_replace('product_original_price', 'product_sale_price', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        echo "✅ Fixed: $file\n";
        $fixed++;
    } else {
        echo "ℹ️  No changes: $file\n";
        $noChanges++;
    }
}

echo "\n" . str_repeat("=", 70) . "\n";
echo "📊 COMPREHENSIVE FIX SUMMARY:\n";
echo "   ✅ Fixed: $fixed files\n";
echo "   ℹ️  No changes needed: $noChanges files\n";
echo "   📦 Total files processed: " . count($filesToFix) . " files\n";
echo str_repeat("=", 70) . "\n";
echo "\n🎉 Done! All deal pages should now work without API key errors.\n";
echo "\n💡 TIP: Test pages by visiting them in browser to ensure no errors.\n";
?>
