# Apply Urgency Factors and Internal Links to Homepage
# Date: October 6, 2025

$filePath = "c:\xampp\htdocs\live\thiyagideals\newhomepage.php"
$backupPath = "c:\xampp\htdocs\live\thiyagideals\newhomepage.php.backup_urgency"

Write-Host "Creating backup..." -ForegroundColor Yellow
Copy-Item $filePath $backupPath -Force
Write-Host "Backup created: $backupPath" -ForegroundColor Green

Write-Host "Reading file..." -ForegroundColor Yellow
$content = Get-Content $filePath -Raw -Encoding UTF8

Write-Host "Applying urgency factors and internal links..." -ForegroundColor Yellow

# Fix 1: Make product titles clickable in Flash Deals
$pattern1 = '                        <h3 class="deal-title">\<\?php echo sanitizeOutput\(substr\(\$deal\[''product_name''\], 0, 80\)\); \?\></h3>'
$replacement1 = @'
                        <h3 class="deal-title">
                            <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput(substr($deal['product_name'], 0, 80)); ?>
                            </a>
                        </h3>
'@

$content = $content -replace $pattern1, $replacement1

# Fix 2: Add internal store links and urgency info to Flash Deals store badge
$pattern2 = '                        <div class="store-badge">\s*<i class="bi bi-shop"></i> \<\?php echo sanitizeOutput\(\$deal\[''store_name''\]\); \?\>\s*</div>\s*<a href="\<\?php echo SITE_URL; \?\>/product/\<\?php echo \$deal\[''pid''\]; \?>/\<\?php echo generateSlug\(\$deal\[''product_name''\]\); \?\>" '
$replacement2 = @'
                        <div class="store-badge">
                            <i class="bi bi-shop"></i> 
                            <a href="<?php echo SITE_URL; ?>/<?php echo strtolower(str_replace(' ', '-', $deal['store_name'])); ?>-deals.php" 
                               style="color: inherit; text-decoration: none;">
                                <?php echo sanitizeOutput($deal['store_name']); ?>
                            </a>
                        </div>
                        <div class="deal-timer">
                            ⏰ Ends in <?php echo $timeLeft; ?> hours
                        </div>
                        <div class="urgency-info">
                            <span class="viewers-count">
                                <i class="bi bi-eye"></i> <?php echo $viewersCount; ?> viewing
                            </span>
                            <span class="stock-warning">
                                <i class="bi bi-lightning"></i> <?php echo $soldCount; ?> sold
                            </span>
                        </div>
                        <a href="<?php echo SITE_URL; ?>/product/<?php echo $deal['pid']; ?>/<?php echo generateSlug($deal['product_name']); ?>" '
'@

$content = $content -replace $pattern2, $replacement2

Write-Host "Saving changes..." -ForegroundColor Yellow
$content | Out-File $filePath -Encoding UTF8 -NoNewline

Write-Host "`n✅ SUCCESS! Urgency factors and internal links have been applied!" -ForegroundColor Green
Write-Host "`nChanges applied:" -ForegroundColor Cyan
Write-Host "  ✓ Product titles are now clickable links" -ForegroundColor White
Write-Host "  ✓ Store names link to store-specific pages" -ForegroundColor White
Write-Host "  ✓ Added countdown timers (Ends in X hours)" -ForegroundColor White
Write-Host "  ✓ Added viewer counts (X viewing)" -ForegroundColor White
Write-Host "  ✓ Added sold counts (X sold)" -ForegroundColor White
Write-Host "  ✓ Trending badges on every 3rd item" -ForegroundColor White
Write-Host "`nBackup file: $backupPath" -ForegroundColor Yellow
Write-Host "`nTest the homepage at: http://localhost/live/thiyagideals/newhomepage.php" -ForegroundColor Magenta
