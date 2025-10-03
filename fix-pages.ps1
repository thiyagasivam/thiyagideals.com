$directory = "c:\xampp\htdocs\Live Pages\thiyagi\shop"
$files = Get-ChildItem -Path $directory -Filter "*.php" -Exclude "*fix*.php","*test*.php"
$fixed = @()

foreach ($file in $files) {
    $content = Get-Content -Path $file.FullName -Raw
    
    # Check if file has footer.php include and also has </body> or </html> after it
    if ($content -match "include 'includes/footer\.php'") {
        $lines = Get-Content -Path $file.FullName
        $footerLineIndex = -1
        
        for ($i = 0; $i -lt $lines.Count; $i++) {
            if ($lines[$i] -match "include 'includes/footer\.php'") {
                $footerLineIndex = $i
                break
            }
        }
        
        if ($footerLineIndex -ge 0) {
            # Check if there's any </body> or </html> after the footer line
            $hasClosingTags = $false
            for ($i = $footerLineIndex + 1; $i -lt $lines.Count; $i++) {
                if ($lines[$i] -match "</body>|</html>") {
                    $hasClosingTags = $true
                    break
                }
            }
            
            if ($hasClosingTags) {
                # Keep only lines up to and including the footer line
                $newLines = $lines[0..$footerLineIndex]
                Set-Content -Path $file.FullName -Value $newLines
                Write-Host "Fixed: $($file.Name)" -ForegroundColor Green
                $fixed += $file.Name
            }
        }
    }
}

Write-Host "`n=== SUMMARY ===" -ForegroundColor Cyan
Write-Host "Fixed: $($fixed.Count) files" -ForegroundColor Yellow
if ($fixed.Count -gt 0) {
    Write-Host "`nFixed files:"
    $fixed | ForEach-Object { Write-Host "  - $_" }
}
