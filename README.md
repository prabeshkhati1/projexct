# AI-Solutions — CET333 Product Development Prototype

A PHP + MySQL web prototype for the CET333 Product Development assignment
(Computer Systems Engineering). It promotes an AI software start-up: services,
past work, articles, events, feedback, a contact form, and a password-protected
admin dashboard.

- **Stack:** HTML5, CSS3, vanilla JavaScript, PHP 8+, MySQL / MariaDB
- **Security:** PDO prepared statements, output escaping, dual client + server
  validation, bcrypt password hashing, CSRF-protected admin actions, session
  hardening.
- **Config:** environment-driven (`.env`), so the same code runs on XAMPP and on
  a host without editing source files.

---

## Pages

- `index.php` — home (hero, services, past work, events, articles, feedback).
- `solutions.php` — services / past work with search, filters, sort, detail modals.
- `articles.php`, `article-detail.php` — articles listing and detail.
- `events.php`, `event-detail.php`, `register-event.php` — events, gallery, registration.
- `feedback.php` — review form (star rating) with admin moderation.
- `contact.php` — job-requirement enquiry form.
- `admin-login.php` + `admin-*.php` — protected dashboard, enquiries, registrations, review moderation.
- `install.php` — one-click database/table creator (dev only).

---

## 1) Run locally with XAMPP (recommended for the assignment)

1. Copy the `ai-solutions-cet333` folder into `C:\xampp\htdocs\`.
2. Start **Apache** and **MySQL** in the XAMPP control panel.
3. Create the database using **either** option:
   - Open `http://localhost/ai-solutions-cet333/install.php`, **or**
   - Open phpMyAdmin → Import → `database/ai_solutions.sql`.
4. Open `http://localhost/ai-solutions-cet333/index.php`.

No `.env` is needed on XAMPP — the defaults (`localhost`, user `root`, blank
password) already match XAMPP.

### Configuration (optional)

Copy `.env.example` to `.env` to override any setting (DB credentials, admin
login, etc.). Values already set in the real environment always win over `.env`.

---

## 2) Push to GitHub

```bash
cd ai-solutions-cet333
git init
git add .
git commit -m "AI-Solutions CET333 prototype"
git branch -M main
git remote add origin https://github.com/<your-username>/<repo>.git
git push -u origin main
```

`.gitignore` already excludes `.env`, `vendor/`, and OS junk, so no secrets are
committed.

---

## 3) Deploy to Vercel

> **Important reality check.** Vercel is a serverless JavaScript-first platform.
> It does **not** run PHP natively and does **not** host MySQL. This project
> deploys using the community **`vercel-php`** runtime (already configured in
> `vercel.json`), but you must provide an **external MySQL database** and be
> aware of the serverless limitations below.

### Steps

1. Create a **managed MySQL database** (any of these work):
   - [Railway](https://railway.app), [Aiven](https://aiven.io),
     [Clever Cloud](https://clever-cloud.com), [FreeSQLDatabase](https://freesqldatabase.com).
2. Import `database/ai_solutions.sql` into that database (via the provider's
   console or a MySQL client). `install.php` usually **cannot** run on managed
   MySQL because it lacks `CREATE DATABASE` rights — import the SQL instead.
3. Import the GitHub repo into Vercel (New Project → Import).
4. In **Vercel → Project → Settings → Environment Variables**, set:

   | Key | Example value |
   |---|---|
   | `DB_HOST` | `your-db-host.provider.com` |
   | `DB_PORT` | `3306` |
   | `DB_NAME` | `ai_solutions` |
   | `DB_USER` | `your_user` |
   | `DB_PASS` | `your_password` |
   | `DB_SSL` | `1` (most managed MySQL require TLS) |
   | `ADMIN_USERNAME` | `admin` |
   | `ADMIN_PASSWORD` | *(a strong password)* |
   | `DISABLE_INSTALL` | `1` |

5. Deploy. `vercel.json` maps every `*.php` file to the PHP runtime and rewrites
   `/` to `index.php`; the `assets/` folder is served as static files.

### Known Vercel limitations (please read)

- **Admin login can be unreliable on Vercel.** PHP file-based sessions live in a
  temporary per-invocation container, so a serverless cold start can drop the
  login session. Public pages and forms work fine; the admin area is best
  demonstrated locally (XAMPP) or on a PHP-native host.
- `install.php` is disabled in production via `DISABLE_INSTALL=1`. Import the SQL
  manually instead.

### Easier alternatives that run this app fully (with working sessions)

If you want a smoother “just works” PHP + MySQL deployment, consider a
PHP-native host instead of / in addition to Vercel:

- **Railway** or **Render** (PHP + MySQL together)
- **InfinityFree** / **000webhost** (free classic PHP + MySQL hosting)
- Any cheap shared cPanel host or a small VPS

Upload the files, import `database/ai_solutions.sql`, set the DB env vars (or edit
`.env`), and it runs exactly like it does on XAMPP.

---

## Default admin login

- Username: `admin`
- Password: `Admin@123`

**Change these before any real deployment** (set `ADMIN_USERNAME` /
`ADMIN_PASSWORD` env vars, and update the `admin_users` row). They exist only for
prototype demonstration.

---

## Validation rules (client + server)

Both live browser validation and matching server-side PHP validation are applied:

- **Full name / Job title:** required, letters only (no numbers).
- **Company name:** required, must include letters; cannot be numbers only.
- **Email:** required, valid format, must end with `@gmail.com`.
- **Phone:** required, digits only, 8–10 digits.
- **Country:** required, must be selected from the country list.
- **Job details / review:** required with min/max length checks.
- **Event registration:** upcoming events only; past events are blocked.
- **Feedback:** stored as `pending` until an admin approves it.

---

## What was hardened in this version

- Environment-driven configuration (`.env`) — no credentials in source.
- bcrypt password hashing with `password_verify` (legacy SHA-256 still accepted).
- CSRF tokens on admin login and review-moderation forms.
- `session_regenerate_id()` on login (session-fixation protection).
- Removed trailing `?>` from include files (prevents “headers already sent”).
- Safer DB layer (connection timeout, TLS support, query errors logged not shown).
- `install.php` can be disabled in production (`DISABLE_INSTALL=1`).
- Added `.gitignore`, `.env.example`, `LICENSE`, `composer.json`, `vercel.json`.

---

## License

MIT — see [`LICENSE`](LICENSE).
