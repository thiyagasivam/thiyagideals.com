<?php
header('Content-Type: application/xml; charset=utf-8');
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/sitemap-news-dynamic';

// Generate SEO-friendly URL slug
function generateSlug($text) {
    $text = strtolower($text);
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s_-]+/', '-', $text);
    return trim($text, '-');
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">
    
    <?php
    // Recent deals as news items
    
    // Get recent deals from EarnPe API for news sitemap
    $page = 1;
    $totalNews = 0;
    $maxPages = 5; // Less pages for news (recent content only)
    $maxNews = 100; // Limit news items
    $cutoffTime = strtotime('-48 hours'); // Only include deals from last 48 hours
    
    do {
        $deals = fetchEarnPeDeals($page);
        if ($deals && is_array($deals) && count($deals) > 0) {
            foreach ($deals as $deal) {
                if (isset($deal['pid']) && isset($deal['product_name'])) {
                    // Check if deal is recent (within 48 hours for Google News)
                    $dealTime = isset($deal['date_time']) ? strtotime($deal['date_time']) : time();
                    
                    if ($dealTime >= $cutoffTime) {
                        $productSlug = generateSlug($deal['product_name']);
                        $newsUrl = SITE_URL . "/deals/" . $deal['pid'] . "/" . $productSlug;
                        
                        // Format for Google News
                        $publicationDate = date('Y-m-d\TH:i:s+00:00', $dealTime);
                        $lastModified = date('Y-m-d\TH:i:s+00:00', $dealTime);
                        
                        // Generate news title and keywords
                        $storeName = isset($deal['store_name']) ? $deal['store_name'] : 'Top Store';
                        $price = isset($deal['product_offer_price']) ? $deal['product_offer_price'] : '0';
                        $originalPrice = isset($deal['product_sale_price']) ? $deal['product_sale_price'] : $price;
                        
                        $discount = 0;
                        if ($originalPrice > $price && $originalPrice > 0) {
                            $discount = round((($originalPrice - $price) / $originalPrice) * 100);
                        }
                        
                        $newsTitle = $deal['product_name'] . " - ";
                        if ($discount > 0) {
                            $newsTitle .= $discount . "% Off at " . $storeName;
                        } else {
                            $newsTitle .= "Special Deal at " . $storeName;
                        }
                        
                        // Generate keywords based on product and store
                        $keywords = strtolower($deal['product_name']) . ", " . strtolower($storeName) . ", deals, discount, offers, shopping";
                        if ($discount > 0) {
                            $keywords .= ", " . $discount . "% off, sale";
                        }
                        
                        $totalNews++;
                        ?>
    <url>
        <loc><?php echo htmlspecialchars($newsUrl); ?></loc>
        <news:news>
            <news:publication>
                <news:name><?php echo SITE_NAME; ?></news:name>
                <news:language>en</news:language>
            </news:publication>
            <news:publication_date><?php echo $publicationDate; ?></news:publication_date>
            <news:title><?php echo htmlspecialchars($newsTitle); ?></news:title>
            <news:keywords><?php echo htmlspecialchars($keywords); ?></news:keywords>
        </news:news>
        <lastmod><?php echo $lastModified; ?></lastmod>
        <changefreq>hourly</changefreq>
        <priority>0.9</priority>
    </url>
                        <?php
                    }
                }
            }
            $page++;
        } else {
            // No more deals, break the loop
            break;
        }
    } while ($page <= $maxPages && $totalNews < $maxNews);
    
    // News processing complete (statistics hidden for security)
    ?>
    
</urlset>