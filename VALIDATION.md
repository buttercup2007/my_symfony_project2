# Symfony Project - Validation & Maintenance Guide

## Quick Start

Your project is now set up with automated validation to prevent issues.

### How to Validate Your Project

#### Using PowerShell (Recommended):
```powershell
.\validate.ps1
```

Or with automatic cache clearing:
```powershell
.\validate.ps1 -ClearCache
```

#### Using Batch (Windows):
```bash
validate.bat
```

## What Gets Validated

The validation script checks:
- ✅ **Twig Templates** - All template files in `templates/`
- ✅ **YAML Configuration** - All config files in `config/`
- ✅ **PHP Syntax** - All PHP files in `src/`
- ✅ **Service Container** - Dependency injection configuration
- ✅ **Routes** - All route definitions

## When to Run Validation

**Run validation after:**
1. Creating or modifying template files (`.twig` files)
2. Adding/modifying controllers or entities
3. Changing configuration files (`.yaml` files)
4. Installing new Composer packages
5. Making any changes before committing to Git

## Project Structure

```
my_symfony_project/
├── src/
│   ├── Controller/
│   │   ├── HomeController.php       # Home route
│   │   └── wedstrijdController.php  # Wedstrijden route
│   └── Entity/
│       ├── Wedstrijd.php            # Database entity
│       ├── Competitie.php           # Database entity
│       └── Sport.php                # Database entity
├── templates/
│   ├── base.html.twig              # Base template
│   ├── home/index.html.twig        # Home page
│   └── wedstrijd/index.html.twig   # Wedstrijden page
├── validate.ps1                     # PowerShell validation script
├── validate.bat                     # Batch validation script
└── composer.json                    # PHP dependencies
```

## Important Files to Keep in Sync

### Templates
- `templates/base.html.twig` - Base layout (imported by all pages)
- `templates/home/index.html.twig` - Home page
- `templates/wedstrijd/index.html.twig` - Wedstrijden listing

### Controllers
- `src/Controller/HomeController.php` - Handles `/` route
- `src/Controller/wedstrijdController.php` - Handles `/wedstrijden` route

### Entities
- `src/Entity/Wedstrijd.php` - Maps to `wedstrijd` table
- `src/Entity/Competitie.php` - Maps to `competities` table
- `src/Entity/Sport.php` - Maps to `sporten` table

## Preventing Common Issues

### Issue: Template not found
**Solution:** Always create the template directory structure in `templates/` before referencing it in a controller.

```php
// Make sure this template exists:
return $this->render('path/to/template.html.twig', [...]);
```

Create the directory: `templates/path/to/`

### Issue: Missing template file
**Prevention:** Run `validate.ps1` after each template change to catch missing files early.

### Issue: Syntax errors
**Prevention:** The validation script checks all PHP syntax automatically.

## Maintenance

### Regular tasks:
1. Run validation after any changes: `.\validate.ps1`
2. Clear cache when needed: `php bin/console cache:clear`
3. Keep routes organized in controller files using `#[Route(...)]` attributes

### Database management:
```powershell
# Create migrations for entity changes
php bin/console make:migration

# Run migrations
php bin/console doctrine:migrations:migrate
```

## Routes

| Route | Controller | Template | Purpose |
|-------|-----------|----------|---------|
| `/` | HomeController | `home/index.html.twig` | Home page with link to wedstrijden |
| `/wedstrijden` | wedstrijdController | `wedstrijd/index.html.twig` | Display sports competitions |

## Troubleshooting

### Cache issues
```powershell
php bin/console cache:clear
```

### Template errors
```powershell
php bin/console lint:twig templates/
```

### PHP syntax errors
```powershell
php -l src/Controller/YourFile.php
```

### Route issues
```powershell
php bin/console debug:router
```

### Container/dependency injection errors
```powershell
php bin/console lint:container
```

## Git Integration

Add validation to your workflow:
1. Before committing, run: `.\validate.ps1 -ClearCache`
2. Ensure all checks pass (exit code 0)
3. Then commit your changes

To make it automatic, consider setting up a pre-commit hook in your `.git/hooks/pre-commit` file.
