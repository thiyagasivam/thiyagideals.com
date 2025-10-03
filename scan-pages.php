<?php
$directory = __DIR__;
$files = glob($directory . '/*.php');
$problematic = [];

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip fix scripts
    if (strpos($filename, 'fix-') === 0 || strpos($filename, 'test') !== false) {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Check if file includes footer AND has closing tags after it
    if (strpos($content, "include 'includes/footer.php'") !== false) {
        $footerPos = strpos($content, "include 'includes/footer.php'");
        $afterFooter = substr($content, $footerPos);
        
        if (strpos($afterFooter, '</body>') !== false || strpos($afterFooter, '</html>') !== false) {
            $problematic[] = $filename;
            echo "❌ $filename - Has duplicate closing tags\n";
        }
    }
}

echo "\n=== SUMMARY ===\n";
echo "Total problematic files: " . count($problematic) . "\n";
