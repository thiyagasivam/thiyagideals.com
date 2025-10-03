<?php
/**
 * Fix All Generated Pages
 * Fixes header/footer include paths in all auto-generated pages
 */

$pagesFixed = 0;
$pagesFailed = 0;

// Get all PHP files in shop directory
$files = glob(__DIR__ . '/*.php');

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip system files
    if (in_array($filename, ['index.php', 'product.php', 'generate-pages-config.php', 'generate-pages-execute.php', 'fix-all-pages.php', 'all-pages.php'])) {
        continue;
    }
    
    $content = file_get_contents($file);
    $originalContent = $content;
    $changes = 0;
    
    // Fix header include
    if (strpos($content, "include 'header.php'") !== false) {
        $content = str_replace("include 'header.php'", "include 'includes/header.php'", $content);
        $changes++;
    }
    
    // Fix footer include
    if (strpos($content, "include 'footer.php'") !== false) {
        $content = str_replace("include 'footer.php'", "include 'includes/footer.php'", $content);
        $changes++;
    }
    
    // Remove duplicate adjustBrightness function at the end of file
    $pattern = '/\<\?php\s*\/\/\s*Helper function to adjust color brightness.*?function adjustBrightness\(.*?\}\s*\?\>\s*$/s';
    if (preg_match($pattern, $content)) {
        $content = preg_replace($pattern, '', $content);
        $changes++;
    }
    
    // If changes were made, save the file
    if ($changes > 0 && $content !== $originalContent) {
        if (file_put_contents($file, $content)) {
            $pagesFixed++;
            echo "✅ Fixed: {$filename} ({$changes} changes)\n";
        } else {
            $pagesFailed++;
            echo "❌ Failed: {$filename}\n";
        }
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "✅ Pages fixed: {$pagesFixed}\n";
echo "❌ Pages failed: {$pagesFailed}\n";
echo str_repeat("=", 50) . "\n";
echo "\n🎉 Fix complete!\n";
?>