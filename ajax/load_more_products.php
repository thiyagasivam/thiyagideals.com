<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

// Set JSON header
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Get page parameter
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;

// Calculate API pages to fetch
$apiStartPage = (($page - 1) * API_PAGES_TO_FETCH) + 1;
$deals = fetchMultipleEarnPeDeals($apiStartPage, API_PAGES_TO_FETCH);

if (!$deals || empty($deals)) {
    http_response_code(404);
    echo json_encode(['error' => 'No more products found']);
    exit;
}

// Generate SEO-friendly URL slug
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

$html = '';
foreach ($deals as $index => $deal) {
    // Add urgency indicators
    $discountPercent = calculateDiscount($deal['product_sale_price'], $deal['product_offer_price']);
    $isHotDeal = (int)str_replace(['%', ' OFF'], '', $discountPercent) > 40;
    $isLimitedStock = ($index % 3 == 0); // Simulate limited stock for variety
    $viewerCount = rand(15, 156); // Random viewer count for urgency
    
    $html .= '<div class="product-card ' . ($isHotDeal ? 'hot-deal-card' : '') . '" data-product-id="' . $deal['pid'] . '">';
    $html .= '<div class="product-image-section">';
    
    if ($isHotDeal) {
        $html .= '<div class="product-badge"><span class="discount-badge-corner">🔥 HOT DEAL</span></div>';
    }
    
    if ($isLimitedStock) {
        $html .= '<div class="stock-badge"><span class="limited-stock-badge">⚡ Only 3 left!</span></div>';
    }
    
    $html .= '<img src="' . htmlspecialchars_decode($deal['product_image']) . '" ';
    $html .= 'alt="' . sanitizeOutput($deal['product_name']) . '" ';
    $html .= 'class="product-image" loading="lazy" ';
    $html .= 'onerror="this.src=\'https://via.placeholder.com/300x200?text=Product+Image\'">';
    $html .= '</div>';
    
    $html .= '<div class="product-info">';
    $html .= '<h3 class="product-title">' . sanitizeOutput($deal['product_name']) . '</h3>';
    
    // Urgency Indicators
    $html .= '<div class="urgency-indicators">';
    $html .= '<div class="viewer-count"><i class="bi bi-eye-fill"></i><span>' . $viewerCount . ' people viewing</span></div>';
    if ($isLimitedStock) {
        $html .= '<div class="stock-alert"><i class="bi bi-exclamation-triangle-fill"></i><span>Low stock!</span></div>';
    }
    $html .= '</div>';
    
    $html .= '<div class="product-pricing">';
    $html .= '<span class="current-price">' . formatPrice($deal['product_offer_price']) . '</span>';
    $html .= '<span class="original-price">' . formatPrice($deal['product_sale_price']) . '</span>';
    $html .= '<span class="discount-badge ' . ($isHotDeal ? 'hot-discount' : '') . '">' . $discountPercent . '</span>';
    $html .= '</div>';
    
    // Savings Calculator
    $html .= '<div class="savings-info">';
    $html .= '<span class="savings-text">💰 You save ₹' . number_format($deal['product_sale_price'] - $deal['product_offer_price']) . '</span>';
    $html .= '</div>';
    
    $html .= '<div class="product-store">';
    $html .= '<i class="bi bi-shop"></i> ' . sanitizeOutput($deal['store_name']);
    $html .= '<span class="delivery-info"><i class="bi bi-truck"></i>';
    $html .= ($deal['product_offer_price'] > 499 ? 'Free Delivery' : 'Fast Delivery') . '</span>';
    $html .= '</div>';
    
    // Timer for urgency
    $html .= '<div class="deal-timer">';
    $html .= '<i class="bi bi-clock"></i>';
    $html .= '<span>Deal ends in: <strong id="timer-' . $deal['pid'] . '">23:47:12</strong></span>';
    $html .= '</div>';
    
    $html .= '<a href="' . SITE_URL . '/product/' . $deal['pid'] . '/' . generateSlug($deal['product_name']) . '" ';
    $html .= 'class="view-details-btn ' . ($isHotDeal ? 'hot-deal-btn' : '') . '" ';
    $html .= 'onclick="trackProductClick(\'' . $deal['pid'] . '\')" ';
    $html .= 'title="View details for ' . sanitizeOutput($deal['product_name']) . '">';
    $html .= '<i class="bi bi-cart-plus"></i>';
    $html .= ($isHotDeal ? '🔥 Grab Hot Deal Now!' : 'View Details & Buy Now');
    $html .= '</a>';
    $html .= '</div>';
    $html .= '</div>';
}

echo json_encode([
    'success' => true,
    'html' => $html,
    'products_count' => count($deals),
    'page' => $page
]);
?>