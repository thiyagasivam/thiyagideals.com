<?php
// Quick diagnostic script to check for undefined $pid issues
// Run this on your server to identify problematic lines

echo "<h2>Checking for \$pid issues in deals-under-500.php</h2>\n";

$filename = 'deals-under-500.php';
if (!file_exists($filename)) {
    echo "<p style='color:red'>File not found: $filename</p>";
    exit;
}

$lines = file($filename, FILE_IGNORE_NEW_LINES);
$issues = [];

foreach ($lines as $lineNum => $line) {
    $actualLineNum = $lineNum + 1;
    
    // Check for crc32($pid) usage
    if (preg_match('/crc32\s*\(\s*\$pid\s*\)/', $line)) {
        $issues[] = [
            'line' => $actualLineNum,
            'code' => trim($line),
            'issue' => 'Uses $pid instead of $deal[\'pid\']'
        ];
    }
    
    // Check for direct $pid usage (not in array context)
    if (preg_match('/\$pid(?!\s*\[)/', $line) && !preg_match('/\$deal\[\'pid\'\]/', $line)) {
        $issues[] = [
            'line' => $actualLineNum,
            'code' => trim($line),
            'issue' => 'Undefined $pid variable'
        ];
    }
}

if (empty($issues)) {
    echo "<p style='color:green'>✅ No \$pid issues found!</p>";
} else {
    echo "<p style='color:red'>❌ Found " . count($issues) . " issue(s):</p>";
    echo "<table border='1' style='border-collapse:collapse; width:100%'>";
    echo "<tr><th>Line</th><th>Issue</th><th>Code</th></tr>";
    
    foreach ($issues as $issue) {
        echo "<tr>";
        echo "<td>{$issue['line']}</td>";
        echo "<td style='color:red'>{$issue['issue']}</td>";
        echo "<td><code>" . htmlspecialchars($issue['code']) . "</code></td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<h3>Recommended Fix:</h3>";
    echo "<p>Replace all instances of <code>crc32(\$pid)</code> with:</p>";
    echo "<pre style='background:#f5f5f5; padding:10px;'>";
    echo "\$productId = \$deal['pid'] ?? 'default-' . \$index;\n";
    echo "\$stockIndex = crc32((string)\$productId) % count(\$stockMessages);";
    echo "</pre>";
}

echo "<hr>";
echo "<p><strong>Server Info:</strong></p>";
echo "<ul>";
echo "<li>PHP Version: " . PHP_VERSION . "</li>";
echo "<li>File Last Modified: " . date('Y-m-d H:i:s', filemtime($filename)) . "</li>";
echo "<li>File Size: " . filesize($filename) . " bytes</li>";
echo "</ul>";
?>