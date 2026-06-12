# FactoryOS

FactoryOS is a lightweight factory management system built with native PHP and MySQL using a custom MVC structure. It is designed for small to mid-sized manufacturing workflows that need a simple, self-hosted admin panel for master data, procurement, stock tracking, quality control, and role-based access.

This project is currently best described as a practical in-progress ERP-style admin system: several core flows are implemented and usable, while some modules still need expansion and refinement.

## Highlights

- Native PHP MVC structure with custom routing
- MySQL-backed data layer using PDO
- Login flow with session handling and math CAPTCHA
- Role and permission system with super admin access
- User and role management with CRUD permissions
- Master data management for factories, products, and suppliers
- Inventory foundations for warehouses and stock ledger entries
- Procurement flow for purchase orders and PO items
- Production BOM management
- Quality control, maintenance, sales, HR, reports, and settings modules
- Personalized UI settings stored per user
- Responsive admin layout with desktop sidebar and mobile bottom navigation
- DataTables, Select2, SweetAlert2, JustValidate, Tailwind CSS

## Tech Stack

- PHP 8+
- MySQL / MariaDB
- PDO
- Apache with `mod_rewrite`
- Tailwind CSS via CDN
- jQuery
- DataTables
- Select2
- SweetAlert2
- JustValidate
- Animate.css

## Project Structure

```text
app/
  Controllers/
  Core/
  Helpers/
  Models/
  Views/
config/
database/
public/
routes/
tests/
```

## Current Modules

Implemented or partially implemented modules in this repository:

- Authentication
- Dashboard
- Factories
- Products
- Suppliers
- Warehouses
- Stock
- Purchase Orders
- BOM
- Quality Control
- Maintenance
- Sales
- HR
- Reports
- Settings
- Users and Roles

## Requirements

Before running the project, make sure your environment has:

- PHP 8 or newer
- MySQL or MariaDB
- Apache with URL rewriting enabled
- PHP extensions:
  - `pdo`
  - `pdo_mysql`
  - `gd`

## Local Setup

1. Clone the repository into your web root.
2. Create a database named `myfactory_db`.
3. Update database credentials in [`config/database.php`](config/database.php).
4. Import [`database/schema.sql`](database/schema.sql).
5. Run the schema update script:

```bash
php database/update_schema.php
```

6. Run the role and permission migration:

```bash
php migrate_roles.php
```

7. Make sure Apache rewrite rules are enabled and the included `.htaccess` files are respected.
8. Open the app from your browser using the configured base path, which is currently `/myfactory`.

## Default Login

The base schema seeds one admin account:

- Username: `admin`
- Password: `admin123`

Change credentials and database settings before using the project outside local development.

## Configuration Notes

- Database settings live in [`config/database.php`](config/database.php)
- App path settings live in [`config/app.php`](config/app.php)
- If you deploy the app under a different folder name, update the configured base path accordingly

## Routing

The application uses a custom front-controller and route table defined in [`routes/web.php`](routes/web.php). Requests are rewritten into the PHP entry point through:

- [`.htaccess`](.htaccess)
- [`public/.htaccess`](public/.htaccess)

## Security Notes

This repository is fine for learning, demos, and iterative self-hosting, but if you plan to expose it publicly you should review and harden it before production use.

Recommended before public deployment:

- Replace local database credentials
- Force HTTPS
- Review session and cookie settings
- Add CSRF protection to all state-changing forms if missing in your branch
- Audit file permissions and backup storage
- Rate-limit login attempts
- Review error handling and logging

## Known Status

This codebase is under active development. Some modules are more complete than others, and some views or workflows may still need polishing or expansion depending on your use case.

If you publish this repository, it is a good idea to describe it as:

- a custom PHP factory management system
- a self-hosted manufacturing admin starter
- an in-progress ERP-style internal operations app

## Roadmap Ideas

- Full supplier, warehouse, and stock management UX polish
- Better reporting and printable exports
- More complete QC and maintenance workflows
- Audit log explorer UI
- Password reset and stronger auth hardening
- Automated backups and restore UI
- API layer for external integrations

## Author

Created by Yasin Ullah

- LinkedIn: [Yasin Ullah](https://www.linkedin.com/in/yasin-ullah-029229232/)
- WhatsApp: `03361593533`
