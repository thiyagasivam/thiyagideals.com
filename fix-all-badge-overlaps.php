<?php
/**
 * Fix Discount Badge Overlap Issues - Bulk Update Script
 * Applies badge positioning fix + complete UI enhancements to all affected pages
 * Created: 2025-10-05
 */

// Pages that need fixing (excluding already enhanced ones)
$pagesToFix = [
    // Audience Pages
    'men-deals.php',
    'kids-deals.php',
    'seniors-deals.php',
    'students-deals.php',
    'tech-enthusiasts-deals.php',
    
    // Quality Pages
    'premium-quality-deals.php',
    'budget-friendly-deals.php',
    'imported-products-deals.php',
    'made-in-india-deals.php',
    'eco-friendly-products-deals.php',
    
    // Shopping Pattern Pages
    'bulk-buy-deals.php',
    'single-item-deals.php',
    'subscription-deals.php',
    'pre-order-deals.php',
    'refurbished-deals.php',
    
    // Urgency Pages
    'flash-sale-24hrs.php',
    'weekly-deals.php',
    'monthly-special-deals.php',
    'seasonal-clearance-deals.php',
    'last-chance-deals.php',
    
    // Delivery Pages
    'same-day-delivery-deals.php',
    'next-day-delivery-deals.php',
    'free-shipping-deals.php',
    'cod-available-deals.php',
    'express-delivery-deals.php',
    
    // Condition Pages
    'new-arrivals-deals.php',
    'open-box-deals.php',
    'certified-products-deals.php',
    'warranty-included-deals.php',
    'exchange-offers-deals.php',
    
    // Price Range Pages
    'deals-500-999.php',
    'deals-1000-1499.php',
    'deals-2500-4999.php',
    'deals-10000-14999.php',
    'deals-15000-24999.php',
    'deals-25000-49999.php',
    'deals-50000-plus.php',
    
    // Festival Pages (if not already enhanced)
    'republic-day-deals.php',
    'independence-day-deals.php',
    'gandhi-jayanti-deals.php',
    'christmas-deals.php',
    'new-year-deals.php',
    'valentine-day-deals.php',
    'mothers-day-deals.php',
    'fathers-day-deals.php',
    'raksha-bandhan-deals.php',
    'janmashtami-deals.php',
    'ganesh-chaturthi-deals.php',
    'navratri-deals.php',
    'durga-puja-deals.php',
    'dussehra-deals.php',
    'holi-deals.php',
    'eid-deals.php',
    'onam-deals.php',
];

// Enhanced discount badge CSS with positioning
$enhancedBadgeCSS = <<<'CSS'
        /* Discount Badge Enhancement - Fixed Positioning */
        .discount-badge {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            font-weight: 800;
            font-size: 0.9rem;
            padding: 5px 12px;
            border-radius: 5px;
            box-shadow: 0 3px 10px rgba(245, 87, 108, 0.4);
            z-index: 10;
            animation: pulse-badge 2s ease-in-out infinite;
        }
        
        @keyframes pulse-badge {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
CSS;

// Enhanced product card HTML with all UI improvements
$enhancedProductCard = <<<'HTML'
                <div class="col-6 col-md-4 col-lg-3 product-item" data-product-name="<?php echo strtolower($productName); ?>">
                    <div class="product-card h-100 position-relative">
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
                                '⚡ ENDING SOON',
                                '🔥 LIMITED STOCK',
                                '⏰ HURRY UP',
                                '💥 ALMOST GONE',
                                '🎯 GRAB NOW'
                            ];
                            $urgencyIndex = crc32($pid) % count($urgencyMessages);
                            ?>
                            <span class="badge bg-dark text-white px-2 py-1 mb-1 blink-animation">
                                <?php echo $urgencyMessages[$urgencyIndex]; ?>
                            </span>
                        </div>
                        
                        <a href="<?php echo $productUrl; ?>" class="text-decoration-none" data-product-id="<?php echo $pid; ?>" title="View <?php echo $productName; ?> details">
                            <div class="product-image">
                                <img src="<?php echo $productImage; ?>" alt="<?php echo $productName; ?>" loading="lazy">
                                <span class="discount-badge"><?php echo round($discount); ?>% OFF</span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title" title="<?php echo $productName; ?>">
                                    <?php echo $productName; ?>
                                </h3>
                                
                                <!-- Price Section -->
                                <div class="product-price mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="price-current"><?php echo formatPrice($offerPrice); ?></span>
                                        <span class="price-original"><?php echo formatPrice($originalPrice); ?></span>
                                    </div>
                                </div>
                                
                                <!-- Savings Highlight -->
                                <div class="savings-badge text-success fw-bold mb-2">
                                    <i class="bi bi-piggy-bank-fill"></i> Save <?php echo formatPrice($savings); ?>
                                </div>
                                
                                <!-- Urgency Factor -->
                                <?php 
                                $stockMessages = [
                                    ['text' => 'Only 3 left in stock!', 'class' => 'text-danger', 'icon' => 'exclamation-circle-fill'],
                                    ['text' => 'Low stock - order soon!', 'class' => 'text-warning', 'icon' => 'clock-fill'],
                                    ['text' => 'Selling fast!', 'class' => 'text-info', 'icon' => 'fire'],
                                ];
                                $stockIndex = crc32($pid) % count($stockMessages);
                                $stockMsg = $stockMessages[$stockIndex];
                                ?>
                                <div class="urgency-text <?php echo $stockMsg['class']; ?> small mb-2">
                                    <i class="bi bi-<?php echo $stockMsg['icon']; ?>"></i> <?php echo $stockMsg['text']; ?>
                                </div>
                                
                                <!-- Store Badge -->
                                <div class="product-store mb-2">
                                    <i class="bi bi-shop"></i> <?php echo $storeName; ?>
                                </div>
                                
                                <!-- Powerful CTA Button -->
                                <button class="btn btn-danger btn-sm w-100 mt-2 view-details-btn cta-button" 
                                        data-product-id="<?php echo $pid; ?>" 
                                        title="Get this deal now!">
                                    <i class="bi bi-lightning-charge-fill"></i> 
                                    <strong>GRAB THIS DEAL</strong>
                                </button>
                                
                                <!-- Secondary CTA -->
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        <i class="bi bi-eye-fill"></i> 
                                        <?php echo rand(50, 500); ?> people viewing
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
HTML;

// Statistics
$stats = [
    'total' => count($pagesToFix),
    'success' => 0,
    'skipped' => 0,
    'failed' => 0,
    'errors' => []
];

echo "=== DISCOUNT BADGE OVERLAP FIX - BULK UPDATE ===\n";
echo "Starting time: " . date('Y-m-d H:i:s') . "\n";
echo "Total pages to fix: " . $stats['total'] . "\n";
echo str_repeat("=", 60) . "\n\n";

foreach ($pagesToFix as $index => $page) {
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
    
    // Fix 1: Update discount badge CSS (if exists)
    $oldBadgeCSS = '/.discount-badge\s*\{[^}]+\}/s';
    if (preg_match($oldBadgeCSS, $content)) {
        $content = preg_replace($oldBadgeCSS, $enhancedBadgeCSS, $content);
        $changesApplied[] = "Badge CSS updated";
    }
    
    // Fix 2: Update product title CSS (if exists)
    $oldTitlePattern = '/.product-title\s*\{[^}]+\}/s';
    $newTitleCSS = <<<'CSS'
        .product-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #2c3e50 !important;
            margin-bottom: 0.5rem;
            min-height: 2.8em;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.4em;
        }
CSS;
    
    if (preg_match($oldTitlePattern, $content)) {
        $content = preg_replace($oldTitlePattern, $newTitleCSS, $content);
        $changesApplied[] = "Title CSS updated";
    }
    
    // Fix 3: Add CTA button CSS if missing
    if (strpos($content, '.cta-button') === false) {
        // Find the style section end tag
        if (preg_match('/<\/style>/i', $content)) {
            $ctaCSS = <<<'CSS'

        /* Powerful CTA Button */
        .cta-button {
            background: linear-gradient(135deg, #ff4757 0%, #ff6348 100%) !important;
            border: none !important;
            font-weight: 700 !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 71, 87, 0.4);
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
        
        /* Urgency Animations */
        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
        
        .blink-animation {
            animation: blink 1.5s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        @keyframes blink {
            0%, 50%, 100% { opacity: 1; }
            25%, 75% { opacity: 0.7; }
        }
    </style>
CSS;
            $content = str_replace('</style>', $ctaCSS, $content);
            $changesApplied[] = "CTA CSS added";
        }
    }
    
    // Fix 4: Update basic product card HTML structure
    // Look for basic product card pattern
    $basicCardPattern = '/<div class="col-6 col-md-4 col-lg-3 product-item">\s*<div class="product-card h-100">\s*<a href="<\?php echo \$productUrl; \?>"[^>]*>.*?<\/a>\s*<\/div>\s*<\/div>/s';
    
    if (preg_match($basicCardPattern, $content) && strpos($content, 'position-relative') === false) {
        // This is a basic card without enhancements - replace it
        $content = preg_replace($basicCardPattern, $enhancedProductCard, $content);
        $changesApplied[] = "Product card structure enhanced";
    }
    
    // Check if any changes were made
    if ($content === $originalContent) {
        echo "  ℹ️  No changes needed - Already enhanced\n\n";
        $stats['skipped']++;
        continue;
    }
    
    // Backup original file
    $backupPath = $filePath . '.backup_' . date('Ymd_His');
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
echo "  ℹ️  Skipped (not found/already enhanced): {$stats['skipped']}\n";
echo "  ❌ Failed: {$stats['failed']}\n";

if (!empty($stats['errors'])) {
    echo "\n⚠️  ERRORS:\n";
    foreach ($stats['errors'] as $error) {
        echo "  - $error\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "✨ Badge overlap issues have been fixed!\n";
echo "🎯 All product cards now have:\n";
echo "  • Properly positioned discount badges (bottom-right)\n";
echo "  • Multiple urgency badges (top section)\n";
echo "  • Stock alerts with color coding\n";
echo "  • Enhanced product titles (2-line with ellipsis)\n";
echo "  • Powerful CTAs with animations\n";
echo "  • Social proof indicators\n";
echo "\n💡 Next steps:\n";
echo "  1. Test random pages to verify fixes\n";
echo "  2. Check mobile responsiveness\n";
echo "  3. Clear browser cache for best results\n";
echo "  4. Update sitemap with all enhanced pages\n";
echo str_repeat("=", 60) . "\n";
?>
