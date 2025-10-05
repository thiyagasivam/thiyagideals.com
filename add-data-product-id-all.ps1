# PowerShell script to add data-product-id to all product links
# This ensures mobile tracking works on all pages

$files = @(
    "weekly-deals.php",
    "todays-deals.php", 
    "trending.php",
    "toys-kids.php",
    "top-rated.php",
    "super-saver.php",
    "sports-fitness.php",
    "recommended-deals.php",
    "product.php",
    "price-drop-alert.php",
    "premium-deals.php",
    "pet-supplies.php",
    "payday-special.php",
    "new-arrivals.php",
    "most-saved.php",
    "month-end-sale.php",
    "midnight-deals.php",
    "mega-discounts.php",
    "maximum-savings.php",
    "luxury-deals.php",
    "lowest-prices.php",
    "local-sellers.php",
    "limited-stock.php",
    "last-chance.php",
    "home-kitchen.php",
    "health-wellness.php",
    "handmade-deals.php",
    "gift-ideas.php",
    "free-delivery.php",
    "flipkart-deals.php",
    "flash-sale.php",
    "festival-sale.php",
    "fashion-deals.php",
    "electronics-deals.php",
    "editors-choice.php",
    "eco-friendly.php",
    "deal-of-day.php",
    "combo-deals.php",
    "clearance-sale.php",
    "buy-1-get-1.php",
    "best-value.php",
    "best-sellers.php",
    "beauty-deals.php",
    "automotive.php",
    "deals-1000-5000.php",
    "deals-25-percent-off.php",
    "deals-30-percent-off.php",
    "deals-500-1000.php",
    "deals-under-1000.php",
    "deals-under-2000.php",
    "weekend-special.php",
    "books-media.php"
)

$basePath = "c:\xampp\htdocs\Live Pages\thiyagideals"
$modified = 0
$skipped = 0

foreach ($file in $files) {
    $filePath = Join-Path $basePath $file
    
    if (!(Test-Path $filePath)) {
        Write-Host "SKIPPED: $file (file not found)" -ForegroundColor Yellow
        $skipped++
        continue
    }
    
    $content = Get-Content $filePath -Raw
    
    # Check if file has product links but no data-product-id
    if ($content -match 'href.*product.*pid' -and $content -notmatch 'data-product-id') {
        Write-Host "NEEDS UPDATE: $file" -ForegroundColor Cyan
        
        # Pattern 1: Links with btn btn-primary class
        $pattern1 = '(<a href="<\?php echo SITE_URL; \?>/product/<\?php echo \$deal\[''pid''\]; \?>/<\?php echo create(?:Slug)?\(\$deal\[''product_name''\]\); \?>")\s+(class="btn btn-primary)'
        $replacement1 = '$1 data-product-id="<?php echo $deal[''pid'']; ?>" title="View details for <?php echo sanitizeOutput($deal[''product_name'']); ?>" $2'
        
        $newContent = $content -replace $pattern1, $replacement1
        
        # Pattern 2: Links with btn btn-outline-primary class  
        $pattern2 = '(<a href="<\?php echo SITE_URL; \?>/product/<\?php echo \$deal\[''pid''\]; \?>/<\?php echo generateSlug\(\$deal\[''product_name''\]\); \?>")\s+(class="btn btn-outline-primary)'
        $replacement2 = '$1 data-product-id="<?php echo $deal[''pid'']; ?>" title="View details for <?php echo sanitizeOutput($deal[''product_name'']); ?>" $2'
        
        $newContent = $newContent -replace $pattern2, $replacement2
        
        if ($newContent -ne $content) {
            Set-Content -Path $filePath -Value $newContent -NoNewline
            Write-Host "UPDATED: $file" -ForegroundColor Green
            $modified++
        } else {
            Write-Host "NO MATCH: $file (pattern didn't match)" -ForegroundColor Yellow
            $skipped++
        }
    } elseif ($content -match 'data-product-id') {
        Write-Host "ALREADY HAS: $file (already has data-product-id)" -ForegroundColor Gray
        $skipped++
    } else {
        Write-Host "NO LINKS: $file (no product links found)" -ForegroundColor DarkGray
        $skipped++
    }
}

Write-Host "`n==================================" -ForegroundColor Cyan
Write-Host "SUMMARY:" -ForegroundColor Cyan
Write-Host "Total files checked: $($files.Count)" -ForegroundColor White
Write-Host "Files modified: $modified" -ForegroundColor Green
Write-Host "Files skipped: $skipped" -ForegroundColor Yellow
Write-Host "==================================`n" -ForegroundColor Cyan
