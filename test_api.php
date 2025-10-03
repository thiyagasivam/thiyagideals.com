<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

echo "<h2>API Test Results</h2>";
echo "<p><strong>API Configuration:</strong></p>";
echo "<ul>";
echo "<li>API URL: " . EARNPE_API_URL . "</li>";
echo "<li>API Key: " . EARNPE_API_KEY . "</li>";
echo "<li>User ID: " . EARNPE_USER_ID . "</li>";
echo "<li>Token: " . (defined('EARNPE_TOKEN') ? 'DEFINED' : 'NOT DEFINED') . "</li>";
echo "</ul>";

// Test API call
echo "<h3>Testing API Connection...</h3>";
$deals = fetchEarnPeDeals(1);

if ($deals) {
    echo "<p style='color: green;'>✅ API is working! Found " . count($deals) . " deals on page 1.</p>";
    
    if (count($deals) > 0) {
        $firstDeal = $deals[0];
        echo "<h3>Sample Deal Data:</h3>";
        echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
        echo "<tr><th>Field</th><th>Value</th></tr>";
        
        foreach ($firstDeal as $key => $value) {
            if (is_string($value) || is_numeric($value)) {
                echo "<tr><td><strong>$key</strong></td><td>" . htmlspecialchars($value) . "</td></tr>";
            }
        }
        echo "</table>";
        
        // Test product by ID
        if (isset($firstDeal['pid'])) {
            $testPid = $firstDeal['pid'];
            echo "<h3>Testing Product Retrieval (PID: $testPid)</h3>";
            $product = getProductById($testPid);
            
            if ($product) {
                echo "<p style='color: green;'>✅ getProductById is working!</p>";
                echo "<p><strong>Product Name:</strong> " . $product['product_name'] . "</p>";
                echo "<p><strong>Price:</strong> ₹" . $product['product_offer_price'] . "</p>";
                echo "<p><strong>Store:</strong> " . $product['store_name'] . "</p>";
                echo "<p><a href='product.php?id=$testPid' target='_blank'>📱 Test Product Page</a></p>";
            } else {
                echo "<p style='color: red;'>❌ getProductById failed!</p>";
            }
        }
    }
    
    echo "<h3>Available Sitemaps:</h3>";
    echo "<ul>";
    echo "<li><a href='sitemap.xml' target='_blank'>🗂️ Main Sitemap Index</a></li>";
    echo "<li><a href='sitemap-main.xml' target='_blank'>🏠 Static Pages Sitemap</a></li>";
    echo "<li><a href='sitemap-products.php' target='_blank'>🗺️ Dynamic Products Sitemap</a></li>";
    echo "<li><a href='sitemap-images-dynamic.php' target='_blank'>🖼️ Dynamic Images Sitemap</a></li>";
    echo "<li><a href='sitemap-news-dynamic.php' target='_blank'>📰 Dynamic News Sitemap</a></li>";
    echo "</ul>";
    
} else {
    echo "<p style='color: red;'>❌ API call failed!</p>";
    
    // Detailed error checking
    echo "<h3>Troubleshooting:</h3>";
    
    // Test CURL
    if (!function_exists('curl_init')) {
        echo "<p style='color: red;'>❌ CURL is not enabled!</p>";
    } else {
        echo "<p style='color: green;'>✅ CURL is available.</p>";
        
        // Test direct API call
        echo "<h4>Direct API Test:</h4>";
        $url = EARNPE_API_URL . '?apikey=' . EARNPE_API_KEY . '&page=1';
        echo "<p><strong>Test URL:</strong> $url</p>";
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                'User-Id: ' . EARNPE_USER_ID,
                'Authorization: Bearer ' . EARNPE_TOKEN
            ),
        ));
        
        $response = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_error = curl_error($curl);
        curl_close($curl);
        
        echo "<p><strong>HTTP Code:</strong> $http_code</p>";
        if ($curl_error) {
            echo "<p style='color: red;'><strong>CURL Error:</strong> $curl_error</p>";
        }
        echo "<p><strong>Response:</strong> " . substr($response, 0, 500) . "...</p>";
    }
}
?>