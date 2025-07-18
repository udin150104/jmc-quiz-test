# Quiz JMC IT Consultant
---
## Jawaban Quiz Test Kemampuan Dasar I dan II

### Tech Stack
```bash
  LARAVEL v12.20.0 
  VITE v6.3.5 
```

### Teknologi yang digunakan dalam pembuatan/pengembangan 
```bash
php -v
PHP 8.3.23 (cli) (built: Jul  3 2025 16:10:55) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.3.23, Copyright (c) Zend Technologies
    with Zend OPcache v8.3.23, Copyright (c), by Zend Technologies
----------------------------------------------------------------------------
node --version
v22.16.0
----------------------------------------------------------------------------
npm --version
10.9.2
----------------------------------------------------------------------------
lsb_release -a 
No LSB modules are available.
Distributor ID:	Linuxmint
Description:	Linux Mint 21.3
Release:	21.3
Codename:	virginia
```

### installasi 
```php
// ---- clone ----------
git clone https://github.com/udin150104/jmc-quiz-test.git 
// atau
git clone git@github.com:udin150104/jmc-quiz-test.git

// settings 
cp .env.example .env 
composer install
php artisan storage:link
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan optimize:clear
php artisan serve
```