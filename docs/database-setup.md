# Database Setup

This project is configured for MySQL with the database name `perpus_db`.

## 1. Create the Database

Create the database in MySQL:

```sql
CREATE DATABASE perpus_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

## 2. Configure `.env`

Copy `.env.example` to `.env`, then make sure the database section matches your local MySQL user:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=perpus_db
DB_USERNAME=root
DB_PASSWORD=
```

If your MySQL user has a password, fill `DB_PASSWORD` with that value.

## 3. Run Migrations and Seed Data

Run the migrations and seed the demo data:

```bash
php artisan migrate --seed
```

The seeder creates:

- An admin account
- Two user accounts
- Book categories
- Sample books
- Sample loan and return history

## 4. Optional SQL Dump Import

You can also import [database/perpus_db.sql](../database/perpus_db.sql) directly through phpMyAdmin, MySQL Workbench, or the MySQL CLI.

If you use the SQL dump, make sure `.env` still points to the same database:

```env
DB_DATABASE=perpus_db
```

## Demo Credentials

| Role | Login | Password |
| --- | --- | --- |
| Admin | `admin` | `password` |
| User | `chico@student.undip.ac.id` | `password` |
| User | `siti.a@gmail.com` | `password` |
