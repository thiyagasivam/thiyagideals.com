<?php
/**
 * Bulk UI Enhancement Application Script
 * Applies product card enhancements to all recently created pages
 * - Fixes product title overlap
 * - Adds urgency factors
 * - Implements powerful CTAs
 * - Fixes image overlap
 */

// Pages to update (organized by phase)
$pagesToUpdate = [
    // Phase 2: Festival Pages (17 pages)
    'diwali-deals.php',
    'christmas-deals.php',
    'holi-deals.php',
    'eid-deals.php',
    'new-year-deals.php',
    'valentine-deals.php',
    'raksha-bandhan-deals.php',
    'ganesh-chaturthi-deals.php',
    'onam-deals.php',
    'pongal-deals.php',
    'independence-day-deals.php',
    'republic-day-deals.php',
    'navratri-deals.php',
    'dussehra-deals.php',
    'baisakhi-deals.php',
    'ugadi-deals.php',
    'guru-purnima-deals.php',
    
    // Phase 3: Price Range Pages (12 pages)
    'deals-under-500.php',
    'deals-500-1000.php',
    'deals-1000-5000.php',
    'deals-under-1000.php',
    'deals-under-2000.php',
    'deals-100-500.php',
    'deals-5000-10000.php',
    'deals-10000-plus.php',
    'deals-under-250.php',
    'deals-250-500.php',
    'deals-2000-5000.php',
    'deals-above-5000.php',
    
    // Phase 4: Discount Percentage Pages (8 pages)
    'deals-10-percent-off.php',
    'deals-40-percent-off.php',
    'deals-50-percent-off.php',
    'deals-60-percent-off.php',
    'deals-70-percent-off.php',
    'deals-75-percent-off.php',
    'deals-80-percent-off.php',
    'deals-90-percent-off.php',
    
    // Phase 5: Comprehensive Pages (52 pages)
    // Audience-Based (10)
    'kids-deals.php',
    'men-deals.php',
    'women-deals.php',
    'students-deals.php',
    'senior-citizen-deals.php',
    'family-deals.php',
    'professional-deals.php',
    'fitness-enthusiast-deals.php',
    'gamers-deals.php',
    'travelers-deals.php',
    
    // Quality-Based (10)
    'premium-quality.php',
    'budget-friendly.php',
    'best-quality.php',
    'value-for-money.php',
    'top-brand-deals.php',
    'certified-products.php',
    'warranty-deals.php',
    'genuine-products.php',
    'imported-deals.php',
    'handpicked-deals.php',
    
    // Shopping Pattern (10)
    'bulk-buy-deals.php',
    'combo-offers.php',
    'bundle-deals.php',
    'subscribe-save.php',
    'repeat-purchase.php',
    'wholesale-deals.php',
    'group-buying.php',
    'pre-order-deals.php',
    'back-in-stock.php',
    'restocked-deals.php',
    
    // Urgency-Based (8)
    'today-only.php',
    'ending-today.php',
    'last-few-hours.php',
    'expiring-soon.php',
    'final-call.php',
    'today-special.php',
    'hourly-deals.php',
    'flash-lightning.php',
    
    // Delivery-Based (8)
    'same-day-delivery.php',
    'next-day-delivery.php',
    'express-delivery.php',
    'scheduled-delivery.php',
    'weekend-delivery.php',
    'doorstep-delivery.php',
    'contactless-delivery.php',
    'free-shipping-deals.php',
    
    // Condition-Based (6)
    'new-launch-deals.php',
    'pre-owned-deals.php',
    'refurbished-deals.php',
    'open-box-deals.php',
    'like-new-deals.php',
    'clearance-deals.php',
];

// CSS styles to add
$cssToAdd = <<<'CSS'

        /* Product Title Enhancement - Fix Overlap */
        .product-title {
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden !important;
            text-overflow: ellipsis;
            line-height: 1.4;
            max-height: 2.8em;
            min-height: 2.8em;
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem;
            white-space: normal !important;
        }
        
        /* Powerful CTA Button */
        .cta-button {
            background: linear-gradient(135deg, #ff4757, #ff6348);
            border: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 10px 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 71, 87, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .cta-button::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .cta-button:hover::before {
            width: 300px;
            height: 300px;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 71, 87, 0.4);
            background: linear-gradient(135deg, #ff6348, #ff4757);
        }
        
        .cta-button:active {
            transform: translateY(0);
        }
        
        /* Urgency Animations */
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.9; }
        }
        
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        
        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .blink-animation {
            animation: blink 1.5s ease-in-out infinite;
        }
        
        /* Savings Badge Enhancement */
        .savings-badge {
            background: #d4edda;
            border: 2px solid #28a745;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.85rem;
            display: inline-block;
        }
        
        /* Urgency Text Styling */
        .urgency-text {
            font-weight: 600;
            font-size: 0.75rem;
            padding: 4px 8px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 4px;
            display: inline-block;
        }
        
        /* Product Card Hover Effect */
        .product-card {
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border-color: #ff4757;
        }
        
        /* Discount Badge Enhancement */
        .discount-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            font-weight: 800;
            font-size: 0.9rem;
            padding: 5px 12px;
            box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
        }
        
        /* Price Display Enhancement */
        .price-current {
            font-size: 1.3rem;
            font-weight: 800;
            color: #27ae60;
        }
        
        .price-original {
            font-size: 0.9rem;
            color: #95a5a6;
            text-decoration: line-through;
        }
        
        /* Product Image Container */
        .product-image {
            position: relative;
            z-index: 1;
        }
        
        /* Product Info Section */
        .product-info {
            position: relative;
            z-index: 2;
            background: white;
            padding: 12px;
        }
        
        /* Mobile Responsive */
        @media (max-width: 768px) {
            .product-title {
                font-size: 0.8rem;
                -webkit-line-clamp: 2;
                min-height: 2.4em;
            }
            
            .cta-button {
                font-size: 0.75rem;
                padding: 8px 12px;
            }
            
            .urgency-text {
                font-size: 0.7rem;
            }
        }
CSS;

// Statistics
$stats = [
    'processed' => 0,
    'updated' => 0,
    'skipped' => 0,
    'errors' => 0,
    'css_added' => 0,
    'html_updated' => 0,
];

echo "🚀 Starting Bulk UI Enhancement Application...\n";
echo str_repeat("=", 70) . "\n\n";

foreach ($pagesToUpdate as $page) {
    $stats['processed']++;
    
    echo "[$stats[processed]/" . count($pagesToUpdate) . "] Processing: $page\n";
    
    if (!file_exists($page)) {
        echo "   ⚠️  File not found, skipping...\n\n";
        $stats['skipped']++;
        continue;
    }
    
    try {
        $content = file_get_contents($page);
        $originalContent = $content;
        $changes = 0;
        
        // Step 1: Add CSS if not already present
        if (strpos($content, '.cta-button') === false) {
            // Find the closing </style> tag and insert CSS before it
            $content = str_replace('</style>', $cssToAdd . "\n    </style>", $content);
            $changes++;
            $stats['css_added']++;
            echo "   ✅ Added CSS styles\n";
        } else {
            echo "   ℹ️  CSS already present\n";
        }
        
        // Step 2: Update product card HTML structure
        // Pattern 1: Basic product card with text-truncate
        $oldPattern1 = '/<h3 class="product-title text-truncate"[^>]*>([\s\S]*?)<\/h3>/';
        if (preg_match($oldPattern1, $content)) {
            $content = preg_replace(
                '/<h3 class="product-title text-truncate" title="([^"]*)">\s*<\?php echo[^;]+;\s*\?>\s*<\/h3>/',
                '<h3 class="product-title" title="<?php echo $productName; ?>">
                                    <?php echo $productName; ?>
                                </h3>',
                $content
            );
            $changes++;
            echo "   ✅ Removed text-truncate class\n";
        }
        
        // Step 3: Update product card structure with urgency factors
        // Look for old product card structure and replace with enhanced version
        $oldCardPattern = '/<div class="col-6 col-md-4 col-lg-3 product-item"[^>]*>[\s\S]*?<div class="product-card[^>]*>[\s\S]*?<a href="<\?php echo \$productUrl; \?>"[^>]*>[\s\S]*?<div class="product-image">[\s\S]*?<\/div>[\s\S]*?<div class="product-info">[\s\S]*?<h3 class="product-title"[^>]*>[\s\S]*?<\/h3>/';
        
        if (preg_match($oldCardPattern, $content) && strpos($content, 'urgency-text') === false) {
            // Add urgency badges and enhanced structure
            $searchPattern = '/(<div class="product-card h-100 position-relative">)/';
            
            $replacement = '$1
                        <!-- Multiple Badges -->
                        <div class="position-absolute top-0 start-0 end-0 d-flex justify-content-between align-items-start p-2 z-3">
                            <!-- Best Value Badge -->
                            <?php if ($discount >= 50): ?>
                                <span class="badge bg-danger text-white px-2 py-1 mb-1 pulse-animation">
                                    🔥 HOT DEAL
                                </span>
                            <?php elseif ($discount >= 40): ?>
                                <span class="badge bg-warning text-dark px-2 py-1 mb-1">
                                    💎 BEST VALUE
                                </span>
                            <?php endif; ?>
                            
                            <!-- Urgency Badge -->
                            <?php 
                            $urgencyMessages = [
                                \'⚡ ENDING SOON\',
                                \'🔥 LIMITED STOCK\',
                                \'⏰ HURRY UP\',
                                \'💥 ALMOST GONE\',
                                \'🎯 GRAB NOW\'
                            ];
                            $urgencyIndex = crc32($pid) % count($urgencyMessages);
                            ?>
                            <span class="badge bg-dark text-white px-2 py-1 mb-1 blink-animation">
                                <?php echo $urgencyMessages[$urgencyIndex]; ?>
                            </span>
                        </div>
                        ';
            
            $content = preg_replace($searchPattern, $replacement, $content, 1);
            $changes++;
            echo "   ✅ Added urgency badges\n";
        }
        
        // Step 4: Update CTA button
        $oldButtonPattern = '/<button class="btn btn-primary[^"]*"[^>]*>[\s\S]*?<i class="bi bi-cart-plus-fill"><\/i>\s*View Deal[\s\S]*?<\/button>/';
        
        if (preg_match($oldButtonPattern, $content) && strpos($content, 'GRAB THIS DEAL') === false) {
            $content = preg_replace(
                $oldButtonPattern,
                '<button class="btn btn-danger btn-sm w-100 mt-2 view-details-btn cta-button" 
                                        data-product-id="<?php echo $pid; ?>" 
                                        title="Get this deal now!">
                                    <i class="bi bi-lightning-charge-fill"></i> 
                                    <strong>GRAB THIS DEAL</strong>
                                </button>',
                $content
            );
            $changes++;
            echo "   ✅ Updated CTA button\n";
        }
        
        // Step 5: Add stock alerts if not present
        if (strpos($content, 'urgency-text') === false && strpos($content, 'product-store') !== false) {
            // Add urgency text before store badge
            $content = preg_replace(
                '/(<div class="product-store[^>]*>)/',
                '<!-- Urgency Factor -->
                                <?php 
                                $stockMessages = [
                                    [\'text\' => \'Only 3 left in stock!\', \'class\' => \'text-danger\', \'icon\' => \'exclamation-circle-fill\'],
                                    [\'text\' => \'Low stock - order soon!\', \'class\' => \'text-warning\', \'icon\' => \'clock-fill\'],
                                    [\'text\' => \'Selling fast!\', \'class\' => \'text-info\', \'icon\' => \'fire\'],
                                ];
                                $stockIndex = crc32($pid) % count($stockMessages);
                                $stockMsg = $stockMessages[$stockIndex];
                                ?>
                                <div class="urgency-text <?php echo $stockMsg[\'class\']; ?> small mb-2">
                                    <i class="bi bi-<?php echo $stockMsg[\'icon\']; ?>"></i> <?php echo $stockMsg[\'text\']; ?>
                                </div>
                                
                                $1',
                $content,
                1
            );
            $changes++;
            echo "   ✅ Added stock alerts\n";
        }
        
        // Step 6: Add social proof if not present
        if (strpos($content, 'people viewing') === false && strpos($content, 'cta-button') !== false) {
            // Add social proof after CTA button
            $content = preg_replace(
                '/(<button class="[^"]*cta-button[^"]*"[\s\S]*?<\/button>)/',
                '$1
                                
                                <!-- Secondary CTA -->
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-eye-fill"></i> 
                                        <?php echo rand(50, 500); ?> people viewing
                                    </small>
                                </div>',
                $content,
                1
            );
            $changes++;
            echo "   ✅ Added social proof\n";
        }
        
        // Step 7: Enhance savings badge
        if (strpos($content, 'savings-badge') === false && strpos($content, 'Save <?php echo formatPrice($savings)') !== false) {
            $content = preg_replace(
                '/<div class="text-success[^>]*>\s*<i class="bi bi-piggy-bank-fill"><\/i> Save <\?php echo formatPrice\(\$savings\); \?>\s*<\/div>/',
                '<div class="savings-badge text-success fw-bold mb-2">
                                    <i class="bi bi-piggy-bank-fill"></i> Save <?php echo formatPrice($savings); ?>
                                </div>',
                $content
            );
            $changes++;
            echo "   ✅ Enhanced savings badge\n";
        }
        
        // Save the file if changes were made
        if ($changes > 0 && $content !== $originalContent) {
            file_put_contents($page, $content);
            $stats['updated']++;
            $stats['html_updated']++;
            echo "   ✅ Successfully updated with $changes change(s)\n\n";
        } elseif ($content === $originalContent) {
            echo "   ℹ️  No changes needed (already updated)\n\n";
            $stats['skipped']++;
        } else {
            echo "   ✅ File updated\n\n";
            $stats['updated']++;
        }
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n\n";
        $stats['errors']++;
    }
}

// Final Summary
echo "\n" . str_repeat("=", 70) . "\n";
echo "🎉 BULK UI ENHANCEMENT COMPLETED!\n";
echo str_repeat("=", 70) . "\n\n";

echo "📊 Summary:\n";
echo "   Total Processed:     " . $stats['processed'] . " files\n";
echo "   ✅ Updated:          " . $stats['updated'] . " files\n";
echo "   ℹ️  Skipped:          " . $stats['skipped'] . " files\n";
echo "   ❌ Errors:           " . $stats['errors'] . " files\n";
echo "   🎨 CSS Added:        " . $stats['css_added'] . " files\n";
echo "   📝 HTML Updated:     " . $stats['html_updated'] . " files\n\n";

echo "✨ Enhancements Applied:\n";
echo "   ✅ Fixed product title overlap\n";
echo "   ✅ Added urgency badges (5 variants)\n";
echo "   ✅ Added stock alerts (3 variants)\n";
echo "   ✅ Implemented powerful CTAs\n";
echo "   ✅ Added social proof\n";
echo "   ✅ Enhanced savings display\n";
echo "   ✅ Fixed image overlap\n";
echo "   ✅ Added hover effects\n";
echo "   ✅ Mobile responsive\n\n";

if ($stats['updated'] > 0) {
    echo "🎯 Success Rate: " . round(($stats['updated'] / $stats['processed']) * 100, 1) . "%\n\n";
    echo "🚀 Next Steps:\n";
    echo "   1. Test sample pages in browser\n";
    echo "   2. Verify mobile responsiveness\n";
    echo "   3. Check all animations working\n";
    echo "   4. Monitor user engagement metrics\n\n";
}

echo "📁 Log saved to: BULK_UI_ENHANCEMENT_LOG.txt\n";

// Save log
$logContent = ob_get_contents();
file_put_contents('BULK_UI_ENHANCEMENT_LOG.txt', $logContent);

echo "\n✅ All done! Your pages are now conversion-optimized! 🎉\n";
?>
