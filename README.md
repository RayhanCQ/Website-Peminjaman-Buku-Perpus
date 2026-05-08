# PerpusKu

PerpusKu is a Laravel-based library management app for tracking books, members, loans, and returns in one tidy dashboard. It is built for a small campus/library workflow: admins manage the collection and circulation, while users browse available books and borrow them.

## What It Does

- Role-based login for `admin` and regular library users.
- Admin dashboard with total book titles and active loan counts.
- Book management with categories, stock totals, available stock, shelf location, and synopsis fields.
- Member overview with each user's borrowing history and active loans.
- Loan return flow that restores book availability automatically.
- User dashboard with active-loan and history counters.
- User book search by title or author before borrowing.
- Seeded sample data so the app feels alive immediately after setup.

## Tech Stack

- Laravel 12
- PHP 8.2+
- MySQL
- Blade templates
- Tailwind CSS through CDN in the current views
- Vite, Tailwind CSS, and Axios available through the frontend toolchain

## Quick Start

Install backend and frontend dependencies:

```bash
composer install
npm install
```

Create your environment file and app key:

```bash
cp .env.example .env
php artisan key:generate
```

Set up the MySQL database, then run migrations and seeders:

```bash
php artisan migrate --seed
```

Start the app:

```bash
php artisan serve
```

Open the local URL printed by Laravel, usually `http://127.0.0.1:8000`.

## Database Setup

The full database setup guide now lives in [docs/database-setup.md](docs/database-setup.md). It covers the `perpus_db` MySQL database, `.env` values, migrations, seed data, and the optional SQL dump import from [database/perpus_db.sql](database/perpus_db.sql).

## Demo Accounts

After running the seeder, you can use these accounts:

| Role | Login | Password |
| --- | --- | --- |
| Admin | `admin` | `password` |
| User | `chico@student.undip.ac.id` | `password` |
| User | `siti.a@gmail.com` | `password` |

The `admin` shortcut maps to `admin@perpus.local` in the login controller.

## Main Pages

| Area | Route | Purpose |
| --- | --- | --- |
| Login | `/` | Sign in as admin or user |
| Admin dashboard | `/admin/dashboard` | See collection and loan summary |
| Users | `/admin/users` | Review member borrowing activity |
| Returns | `/admin/pengembalian` | Record returned books |
| Books | `/admin/buku` | View available and empty-stock books |
| Add book | `/admin/buku/tambah` | Add a new book title |
| User dashboard | `/user/dashboard` | See personal loan summary |
| Borrowing | `/user/peminjaman` | Search and borrow books |

## Project Map

```text
app/Http/Controllers/   Request flow for auth, admin, books, and users
app/Models/             Eloquent models for users, books, categories, and loans
database/migrations/    Table definitions
database/seeders/       Demo accounts, books, categories, and loan history
database/perpus_db.sql  Optional SQL dump
resources/views/        Blade pages for login, admin, and user screens
routes/web.php          Web route list
```

## Useful Commands

```bash
php artisan migrate --seed   # Build database tables and seed sample data
php artisan test             # Run the Laravel test suite
npm run dev                  # Start Vite for frontend assets
npm run build                # Build frontend assets for production
```

## Notes

- The app expects MySQL by default and uses `perpus_db` as the database name.
- Default seeded passwords are only for local/demo usage.
- Returning a book increments `stok_tersedia`; borrowing decrements it inside a database transaction.
