<?php
/**
 * Dynamic Complete Sitemap Generator
 * Auto-generates sitemap with ALL PHP pages and deals
 * Updated: January 4, 2026
 */

header('Content-Type: application/xml; charset=utf-8');
require_once 'includes/config.php';

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xhtml="http://www.w3.org/1999/xhtml">
    
    <?php
    $currentDate = date('Y-m-d\TH:i:s+00:00');
    
    // Home page - Highest priority
    ?>
    <url>
        <loc><?php echo SITE_URL; ?></loc>
        <lastmod><?php echo $currentDate; ?></lastmod>
        <changefreq>hourly</changefreq>
        <priority>1.0</priority>
        <xhtml:link rel="alternate" hreflang="en-in" href="<?php echo SITE_URL; ?>" />
    </url>
    
    <?php
    // Paginated home pages
    for ($page = 2; $page <= 20; $page++) {
        echo "    <url>\n";
        echo "        <loc>" . SITE_URL . "?page=" . $page . "</loc>\n";
        echo "        <lastmod>" . $currentDate . "</lastmod>\n";
        echo "        <changefreq>hourly</changefreq>\n";
        echo "        <priority>0.8</priority>\n";
        echo "    </url>\n";
    }
    
    // Get all PHP files in root directory
    $phpFiles = glob(__DIR__ . '/*.php');
    
    // Exclude files
    $excludeFiles = [
        '404.php',
        'sitemap.xml.php',
        'sitemap-main.xml',
        'sitemap-products.php',
        'sitemap-images-dynamic.php',
        'sitemap-news-dynamic.php',
        'function-test.php',
        'api-analysis.php',
        'detailed-api-analysis.php',
        'check-pid-issues.php',
        'scan-pages.php',
        'product.php' // Handled separately
    ];
    
    // Priority mapping for different page types
    $priorityMap = [
        // Store-specific - Very High
        'amazon-deals' => 0.95,
        'flipkart-deals' => 0.95,
        
        // Price ranges - High
        'deals-under-500' => 0.90,
        'deals-under-1000' => 0.90,
        'deals-under-2000' => 0.85,
        'deals-500-1000' => 0.85,
        
        // Popular discount levels - High
        'deals-50-percent-off' => 0.90,
        'deals-70-percent-off' => 0.90,
        'deals-80-percent-off' => 0.85,
        
        // Trending pages - High
        'hot-deals' => 0.95,
        'todays-deals' => 0.95,
        'flash-sale' => 0.90,
        'best-sellers' => 0.85,
        
        // Festival/seasonal - Medium-High
        'diwali-deals' => 0.80,
        'christmas-deals' => 0.80,
        'black-friday-deals' => 0.80,
        
        // Categories - Medium
        'electronics-deals' => 0.80,
        'fashion-deals' => 0.80,
        'beauty-deals' => 0.75,
        
        // Default for other pages
        'default' => 0.70
    ];
    
    // Change frequency mapping
    $changefreqMap = [
        'hot-deals' => 'hourly',
        'todays-deals' => 'hourly',
        'flash-sale' => 'hourly',
        'amazon-deals' => 'hourly',
        'flipkart-deals' => 'hourly',
        'default' => 'daily'
    ];
    
    // Process all PHP files
    foreach ($phpFiles as $file) {
        $filename = basename($file);
        
        // Skip excluded files and backups
        if (in_array($filename, $excludeFiles) || 
            strpos($filename, 'backup') !== false || 
            strpos($filename, 'FIXED') !== false ||
            strpos($filename, 'test') !== false) {
            continue;
        }
        
        // Get page name without extension
        $pageName = pathinfo($filename, PATHINFO_FILENAME);
        $pageUrl = SITE_URL . '/' . $pageName;
        
        // Determine priority
        $priority = isset($priorityMap[$pageName]) ? $priorityMap[$pageName] : $priorityMap['default'];
        
        // Determine change frequency
        $changefreq = isset($changefreqMap[$pageName]) ? $changefreqMap[$pageName] : $changefreqMap['default'];
        
        echo "    <url>\n";
        echo "        <loc>" . htmlspecialchars($pageUrl) . "</loc>\n";
        echo "        <lastmod>" . $currentDate . "</lastmod>\n";
        echo "        <changefreq>" . $changefreq . "</changefreq>\n";
        echo "        <priority>" . $priority . "</priority>\n";
        echo "    </url>\n";
    }
    ?>
    
</urlset>
