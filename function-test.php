<?php
// Test file to check function loading
echo "Testing function loading...<br>";

require_once 'includes/config.php';
echo "Config loaded successfully<br>";

require_once 'includes/functions.php';
echo "Functions loaded successfully<br>";

// Test if functions exist
if (function_exists('fetchEarnPeDeals')) {
    echo "✅ fetchEarnPeDeals function exists<br>";
} else {
    echo "❌ fetchEarnPeDeals function NOT found<br>";
}

if (function_exists('formatPrice')) {
    echo "✅ formatPrice function exists<br>";
} else {
    echo "❌ formatPrice function NOT found<br>";
}

// Test formatPrice function
if (function_exists('formatPrice')) {
    echo "Testing formatPrice(1000): " . formatPrice(1000) . "<br>";
}

// Test calculateDiscount function
if (function_exists('calculateDiscount')) {
    echo "Testing calculateDiscount(1000, 800): " . calculateDiscount(1000, 800) . "<br>";
}

echo "All tests completed!";
?>