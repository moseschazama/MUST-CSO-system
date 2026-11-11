<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## MUST CSO website

A Laravel 12 + Tailwind CSS v4 + MySQL site for the MUST Catholic Students
Organization, designed in the clean, glassmorphic style of yonsepay.com.

### Requirements

- PHP 8.2+ with the `pdo_mysql`, `mbstring`, `openssl`, `zip` extensions
- Composer
- Node.js 18+ and npm
- MySQL (via XAMPP or any local server) on port 3306

### Setup

1. Create the database (once):

   ```bash
   mysql -u root -e "CREATE DATABASE must_cso_site CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

2. Configure `.env` (already set for XAMPP MySQL):

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=must_cso_site
   DB_USERNAME=root
   DB_PASSWORD=
   ```

3. Install dependencies:

   ```bash
   composer install
   npm install
   ```

4. Migrate and seed the sample content:

   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

5. Build the front-end assets:

   ```bash
   npm run build
   ```

6. Run the site:

   ```bash
   php artisan serve
   ```

   Open http://127.0.0.1:8000.

### Editing content

Almost everything lives in two places:

- `config/cso.php` — organization name, motto, mission, patron saint, core values,
  contact details, social links and Google Drive folder URLs. Paste your real
  shared folder links here; leave a URL as `null` and the card shows "coming soon".
- `database/seeders/` — leaders, activities, events, announcements, reports and
  gallery photos. Edit the arrays, then run `php artisan migrate:fresh --seed`
  to rebuild the database.

Gallery photos use Google Drive file IDs. Open a photo in Drive and copy the ID
from `.../file/d/<ID>/view`, then paste it into the `files` array of the matching
album in `config/cso.php`.

### Notes

- The seeded names, emails and phone numbers are **sample data** — replace them
  before going live.
- The patron saint is set to St. Aloysius Gonzaga as a placeholder; update
  `config/cso.php` with the real patron of MUST CSO.
- The original Google Drive albums (THU102226, SUN181026, M'PHAKATI 2-311026)
  are wired into the gallery with 46 curated thumbnails.
