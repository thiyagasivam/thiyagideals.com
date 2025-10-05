<?php
/**
 * Comprehensive URL Fixer for all-pages.php
 * Fixes all href patterns to use SITE_URL properly
 */

$file = 'all-pages.php';
$content = file_get_contents($file);

// Replace all href patterns that reference $page['url'] to include SITE_URL
$content = preg_replace(
    '/<a href="<\?php echo \$page\[\'url\'\]; \?>"/',
    '<a href="<?php echo SITE_URL; ?>/<?php echo $page[\'url\']; ?>"',
    $content
);

// Save the fixed content
file_put_contents($file, $content);

echo "✅ Fixed all href patterns in all-pages.php!\n";
echo "🔗 All links now use SITE_URL properly\n";
echo "\n🎉 Done!\n";
?>
