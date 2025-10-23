<!DOCTYPE html>
<html>
<head>
    <title>Product Links Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .product { border: 1px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 5px; }
        .test-link { color: #007bff; text-decoration: none; padding: 8px 16px; background: #f8f9fa; border: 1px solid #007bff; border-radius: 4px; display: inline-block; margin-top: 10px; }
        .test-link:hover { background: #007bff; color: white; }
        .success { color: green; font-weight: bold; }
        .info { color: #666; font-size: 0.9em; }
    </style>
</head>
<body>
    <h1>🔗 Product Links Test - Localhost</h1>
    <p class="info">This page tests that product detail page links work correctly on localhost after fixing the routing issues.</p>
    
    <?php
    error_reporting(E_ALL & ~E_WARNING);
    require_once 'includes/config.php';
    require_once 'includes/functions.php';
    
    echo '<div class="success">✅ Configuration loaded successfully!</div>';
    echo '<p><strong>Current SITE_URL:</strong> ' . SITE_URL . '</p>';
    
    $deals = fetchEarnPeDeals(1);
    if ($deals && is_array($deals)) {
        echo '<div class="success">✅ API connected and products fetched!</div>';
        echo '<p><strong>Found:</strong> ' . count($deals) . ' products</p>';
        
        $count = 0;
        foreach ($deals as $deal) {
            if ($count < 3) { // Show first 3 products
                $slug = generateSlug($deal['product_name']);
                $productUrl = SITE_URL . "/product/" . $deal['pid'] . "/" . $slug;
                
                echo '<div class="product">';
                echo '<h3>' . htmlspecialchars($deal['product_name']) . '</h3>';
                echo '<p><strong>Price:</strong> ₹' . number_format($deal['product_offer_price']) . '</p>';
                echo '<p><strong>Product ID:</strong> ' . $deal['pid'] . '</p>';
                echo '<p><strong>Generated URL:</strong><br><code>' . $productUrl . '</code></p>';
                echo '<a href="' . $productUrl . '" class="test-link" target="_blank">🚀 Test Product Page</a>';
                echo '</div>';
                $count++;
            }
        }
        
        echo '<div style="margin-top: 30px; padding: 15px; background: #e7f3ff; border-radius: 5px;">';
        echo '<h3>🎯 How to Test:</h3>';
        echo '<ol>';
        echo '<li>Click any "Test Product Page" link above</li>';
        echo '<li>The product detail page should load correctly</li>';
        echo '<li>You should see product information, pricing, and buy buttons</li>';
        echo '<li>If you see a 404 error, there might be an Apache/htaccess issue</li>';
        echo '</ol>';
        echo '<p><strong>Direct test URLs:</strong></p>';
        echo '<ul>';
        $firstProduct = $deals[0];
        echo '<li><a href="' . SITE_URL . '/product/' . $firstProduct['pid'] . '" target="_blank">' . SITE_URL . '/product/' . $firstProduct['pid'] . '</a> (without slug)</li>';
        echo '<li><a href="' . SITE_URL . '/product/' . $firstProduct['pid'] . '/' . generateSlug($firstProduct['product_name']) . '" target="_blank">' . SITE_URL . '/product/' . $firstProduct['pid'] . '/' . generateSlug($firstProduct['product_name']) . '</a> (with slug)</li>';
        echo '</ul>';
        echo '</div>';
        
    } else {
        echo '<div style="color: red;">❌ Could not fetch products from API</div>';
    }
    ?>
    
    <div style="margin-top: 30px; padding: 15px; background: #f8f9fa; border-radius: 5px;">
        <h3>🛠️ What was Fixed:</h3>
        <ul>
            <li>✅ HTTPS redirect now excludes localhost in .htaccess</li>
            <li>✅ SITE_URL automatically detects localhost vs production</li>
            <li>✅ Product URL rewriting rules are properly configured</li>
            <li>✅ getProductById function works correctly</li>
            <li>✅ generateSlug function creates proper URLs</li>
        </ul>
        
        <h3>📝 Technical Details:</h3>
        <ul>
            <li><strong>URL Pattern:</strong> /product/{id}/{slug}</li>
            <li><strong>Rewrite Rule:</strong> ^product/([0-9]+)/?([^/]*)?/?$ → product.php?id=$1</li>
            <li><strong>Environment Detection:</strong> Automatic localhost vs production</li>
            <li><strong>API Integration:</strong> EarnPe API with 10 products per page</li>
        </ul>
    </div>
</body>
</html>