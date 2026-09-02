# Fix Symfony Cache Permission Issues
# Run this if you get "Unable to write in the cache directory" error

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Symfony Cache Fix" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

Write-Host "Step 1: Checking for locked cache files..." -ForegroundColor Cyan

# Kill any PHP processes that might be locking the cache
$phpProcesses = Get-Process -Name "php" -ErrorAction SilentlyContinue
if ($phpProcesses) {
    Write-Host "Found PHP processes. Stopping them..." -ForegroundColor Yellow
    Stop-Process -Name "php" -Force -ErrorAction SilentlyContinue
    Start-Sleep -Milliseconds 500
}

Write-Host "Step 2: Removing cache directory..." -ForegroundColor Cyan
$cachePath = Join-Path (Get-Location) "var\cache"
$logPath = Join-Path (Get-Location) "var\log"

if (Test-Path $cachePath) {
    Remove-Item -Path $cachePath -Recurse -Force -ErrorAction SilentlyContinue
    Write-Host "[OK] Cache directory removed"
}

if (Test-Path $logPath) {
    Remove-Item -Path $logPath -Recurse -Force -ErrorAction SilentlyContinue
    Write-Host "[OK] Log directory removed"
}

Write-Host "Step 3: Creating new cache directories..." -ForegroundColor Cyan
New-Item -ItemType Directory -Path "var\cache\dev" -Force | Out-Null
New-Item -ItemType Directory -Path "var\log" -Force | Out-Null
Write-Host "[OK] Directories recreated"

Write-Host "Step 4: Clearing Symfony cache..." -ForegroundColor Cyan
$result = & php bin/console cache:clear 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] Cache cleared successfully" -ForegroundColor Green
} else {
    Write-Host "[FAIL] Cache clear failed" -ForegroundColor Red
    Write-Host $result
    exit 1
}

Write-Host "Step 5: Warming up cache..." -ForegroundColor Cyan
$result = & php bin/console cache:warmup 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "[OK] Cache warmed up successfully" -ForegroundColor Green
} else {
    Write-Host "[WARNING] Cache warmup failed (non-critical)" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "SUCCESS: Cache issue fixed!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Your application should now work without cache errors." -ForegroundColor Green
