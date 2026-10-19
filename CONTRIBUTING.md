# Contributing to the MUST CSO Website

Thank you for helping build the MUST Catholic Students Organisation website. This guide explains
how to set up the project, make changes, and submit them safely.

## 1. Set up your environment

Follow the [Local setup](README.md#local-setup) section of the README. You will need PHP 8.3+,
Composer, Node.js 20.19+ or 22.12+, npm, and MySQL 8.

Once the application runs locally:

```bash
php artisan test          # run the test suite
vendor/bin/pint --test    # check formatting
npm run build             # build front-end assets
```

Keep `APP_DEBUG=true` and `APP_ENV=local` in your local `.env` only. Never commit `.env` or any
credentials.

## 2. Branching

- `main` should remain in a deployable state.
- Create a branch for each change:
  - `feat/short-description` for new features,
  - `fix/short-description` for bug fixes,
  - `chore/short-description` for tooling or maintenance.
- Rebase or merge `main` into your branch before opening a pull request.

Examples:

```bash
git switch main
git pull
git switch -c feat/event-categories
```

## 3. Commit style

Use clear, conventional commit messages:

```
feat(events): add event category filter
fix(contact): correct validation message for short messages
chore(deps): update phpunit
```

Small, focused commits are easier to review than one large commit.

## 4. Making changes

### Backend

- Follow existing Laravel conventions and the structure already in `app/`.
- Validate request data with form requests (`app/Http/Requests`).
- Authorise admin actions through the `admin` middleware and the `is_admin` flag. Never trust
  user input for authorisation decisions.
- Use migrations for schema changes. Do not edit migrations that have already been merged and run
  in shared environments.
- Escape output in Blade by default (`{{ }}`); only use `{!! !!}` for content you have explicitly
  sanitised.

### Frontend

- Use the design tokens in `resources/css/app.css` (`burgundy`, `ivory`, `gold`, `charcoal`,
  `font-serif`, `font-sans`) rather than introducing new colours or fonts.
- Build reusable Blade components in `resources/views/components` instead of duplicating markup.
- Keep JavaScript minimal and progressive: pages must remain usable without JavaScript.
- Follow accessibility basics: semantic landmarks, visible labels, keyboard-operable controls,
  `aria-*` attributes where needed, visible focus states, and alt text for images.
- Run `npm run build` before submitting to confirm the production build succeeds.

### Content rules

This is a public-facing site for a real community. Accuracy matters more than speed:

- **Never invent** leadership names, chaplaincy details, Mass times, contact information,
  statistics, or institutional endorsements.
- Pending information should be described as pending, not guessed.
- Any sample or seeded content must set `is_demo = true`. The interface labels these entries as
  demonstration content.
- Do not commit photographs of identifiable people without permission, and do not commit private
  data (for example, real contact form submissions or member lists).
- The artwork in `public/images/` is illustrative placeholder art. Replace it only with approved
  photography.

## 5. Tests

Every behaviour change should come with a test:

```bash
php artisan test
```

- Tests live in `tests/Feature` and use `RefreshDatabase`.
- The test suite uses an in-memory SQLite database; it never touches your local MySQL data.
- Tests must not require network access, a mail service, or a queue worker.
- Security boundaries (authentication, authorisation, validation, throttling) should always have
  tests.

## 6. Formatting and quality checks

Before opening a pull request:

```bash
vendor/bin/pint          # fix formatting
vendor/bin/pint --test   # verify formatting in CI style
php artisan test
npm run build
```

## 7. Pull requests

Include:

- what the change does and why,
- any content approval that is still outstanding,
- screenshots for visual changes (before/after where relevant),
- the commands you ran and their results,
- any migration or deployment steps.

Do not push directly to `main`. Open a pull request and wait for review.

## 8. Security

- Never commit `.env`, database dumps, API keys, passwords, or tokens.
- Report security issues privately to the maintainers rather than in a public issue.
- Treat contact form submissions as private data.
- Keep dependencies current, and review changes to `composer.lock` and `package-lock.json` as part
  of code review.

## 9. Questions

If anything in this guide is unclear, open an issue describing what you are trying to do and where
you got stuck. Clear questions help improve this guide for the next contributor.
