# FactoryOS / فیکٹری او ایس

**Enterprise Factory Management System**

---

## TABLE OF CONTENTS / فہرست مضامین

1. [Introduction / تعارف](#introduction--تعارف)
2. [Technology Stack / تکنیکی انفراسٹرکچر](#technology-stack--تکنیکی-انفراسٹرکچر)
3. [System Requirements / سسٹم کے تقاضے](#system-requirements--سسٹم-کے-تقاضے)
4. [Installation Guide / انسٹالیشن گائیڈ](#installation-guide--انسٹالیشن-گائیڈ)
5. [Default Login / ڈیفالٹ لاگ ان](#default-login--ڈیفالٹ-لاگ-ان)
6. [Complete Module Documentation / مکمل ماڈیول دستاویزات](#complete-module-documentation--مکمل-ماڈیول-دستاویزات)
7. [Database Schema / ڈیٹا بیس اسکیما](#database-schema--ڈیٹا-بیس-اسکیما)
8. [User Roles & Permissions / صارف کے کردار اور اجازات](#user-roles--permissions--صارف-کے-کردار-اور-اجازات)
9. [Security Features / سیکیورٹی فیچرز](#security-features--سیکیورٹی-فیچرز)
10. [Project File Structure / فائل سٹرکچر](#project-file-structure--فائل-سٹرکچر)
11. [Current Status & Roadmap / موجودہ حالت اور روڈ میپ](#current-status--roadmap--موجودہ-حالت-اور-روڈ-میپ)
12. [Support / رابطہ](#support--رابطہ)

---

## Introduction / تعارف

**English:**

FactoryOS is a lightweight, self-hosted factory management system and mini-ERP admin panel designed for small-to-mid-sized manufacturing workflows. It provides a centralized web-based platform to manage master data, procurement, inventory tracking, production planning, quality control, machine maintenance, human resources, sales, and user access control. Every action is logged for audit purposes, and the system includes role-based access control (RBAC) so different staff members only see and interact with modules relevant to their responsibilities.

**اردو:**

فیکٹری او ایس ایک ہلکی اور خود میزبان فیکٹری مینجمنٹ سسٹم ہے جو چھوٹی سے درمیانے درجے کی مینوفیکچرنگ کمپنیوں کے لیے ڈیزائن کیا گیا ہے۔ یہ ایک مرکزی ویب پلیٹ فارم فراہم کرتا ہے جس کے ذریعے آپ فیکٹری کا تمام ڈیٹا، خریداری، اسٹاک کی نگرانی، پروڈکشن پلاننگ، کوالٹی کنٹرول، مشین کی دیکھ بھال، انسانی وسائل، فروخت، اور صارفین کے رسائی کنٹرول کو مینج کر سکتے ہیں۔ ہر عمل آڈٹ مقاصد کے لیے ریکارڈ کیا جاتا ہے، اور رول بیسڈ ایکسیس کنٹرول (RBAC) کی وجہ سے ہر عملہ صرف ان ماڈیولز کو دیکھ اور استعمال کر سکتا ہے جو اس کی ذمہ داریوں سے متعلق ہوں۔

---

## Technology Stack / تکنیکی انفراسٹرکچر

| Layer | Technology | Purpose |
|-------|------------|---------|
| **Backend** | Native PHP 8.3+ | Core application logic with custom MVC architecture |
| **Database** | MySQL / MariaDB | Primary relational data store |
| **Database Access** | PDO with prepared statements | Secure, injection-safe database queries |
| **Web Server** | Apache with `mod_rewrite` | URL rewriting and clean routing |
| **Frontend CSS** | Tailwind CSS (CDN) | Modern responsive styling |
| **Frontend JS** | jQuery 3.7.1 | DOM manipulation and AJAX |
| **Tables** | DataTables 1.13.6 + Responsive 2.5.0 | Sortable, searchable, paginated tables |
| **Dropdowns** | Select2 4.1.0 | Searchable dropdowns with keyboard support |
| **Alerts** | SweetAlert2 v11 | Toast notifications and confirmation dialogs |
| **Validation** | JustValidate | Client-side form validation |
| **Animations** | Animate.css 4.1.1 | Page and modal entrance animations |
| **Tabs** | Alpine.js 3.x | Used on User Management page for tab switching |
| **Icons** | Font Awesome 6.4.2 | UI icons |
| **Image** | GD Library | Dynamic math CAPTCHA generation |

---

## System Requirements / سسٹم کے تقاضے

**English:**

- PHP 8.0 or newer
- MySQL 5.7+ or MariaDB 10.3+
- Apache web server with `mod_rewrite` enabled
- PHP extensions:
  - `pdo`
  - `pdo_mysql`
  - `gd` (for CAPTCHA generation)
- A web root directory where the application folder can be placed

**اردو:**

- پی ایچ پی 8.0 یا اس سے نیا ورژن
- مائی ایس کیو ایل 5.7+ یا ماریا ڈی بی 10.3+
- Apache ویب سرور جس میں `mod_rewrite` فعال ہو
- پی ایچ پی ایکسٹینشنز:
  - `pdo`
  - `pdo_mysql`
  - `gd` (CAPTCHA بنانے کے لیے)
- ایک ویب روٹ ڈائریکٹری جہاں ایپلی کیشن فولڈر رکھا جا سکے

---

## Installation Guide / انسٹالیشن گائیڈ

**English:**

1. **Clone or copy** the project folder into your web server root (e.g., `C:\phpserver\www\myfactory` or `/var/www/html/myfactory`).
2. **Create a database** named `myfactory_db` in MySQL/MariaDB.
3. **Update database credentials** in `config/database.php` with your host, database name, username, and password.
4. **Import the base schema:**
   ```bash
   php database/schema.sql
   ```
   Or import via phpMyAdmin.
5. **Run the schema update script** to add production/BOM/QC tables:
   ```bash
   php database/update_schema.php
   ```
6. **Run the role migration** to create roles and permissions:
   ```bash
   php migrate_roles.php
   ```
7. **Seed demo data** (optional but recommended):
   ```bash
   php database/seed.php
   ```
8. **Ensure Apache rewrite rules are active.** The `.htaccess` files in the root and `public/` folder handle URL rewriting automatically.
9. **Open the app** in your browser at the configured base path (default: `/myfactory`).

**اردو:**

1. **پروجیکٹ فولڈر** کو اپنے ویب سرور روٹ میں کاپی کریں (مثلاً `C:\phpserver\www\myfactory`)۔
2. **ڈیٹا بیس بنائیں** `myfactory_db` نام سے مائی ایس کیو ایل میں۔
3. **ڈیٹا بیس کریڈنشلز** کو `config/database.php` میں اپ ڈیٹ کریں۔
4. **بیس اسکیما امپورٹ کریں** `database/schema.sql` فائل سے۔
5. **اسکیما اپ ڈیٹ سکرپٹ چلائیں** تاکہ پروڈکشن، BOM، اور QC ٹیبلز بن جائیں:
   ```bash
   php database/update_schema.php
   ```
6. **رولز مائیگریشن چلائیں** تاکہ صارفین کے کردار اور اجازات کا نظام قائم ہو:
   ```bash
   php migrate_roles.php
   ```
7. **ڈیمو ڈیٹا شامل کریں** (اختیاری لیکن تجویز شدہ):
   ```bash
   php database/seed.php
   ```
8. **Apache rewrite rules** فعال ہیں یقینی بنائیں۔
9. **براؤزر میں ایپ کھولیں** `/myfactory` پر۔

---

## Default Login / ڈیفالٹ لاگ ان

| Field | Value |
|-------|-------|
| **Username** | `admin` |
| **Password** | `admin123` |
| **Role** | Super Admin |

> **Important:** Change the default password immediately after first login.

---

## Complete Module Documentation / مکمل ماڈیول دستاویزات

This section describes every module, what it does, how it affects other parts of the system, and how to use it. / اس حصے میں ہر ماڈیول کی تفصیل، اس کا کام، دوسرے حصوں پر اس کے اثرات، اور استعمال کا طریقہ بیان کیا گیا ہے۔

---

### 1. Authentication & Session Security / تصدیق اور سیشن سیکیورٹی

**English:**

The Authentication module is the entry gate to FactoryOS. It ensures only verified users can access the system.

**Features:**
- **Login Page:** Accessible at `/login`. Requires username, password, and a dynamic math CAPTCHA.
- **Math CAPTCHA:** Generated using PHP GD library. Displays a simple addition/subtraction problem (numbers 1-9) with noise dots and lines to prevent bot attacks. The CAPTCHA image refreshes on each load.
- **Password Verification:** Uses PHP `password_verify()` with bcrypt hashes.
- **Account Status Check:** Only `active` accounts can log in. `inactive` or `locked` accounts are rejected.
- **Session Regeneration:** On successful login, the session ID is regenerated to prevent session fixation attacks.
- **Session Storage:** Stores `user_id`, `role`, `full_name`, `last_activity`, and personalized `theme` in the PHP session.
- **Idle Timeout:** 40 minutes of inactivity automatically logs the user out.
- **Absolute Timeout:** Maximum session duration is 8 hours, after which re-login is required.
- **Logout:** Immediately destroys the session and redirects to the login page.

**Effect throughout the app:** Every page (except login and CAPTCHA) checks for an active session. Expired or invalid sessions redirect to `/login`. The user's role and permissions determine which sidebar links appear and which API endpoints allow access.

**اردو:**

تصدیق کا ماڈیول FactoryOS کا داخلہ دروازہ ہے۔ یہ یقینی بناتا ہے کہ صرف تصدیق شدہ صارفین ہی سسٹم تک رسائی حاصل کر سکیں۔

**خصوصیات:**
- **لاگ ان صفحہ:** `/login` پر دستیاب۔ صارف نام، پاس ورڈ، اور متحرک ریاضی CAPTCHA درکار ہے۔
- **ریاضی CAPTCHA:** پی ایچ پی GD لائبریری سے بنایا جاتا ہے۔ شور نقطوں اور لکیروں کے ساتھ ایک سادہ جمع/تفریق کا مسئلہ دکھایا جاتا ہے تاکہ بوٹ حملوں سے بچا جا سکے۔
- **پاس ورڈ تصدیق:** `password_verify()` کے ساتھ bcrypt ہیش استعمال ہوتا ہے۔
- **اکاؤنٹ سٹیٹس:** صرف `active` اکاؤنٹ لاگ ان کر سکتے ہیں۔ `inactive` یا `locked` اکاؤنٹس مسترد۔
- **سیشن ری جینریشن:** کامیاب لاگ ان پر سیشن ID تبدیل ہوتا ہے تاکہ سیشن فکسیشن سے بچا جا سکے۔
- **خاموشی ٹائم آؤٹ:** 40 منٹ کی بے حرکتی پر خودکار لاگ آؤٹ۔
- **مکمل ٹائم آؤٹ:** 8 گھنٹے کے بعد دوبارہ لاگ درکار۔
- **لاگ آؤٹ:** فوری سیشن ختم کرتا ہے۔

**پورے ایپ پر اثر:** ہر صفحہ (لاگ ان اور CAPTCHA کے علاوہ) فعال سیشن چیک کرتا ہے۔ صارف کا کردار اور اجازات یہ طے کرتے ہیں کہ کن مینو آئٹمز اور API کو رسائی ملے گی۔

---

### 2. Dashboard / ڈیش بورڈ

**English:**

The Dashboard is the first screen after login. It provides a high-level executive summary of factory operations.

**Features:**
- **4 KPI Cards:**
  1. **Total Products:** Count of all products registered in the system (raw materials + finished goods).
  2. **Pending Orders:** Count of purchase orders with `pending` status.
  3. **Suppliers:** Total number of active suppliers.
  4. **System Status:** Always displays "Optimal" as a health indicator.
- **Recent Purchase Orders:** A table showing the last 5 purchase orders with PO number, supplier name, date, and status badge.
- **Quick Action:** A "New PO" button that navigates directly to the Procurement creation form.

**Effect throughout the app:** The Dashboard pulls live data from `products`, `purchase_orders`, and `suppliers` tables. As you add products, create POs, or register suppliers, these numbers update immediately on next refresh.

**اردو:**

ڈیش بورڈ لاگ ان کے بعد پہلا سکرین ہے۔ یہ فیکٹری آپریشنز کا اعلیٰ سطحی خلاصہ پیش کرتا ہے۔

**خصوصیات:**
- **4 KPI کارڈز:**
  1. **کل مصنوعات:** سسٹم میں رجسٹرڈ تمام مصنوعات کی تعداد۔
  2. **زیر التوا آرڈرز:** `pending` حالت میں خریداری آرڈرز کی تعداد۔
  3. **سپلائرز:** کل فعال سپلائرز۔
  4. **سسٹم سٹیٹس:** صحت کا اشارہ "Optimal" دکھاتا ہے۔
- **حالیہ خریداری آرڈرز:** آخری 5 POs کی فہرست۔
- **فوری ایکشن:** "New PO" بٹن براہ راست خریداری فارم پر لے جاتا ہے۔

**پورے ایپ پر اثر:** ڈیش بورڈ `products`، `purchase_orders`، اور `suppliers` ٹیبلز سے براہ راست ڈیٹا لیتا ہے۔ نئی مصنوعات یا آرڈرز شامل کرنے پر یہ نمبر فوری تازہ ہو جاتے ہیں۔

---

### 3. Master Data Management / بنیادی ڈیٹا مینجمنٹ

Master Data is the foundation of the entire system. All other modules (Inventory, Procurement, Production, QC, Maintenance) reference these records. / بنیادی ڈیٹا پورے سسٹم کی بنیاد ہے۔ باقی تمام ماڈیولز ان ریکارڈز کا حوالہ دیتے ہیں۔

#### 3A. Factories / فیکٹریاں

**English:**
- **What it does:** Registers manufacturing plants or factory buildings.
- **Fields:** Name, Location, Contact Number, Status (active/inactive).
- **How to use:** Navigate to Master Data > Factories. Click "Add Factory" to open a modal. Fill the form and save. Use the Edit or Delete buttons on any row to modify.
- **Effect:** Factories are parent entities for Warehouses and Machines. You cannot create a warehouse or assign a machine without first creating a factory. Changing a factory's status to `inactive` does not automatically disable its warehouses, but it signals that the plant is not in use.

**اردو:**
- **کام:** مینوفیکچرنگ پلانٹس یا فیکٹری عمارتوں کو رجسٹر کرنا۔
- **فیلڈز:** نام، مقام، رابطہ نمبر، حالت۔
- **استعمال:** Master Data > Factories پر جائیں۔ "Add Factory" پر کلک کریں۔
- **اثر:** فیکٹریاں Warehouses اور Machines کی والدینٹیٹی ہیں۔ فیکٹری بنائے بغیر گودام یا مشین نہیں بن سکتی۔

#### 3B. Products / مصنوعات

**English:**
- **What it does:** Registers every item that flows through the factory.
- **Fields:** SKU (unique stock-keeping unit), Name, Type (`raw_material`, `finished_good`, `semi_finished`), Reorder Level, Price, Status.
- **How to use:** Navigate to Master Data > Products. The list shows all products with their type and status.
- **Effect:** Products are used everywhere:
  - **Inventory:** Stock entries reference products.
  - **Procurement:** Purchase order line items reference products.
  - **Production:** BOMs (Bill of Materials) reference products as both parent finished goods and child raw materials.
  - **QC:** Quality checks reference products indirectly via PO or production order.
- **Reorder Level:** This is a numeric threshold. When stock falls below this value, the system is ready (in future versions) to trigger low-stock alerts.

**اردو:**
- **کام:** فیکٹری سے گزرنے والی ہر چیز کو رجسٹر کرنا۔
- **فیلڈز:** SKU (منفرد کوڈ)، نام، قسم (خام مال، تیار شدہ، نیم تیار)، ری آرڈر لیول، قیمت، حالت۔
- **اثر:** مصنوعات ہر جگہ استعمال ہوتی ہیں — اسٹاک، خریداری، پروڈکشن BOM، اور کوالٹی کنٹرول میں۔
- **ری آرڈر لیول:** یہ ایک نمبر ہے جب اسٹاک اس سے کم ہو تو مستقبل میں الرٹ بھیجا جا سکتا ہے۔

#### 3C. Suppliers / سپلائرز

**English:**
- **What it does:** Maintains a directory of vendors who supply raw materials or services.
- **Fields:** Name, Email, Phone, Address, Status.
- **How to use:** Navigate to Master Data > Suppliers. Add, edit, or delete suppliers via modal forms.
- **Effect:** Suppliers are linked directly to Purchase Orders. When creating a PO, you select a supplier from this list. The supplier's name and contact info appear on the PO record and dashboard.

**اردو:**
- **کام:** خام مال یا خدمات فراہم کرنے والے وینڈرز کی ڈائریکٹری۔
- **فیلڈز:** نام، ای میل، فون، پتہ، حالت۔
- **اثر:** سپلائرز براہ راست خریداری آرڈرز سے منسلک ہوتے ہیں۔ PO بناتے وقت یہاں سے سپلائر منتخب کیا جاتا ہے۔

---

### 4. Inventory & Warehouse Management / انوینٹری اور گودام مینجمنٹ

#### 4A. Warehouses / گودام

**English:**
- **What it does:** Defines storage locations inside factories.
- **Fields:** Factory (dropdown linking to Factories), Name, Location.
- **How to use:** Navigate to Inventory > Warehouses. Each warehouse must belong to a factory.
- **Effect:** All stock is stored inside a warehouse. Without warehouses, you cannot record inventory. The factory-warehouse relationship allows you to organize inventory by physical plant.

**اردو:**
- **کام:** فیکٹری کے اندر ذخیرہ کرنے کی جگہوں کی وضاحت۔
- **فیلڈز:** فیکٹری (ڈراپ ڈاؤن)، نام، مقام۔
- **اثر:** تمام اسٹاک گودام میں محفوظ ہوتا ہے۔ گودام کے بغیر انوینٹری ریکارڈ نہیں ہو سکتی۔

#### 4B. Stock / اسٹاک

**English:**
- **What it does:** Tracks current inventory balances per warehouse and product batch.
- **Fields:** Warehouse (dropdown), Product (dropdown), Batch Number, Quantity, Expiry Date.
- **How to use:** Navigate to Inventory > Stock to see all stock records. Navigate to Inventory > Stock Inward to add new goods receipt entries (GRN).
- **Effect:** Stock is the live inventory ledger. When you receive goods against a Purchase Order, stock quantities increase. In future modules, production consumption will decrease stock. The batch number and expiry date support FIFO/FEFO traceability for industries like food and pharma.

**اردو:**
- **کام:** ہر گودام اور پروڈکٹ بیچ کے موجودہ اسٹاک کا حساب رکھنا۔
- **فیلڈز:** گودام، مصنوعات، بیچ نمبر، مقدار، ختم ہونے کی تاریخ۔
- **استعمال:** Inventory > Stock پر فہرست دیکھیں۔ Inventory > Stock Inward پر نیا سامان داخل کریں۔
- **اثر:** اسٹاک لائو انوینٹری لیجر ہے۔ خریداری پر سامان وصول ہونے پر مقدار بڑھتی ہے۔ بیچ نمبر اور ایکسپائری تاریخ FIFO/FEFO ٹریسیبیلٹی کے لیے ہے۔

---

### 5. Procurement Management / خریداری مینجمنٹ

**English:**

The Procurement module handles the full purchase order lifecycle from creation to receipt.

**Features:**
- **PO List:** Displays all purchase orders in a DataTable with sorting, searching, and pagination. Columns include PO Number, Supplier, Date, Total Amount, and Status (pending/approved/received/cancelled).
- **Create PO:** A form with:
  - Supplier selection (Select2 dropdown)
  - Order date
  - Dynamic line items: add/remove rows, each containing Product (Select2), Quantity, and Unit Price
  - Auto-calculated total amount as you type
  - JustValidate client-side validation
- **View PO:** Opens a detail page showing the PO header and all line items.
- **Status Flow:** `pending` → `approved` → `received` (or `cancelled` at any stage).

**How to use:**
1. Go to Procurement.
2. Click "New PO" (or the button on Dashboard).
3. Select a supplier.
4. Add line items by clicking "Add Item". Choose products, enter quantity and price.
5. Submit. The PO appears in the list with `pending` status.

**Effect throughout the app:**
- New POs increase the "Pending Orders" count on the Dashboard.
- PO records feed into the "Recent Purchase Orders" table on the Dashboard.
- PO statuses can trigger future QC inspections (incoming material inspection).
- PO total amounts feed into procurement cost reporting (when reports module is expanded).

**اردو:**

یہ ماڈیول خریداری آرڈر کے مکمل چکر کو بنانے سے لے کر وصولی تک ہینڈل کرتا ہے۔

**خصوصیات:**
- **PO فہرست:** تمام خریداری آرڈرز DataTable میں دکھائے جاتے ہیں۔
- **PO بنانا:** فارم میں سپلائر، تاریخ، اور متحرک لائن آئٹمز شامل ہیں۔ ہر آئٹم میں مصنوعات، مقدار، اور یونٹ قیمت ہوتی ہے۔ کل رقم خودکار حساب ہوتی ہے۔
- **PO دیکھنا:** تفصیلی صفحہ سر اور لائن آئٹمز دکھاتا ہے۔
- **حالت کا بہاؤ:** `pending` → `approved` → `received` (یا `cancelled`)۔

**اثر:** نئے POs ڈیش بورڈ پر "Pending Orders" بڑھاتے ہیں۔ PO ریکارڈز "Recent Purchase Orders" میں دکھائے جاتے ہیں۔ مستقبل میں QC انسپکشن کا ٹرگر بن سکتے ہیں۔

---

### 6. Production Management / پروڈکشن مینجمنٹ

#### 6A. Bill of Materials (BOM) / بل آف میٹیریلز

**English:**
- **What it does:** Defines the recipe or formula for manufacturing a finished good. A BOM lists all raw materials and their quantities required to produce one unit of a finished product.
- **Fields:** Product (finished good), BOM Name, Version, Status, and dynamic component rows (Raw Material + Quantity).
- **How to use:** Navigate to Production > BOM. The list shows existing BOMs. Click "Create BOM" to open a modal. Select the finished product, give the BOM a name, then add raw material components with quantities.
- **Effect:** BOMs are the blueprint for production. When a production order is created, it references a BOM to know exactly which materials to consume and in what quantities. Changing a BOM version allows you to update product recipes without losing historical production data.

**اردو:**
- **کام:** تیار شدہ مصنوعات کی ترکیب یا فارمولے کی وضاحت۔ BOM میں تمام خام مال اور ان کی مقدار بتائی جاتی ہے جو ایک یونٹ بنانے کے لیے درکار ہے۔
- **فیلڈز:** مصنوعات (تیار شدہ)، BOM نام، ورژن، حالت، اور متحرک جزو قطاریں (خام مال + مقدار)۔
- **استعمال:** Production > BOM پر جائیں۔ "Create BOM" سے نیا BOM بنائیں۔
- **اثر:** BOMs پروڈکشن کے نقشے ہیں۔ پروڈکشن آرڈر BOM کا حوالہ دیتا ہے تاکہ معلوم ہو کہ کن materals کو کتنی مقدار میں استعمال کرنا ہے۔

---

### 7. Quality Control (QC) / کوالٹی کنٹرول

**English:**
- **What it does:** Records inspection results for incoming materials or finished production batches.
- **Fields:** Reference Type (PO or Production), Reference ID, Inspector (user), Inspection Date, Status (passed/failed), Remarks.
- **How to use:** Navigate to QC. The list shows all inspection records with inspector names and statuses.
- **Effect:** QC records provide traceability. If a finished product batch fails in the market, you can trace back to the QC inspection, the production order, the BOM, the raw material batches, and the supplier PO. Failed QC statuses can trigger rejection workflows and supplier performance tracking.

**اردو:**
- **کام:** آنے والے سامان یا تیار شدہ بیچز کی انسپکشن رزلٹس ریکارڈ کرنا۔
- **فیلڈز:** حوالہ کی قسم (PO یا پروڈکشن)، حوالہ ID، انسپکٹر، تاریخ، حالت (پاس/ناکام)، ریمارکس۔
- **استعمال:** QC مینو پر جائیں۔ تمام انسپکشن ریکارڈز فہرست میں دکھائے جاتے ہیں۔
- **اثر:** QC ریکارڈز ٹریسیبیلٹی فراہم کرتے ہیں۔ ناکامی کی صورت میں سپلائر، پروڈکشن آرڈر، BOM، اور خام مال بیچ تک ٹریک کیا جا سکتا ہے۔

---

### 8. Machine Maintenance / مشین دیکھ بھال

**English:**
- **What it does:** Maintains a register of all machines and equipment across factories.
- **Fields:** Factory, Machine Name, Unique Code, Status (`operational`, `breakdown`, `under_maintenance`), Last Maintenance Date.
- **How to use:** Navigate to Maintenance. View the full machine list. Status is shown as color-coded badges.
- **Effect:** Machine status affects production planning. Only `operational` machines should be assigned to production orders. `under_maintenance` or `breakdown` machines trigger maintenance alerts. The `last_maintenance` field supports preventive maintenance scheduling.

**اردو:**
- **کام:** تمام فیکٹریوں میں مشینوں اور آلات کا رجسٹر رکھنا۔
- **فیلڈز:** فیکٹری، مشین کا نام، منفرد کوڈ، حالت (operational/breakdown/under_maintenance)، آخری دیکھ بھال کی تاریخ۔
- **استعمال:** Maintenance مینو پر فہرست دیکھیں۔
- **اثر:** مشین کی حالت پروڈکشن پلاننگ کو متاثر کرتی ہے۔ صرف `operational` مشینیں پروڈکشن آرڈر کو دی جا سکتی ہیں۔ `breakdown` پر الرٹ جاتا ہے۔

---

### 9. Sales & Dispatch / فروخت اور ڈسپیچ

**English:**
- **Current Status:** Scaffolded placeholder. The route exists and loads a view, but the backend CRUD is not yet implemented.
- **Planned Purpose:** Will manage customer orders, sales order status, dispatch planning, delivery notes (challans), and finished goods dispatch from warehouses.
- **Effect (when complete):** Sales orders will deduct finished goods stock from warehouses and generate dispatch documents.

**اردو:**
- **موجودہ حالت:** عارضی placeholder۔ راستہ موجود ہے لیکن بیک اینڈ CRUD ابھی نہیں بنایا گیا۔
- **منصوبہ شدہ مقصد:** کسٹمر آرڈرز، فروخت کی حالت، ڈسپیچ پلاننگ، اور ڈیلیوری نوٹس مینج کرے گا۔
- **اثر (مکمل ہونے پر):** فروخت کے آرڈرز تیار شدہ اسٹاک کو گودام سے کم کریں گے۔

---

### 10. HR & Attendance / HR اور حاضری

**English:**
- **Current Status:** Scaffolded placeholder.
- **Planned Purpose:** Will manage employee directory, department assignment, shift allocation, attendance entry, operator-to-machine mapping, and overtime tracking.
- **Effect (when complete):** HR data will link operators to production orders and machines for performance tracking.

**اردو:**
- **موجودہ حالت:** عارضی placeholder۔
- **منصوبہ شدہ مقصد:** ملازمین کی ڈائریکٹری، شفٹ الاؤکیشن، حاضری، اور آپریٹر ٹریکنگ۔
- **اثر (مکمل ہونے پر):** HR ڈیٹا آپریٹرز کو پروڈکشن آرڈرز اور مشینوں سے جوڑے گا۔

---

### 11. Reports & Analytics / رپورٹس اور تجزیات

**English:**
- **Current Status:** Scaffolded placeholder with a report selector UI.
- **Planned Purpose:** Will provide exportable/filterable reports for production, inventory, purchase, supplier performance, machine downtime, QC rejection, wastage analysis, and daily/weekly/monthly management summaries.
- **Effect (when complete):** Management will be able to export CSV/Excel data and make data-driven decisions.

**اردو:**
- **موجودہ حالت:** عارضی placeholder جس میں رپورٹ سلیکٹر UI ہے۔
- **منصوبہ شدہ مقصد:** پروڈکشن، انوینٹری، خریداری، سپلائر پرفارمنس، مشین ڈاؤن ٹائم، QC، اور ری作废 کا تجزیہ۔
- **اثر (مکمل ہونے پر):** مینجمنٹ CSV/ایکسل ایکسپورٹ کر سکے گی اور ڈیٹا پر مبنی فیصلے کر سکے گی۔

---

### 12. User Management & RBAC / صارف مینجمنٹ اور رسائی کنٹرول

**English:**

This is one of the most critical modules. It controls who can access what.

**Features:**
- **Two Tabs (Alpine.js):**
  1. **Users:** Manage user accounts.
  2. **Roles & Permissions:** Manage roles and their permission matrices.
- **User CRUD:**
  - Fields: Username, Full Name, Email, Role (dropdown), Status (active/inactive/locked), Password.
  - Add new users.
  - Edit existing users.
  - Delete users (cannot delete yourself or the Super Admin).
- **Role CRUD:**
  - Fields: Role Name, Description.
  - Permission Matrix: 11 modules × 4 actions (Create, Read, Update, Delete).
  - Modules: Master Data, Inventory, Procurement, Production, QC, Maintenance, Sales, HR, Reports, Settings, User Management.
- **Default Roles:**
  - **Super Admin (ID 1):** Locked role. Has automatic full access to everything. Cannot be deleted.
  - **User (ID 2):** Default limited role.
- **Sidebar Filtering:** The main layout automatically hides menu items for which the logged-in user does not have `read` permission.
- **Server-Side Enforcement:** Even if someone manually types a URL, the controller checks `checkPermission()` and blocks unauthorized access.

**Effect throughout the app:** RBAC affects every single page. If a user has no `read` permission for Procurement, the Procurement menu disappears and direct URL access is blocked. If they have `read` but not `delete`, they can view POs but not delete them.

**اردو:**

یہ سب سے اہم ماڈیولز میں سے ایک ہے۔ یہ کنٹرول کرتا ہے کہ کون کیا استعمال کر سکتا ہے۔

**خصوصیات:**
- **دو ٹیبز:**
  1. **صارفین:** اکاؤنٹس مینج کریں۔
  2. **کردار اور اجازات:** کردار اور اجازات کا میٹرکس مینج کریں۔
- **صارف CRUD:** صارف نام، پورا نام، ای میل، کردار، حالت، پاس ورڈ۔
- **رول CRUD:** رول نام، تفصیل، اور 11 ماڈیولز × 4 ایکشنز کا اجازات میٹرکس۔
- **ڈیفالٹ رولز:**
  - **سپر ایڈمن:** لاک شدہ، ہر چیز تک مکمل رسائی۔
  - **یوزر:** محدود ڈیفالٹ رول۔
- **سائڈبار فلٹرنگ:** مینو خودکار طور پر ان آئٹمز کو چھپا دیتا ہے جن کا `read` اجازت نہیں۔
- **سرور سائڈ انفورسمنٹ:** براہ راست URL ٹائپ کرنے پر بھی کنٹرولر بلاک کر دیتا ہے۔

**اثر:** RBAC ہر صفحہ کو متاثر کرتا ہے۔ اگر کسی صارف کو Procurement کا `read` اجازت نہیں، تو مینو غائب اور براہ راست رسائی بلاک۔

---

### 13. Settings & UI Customization / ترتیبات اور UI کسٹمائزیشن

**English:**
- **What it does:** Allows each user to personalize their interface theme. Preferences are saved in the database and persist across sessions.
- **Fields:**
  - **Typography:** Font Family (Inter, Roboto, Open Sans, Poppins), Font Size (12px, 14px, 16px).
  - **Brand Colors:** Primary Color, Secondary Color (HTML5 color pickers).
  - **Layout Backgrounds:** Sidebar Background, Header Background.
- **How to use:** Go to Settings. Adjust colors and fonts. Click Save Changes. The theme applies instantly on page reload.
- **Effect:** The layout injects these preferences as CSS variables (`:root`) on every page load. Every user's experience can be visually different based on their preference.

**اردو:**
- **کام:** ہر صارف کو اپنا انٹرفیس تبدیل کرنے کی اجازت۔ ترجیحات ڈیٹا بیس میں محفوظ ہوتی ہیں۔
- **فیلڈز:** فونٹ فیملی، فونٹ سائز، پرائمری رنگ، سیکنڈری رنگ، سائڈبار بیک گراؤنڈ، ہیڈر بیک گراؤنڈ۔
- **استعمال:** Settings پر جائیں، رنگ اور فونٹ سیٹ کریں، Save Changes پر کلک کریں۔
- **اثر:** ترجیحات CSS variables کے طور پر ہر صفحہ پر لاگو ہوتی ہیں۔ ہر صارف کا تجربہ بصری طور پر مختلف ہو سکتا ہے۔

---

### 14. Backup & Restore / بیک اپ اور ریسٹور

**English:**
- **What it does:** Creates encrypted database backups and allows downloading them.
- **Security:** Backups are encrypted using AES-256-CBC with a random IV. File extension is `.fob` (FactoryOS Backup).
- **How to use:** Go to Settings > Backups. Click "Create Backup" to generate a new encrypted snapshot. Click "Download" on any existing backup to save it locally.
- **Effect:** Protects against data loss. The backup contains a full SQL export of the database. Restore functionality can be added in future updates.

**اردو:**
- **کام:** انکرپٹڈ ڈیٹا بیس بیک اپ بناتا ہے اور ڈاؤن لوڈ کرنے دیتا ہے۔
- **سیکیورٹی:** AES-256-CBC انکرپشن رینڈم IV کے ساتھ۔ فائل ایکسٹینشن `.fob`۔
- **استعمال:** Settings > Backups پر جائیں۔ "Create Backup" سے نیا بیک اپ بنائیں۔ "Download" سے محفوظ کریں۔
- **اثر:** ڈیٹا لاس سے بچاتا ہے۔ بیک اپ میں ڈیٹا بیس کا مکمل SQL ایکسپورٹ ہوتا ہے۔

---

## Database Schema / ڈیٹا بیس اسکیما

The application uses **17 tables** in MySQL/MariaDB. Below is a complete list:

| # | Table | Purpose | Key Relationships |
|---|-------|---------|-------------------|
| 1 | `users` | Login accounts | Linked to `roles`, `user_settings` |
| 2 | `user_settings` | Per-user UI theme | FK → `users(id)` |
| 3 | `roles` | RBAC roles | Linked to `role_permissions` |
| 4 | `role_permissions` | Permission matrix (11 modules × 4 actions) | FK → `roles(id)` |
| 5 | `factories` | Manufacturing plants | Parent of warehouses & machines |
| 6 | `products` | SKU master (raw/finished/semi) | Referenced by stock, POs, BOMs |
| 7 | `suppliers` | Vendor directory | Referenced by purchase orders |
| 8 | `warehouses` | Storage locations | FK → `factories(id)` |
| 9 | `stock` | Inventory balances | FK → `warehouses(id)`, `products(id)` |
| 10 | `purchase_orders` | PO headers | FK → `suppliers(id)`, `users(id)` |
| 11 | `po_items` | PO line items | FK → `purchase_orders(id)`, `products(id)` |
| 12 | `boms` | Bill of Materials headers | FK → `products(id)` |
| 13 | `bom_items` | BOM components | FK → `boms(id)`, `products(id)` |
| 14 | `production_orders` | Work orders | FK → `products(id)`, `boms(id)` |
| 15 | `qc_records` | Quality inspections | FK → `users(id)` (inspector) |
| 16 | `machines` | Equipment register | FK → `factories(id)` |
| 17 | `audit_logs` | Action audit trail | FK → `users(id)` ON DELETE SET NULL |

---

## User Roles & Permissions / صارف کے کردار اور اجازات

### Default Roles / ڈیفالٹ کردار

| Role ID | Role Name | Description |
|---------|-----------|-------------|
| 1 | Super Admin | Full system access. Cannot be deleted. |
| 2 | User | Default limited role. Permissions can be customized. |

### Permission Matrix / اجازات کا میٹرکس

Each role can have permissions on **11 modules**, each with **4 actions**:

**Modules:** Master Data, Inventory, Procurement, Production, QC, Maintenance, Sales, HR, Reports, Settings, User Management.

**Actions:** Create, Read, Update, Delete.

**Example:** A "Procurement Officer" role might have `Read+Create` on Procurement, `Read` on Inventory and Master Data, and no access to User Management.

---

## Security Features / سیکیورٹی فیچرز

**English:**

1. **Password Hashing:** All passwords stored with PHP `password_hash()` (bcrypt).
2. **Prepared Statements:** 100% of database queries use PDO prepared statements to prevent SQL injection.
3. **Output Escaping:** All rendered output uses `htmlspecialchars()` to prevent XSS.
4. **CSRF Token System:** A `_csrf_token` is generated in session. Forms include it via `Html::csrf()`. (Note: Middleware is built but not yet auto-wired on all routes — manual validation is present on key forms.)
5. **Session Fixation Protection:** `session_regenerate_id(true)` on login.
6. **Idle & Absolute Timeouts:** 40 minutes idle, 8 hours max.
7. **Rate Limiting:** `ThrottleMiddleware` tracks IP-based requests (>100/min = 429 response). (Built but pending auto-wire.)
8. **Math CAPTCHA:** GD-generated noisy image on login to stop brute force bots.
9. **Audit Logging:** `AuditService` logs every critical create/update/delete with old values, new values, IP address, and timestamp.
10. **Encrypted Backups:** `.fob` files use AES-256-CBC encryption.

**اردو:**

1. **پاس ورڈ ہیشنگ:** تمام پاس ورڈز `password_hash()` (bcrypt) سے محفوظ۔
2. **تیار شدہ اسٹیٹمنٹس:** 100% ڈیٹا بیس کوئریز PDO تیار شدہ اسٹیٹمنٹس استعمال کرتی ہیں۔
3. **آؤٹ پٹ ایسکیپنگ:** `htmlspecialchars()` سے XSS سے بچاؤ۔
4. **CSRF ٹوکن:** سیشن میں `_csrf_token` بنتا ہے۔ (middleware تعمیر شدہ ہے لیکن کچھ راستوں پر دستی تصدیق موجود ہے۔)
5. **سیشن فکسیشن پروٹیکشن:** لاگ ان پر `session_regenerate_id(true)`۔
6. **ٹائم آؤٹس:** 40 منٹ خاموشی، 8 گھنٹے حد۔
7. **ریٹ لیمٹنگ:** `ThrottleMiddleware` IP پر مبنی۔
8. **ریاضی CAPTCHA:** لاگ ان پر شور والی تصویر۔
9. **آڈٹ لاگنگ:** ہر اہم عمل کے پرانے/نئے اقدار، IP، اور وقت کا ریکارڈ۔
10. **انکرپٹڈ بیک اپ:** `.fob` فائلز AES-256-CBC سے محفوظ۔

---

## Project File Structure / فائل سٹرکچر

```text
myfactory/
├── .env.example                  # Example environment variables
├── .htaccess                     # Root URL rewriting
├── index.php                     # Proxy to public/index.php
├── README.md                     # This file
├── prompt.md                     # Internal generation guidelines
│
├── app/
│   ├── Core/                     # Framework core
│   │   ├── Application.php       # Bootstrap
│   │   ├── Router.php            # Laravel-style router
│   │   ├── Controller.php        # Base controller
│   │   ├── Model.php             # Base model
│   │   ├── Database.php          # PDO singleton
│   │   ├── Auth.php              # Auth helper
│   │   ├── Request.php           # HTTP request wrapper
│   │   ├── Response.php          # HTTP response helpers
│   │   ├── Session.php           # Session + flash messages
│   │   ├── Middleware.php        # Middleware base
│   │   └── View.php              # View renderer
│   ├── Controllers/              # All controllers (Auth, Dashboard, MasterData, Inventory, etc.)
│   ├── Models/                   # All models (User, Product, PurchaseOrder, BOM, etc.)
│   ├── Views/                    # All view templates
│   ├── Helpers/                  # AppHelper, CaptchaHelper, Html
│   ├── Middlewares/              # AuthMiddleware, CsrfMiddleware, ThrottleMiddleware
│   └── Services/                 # AuditService, BackupService
│
├── config/
│   ├── app.php                   # App name, base path, timeouts
│   └── database.php              # DB host, name, user, pass
│
├── routes/
│   └── web.php                   # All route definitions
│
├── public/
│   ├── index.php                 # Front controller
│   └── .htaccess                 # Public rewrite rules
│
├── database/
│   ├── schema.sql                # Base schema + admin seed
│   ├── setup_db.php              # One-shot DB creator
│   ├── migrate.php               # Migration runner
│   ├── update_schema.php         # Adds BOM/QC/Production tables
│   ├── seed.php                  # Demo data seeder
│   ├── seeders/                  # Alternate seeders
│   └── factory.sqlite            # SQLite file (legacy)
│
├── migrate_roles.php             # Role & permission migration
├── setup_system.php              # One-click full setup
├── build_system_step1.php        # Legacy scaffold generator
├── build_missing.php             # Legacy scaffold generator
├── clean_syntax.php              # Utility: fix stray escapes
└── tests/
    └── AuthTest.php              # PHPUnit auth tests
```

---

## Current Status & Roadmap / موجودہ حالت اور روڈ میپ

### Fully Implemented / مکمل طور پر نافذ

- Authentication with CAPTCHA and session timeouts
- Dashboard with live KPIs
- Master Data: Factories, Products (partial view), Suppliers (backend ready)
- Inventory: Warehouses (backend), Stock listing, Stock Inward form
- Procurement: Full PO lifecycle (list, create with dynamic items, view)
- Production: BOM list and creation with dynamic components
- Quality Control: Records listing
- Maintenance: Machine listing
- User Management & RBAC: Full CRUD for users and roles with permission matrix
- Settings: UI theme customization
- Backups: Encrypted backup creation and download
- Audit Logging: Backend service logging all actions

### Partial / Scaffolded / عارضی یا جزوی

- Sales & Dispatch (placeholder page)
- HR & Attendance (placeholder page)
- Reports (placeholder page with selector UI)
- Some views missing (suppliers.php, warehouses.php, stock.php, procurement/view.php) — backend APIs exist

### Roadmap / مستقبل کے منصوبے

- Complete missing views and polish all UIs
- Full Sales order → Dispatch → Stock deduction flow
- HR module with attendance and operator assignment
- Reporting engine with CSV/Excel export
- QC inspection entry forms (currently read-only list)
- Maintenance ticket and scheduling system
- Automated scheduled backups (daily/weekly)
- Password reset / forgot password flow
- Email notifications for low stock and pending approvals
- Full batch traceability reports

---

## Support / رابطہ

**Created by / تیار کردہ:**

**Yasin Ullah**

- **LinkedIn:** [Yasin Ullah](https://www.linkedin.com/in/yasin-ullah-029229232/)
- **WhatsApp:** `03361593533`

---

*This document is intended for client review and covers every module, feature, database table, configuration file, and security mechanism present in the FactoryOS codebase as of the latest commit.*

*یہ دستاویز کلائنٹ کے جائزے کے لیے ہے اور FactoryOS کوڈ بیس میں موجود ہر ماڈیول، فیچر، ڈیٹا بیس ٹیبل، کنفیگریشن فائل، اور سیکیورٹی میکانزم کو covers کرتی ہے۔*
