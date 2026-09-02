@echo off
REM Symfony Project Validation Script
REM This script validates all critical components of the Symfony project

setlocal enabledelayedexpansion
set ERRORS=0

echo.
echo ========================================
echo Symfony Project Validation
echo ========================================
echo.

REM Check Twig templates
echo [1/5] Validating Twig templates...
php bin/console lint:twig templates/ > nul 2>&1
if %ERRORLEVEL% neq 0 (
    echo [FAIL] Twig template validation failed
    php bin/console lint:twig templates/
    set /a ERRORS+=1
) else (
    echo [OK] All Twig templates are valid
)

REM Check YAML config
echo [2/5] Validating YAML configuration...
php bin/console lint:yaml config/ > nul 2>&1
if %ERRORLEVEL% neq 0 (
    echo [FAIL] YAML validation failed
    php bin/console lint:yaml config/
    set /a ERRORS+=1
) else (
    echo [OK] All YAML files are valid
)

REM Check PHP files in src/
echo [3/5] Checking PHP syntax in src/...
for /r src %%F in (*.php) do (
    php -l "%%F" > nul 2>&1
    if %ERRORLEVEL% neq 0 (
        echo [FAIL] Syntax error in %%F
        php -l "%%F"
        set /a ERRORS+=1
    )
)
if %ERRORS% equ 0 (
    echo [OK] All PHP files in src/ are valid
)

REM Check Symfony container
echo [4/5] Validating Symfony service container...
php bin/console lint:container > nul 2>&1
if %ERRORLEVEL% neq 0 (
    echo [FAIL] Container validation failed
    php bin/console lint:container
    set /a ERRORS+=1
) else (
    echo [OK] Service container is valid
)

REM Check routes
echo [5/5] Validating routes...
php bin/console debug:router > nul 2>&1
if %ERRORLEVEL% neq 0 (
    echo [FAIL] Route validation failed
    set /a ERRORS+=1
) else (
    echo [OK] Routes are configured correctly
)

REM Clear cache if no errors
if %ERRORS% equ 0 (
    echo.
    echo [OK] All validations passed! Clearing cache...
    php bin/console cache:clear
    echo.
    echo ========================================
    echo SUCCESS: Project is ready to use
    echo ========================================
) else (
    echo.
    echo ========================================
    echo FAILURE: %ERRORS% validation error(s) found
    echo ========================================
    exit /b 1
)

endlocal
