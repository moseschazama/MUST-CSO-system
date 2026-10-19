# MUST Catholic Students Organisation Website

The official website foundation for the **MUST Catholic Students Organisation (CSO)** — *Faith. Fellowship. Service.*

This repository currently contains the first working vertical slice of the website: a public
homepage, About and Contact pages, a published events section, and a secure administrator area for
managing events and reading contact messages.

> **Status:** under active development. The implementation described in this README lives on the
> [`feat/cso-foundation`](https://github.com/moseschazama/MUST-CSO-system/tree/feat/cso-foundation)
> branch; `main` only contains the Laravel application skeleton until the foundation is reviewed and
> merged. Some content is intentionally pending approval (see [Pending work](#pending-work)).
> Demonstration content is always labelled.

---

## Contents

- [What is implemented](#what-is-implemented)
- [Technology](#technology)
- [Requirements](#requirements)
- [Local setup](#local-setup)
- [Everyday commands](#everyday-commands)
- [Database](#database)
- [Project structure](#project-structure)
- [Testing](#testing)
- [Content policy](#content-policy)
- [Security notes](#security-notes)
- [Deployment outline](#deployment-outline)
- [Pending work](#pending-work)
- [Contributing](#contributing)

---

## What is implemented

**Public website**

- Responsive homepage with branded header and navigation, hero, About introduction, upcoming events,
  faith formation, community life, and footer.
- About page describing the purpose of the CSO without inventing unconfirmed details.
- Contact page with a working, validated, rate-limited message form.
- Public events index and event detail pages. Only **published** events are visible.
- Branded 403 and 404 pages.
- Health endpoint at `/health` (checks the database connection) and Laravel's `/up` endpoint.

**Administrator area**

- Sign-in at `/admin/login` using session authentication, password hashing, CSRF protection,
  session regeneration, and login rate limiting. There is no public registration.
- Dashboard with live counts of upcoming/published events and unread messages.
- Full event management flow: create (draft or published), edit, slug generation, and delete.
- Contact message inbox with read/unread toggling. Messages are only visible to administrators.

**Foundations**

- MySQL migrations for users (with an `is_admin` flag), events, and contact messages.
- Reusable Blade layouts, components, and design tokens (deep burgundy, ivory, antique gold,
  charcoal; serif headings).
- Self-hosted web fonts, Tailwind CSS 4, and a production Vite build.
- PHPUnit feature tests covering public routes, the contact flow, authentication and authorisation
  boundaries, event management, and the admin creation command.
- Local SVG artwork in `public/images/` used as clearly-identified placeholders for approved photography.

---

## Technology

| Layer | Choice |
| --- | --- |
| Backend | PHP 8.3+ / Laravel 13 |
| Database | MySQL 8 |
| Views | Blade (server-rendered) |
| Styling | Tailwind CSS 4 (via Vite) |
| JavaScript | Small progressive-enhancement script only (no SPA framework) |
| Tests | PHPUnit (feature tests) |
| Formatting | Laravel Pint |

---

## Requirements

- **PHP** 8.3 or newer with the usual Laravel extensions: `ctype`, `curl`, `dom`, `fileinfo`,
  `filter`, `hash`, `mbstring`, `openssl`, `pcre`, `pdo`, `pdo_mysql`, `session`, `tokenizer`, `xml`.
- **Composer** 2.x
- **Node.js** 20.19+ or 22.12+ (required by Vite 8) and **npm**
- **MySQL** 8.0+
- **Git**

> Other databases are not supported for the application itself. The automated test suite uses an
> in-memory SQLite database (configured in `phpunit.xml`) so tests are fast and never touch your
> development data.

---

## Local setup

### 1. Clone and install PHP dependencies

The foundation currently lives on the `feat/cso-foundation` branch, so clone that branch (drop
`--branch feat/cso-foundation` once it has been merged into `main`):

```bash
git clone --branch feat/cso-foundation https://github.com/moseschazama/MUST-CSO-system.git
cd MUST-CSO-system
composer install
```

### 2. Create the MySQL database and user

Generate a password for local development:

```bash
openssl rand -hex 24
```

Then open MySQL as an administrator. On many Linux installations `sudo mysql` uses the operating
system's root account; if your MySQL root user has a password instead, use `mysql -u root -p`:

```bash
sudo mysql
```

and run the following SQL, replacing `PASTE_THE_GENERATED_PASSWORD_HERE`:

```sql
CREATE DATABASE must_cso CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

CREATE USER 'cso_dev'@'localhost' IDENTIFIED BY 'PASTE_THE_GENERATED_PASSWORD_HERE';
CREATE USER 'cso_dev'@'127.0.0.1' IDENTIFIED BY 'PASTE_THE_GENERATED_PASSWORD_HERE';

GRANT ALL PRIVILEGES ON must_cso.* TO 'cso_dev'@'localhost';
GRANT ALL PRIVILEGES ON must_cso.* TO 'cso_dev'@'127.0.0.1';

FLUSH PRIVILEGES;
```

Verify the connection (replace the password):

```bash
mysql -h 127.0.0.1 -u cso_dev -p must_cso -e "SELECT DATABASE();"
```

### 3. Configure the environment

```bash
cp .env.example .env
php artisan key:generate
```

Open `.env` and set:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=must_cso
DB_USERNAME=cso_dev
DB_PASSWORD=the-password-you-generated
```

`APP_TIMEZONE` is set to `Africa/Blantyre`. Keep `APP_DEBUG=true` locally and set it to `false` in
production.

### 4. Run migrations

```bash
php artisan migrate
```

Run migrations only against the database you just configured. Do not run `migrate:fresh` against an
environment that contains real data.

### 5. Create the first administrator

```bash
php artisan cso:create-admin
```

The command asks for a name, email address, and a confirmed password of at least 12 characters. It
creates the account or updates an existing one and grants administrator access. Passwords are hashed
by Laravel and never stored in the repository.

### 6. Optional: local demonstration content

```bash
php artisan db:seed
```

This adds sample events marked `is_demo`, which are labelled **"Demonstration event"** wherever they
appear. Seeding is skipped automatically outside the `local` environment. Never present this data
as official.

### 7. Install and build front-end assets

```bash
npm ci
npm run build
```

### 8. Serve the application

```bash
php artisan serve
```

- Public website: <http://localhost:8000>
- Administrator sign-in: <http://localhost:8000/admin/login>
- Health check: <http://localhost:8000/health>

For active front-end work, run `npm run dev` in a second terminal instead of rebuilding on every
change.

---

## Everyday commands

| Task | Command |
| --- | --- |
| Run the test suite | `php artisan test` |
| Check code formatting | `vendor/bin/pint --test` |
| Fix code formatting | `vendor/bin/pint` |
| Build front-end assets | `npm run build` |
| Start the Vite dev server | `npm run dev` |
| Serve the application | `php artisan serve` |
| List routes | `php artisan route:list` |
| Reset local database and seed demos | `php artisan migrate:fresh --seed` |
| Create or update an administrator | `php artisan cso:create-admin` |
| Clear cached config | `php artisan config:clear` |

> `php artisan migrate:fresh` deletes all data in the configured database. Only use it locally.

---

## Database

- `users` — administrator accounts. `is_admin` controls access to the admin area.
- `events` — event content. `is_published` controls public visibility; `is_demo` marks
  demonstration content; `created_by_id` records the administrator who created the event.
- `contact_messages` — messages submitted through the public contact form. `read_at` tracks the
  read state in the admin inbox.
- Laravel's default `cache`, `jobs`, and `sessions` tables are also used. Session driver, cache
  store, and queue connection all default to `database`.

Migration files live in `database/migrations`. Add new migrations instead of editing ones that have
already been run in any shared environment.

---

## Project structure

```
app/
  Console/Commands/        cso:create-admin command
  Http/Controllers/        public and admin controllers
  Http/Middleware/         EnsureUserIsAdmin
  Http/Requests/           validation form requests (login, events, contact)
  Models/                  User, Event, ContactMessage
database/
  factories/               test factories
  migrations/              schema
  seeders/                 demo content (local only)
public/
  images/                  illustrative placeholder artwork
resources/
  css/app.css              design tokens, base styles, components
  js/app.js                mobile navigation and confirmation dialogs
  views/
    components/            layouts, site header/footer, form controls
    pages/                 home, about, contact
    events/                public events index and detail
    admin/                 dashboard, events management, messages inbox
    errors/                branded 403 and 404 pages
routes/web.php             all public and admin routes
tests/Feature/             feature tests
```

---

## Testing

```bash
php artisan test
```

The suite uses `RefreshDatabase` and an in-memory SQLite database, so it does not touch the
development MySQL database. It covers:

- public pages and the health endpoint,
- published/unpublished event visibility,
- contact form validation, storage, and rate limiting,
- admin sign-in, invalid credentials, login throttling, sign-out,
- redirection for guests and `403` responses for authenticated non-administrators,
- event create/update/delete and validation,
- contact message review and read/unread toggling,
- the `cso:create-admin` command.

Front-end assets are not required for the tests (`withoutVite` is used), but run `npm run build`
before deployment.

---

## Content policy

This repository must not present invented information as official:

- Do not add names of leaders, chaplains, or executives without confirmation.
- Do not add Mass times, phone numbers, email addresses, or social media links that have not been
  confirmed by the CSO.
- Do not add statistics, member counts, or achievements that cannot be verified.
- Any sample event or seeded content must set `is_demo = true` so the interface labels it as
  demonstration content.
- The SVG files in `public/images/` are illustrative placeholders, not photographs. Replace them
  with approved CSO photography (with permission from the people shown) when it is available.

Photography slots are already laid out on the homepage and About page, so approved images can be
dropped in without redesigning the pages.

---

## Security notes

- `.env` is ignored by Git. Never commit environment files, database dumps, credentials, or private
  member data.
- There is no public registration. Administrators are created with `php artisan cso:create-admin`.
- Login attempts are rate limited per email address and IP address.
- Contact submissions are rate limited and stored in the database; only administrators can read
  them.
- Set `APP_DEBUG=false` and use HTTPS in production. Consider enforcing secure session cookies at
  the web server level and keeping `composer`/`npm` dependencies updated.
- If you discover a security issue, report it privately to the repository maintainers rather than
  opening a public issue with exploit details.

---

## Deployment outline

1. Provision PHP 8.3+, MySQL 8, and a web server whose document root is the `public/` directory.
2. Create the production database and a least-privilege MySQL user.
3. Set production values in `.env` (`APP_ENV=production`, `APP_DEBUG=false`, `APP_URL=https://...`,
   database credentials). Never reuse development passwords.
4. Run `php artisan key:generate` once if `APP_KEY` is empty.
5. Install and build:
   ```bash
   composer install --no-dev --optimize-autoloader
   npm ci
   npm run build
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
6. Make `storage/` and `bootstrap/cache/` writable by the web server user.
7. Create administrator accounts with `php artisan cso:create-admin`.
8. Monitor `GET /health` for application and database health.

> Email delivery is not configured yet. Contact messages are stored in the database and visible in
> the admin inbox. Configure `MAIL_*` and add a notification before promising email follow-up to
> visitors.

---

## Pending work

The following are intentionally **not** implemented in this first vertical slice:

- password reset and email verification flows for administrators,
- email notifications when a contact message is submitted,
- a media library for uploading approved photography,
- announcements and richer event categories,
- official content: history, leadership, chaplaincy, Mass times, contact channels,
- a cookie/privacy notice and analytics (none are used yet),
- CI workflow running tests and the Vite build.

---

## Contributing

Please read
[CONTRIBUTING.md](https://github.com/moseschazama/MUST-CSO-system/blob/feat/cso-foundation/CONTRIBUTING.md)
(currently on the `feat/cso-foundation` branch) before opening a pull request. In short:

1. Branch from `main` using `feat/…`, `fix/…`, or `chore/…`.
2. Keep changes focused and add tests for new behaviour.
3. Run `php artisan test`, `vendor/bin/pint --test`, and `npm run build`.
4. Do not commit `.env`, credentials, database dumps, or unapproved personal data.
5. Label all demonstration content and never invent official CSO information.
