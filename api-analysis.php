<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

echo "=== EarnPe API Analysis ===\n\n";

// Fetch sample data from multiple pages
$allData = [];
$stores = [];
$categories = [];
$priceRanges = [];

for ($page = 1; $page <= 5; $page++) {
    $deals = fetchEarnPeDeals($page);
    if ($deals && is_array($deals)) {
        echo "Page $page: " . count($deals) . " products\n";
        $allData = array_merge($allData, $deals);
        
        // Collect unique stores
        foreach ($deals as $deal) {
            if (!empty($deal['store_name'])) {
                $stores[$deal['store_name']] = ($stores[$deal['store_name']] ?? 0) + 1;
            }
            
            // Collect price ranges
            if (!empty($deal['product_offer_price'])) {
                $priceRanges[] = $deal['product_offer_price'];
            }
        }
    }
}

echo "\n=== TOTAL DATA COLLECTED ===\n";
echo "Total Products: " . count($allData) . "\n";
echo "Unique Stores: " . count($stores) . "\n\n";

echo "=== SAMPLE PRODUCT STRUCTURE ===\n";
if (!empty($allData)) {
    $firstProduct = $allData[0];
    echo "Available Fields:\n";
    foreach ($firstProduct as $key => $value) {
        $valuePreview = is_string($value) ? substr($value, 0, 50) : $value;
        echo "  - $key: " . (is_string($valuePreview) ? "\"$valuePreview...\"" : $valuePreview) . "\n";
    }
    
    echo "\n=== FULL FIRST PRODUCT DATA ===\n";
    print_r($firstProduct);
}

echo "\n=== TOP 10 STORES ===\n";
arsort($stores);
$topStores = array_slice($stores, 0, 10, true);
foreach ($topStores as $store => $count) {
    echo "  - $store: $count products\n";
}

echo "\n=== PRICE ANALYSIS ===\n";
if (!empty($priceRanges)) {
    echo "  Min Price: ₹" . min($priceRanges) . "\n";
    echo "  Max Price: ₹" . max($priceRanges) . "\n";
    echo "  Avg Price: ₹" . round(array_sum($priceRanges) / count($priceRanges)) . "\n";
}

echo "\n=== POSSIBLE PAGE IDEAS ===\n\n";

echo "Based on available API data, you can create:\n\n";

echo "1. CATEGORY PAGES:\n";
echo "   - Best Deals Under ₹500\n";
echo "   - Best Deals ₹500-1000\n";
echo "   - Premium Deals (₹10,000+)\n";
echo "   - Hot Deals (40%+ OFF)\n";
echo "   - Super Saver (50%+ OFF)\n\n";

echo "2. STORE PAGES:\n";
foreach ($topStores as $store => $count) {
    $slug = strtolower(str_replace([' ', '.'], '-', $store));
    echo "   - $store Deals ($count products)\n";
}
echo "\n";

echo "3. SPECIAL COLLECTIONS:\n";
echo "   - Today's Top Deals\n";
echo "   - Weekend Special Offers\n";
echo "   - Flash Sale Products\n";
echo "   - Limited Stock Deals\n";
echo "   - Free Delivery Products\n";
echo "   - New Arrivals\n\n";

echo "4. PRICE-BASED PAGES:\n";
echo "   - Budget Deals (Under ₹500)\n";
echo "   - Mid-Range (₹500-5000)\n";
echo "   - Premium Products (₹5000+)\n\n";

echo "5. DISCOUNT PAGES:\n";
echo "   - 10% OFF or More\n";
echo "   - 25% OFF or More\n";
echo "   - 40% OFF or More\n";
echo "   - 50% OFF or More\n";
echo "   - Mega Discounts (60%+ OFF)\n\n";

echo "6. COMPARISON PAGES:\n";
echo "   - Best Price Comparison\n";
echo "   - Store Price Comparison\n";
echo "   - Product Alternatives\n\n";

echo "7. TRENDING PAGES:\n";
echo "   - Most Viewed Products\n";
echo "   - Most Saved Products\n";
echo "   - Trending This Week\n\n";

echo "=== END ANALYSIS ===\n";
?>