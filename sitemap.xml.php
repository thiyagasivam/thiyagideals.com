<?php
/**
 * Sitemap Generator for Shop Deals
 * Creates XML sitemap for all deal pages
 */

header('Content-Type: application/xml; charset=utf-8');

$baseUrl = 'https://thiyagideals.com/shop';

$pages = [
    // Main pages
    ['url' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
    ['url' => '/index.php', 'priority' => '1.0', 'changefreq' => 'daily'],
    
    // Price-based pages
    ['url' => '/deals-under-500.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/deals-under-1000.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/deals-under-2000.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/deals-500-1000.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/deals-1000-5000.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/premium-deals.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/luxury-deals.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    
    // Discount-based pages
    ['url' => '/hot-deals.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/super-saver.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/mega-discounts.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/deals-25-percent-off.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/deals-30-percent-off.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/clearance-sale.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    
    // Store-specific pages
    ['url' => '/amazon-deals.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/flipkart-deals.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    
    // Time-based pages
    ['url' => '/todays-deals.php', 'priority' => '1.0', 'changefreq' => 'hourly'],
    ['url' => '/weekly-deals.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/weekend-special.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/flash-sale.php', 'priority' => '0.9', 'changefreq' => 'hourly'],
    
    // Special collections
    ['url' => '/new-arrivals.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/trending.php', 'priority' => '0.9', 'changefreq' => 'hourly'],
    ['url' => '/best-sellers.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/editors-choice.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/limited-stock.php', 'priority' => '0.9', 'changefreq' => 'hourly'],
    ['url' => '/free-delivery.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    
    // Savings-focused pages
    ['url' => '/maximum-savings.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/best-value.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/combo-deals.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    
    // Category pages
    ['url' => '/electronics-deals.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/fashion-deals.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/home-kitchen.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/beauty-deals.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/sports-fitness.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/books-media.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/toys-kids.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/automotive.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/health-wellness.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/pet-supplies.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    
    // Event-based pages
    ['url' => '/festival-sale.php', 'priority' => '0.9', 'changefreq' => 'daily'],
    ['url' => '/month-end-sale.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/payday-special.php', 'priority' => '0.8', 'changefreq' => 'weekly'],
    ['url' => '/midnight-deals.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    
    // Price comparison pages
    ['url' => '/price-drop-alert.php', 'priority' => '0.8', 'changefreq' => 'hourly'],
    ['url' => '/lowest-prices.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    
    // Additional special pages
    ['url' => '/recommended-deals.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/top-rated.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/most-saved.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/deal-of-day.php', 'priority' => '1.0', 'changefreq' => 'daily'],
    ['url' => '/last-chance.php', 'priority' => '0.9', 'changefreq' => 'hourly'],
    ['url' => '/buy-1-get-1.php', 'priority' => '0.8', 'changefreq' => 'daily'],
    ['url' => '/gift-ideas.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/eco-friendly.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/handmade-deals.php', 'priority' => '0.7', 'changefreq' => 'daily'],
    ['url' => '/local-sellers.php', 'priority' => '0.7', 'changefreq' => 'daily'],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($pages as $page): ?>
    <url>
        <loc><?php echo htmlspecialchars($baseUrl . $page['url']); ?></loc>
        <lastmod><?php echo date('Y-m-d'); ?></lastmod>
        <changefreq><?php echo $page['changefreq']; ?></changefreq>
        <priority><?php echo $page['priority']; ?></priority>
    </url>
<?php endforeach; ?>
</urlset>