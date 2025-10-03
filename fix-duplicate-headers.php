<?php
/**
 * Fix Duplicate Header Issue in All Specialized Pages
 * Removes duplicate <!DOCTYPE html> and replaces with proper include
 */

$pagesDir = __DIR__;

// Get all specialized page files
$files = glob($pagesDir . '/*.php');

$pagesToFix = [];
$fixedPages = [];
$errors = [];

// Skip these files
$skipFiles = [
    'index.php',
    'product.php',
    'all-pages.php',
    'fix-duplicate-headers.php',
    'fix-all-pages.php',
    'fix-discount-calculation.php',
    'fix-discount-calculation-v2.php',
    'generate-pages-config.php',
    'generate-pages-execute.php',
    '404.php',
    'contact.php',
    'footer.php',
    'default.php'
];

// Identify pages that need fixing
foreach ($files as $file) {
    $filename = basename($file);
    
    if (in_array($filename, $skipFiles)) {
        continue;
    }
    
    // Check if file has duplicate header issue
    $content = file_get_contents($file);
    if (strpos($content, '<!DOCTYPE html>') !== false && strpos($content, "include 'includes/header.php'") !== false) {
        $pagesToFix[] = $file;
    }
}

echo "Found " . count($pagesToFix) . " pages with duplicate header issue\n\n";

// Fix each page
foreach ($pagesToFix as $file) {
    $filename = basename($file);
    echo "Fixing: $filename\n";
    
    try {
        $content = file_get_contents($file);
        
        // Extract metadata
        preg_match('/\$pageTitle = "(.*?)";/', $content, $titleMatch);
        preg_match('/\$metaDescription = "(.*?)";/', $content, $descMatch);
        preg_match('/<meta name="keywords" content="([^"]+)"/', $content, $keywordsMatch);
        
        $pageTitle = isset($titleMatch[1]) ? $titleMatch[1] : '';
        $pageDescription = isset($descMatch[1]) ? $descMatch[1] : '';
        $pageKeywords = isset($keywordsMatch[1]) ? $keywordsMatch[1] : '';
        
        // Find the section to replace
        // From the second ?> (after metaDescription) to the <style> tag
        $lines = explode("\n", $content);
        $startLine = -1;
        $endLine = -1;
        $phpCloseCount = 0;
        
        for ($i = 0; $i < count($lines); $i++) {
            if (strpos($lines[$i], '?>') !== false) {
                $phpCloseCount++;
                if ($phpCloseCount == 2) {
                    $startLine = $i;
                }
            }
            if (strpos($lines[$i], '<style>') !== false) {
                $endLine = $i;
                break;
            }
        }
        
        if ($startLine == -1 || $endLine == -1) {
            throw new Exception("Could not find section boundaries");
        }
        
        // Build the new content
        $before = array_slice($lines, 0, $startLine + 1);
        $after = array_slice($lines, $endLine);
        
        $middle = [
            '',
            '$pageDescription = $metaDescription;',
            '$pageKeywords = "' . $pageKeywords . '";',
            '',
            '// Include header',
            'include \'includes/header.php\';',
            '?>',
            ''
        ];
        
        $newLines = array_merge($before, $middle, $after);
        $newContent = implode("\n", $newLines);
        
        // Write the fixed content
        file_put_contents($file, $newContent);
        
        $fixedPages[] = $filename;
        echo "  ✓ Fixed successfully\n";
        
    } catch (Exception $e) {
        $errors[$filename] = $e->getMessage();
        echo "  ✗ Error: " . $e->getMessage() . "\n";
    }
    
    echo "\n";
}

// Print summary
echo "\n" . str_repeat("=", 60) . "\n";
echo "FIX SUMMARY\n";
echo str_repeat("=", 60) . "\n\n";
echo "Total pages found: " . count($pagesToFix) . "\n";
echo "Successfully fixed: " . count($fixedPages) . "\n";
echo "Errors: " . count($errors) . "\n\n";

if (count($fixedPages) > 0) {
    echo "Fixed pages:\n";
    foreach ($fixedPages as $page) {
        echo "  ✓ $page\n";
    }
    echo "\n";
}

if (count($errors) > 0) {
    echo "Errors:\n";
    foreach ($errors as $page => $error) {
        echo "  ✗ $page: $error\n";
    }
    echo "\n";
}

echo "\nDone!\n";
