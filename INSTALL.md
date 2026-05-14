# AudioGuía — Installation Guide

## Requirements

- PHP 8.2+, extensions: `mysqli`, `intl`, `mbstring`, `fileinfo`, `json`
- MySQL 8.0+
- Apache 2.4+ with `mod_rewrite` enabled
- Composer

## Setup

### 1. Install dependencies
```bash
composer install --no-dev --optimize-autoloader
```

### 2. Configure environment
```bash
cp env .env
```
Edit `.env`:
```
CI_ENVIRONMENT = production
app.baseURL    = 'https://yourdomain.com/audioguia/'
database.default.hostname = localhost
database.default.database = audioguia
database.default.username = YOUR_DB_USER
database.default.password = YOUR_DB_PASS
```

### 3. Create the database
```sql
CREATE DATABASE audioguia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 4. Run migrations & seed
```bash
php spark migrate
php spark db:seed DatabaseSeeder
```

### 5. Apache VirtualHost (production)
```apache
<VirtualHost *:80>
    ServerName yourdomain.com
    DocumentRoot /var/www/audioguia/public

    <Directory /var/www/audioguia/public>
        AllowOverride All
        Require all granted
    </Directory>

    # Deny access to sensitive directories
    <Directory /var/www/audioguia/app>
        Require all denied
    </Directory>
    <Directory /var/www/audioguia/vendor>
        Require all denied
    </Directory>
</VirtualHost>
```

### 6. Writable permissions
```bash
chmod -R 775 writable/
chmod -R 775 public/uploads/
chown -R www-data:www-data writable/ public/uploads/
```

## Default Admin Credentials

Set a strong password before seeding — add it to `.env`:
```
SEED_ADMIN_PASSWORD = <your-strong-password>
```
Then seed:
```bash
php spark db:seed DatabaseSeeder
```

- **URL:** `https://yourdomain.com/audioguia/admin/login`
- **Email:** `admin@audioguia.local`
- **Password:** *(whatever you set in `SEED_ADMIN_PASSWORD`)*

## Directory Notes
- Uploaded images: `public/uploads/images/{stop_id}/`
- Uploaded audio: `public/uploads/audio/{stop_id}/`
- PHP execution is blocked inside `public/uploads/` via `.htaccess`
