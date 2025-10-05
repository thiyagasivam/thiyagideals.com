<?php
/**
 * Enhanced UI Application Script - Fix All Recently Created Pages
 * Applies complete UI enhancements including:
 * - Fixed product title overflow
 * - Multiple urgency factors
 * - Powerful CTAs
 * - Image overlap fix
 * - Social proof
 */

// All recently created pages that need enhancement
$pagesToFix = [
    // Phase 2: Festival Pages
    'diwali-deals.php',
    'christmas-deals.php',
    'holi-deals.php',
    'new-year-deals.php',
    'onam-deals.php',
    'pongal-deals.php',
    'independence-day-deals.php',
    'republic-day-deals.php',
    
    // Phase 3: Price Range Pages
    'deals-under-500.php',
    'deals-500-1000.php',
    'deals-1000-5000.php',
    'deals-under-1000.php',
    'deals-under-2000.php',
    
    // Phase 4: Discount Pages
    'deals-10-percent-off.php',
    'deals-40-percent-off.php',
    'deals-50-percent-off.php',
    'deals-60-percent-off.php',
    'deals-70-percent-off.php',
    'deals-75-percent-off.php',
    'deals-80-percent-off.php',
    'deals-90-percent-off.php',
    
    // Phase 5: Comprehensive Pages
    'kids-deals.php',
    'men-deals.php',
    'women-deals.php',
    'students-deals.php',
    'travelers-deals.php',
    'pre-order-deals.php',
    'free-shipping-deals.php',
    'refurbished-deals.php',
    'open-box-deals.php',
];

$stats = [
    'processed' => 0,
    'fixed' => 0,
    'skipped' => 0,
    'errors' => 0,
];

echo "🚀 Starting Enhanced UI Application for All Pages...\n";
echo str_repeat("=", 80) . "\n\n";

foreach ($pagesToFix as $page) {
    $stats['processed']++;
    echo "[$stats[processed]/" . count($pagesToFix) . "] Processing: $page\n";
    
    if (!file_exists($page)) {
        echo "   ⚠️  File not found, skipping...\n\n";
        $stats['skipped']++;
        continue;
    }
    
    try {
        $content = file_get_contents($page);
        $originalContent = $content;
        $changes = 0;
        
        // Check if already has enhanced product card structure
        if (strpos($content, 'urgency-text') !== false && 
            strpos($content, 'GRAB THIS DEAL') !== false &&
            strpos($content, 'people viewing') !== false) {
            echo "   ℹ️  Already enhanced, skipping...\n\n";
            $stats['skipped']++;
            continue;
        }
        
        // Step 1: Find and replace the entire product card structure
        // Look for the product card loop
        $pattern = '/(<div class="col-6 col-md-4 col-lg-3 product-item".*?>.*?<div class="product-card h-100 position-relative">)(.*?)(<a href="<\?php echo \$productUrl; \?>".*?>)(.*?)(<div class="product-image">.*?<img.*?>.*?<span class="discount-badge">.*?<\/span>.*?<\/div>)(.*?)(<div class="product-info">)(.*?)(<h3 class="product-title".*?>.*?<\/h3>)(.*?)(<div class="product-price">.*?<\/div>)(.*?)((?:<div class="text-success.*?>.*?<\/div>)?)(.*?)((?:<div class="product-store.*?>.*?<\/div>)?)(.*?)(<button.*?class=".*?btn-primary.*?".*?>.*?<\/button>)(.*?)(<\/div>.*?<\/a>.*?<\/div>.*?<\/div>)/s';
        
        if (preg_match($pattern, $content)) {
            echo "   🔍 Found product card structure\n";
            
            // Build the new enhanced product card
            $newProductCard = <<<'NEWCARD'
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
NEWCARD;
            
            // Replace the product card
            $content = preg_replace($pattern, $newProductCard, $content);
            $changes++;
            echo "   ✅ Updated product card structure\n";
        }
        
        // Step 2: Add/Update CSS if not already present or needs update
        if (strpos($content, '.cta-button') === false || strpos($content, 'color: #2c3e50 !important') === false) {
            echo "   🎨 Adding/Updating CSS styles\n";
            
            // Find the closing </style> tag and add CSS before it
            $enhancedCSS = <<<'CSS'

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
            
            if (strpos($content, '</style>') !== false) {
                $content = str_replace('</style>', $enhancedCSS . "\n    </style>", $content);
                $changes++;
                echo "   ✅ Added CSS styles\n";
            }
        }
        
        // Save if changes were made
        if ($changes > 0 && $content !== $originalContent) {
            file_put_contents($page, $content);
            $stats['fixed']++;
            echo "   ✅ Successfully enhanced with $changes change(s)\n\n";
        } else {
            echo "   ℹ️  No changes needed\n\n";
            $stats['skipped']++;
        }
        
    } catch (Exception $e) {
        echo "   ❌ Error: " . $e->getMessage() . "\n\n";
        $stats['errors']++;
    }
}

// Final Summary
echo "\n" . str_repeat("=", 80) . "\n";
echo "🎉 ENHANCED UI APPLICATION COMPLETED!\n";
echo str_repeat("=", 80) . "\n\n";

echo "📊 Summary:\n";
echo "   Total Processed:     " . $stats['processed'] . " files\n";
echo "   ✅ Fixed:            " . $stats['fixed'] . " files\n";
echo "   ℹ️  Skipped:          " . $stats['skipped'] . " files\n";
echo "   ❌ Errors:           " . $stats['errors'] . " files\n\n";

echo "✨ Enhancements Applied:\n";
echo "   ✅ Fixed product title overlap (2-line ellipsis)\n";
echo "   ✅ Added multiple urgency badges (5 variants)\n";
echo "   ✅ Added stock alerts (3 variants)\n";
echo "   ✅ Implemented powerful CTAs (GRAB THIS DEAL)\n";
echo "   ✅ Added social proof (viewer counts)\n";
echo "   ✅ Enhanced savings display\n";
echo "   ✅ Fixed image overlap (z-index)\n";
echo "   ✅ Added hover effects and animations\n";
echo "   ✅ Mobile responsive design\n\n";

if ($stats['fixed'] > 0) {
    echo "🎯 Success Rate: " . round(($stats['fixed'] / $stats['processed']) * 100, 1) . "%\n\n";
}

echo "✅ All pages now have conversion-optimized UI! 🎉\n";
?>
