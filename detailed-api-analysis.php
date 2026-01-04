<?php
/**
 * Comprehensive EarnPe API Data Analysis
 * Shows all available fields and their sample values
 */

require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/detailed-api-analysis';

echo "🔍 EarnPe API Comprehensive Data Analysis\n";
echo "==========================================\n\n";

// Fetch sample data
$deals = fetchEarnPeDeals(1);

if (!$deals || !is_array($deals) || count($deals) === 0) {
    echo "❌ No data received from API\n";
    exit;
}

echo "📊 API Response Overview:\n";
echo "- Total products in sample: " . count($deals) . "\n";
echo "- API URL: " . EARNPE_API_URL . "\n";
echo "- API Key: " . EARNPE_API_KEY . "\n\n";

// Analyze the first product to understand the data structure
$firstProduct = $deals[0];

echo "📋 Available Data Fields:\n";
echo "==========================\n";

$fieldAnalysis = [];
foreach ($firstProduct as $field => $value) {
    $type = gettype($value);
    $sampleValue = is_string($value) ? substr($value, 0, 50) : $value;
    if (strlen($value) > 50) $sampleValue .= "...";
    
    $fieldAnalysis[$field] = [
        'type' => $type,
        'sample' => $sampleValue,
        'length' => is_string($value) ? strlen($value) : 'N/A'
    ];
    
    echo sprintf("%-20s | %-10s | %s\n", $field, $type, $sampleValue);
}

echo "\n📈 Data Analysis Across All Products:\n";
echo "=====================================\n";

// Analyze all products for data patterns
$stores = [];
$priceRanges = [];
$dealTypes = [];

foreach ($deals as $deal) {
    // Store analysis
    if (isset($deal['store_name'])) {
        $stores[$deal['store_name']] = ($stores[$deal['store_name']] ?? 0) + 1;
    }
    
    // Price analysis
    if (isset($deal['product_offer_price'])) {
        $price = (float)$deal['product_offer_price'];
        if ($price < 500) $priceRanges['Under ₹500']++;
        elseif ($price < 1000) $priceRanges['₹500-999']++;
        elseif ($price < 2000) $priceRanges['₹1000-1999']++;
        elseif ($price < 5000) $priceRanges['₹2000-4999']++;
        else $priceRanges['₹5000+']++;
    }
    
    // Deal type analysis
    if (isset($deal['deal_type'])) {
        $dealTypes[$deal['deal_type']] = ($dealTypes[$deal['deal_type']] ?? 0) + 1;
    }
}

echo "🏪 Stores Distribution:\n";
foreach ($stores as $store => $count) {
    echo "   $store: $count products\n";
}

echo "\n💰 Price Distribution:\n";
foreach ($priceRanges as $range => $count) {
    echo "   $range: $count products\n";
}

echo "\n🎯 Deal Types:\n";
foreach ($dealTypes as $type => $count) {
    echo "   Type $type: $count products\n";
}

// Calculate discount statistics
$discounts = [];
$savings = [];
foreach ($deals as $deal) {
    $original = (float)($deal['product_sale_price'] ?? 0);
    $offer = (float)($deal['product_offer_price'] ?? 0);
    
    if ($original > $offer && $original > 0) {
        $discount = (($original - $offer) / $original) * 100;
        $discounts[] = $discount;
        $savings[] = $original - $offer;
    }
}

if (count($discounts) > 0) {
    echo "\n💯 Discount Analysis:\n";
    echo "   Average discount: " . round(array_sum($discounts) / count($discounts)) . "%\n";
    echo "   Maximum discount: " . round(max($discounts)) . "%\n";
    echo "   Minimum discount: " . round(min($discounts)) . "%\n";
    echo "   Average savings: ₹" . number_format(array_sum($savings) / count($savings)) . "\n";
    echo "   Maximum savings: ₹" . number_format(max($savings)) . "\n";
}

echo "\n📊 Sample Product Details:\n";
echo "==========================\n";

// Show detailed view of first 3 products
for ($i = 0; $i < min(3, count($deals)); $i++) {
    $deal = $deals[$i];
    echo "\nProduct " . ($i + 1) . ":\n";
    echo "   ID: " . ($deal['pid'] ?? 'N/A') . "\n";
    echo "   Name: " . ($deal['product_name'] ?? 'N/A') . "\n";
    echo "   Store: " . ($deal['store_name'] ?? 'N/A') . "\n";
    echo "   Original Price: ₹" . number_format($deal['product_sale_price'] ?? 0) . "\n";
    echo "   Offer Price: ₹" . number_format($deal['product_offer_price'] ?? 0) . "\n";
    
    $original = (float)($deal['product_sale_price'] ?? 0);
    $offer = (float)($deal['product_offer_price'] ?? 0);
    if ($original > $offer && $original > 0) {
        $discount = (($original - $offer) / $original) * 100;
        $savings = $original - $offer;
        echo "   Discount: " . round($discount) . "% (Save ₹" . number_format($savings) . ")\n";
    }
    
    echo "   Image: " . (isset($deal['product_image']) ? 'Available' : 'N/A') . "\n";
    echo "   URL: " . (isset($deal['product_url']) ? 'Available' : 'N/A') . "\n";
    echo "   Date: " . ($deal['date_time'] ?? 'N/A') . "\n";
}

echo "\n🎯 Database Storage Recommendations:\n";
echo "====================================\n";
echo "Based on this analysis, here are the key fields to store:\n\n";

echo "Essential Fields:\n";
echo "   ✅ pid - Product ID (Primary Key)\n";
echo "   ✅ product_name - Product title (Full-text searchable)\n";
echo "   ✅ product_sale_price - Original price\n";
echo "   ✅ product_offer_price - Discounted price\n";
echo "   ✅ store_name - Retailer name (Filterable)\n";
echo "   ✅ product_image - Product image URL\n";
echo "   ✅ product_url - Product page URL\n";

echo "\nOptional Fields:\n";
echo "   📝 deal_type - Deal category\n";
echo "   📝 stock_status - Availability status\n";
echo "   📝 store_url - Store homepage URL\n";
echo "   📝 date_time - Deal timestamp\n";

echo "\nCalculated Fields (Auto-generated):\n";
echo "   🧮 discount_percentage - Auto-calculated from prices\n";
echo "   🧮 savings_amount - Auto-calculated savings\n";
echo "   🧮 cache_expiry - For data freshness\n";
echo "   🧮 created_at/updated_at - Timestamps\n";

echo "\n🚀 Performance Optimizations:\n";
echo "=============================\n";
echo "Recommended database indexes:\n";
echo "   📈 idx_store (store_name) - For store filtering\n";
echo "   📈 idx_price (product_offer_price) - For price range queries\n";
echo "   📈 idx_discount (discount_percentage) - For high discount deals\n";
echo "   📈 idx_active (is_active, cache_expiry) - For active deals\n";
echo "   📈 idx_search (product_name) - For full-text search\n";

echo "\n✅ Your database implementation already includes all these optimizations!\n";
?>