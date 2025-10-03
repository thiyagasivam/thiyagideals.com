<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product URL Test - Thiyagi Deals</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .test-section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; border-color: #c3e6cb; }
        .error { background: #f8d7da; border-color: #f5c6cb; }
        .url-test { margin: 10px 0; }
        .url-test a { display: inline-block; margin: 5px 10px 5px 0; padding: 8px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        .url-test a:hover { background: #0056b3; }
    </style>
</head>
<body>
    <h1>🔧 Product URL Configuration Test</h1>
    
    <?php
    require_once 'includes/config.php';
    require_once 'includes/functions.php';
    
    function generateSlug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s_-]+/', '-', $text);
        return trim($text, '-');
    }
    
    echo '<div class="test-section">';
    echo '<h2>📋 Configuration Status</h2>';
    echo '<p><strong>SITE_URL:</strong> ' . SITE_URL . '</p>';
    echo '<p><strong>Current Domain:</strong> http://' . $_SERVER['HTTP_HOST'] . '</p>';
    echo '<p><strong>Current Path:</strong> ' . $_SERVER['REQUEST_URI'] . '</p>';
    echo '</div>';
    
    // Test API connection
    echo '<div class="test-section">';
    echo '<h2>🔌 API Connection Test</h2>';
    $deals = fetchEarnPeDeals(1);
    if ($deals && !empty($deals) && is_array($deals)) {
        echo '<p class="success">✅ API Connection: SUCCESS (' . count($deals) . ' products loaded)</p>';
        
        // Show first 3 products as examples
        echo '<h3>Sample Product URLs:</h3>';
        for ($i = 0; $i < min(3, count($deals)); $i++) {
            $deal = $deals[$i];
            $productId = $deal['pid'];
            $productName = $deal['product_name'];
            $slug = generateSlug($productName);
            
            echo '<div class="url-test">';
            echo '<strong>Product ' . ($i + 1) . ':</strong> ' . htmlspecialchars($productName) . '<br>';
            echo '<strong>ID:</strong> ' . $productId . ' | <strong>Slug:</strong> ' . $slug . '<br>';
            
            // Different URL formats to test
            $urls = [
                'SEO URL' => SITE_URL . '/product/' . $productId . '/' . $slug,
                'Direct URL' => 'product.php?id=' . $productId,
                'SEO (no slug)' => SITE_URL . '/product/' . $productId . '/',
            ];
            
            foreach ($urls as $label => $url) {
                echo '<a href="' . $url . '" target="_blank">' . $label . '</a>';
            }
            echo '</div>';
        }
    } else {
        echo '<p class="error">❌ API Connection: FAILED</p>';
        echo '<p>Error: Could not fetch products from API</p>';
    }
    echo '</div>';
    
    // Test .htaccess rules
    echo '<div class="test-section">';
    echo '<h2>⚙️ URL Rewrite Test</h2>';
    if (function_exists('apache_get_modules')) {
        if (in_array('mod_rewrite', apache_get_modules())) {
            echo '<p class="success">✅ mod_rewrite: ENABLED</p>';
        } else {
            echo '<p class="error">❌ mod_rewrite: DISABLED</p>';
        }
    } else {
        echo '<p>⚠️ Cannot determine mod_rewrite status</p>';
    }
    
    // Check if .htaccess file exists
    if (file_exists('.htaccess')) {
        echo '<p class="success">✅ .htaccess file: EXISTS</p>';
    } else {
        echo '<p class="error">❌ .htaccess file: MISSING</p>';
    }
    echo '</div>';
    
    // JavaScript test
    echo '<div class="test-section">';
    echo '<h2>🧪 JavaScript URL Test</h2>';
    echo '<button onclick="testProductURL()">Test Product URL Generation</button>';
    echo '<div id="jsTestResult"></div>';
    echo '</div>';
    ?>
    
    <div class="test-section">
        <h2>🔗 Navigation Links</h2>
        <a href="index.php">← Back to Shop</a> |
        <a href="test-urls.php">URL Debug Info</a> |
        <a href=".htaccess" target="_blank">View .htaccess</a>
    </div>
    
    <script>
    function testProductURL() {
        const testId = '123';
        const testSlug = 'test-product';
        const baseUrl = '<?php echo SITE_URL; ?>';
        const testUrl = baseUrl + '/product/' + testId + '/' + testSlug;
        
        const result = document.getElementById('jsTestResult');
        result.innerHTML = '<p>Testing URL: <a href="' + testUrl + '" target="_blank">' + testUrl + '</a></p>';
        
        // Test if URL is accessible
        fetch(testUrl, { method: 'HEAD' })
            .then(response => {
                if (response.ok) {
                    result.innerHTML += '<p class="success">✅ URL is accessible</p>';
                } else {
                    result.innerHTML += '<p class="error">❌ URL returned status: ' + response.status + '</p>';
                    result.innerHTML += '<p>Fallback: <a href="product.php?id=' + testId + '">product.php?id=' + testId + '</a></p>';
                }
            })
            .catch(error => {
                result.innerHTML += '<p class="error">❌ URL test failed: ' + error.message + '</p>';
                result.innerHTML += '<p>Fallback: <a href="product.php?id=' + testId + '">product.php?id=' + testId + '</a></p>';
            });
    }
    
    // Auto-test on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Add click handlers to all test links to show status
        const testLinks = document.querySelectorAll('.url-test a');
        testLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                this.style.background = '#ffc107';
                this.innerHTML += ' (Testing...)';
            });
        });
    });
    </script>
</body>
</html>