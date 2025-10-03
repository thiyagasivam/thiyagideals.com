<?php
$directory = __DIR__;
$files = glob($directory . '/*.php');
$fixed = array();
$errors = array();

foreach ($files as $file) {
    $filename = basename($file);
    
    if (strpos($filename, 'fix-') === 0 || $filename === 'scan-pages.php') {
        continue;
    }
    
    $content = file_get_contents($file);
    
    if (strpos($content, "include 'includes/footer.php'") !== false) {
        $footerPos = strpos($content, "include 'includes/footer.php'");
        $afterFooter = substr($content, $footerPos);
        
        if (strpos($afterFooter, '</body>') !== false || strpos($afterFooter, '</html>') !== false) {
            $endOfFooterLine = strpos($content, '?>', $footerPos) + 2;
            $nextNewline = strpos($content, "\n", $endOfFooterLine);
            if ($nextNewline !== false) {
                $endOfFooterLine = $nextNewline + 1;
            }
            
            $newContent = substr($content, 0, $endOfFooterLine);
            
            if (strpos($newContent, "include 'includes/footer.php'") !== false) {
                if (file_put_contents($file, $newContent)) {
                    $fixed[] = $filename;
                    echo "Fixed: $filename\n";
                } else {
                    $errors[] = $filename;
                    echo "Error: $filename\n";
                }
            }
        }
    }
}

echo "\nSummary:\n";
echo "Fixed: " . count($fixed) . " files\n";
echo "Errors: " . count($errors) . " files\n";
