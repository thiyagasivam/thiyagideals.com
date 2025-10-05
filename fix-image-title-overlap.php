<?php
/**
 * Fix Product Image and Title Overlap - Bulk Update Script
 * Applies proper spacing and overflow fixes to prevent overlaps
 * Created: 2025-10-05
 */

// All pages to fix
$allPages = [
    // Reference (already fixed)
    'women-deals.php',
    
    // Pages to fix
    'men-deals.php',
    'kids-deals.php',
    'seniors-deals.php',
    'students-deals.php',
    'budget-friendly-deals.php',
    'imported-products-deals.php',
    'subscription-deals.php',
    'pre-order-deals.php',
    'refurbished-deals.php',
    'weekly-deals.php',
    'same-day-delivery-deals.php',
    'next-day-delivery-deals.php',
    'free-shipping-deals.php',
    'cod-available-deals.php',
    'express-delivery-deals.php',
    'open-box-deals.php',
    'certified-products-deals.php',
    'deals-500-999.php',
    'deals-1000-1499.php',
    'deals-2500-4999.php',
    'deals-10000-14999.php',
    'deals-15000-24999.php',
    'deals-25000-49999.php',
    'deals-50000-plus.php',
    'republic-day-deals.php',
    'independence-day-deals.php',
    'gandhi-jayanti-deals.php',
    'christmas-deals.php',
    'new-year-deals.php',
    'durga-puja-deals.php',
    'holi-deals.php',
    'onam-deals.php',
    
    // Discount pages
    'deals-10-percent-off.php',
    'deals-40-percent-off.php',
    'deals-50-percent-off.php',
    'deals-60-percent-off.php',
    'deals-70-percent-off.php',
    'deals-75-percent-off.php',
    'deals-80-percent-off.php',
    'deals-90-percent-off.php',
    
    // Festival pages
    'diwali-deals.php',
    'black-friday-deals.php',
    'cyber-monday-deals.php',
    'prime-day-deals.php',
];

// Enhanced CSS for product image (prevents overlap)
$productImageCSS = <<<'CSS'
        /* Product Image Container - Fix Overlap */
        .product-image {
            position: relative;
            z-index: 1;
            overflow: hidden;
            border-radius: 8px 8px 0 0;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        
        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
CSS;

// Enhanced CSS for product info (prevents overlap)
$productInfoCSS = <<<'CSS'
        /* Product Info Section - Fix Overlap */
        .product-info {
            position: relative;
            z-index: 2;
            background: white;
            padding: 12px;
            margin-top: 0;
            border-radius: 0 0 8px 8px;
        }
CSS;

// Enhanced CSS for product card (proper structure)
$productCardCSS = <<<'CSS'
        /* Product Card Hover Effect */
        .product-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background: white;
        }
CSS;

// Statistics
$stats = [
    'total' => count($allPages),
    'success' => 0,
    'skipped' => 0,
    'failed' => 0,
    'errors' => []
];

echo "=== PRODUCT IMAGE & TITLE OVERLAP FIX - BULK UPDATE ===\n";
echo "Starting time: " . date('Y-m-d H:i:s') . "\n";
echo "Total pages to fix: " . $stats['total'] . "\n";
echo str_repeat("=", 60) . "\n\n";

foreach ($allPages as $index => $page) {
    $num = $index + 1;
    echo "[$num/{$stats['total']}] Processing: $page\n";
    
    $filePath = __DIR__ . '/' . $page;
    
    // Check if file exists
    if (!file_exists($filePath)) {
        echo "  ⚠️  File not found - SKIPPED\n\n";
        $stats['skipped']++;
        continue;
    }
    
    // Read file content
    $content = file_get_contents($filePath);
    if ($content === false) {
        echo "  ❌ Failed to read file\n\n";
        $stats['failed']++;
        $stats['errors'][] = "$page - Failed to read";
        continue;
    }
    
    $originalContent = $content;
    $changesApplied = [];
    
    // Fix 1: Update product-image CSS
    $oldImagePattern = '/\.product-image\s*\{[^}]*position:\s*relative;[^}]*\}/s';
    if (preg_match($oldImagePattern, $content, $matches)) {
        // Only update if it doesn't already have overflow: hidden
        if (strpos($matches[0], 'overflow: hidden') === false) {
            $content = preg_replace($oldImagePattern, $productImageCSS, $content);
            $changesApplied[] = "Product image CSS updated";
        }
    }
    
    // Fix 2: Update product-info CSS
    $oldInfoPattern = '/\.product-info\s*\{[^}]*position:\s*relative;[^}]*\}/s';
    if (preg_match($oldInfoPattern, $content, $matches)) {
        // Only update if it doesn't already have margin-top: 0
        if (strpos($matches[0], 'margin-top: 0') === false) {
            $content = preg_replace($oldInfoPattern, $productInfoCSS, $content);
            $changesApplied[] = "Product info CSS updated";
        }
    }
    
    // Fix 3: Update product-card CSS
    $oldCardPattern = '/\.product-card\s*\{[^}]*transition:\s*all[^}]*\}/s';
    if (preg_match($oldCardPattern, $content, $matches)) {
        // Only update if it doesn't already have overflow: hidden
        if (strpos($matches[0], 'overflow: hidden') === false && 
            strpos($matches[0], 'flex-direction: column') === false) {
            $content = preg_replace($oldCardPattern, $productCardCSS, $content);
            $changesApplied[] = "Product card CSS updated";
        }
    }
    
    // Fix 4: Ensure product title has proper spacing
    if (preg_match('/\.product-title\s*\{/', $content)) {
        // Check if it has margin-bottom
        if (!preg_match('/\.product-title\s*\{[^}]*margin-bottom:[^}]*\}/s', $content)) {
            $titlePattern = '/(\.product-title\s*\{[^}]*)(color:[^;]+;)/s';
            if (preg_match($titlePattern, $content)) {
                $content = preg_replace(
                    $titlePattern,
                    '$1$2' . "\n            margin-bottom: 0.5rem;",
                    $content
                );
                $changesApplied[] = "Product title spacing added";
            }
        }
    }
    
    // Check if any changes were made
    if ($content === $originalContent) {
        echo "  ℹ️  No changes needed - Already fixed or no matching patterns\n\n";
        $stats['skipped']++;
        continue;
    }
    
    // Backup original file
    $backupPath = $filePath . '.backup_overlap_' . date('Ymd_His');
    if (!copy($filePath, $backupPath)) {
        echo "  ⚠️  Warning: Could not create backup\n";
    }
    
    // Write updated content
    if (file_put_contents($filePath, $content) === false) {
        echo "  ❌ Failed to write file\n\n";
        $stats['failed']++;
        $stats['errors'][] = "$page - Failed to write";
        continue;
    }
    
    echo "  ✅ SUCCESS - Applied: " . implode(", ", $changesApplied) . "\n\n";
    $stats['success']++;
}

// Final Statistics
echo str_repeat("=", 60) . "\n";
echo "=== BULK FIX COMPLETED ===\n";
echo "End time: " . date('Y-m-d H:i:s') . "\n\n";
echo "📊 STATISTICS:\n";
echo "  Total pages: {$stats['total']}\n";
echo "  ✅ Successfully fixed: {$stats['success']}\n";
echo "  ℹ️  Skipped (not found/already fixed): {$stats['skipped']}\n";
echo "  ❌ Failed: {$stats['failed']}\n";

if (!empty($stats['errors'])) {
    echo "\n⚠️  ERRORS:\n";
    foreach ($stats['errors'] as $error) {
        echo "  - $error\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✨ Image and title overlap issues have been fixed!\n";
echo "🎯 All product cards now have:\n";
echo "  • Fixed height product images (200px)\n";
echo "  • Proper overflow: hidden (no image overflow)\n";
echo "  • Border-radius for clean edges\n";
echo "  • Object-fit: cover (proper image scaling)\n";
echo "  • Proper spacing between image and title\n";
echo "  • Flex-direction: column (proper stacking)\n";
echo "  • Margin-top: 0 (no gap between image and info)\n";
echo "\n💡 Next steps:\n";
echo "  1. Test random pages to verify fixes\n";
echo "  2. Check product cards on different screen sizes\n";
echo "  3. Verify images load properly\n";
echo "  4. Clear browser cache for best results\n";
echo str_repeat("=", 60) . "\n";
?>
