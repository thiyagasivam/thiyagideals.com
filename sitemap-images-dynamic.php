<?php
header('Content-Type: application/xml; charset=utf-8');
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Canonical URL for SEO
$canonicalUrl = SITE_URL . '/sitemap-images-dynamic';

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
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    
    <?php
    // Site logo and brand images
    ?>
    <!-- Main Page with Logo -->
    <url>
        <loc><?php echo SITE_URL; ?>/</loc>
        <image:image>
            <image:loc>https://www.thiyagi.com/nt.png</image:loc>
            <image:title><?php echo SITE_NAME; ?> Logo</image:title>
            <image:caption><?php echo SITE_NAME; ?> - Best Deals and Offers Platform</image:caption>
        </image:image>
        <lastmod><?php echo date('Y-m-d\TH:i:s+00:00'); ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    
    <?php
    // Product images from API
    
    // Get product images from EarnPe API
    $page = 1;
    $totalImages = 0;
    $maxPages = 15; // More pages for images
    $maxImages = 1500; // Allow more images
    
    do {
        $deals = fetchEarnPeDeals($page);
        if ($deals && is_array($deals) && count($deals) > 0) {
            foreach ($deals as $deal) {
                if (isset($deal['pid']) && isset($deal['product_name']) && isset($deal['product_image']) && !empty($deal['product_image'])) {
                    $productSlug = generateSlug($deal['product_name']);
                    $productUrl = SITE_URL . "/product/" . $deal['pid'] . "/" . $productSlug;
                    
                    // Handle date formatting safely
                    $dealDate = isset($deal['date_time']) ? $deal['date_time'] : date('Y-m-d H:i:s');
                    $lastModified = date('Y-m-d\TH:i:s+00:00', strtotime($dealDate));
                    
                    $totalImages++;
                    ?>
    <url>
        <loc><?php echo htmlspecialchars($productUrl); ?></loc>
        <image:image>
            <image:loc><?php echo htmlspecialchars(htmlspecialchars_decode($deal['product_image'])); ?></image:loc>
            <image:title><?php echo htmlspecialchars($deal['product_name']); ?></image:title>
            <image:caption>Buy <?php echo htmlspecialchars($deal['product_name']); ?> from <?php echo isset($deal['store_name']) ? htmlspecialchars($deal['store_name']) : 'Top Store'; ?> at best price ₹<?php echo isset($deal['product_offer_price']) ? $deal['product_offer_price'] : '0'; ?></image:caption>
        </image:image>
        <lastmod><?php echo $lastModified; ?></lastmod>
        <changefreq>daily</changefreq>
        <priority>0.7</priority>
    </url>
                    <?php
                }
            }
            $page++;
        } else {
            // No more deals, break the loop
            break;
        }
    } while ($page <= $maxPages && $totalImages < $maxImages);
    
    // Total images processed: $totalImages (statistics hidden)
    ?>
    
</urlset>