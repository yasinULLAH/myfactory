# FactoryOS - Enterprise Factory Management System

A production-ready Factory Management System built with native PHP 8.3 and MySQL.

## Features
- **MVC Architecture:** Custom-built lightweight framework.
- **Security:** CSRF protection, secure sessions, math captcha, and role-based access.
- **Inventory:** Batch tracking, warehouse management, and stock ledgers.
- **Manufacturing:** Multi-level BOM and complex Purchase Order workflows.
- **Customization:** User-specific theme engine (colors, fonts).
- **Integrity:** Encrypted backups and full audit trails.

## Installation
1. Clone the repository to your local server (XAMPP/WAMP/LAMP).
2. Create a database named `myfactory_db` in MySQL.
3. Import `database/schema.sql` into your database.
4. Run `php database/update_schema.php` and `php database/seed.php` from the CLI to add the advanced tables and seed data.
5. Update `config/database.php` with your credentials.
6. Point your web server to the `/public` directory.
7. Default Login: `admin` / `admin123` (Note: Update password after first login).

## Tech Stack
- Backend: PHP 8.3 (PDO)
- Frontend: Tailwind CSS, Animate.css
- Components: DataTables.net, SweetAlert2, Select2, JustValidate

Created by: **Yasin Ullah**
LinkedIn: [https://www.linkedin.com/in/yasin-ullah-029229232/](https://www.linkedin.com/in/yasin-ullah-029229232/)
WhatsApp: 03361593533
