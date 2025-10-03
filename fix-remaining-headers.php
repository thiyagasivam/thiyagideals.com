<?php
/**
 * Fix Remaining Pages with Duplicate Header
 */

$pagesToFix = [
    'hot-deals.php',
    'amazon-deals.php',
    'todays-deals.php',
    'recommended-deals.php',
    'premium-deals.php',
    'midnight-deals.php',
    'handmade-deals.php',
    'flipkart-deals.php',
    'combo-deals.php'
];

$pagesDir = __DIR__;
$fixedCount = 0;

echo "Fixing remaining " . count($pagesToFix) . " pages...\n\n";

foreach ($pagesToFix as $filename) {
    $filepath = $pagesDir . '/' . $filename;
    
    if (!file_exists($filepath)) {
        echo "Skip: $filename (not found)\n";
        continue;
    }
    
    echo "Processing: $filename\n";
    
    $content = file_get_contents($filepath);
    
    // Check if it needs fixing
    if (strpos($content, '<!DOCTYPE html>') === false) {
        echo "  → Already fixed\n\n";
        continue;
    }
    
    // Pattern for these files: $pageKeywords = "..."; ?> <!DOCTYPE html>...<?php include
    // These files already set $pageDescription and $pageKeywords, so we just need to remove the duplicate HTML
    $pattern = '/(\$pageKeywords = .*?;)\s*\?>\s*<!DOCTYPE html>.*?<body>\s*<\?php include \'includes\/header\.php\'; \?>/s';
    
    $replacement = '$1' . "\n\n" .
                   '// Include header' . "\n" .
                   'include \'includes/header.php\';' . "\n" .
                   '?>' . "\n";
    
    $newContent = preg_replace($pattern, $replacement, $content);
    
    if ($newContent && $newContent !== $content) {
        file_put_contents($filepath, $newContent);
        $fixedCount++;
        echo "  ✓ Fixed successfully\n\n";
    } else {
        echo "  ✗ Pattern not matched\n\n";
    }
}

echo "\n" . str_repeat("=", 60) . "\n";
echo "SUMMARY\n";
echo str_repeat("=", 60) . "\n";
echo "Successfully fixed: $fixedCount/" . count($pagesToFix) . " pages\n";
echo "Done!\n";
