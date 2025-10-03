<?php
// URL Testing and Debugging Page
require_once 'includes/config.php';

echo "<h2>URL Configuration Test</h2>";
echo "<p><strong>SITE_URL:</strong> " . SITE_URL . "</p>";
echo "<p><strong>Current Server:</strong> " . $_SERVER['HTTP_HOST'] . "</p>";
echo "<p><strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p><strong>Script Name:</strong> " . $_SERVER['SCRIPT_NAME'] . "</p>";

echo "<h3>Test URLs:</h3>";
echo "<ul>";
echo "<li><a href='" . SITE_URL . "/product/1/test-product'>SEO URL: " . SITE_URL . "/product/1/test-product</a></li>";
echo "<li><a href='product.php?id=1'>Direct URL: product.php?id=1</a></li>";
echo "<li><a href='index.php'>Shop Index: index.php</a></li>";
echo "</ul>";

echo "<h3>htaccess Rules Status:</h3>";
if (function_exists('apache_get_modules') && in_array('mod_rewrite', apache_get_modules())) {
    echo "<p style='color: green;'>✓ mod_rewrite is enabled</p>";
} else {
    echo "<p style='color: red;'>✗ mod_rewrite status unknown (may not be enabled)</p>";
}

echo "<h3>Sample Product Data:</h3>";
require_once 'includes/functions.php';
$deals = fetchEarnPeDeals(1);
if ($deals && !empty($deals)) {
    $firstProduct = $deals[0];
    echo "<p>Sample Product ID: " . $firstProduct['pid'] . "</p>";
    echo "<p>Sample Product Name: " . $firstProduct['product_name'] . "</p>";
    
    function generateSlug($text) {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s_-]+/', '-', $text);
        return trim($text, '-');
    }
    
    $slug = generateSlug($firstProduct['product_name']);
    echo "<p>Generated Slug: " . $slug . "</p>";
    echo "<p><strong>Test Product URL:</strong> <a href='" . SITE_URL . "/product/" . $firstProduct['pid'] . "/" . $slug . "'>" . SITE_URL . "/product/" . $firstProduct['pid'] . "/" . $slug . "</a></p>";
} else {
    echo "<p style='color: red;'>No products found from API</p>";
}
?>