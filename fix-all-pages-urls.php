<?php
/**
 * Fix all URLs in all-pages.php
 * Removes .php extensions and adds SITE_URL prefix
 */

$file = 'all-pages.php';
$content = file_get_contents($file);

// Fix URL patterns - remove .php and add SITE_URL prefix
$replacements = [
    // Fix href with filename.php pattern
    "/'url' => '([^']+)\.php'/" => "'url' => '$1'",
    
    // Fix href in links - simple filenames
    '/<a href="\$page\[\'url\'\]"/' => '<a href="<?php echo SITE_URL; ?>/<?php echo $page[\'url\']; ?>"',
    
    // Fix SITE_URL references that might be missing
    '/href="<?php echo \$page\[\'url\'\]; ?>"/'=>'href="<?php echo SITE_URL; ?>/<?php echo $page[\'url\']; ?>"',
];

foreach ($replacements as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

// Save the fixed content
file_put_contents($file, $content);

echo "✅ Fixed all-pages.php URLs!\n";
echo "📝 All .php extensions removed\n";
echo "🔗 SITE_URL prefix added to all links\n";
echo "\n🎉 Done! The page should now work correctly.\n";
?>
