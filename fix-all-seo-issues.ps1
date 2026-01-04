# Fix All SEO Issues - Comprehensive Script
# Date: January 4, 2026

$workspacePath = "c:\xampp\htdocs\live\thiyagideal"
$fixedCount = 0
$errorCount = 0
$logFile = "$workspacePath\seo-fix-log.txt"

# Initialize log
"SEO Fix Log - Started: $(Get-Date)" | Out-File $logFile

# Get all PHP files that need fixing (excluding backups, tests, includes)
$phpFiles = Get-ChildItem -Path $workspacePath -Filter "*.php" | Where-Object {
    $_.Name -notlike "*backup*" -and 
    $_.Name -notlike "*test*" -and 
    $_.Name -notlike "*FIXED*" -and
    $_.Name -ne "config.php" -and
    $_.Name -ne "functions.php" -and
    $_.Name -ne "header.php" -and
    $_.Name -ne "footer.php" -and
    $_.Name -ne "404.php" -and
    $_.Directory.Name -ne "includes"
}

Write-Host "Found $($phpFiles.Count) PHP files to process" -ForegroundColor Cyan

foreach ($file in $phpFiles) {
    try {
        $content = Get-Content $file.FullName -Raw -Encoding UTF8
        $originalContent = $content
        $modified = $false
        
        # Get page name without extension for canonical URL
        $pageName = $file.BaseName
        
        # Check if file already has canonical URL defined
        if ($content -notmatch '\$canonicalUrl\s*=') {
            Write-Host "Processing: $($file.Name)" -ForegroundColor Yellow
            
            # Find position after require statements and before other variables
            if ($content -match "(require_once\s+['\`"]includes/functions\.php['\`"];)") {
                # Add canonical URL after the require statements
                $canonicalLine = "`n`n// Canonical URL for SEO`n`$canonicalUrl = SITE_URL . '/$pageName';"
                
                # Insert after the last require_once
                $content = $content -replace "(require_once\s+['\`"]includes/functions\.php['\`"];)", "`$1$canonicalLine"
                $modified = $true
                
                "Fixed: $($file.Name) - Added canonical URL" | Add-Content $logFile
            }
        }
        
        # Fix lazy loading threshold (from 6 to 3)
        $lazyPattern = 'loading="<\?php echo \$index < 6 \? ''eager'' : ''lazy''; \?>"'
        $lazyReplacement = 'loading="<?php echo $index < 3 ? ''eager'' : ''lazy''; ?>"'
        
        if ($content -match [regex]::Escape('$index < 6')) {
            $content = $content -replace '\$index < 6', '$index < 3'
            $modified = $true
            "Fixed: $($file.Name) - Updated lazy loading threshold" | Add-Content $logFile
        }
        
        # Save if modified
        if ($modified) {
            $content | Out-File $file.FullName -Encoding UTF8 -NoNewline
            $fixedCount++
            Write-Host "  Fixed: $($file.Name)" -ForegroundColor Green
        }
        
    } catch {
        $errorCount++
        "ERROR: $($file.Name) - $($_.Exception.Message)" | Add-Content $logFile
        Write-Host "  Error: $($file.Name)" -ForegroundColor Red
    }
}

# Summary
$summary = @"

==========================================
SEO FIX SUMMARY - $(Get-Date)
==========================================
Total Files Processed: $($phpFiles.Count)
Successfully Fixed: $fixedCount
Errors: $errorCount
==========================================
"@

$summary | Add-Content $logFile
Write-Host $summary -ForegroundColor Cyan
Write-Host "Log saved to: $logFile" -ForegroundColor Green
