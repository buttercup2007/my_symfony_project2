# Symfony Project Validation Script
# Run this to validate your project before committing changes

param(
    [switch]$ClearCache = $false
)

$ErrorCount = 0

Write-Host ""
Write-Host "========================================" -ForegroundColor Green
Write-Host "Symfony Project Validation" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Green
Write-Host ""

# Check Twig templates
Write-Host "[1/5] Validating Twig templates..." -ForegroundColor Cyan
$result = & php bin/console lint:twig templates/ 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "[FAIL] Twig template validation failed" -ForegroundColor Red
    Write-Host $result
    $ErrorCount++
} else {
    Write-Host "[OK] All Twig templates are valid" -ForegroundColor Green
}

# Check YAML config
Write-Host "[2/5] Validating YAML configuration..." -ForegroundColor Cyan
$result = & php bin/console lint:yaml config/ 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "[FAIL] YAML validation failed" -ForegroundColor Red
    Write-Host $result
    $ErrorCount++
} else {
    Write-Host "[OK] All YAML files are valid" -ForegroundColor Green
}

# Check PHP files in src/
Write-Host "[3/5] Checking PHP syntax in src/..." -ForegroundColor Cyan
$phpFiles = Get-ChildItem -Path "src" -Filter "*.php" -Recurse
$syntaxErrors = 0
foreach ($file in $phpFiles) {
    $result = & php -l $file.FullName 2>&1
    if ($LASTEXITCODE -ne 0) {
        Write-Host "[FAIL] Syntax error in $($file.FullName)" -ForegroundColor Red
        Write-Host $result
        $syntaxErrors++
        $ErrorCount++
    }
}
if ($syntaxErrors -eq 0 -and $phpFiles.Count -gt 0) {
    Write-Host "[OK] All PHP files in src/ are valid" -ForegroundColor Green
}

# Check Symfony container
Write-Host "[4/5] Validating Symfony service container..." -ForegroundColor Cyan
$result = & php bin/console lint:container 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "[FAIL] Container validation failed" -ForegroundColor Red
    Write-Host $result
    $ErrorCount++
} else {
    Write-Host "[OK] Service container is valid" -ForegroundColor Green
}

# Check routes
Write-Host "[5/5] Validating routes..." -ForegroundColor Cyan
$result = & php bin/console debug:router 2>&1
if ($LASTEXITCODE -ne 0) {
    Write-Host "[FAIL] Route validation failed" -ForegroundColor Red
    Write-Host $result
    $ErrorCount++
} else {
    Write-Host "[OK] Routes are configured correctly" -ForegroundColor Green
}

# Results
Write-Host ""
if ($ErrorCount -eq 0) {
    Write-Host "========================================" -ForegroundColor Green
    Write-Host "SUCCESS: All validations passed!" -ForegroundColor Green
    Write-Host "========================================" -ForegroundColor Green
    
    if ($ClearCache) {
        Write-Host "Clearing cache..." -ForegroundColor Yellow
        & php bin/console cache:clear
    }
} else {
    Write-Host "========================================" -ForegroundColor Red
    Write-Host "FAILURE: $ErrorCount validation error(s) found" -ForegroundColor Red
    Write-Host "========================================" -ForegroundColor Red
    exit 1
}
