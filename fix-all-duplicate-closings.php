<?php
/**
 * Fix all pages with duplicate closing tags after footer.php
 */

$directory = __DIR__;
$files = glob($directory . '/*.php');
$fixed = [];
$skipped = [];

foreach ($files as $file) {
    $filename = basename($file);
    
    // Skip this script and includes directory
    if ($filename === 'fix-all-duplicate-closings.php' || strpos($file, 'includes/') !== false) {
        continue;
    }
    
    $content = file_get_contents($file);
    
    // Pattern 1: footer.php followed by </body></html>
    $pattern1 = "/(\s*<\?php include 'includes\/footer\.php'; \?>)\s*\n\s*<\/body>\s*\n\s*<\/html>/";
    
    // Pattern 2: footer.php followed by script + </body></html>
    $pattern2 = "/(\s*<\?php include 'includes\/footer\.php'; \?>)\s*\n\s*\n\s*<!-- Bootstrap JS -->\s*\n\s*<script src=\"https:\/\/cdn\.jsdelivr\.net\/npm\/bootstrap@5\.3\.2\/dist\/js\/bootstrap\.bundle\.min\.js\"><\/script>\s*\n\s*<\/body>\s*\n\s*<\/html>/";
    
    // Pattern 3: Any variation with just </body></html> after footer
    $pattern3 = "/(\s*<\?php include 'includes\/footer\.php'; \?>)\s*\n.*?<\/body>\s*\n.*?<\/html>/s";
    
    $newContent = $content;
    $changed = false;
    
    // Try pattern 2 first (most specific)
    if (preg_match($pattern2, $content)) {
        $newContent = preg_replace($pattern2, "$1", $content);
        $changed = true;
        echo "Fixed (Pattern 2): $filename\n";
    }
    // Try pattern 1
    elseif (preg_match($pattern1, $content)) {
        $newContent = preg_replace($pattern1, "$1", $content);
        $changed = true;
        echo "Fixed (Pattern 1): $filename\n";
    }
    // Try pattern 3 (most general, but check if it has footer include)
    elseif (preg_match("/<\?php include 'includes\/footer\.php'; \?>/", $content) && 
            preg_match("/<\/body>/", $content) && 
            preg_match("/<\/html>/", $content)) {
        // Find position of footer include
        $footerPos = strpos($content, "<?php include 'includes/footer.php'; ?>");
        $bodyPos = strpos($content, "</body>", $footerPos);
        $htmlPos = strpos($content, "</html>", $footerPos);
        
        // If </body> and </html> come after footer include, remove them
        if ($bodyPos !== false && $htmlPos !== false && $bodyPos > $footerPos) {
            $beforeFooter = substr($content, 0, $footerPos + strlen("<?php include 'includes/footer.php'; ?>"));
            $newContent = $beforeFooter;
            $changed = true;
            echo "Fixed (Pattern 3): $filename\n";
        }
    }
    
    if ($changed) {
        file_put_contents($file, $newContent);
        $fixed[] = $filename;
    } else {
        $skipped[] = $filename;
    }
}

echo "\n=== SUMMARY ===\n";
echo "Fixed: " . count($fixed) . " files\n";
echo "Skipped: " . count($skipped) . " files\n";

if (!empty($fixed)) {
    echo "\nFixed files:\n";
    foreach ($fixed as $f) {
        echo "  - $f\n";
    }
}
