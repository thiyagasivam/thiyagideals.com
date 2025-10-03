<?php
header('Content-Type: application/xml; charset=utf-8');
require_once 'includes/config.php';
require_once 'includes/functions.php';

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
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    
    <?php
    // Get all products from EarnPe API for sitemap
    $page = 1;
    $totalProducts = 0;
    $maxPages = 20; // Increase for more comprehensive coverage
    $maxProducts = 2000; // Allow more products
    
    // API credentials hidden for security
    
    do {
        $deals = fetchEarnPeDeals($page);
        if ($deals && is_array($deals) && count($deals) > 0) {
            foreach ($deals as $deal) {
                if (isset($deal['pid']) && isset($deal['product_name'])) {
                    $productSlug = generateSlug($deal['product_name']);
                    $productUrl = SITE_URL . "/product/" . $deal['pid'] . "/" . $productSlug;
                    
                    // Handle date formatting safely
                    $dealDate = isset($deal['date_time']) ? $deal['date_time'] : date('Y-m-d H:i:s');
                    $lastModified = date('Y-m-d\TH:i:s+00:00', strtotime($dealDate));
                    
                    $totalProducts++;
                    ?>
    <url>
        <loc><?php echo htmlspecialchars($productUrl); ?></loc>
        <lastmod><?php echo $lastModified; ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.8</priority>
        
        <?php if (isset($deal['product_image']) && !empty($deal['product_image'])): ?>
        <image:image>
            <image:loc><?php echo htmlspecialchars(htmlspecialchars_decode($deal['product_image'])); ?></image:loc>
            <image:title><?php echo htmlspecialchars($deal['product_name']); ?></image:title>
            <image:caption>Buy <?php echo htmlspecialchars($deal['product_name']); ?> at best price ₹<?php echo isset($deal['product_offer_price']) ? $deal['product_offer_price'] : '0'; ?></image:caption>
        </image:image>
        <?php endif; ?>
        
        <?php if (isset($deal['product_video']) && !empty($deal['product_video'])): ?>
        <video:video>
            <video:thumbnail_loc><?php echo htmlspecialchars(htmlspecialchars_decode($deal['product_image'])); ?></video:thumbnail_loc>
            <video:title><?php echo htmlspecialchars($deal['product_name']); ?> - Product Demo</video:title>
            <video:description>Watch the demo of <?php echo htmlspecialchars($deal['product_name']); ?> and learn about its features and benefits.</video:description>
            <video:content_loc><?php echo htmlspecialchars($deal['product_video']); ?></video:content_loc>
            <video:duration>120</video:duration>
            <video:publication_date><?php echo $lastModified; ?></video:publication_date>
        </video:video>
        <?php endif; ?>
    </url>
                    <?php
                }
            }
            $page++;
        } else {
            // No more deals, break the loop
            break;
        }
    } while ($page <= $maxPages && $totalProducts < $maxProducts);
    
    // Total products processed: $totalProducts (hidden for security)
    ?>
    
</urlset>