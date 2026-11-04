# Todo List - Multi-User Todo List Management Application

A complete, modern, responsive, and secure multi-user Todo List Management Web Application built with **PHP 8.3**, **Laravel 13**, **MySQL (XAMPP)**, **Bootstrap 5**, and **Laravel Blade**.

Each registered user has a completely isolated and private task list with zero possibility of accessing or modifying other users' tasks.

---

## Features

- **Multi-User Isolation**: Every user only has access to their own tasks. Strict database-level foreign keys and Eloquent relationship scoping ensure complete data privacy.
- **Authentication System**:
  - Secure Registration with validation, unique email verification, and password hashing (`bcrypt`).
  - Login with "Remember Me" functionality and session regeneration.
  - Secure Logout with session invalidation.
  - Protected routes via Laravel `auth` middleware and CSRF token protection on all forms.
- **Full Todo CRUD**:
  - **Create Task**: Title, description, priority (Low, Medium, High), status (Pending, In Progress, Completed), and due date.
  - **View Tasks**: Modern dashboard with statistics cards and dedicated task list view.
  - **Edit & Update**: Full task editing with server-side validation and old value retention.
  - **Quick Status Change**: Update task status instantly directly from the dashboard or task table.
  - **Delete Task**: Safe deletion with client-side confirmation dialog.
- **Search, Filter & Sort**:
  - Search by task title.
  - Filter by status (`Pending`, `In Progress`, `Completed`).
  - Filter by priority (`Low`, `Medium`, `High`).
  - Filter by specific due date.
  - Sort by Newest, Oldest, Due Date (Ascending/Descending).
- **Modern SaaS UI**:
  - Inspired by modern SaaS productivity tools.
  - Bootstrap 5 via CDN (No Node.js, npm, or Vite build step required).
  - Bootstrap Icons via CDN.
  - Clean color palette with distinct badges for priorities and statuses.
  - Fully responsive on mobile, tablet, and desktop screens.

---

## Tech Stack

- **Backend**: PHP 8.3.36
- **Framework**: Laravel 13
- **Database**: MySQL / MariaDB (XAMPP)
- **Database Tool**: phpMyAdmin
- **ORM**: Laravel Eloquent ORM
- **Frontend**: Laravel Blade, HTML5, CSS3, Vanilla JavaScript
- **Styling**: Bootstrap 5.3.3 (CDN) + Custom CSS (`public/css/style.css`)
- **Icons**: Bootstrap Icons 1.11.3 (CDN)

---

## Installation & Setup Instructions

### Prerequisites

1. **XAMPP** running **Apache** and **MySQL** (default port `3306`).
2. **PHP 8.3+** available in your PATH.
3. **Composer 2.x** installed.

### Step 1: Database Setup

Make sure MySQL is started in the XAMPP Control Panel.
Create the database in phpMyAdmin or via command line:

```sql
CREATE DATABASE IF NOT EXISTS todo_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### Step 2: Configure Environment

Verify that `.env` contains the following database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=root
DB_PASSWORD=
```

### Step 3: Run Migrations and Seeders

Run the database migrations and seed sample users and tasks:

```sh
php artisan config:clear
php artisan migrate
php artisan db:seed
```

### Step 4: Start Application Server

Start Laravel's built-in development server (no Node.js required):

```sh
php artisan serve
```

Visit the application in your browser:

```
http://127.0.0.1:8000
```

---

## Pre-Seeded Test Accounts

You can test user data isolation using these pre-seeded accounts:

| User | Email | Password | Role / Data |
|---|---|---|---|
| **John Doe** | `john@example.com` | `password123` | Has 3 sample tasks |
| **Jane Smith** | `jane@example.com` | `password123` | Has 2 sample tasks |

Or register your own new account directly from the **Register** page!

---

## Running the Automated Test Suite

The application includes 28 comprehensive automated feature tests covering authentication, CRUD operations, filtering, and cross-user data isolation:

```sh
php artisan test
```

### Test Coverage Highlights:

- `AuthTest`: Registration, login validation, session regeneration, guest route protection, and logout.
- `TodoCrudTest`: Task creation, validation, viewing, updating, deleting, status toggle, search, and filtering.
- `DataIsolationTest`: Verifies that User A cannot see, edit, update, delete, or change status on User B's tasks (returning HTTP 404).
