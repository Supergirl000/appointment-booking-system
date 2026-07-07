# Appointment Booking System

A professional Laravel admin booking system built for portfolio and Fiverr presentation. The application is designed for service-based businesses that need a clean back-office workflow for services, customers, appointments, calendar visibility, reports, and business settings.

## Tech Stack

- Laravel
- MySQL
- Blade
- Tailwind CSS
- Laravel Breeze authentication
- Vite
- PHPUnit

No React, Vue, Bootstrap, payment gateway, or public booking frontend is included.

## Features

- Breeze authentication with login, register, password reset, logout, and profile management
- Premium admin dashboard with live appointment/customer/service statistics
- Services CRUD with search and status filtering
- Customers CRUD with searchable customer records
- Appointments CRUD with customer, service, staff, date, time, status, and notes
- Monthly calendar view with appointment counts and appointment cards
- Reports page with appointment totals, status distribution, monthly totals, service demand, and estimated completed revenue
- Business settings management using key/value storage
- Responsive admin layout with mobile sidebar, topbar, reusable Blade components, and Tailwind-only UI
- Realistic demo data for beauty salons, spas, clinics, and consulting businesses

## Demo Login

After running the seeders, use:

```text
Email: admin@example.com
Password: password
```

## Installation

1. Clone or copy the project.

2. Install PHP dependencies:

```bash
composer install
```

3. Install frontend dependencies:

```bash
npm install
```

4. Copy the environment file:

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

5. Generate the app key:

```bash
php artisan key:generate
```

6. Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=appointment_booking
DB_USERNAME=root
DB_PASSWORD=
```

7. Run migrations and seed demo data:

```bash
php artisan migrate:fresh --seed
```

8. Build frontend assets:

```bash
npm run build
```

9. Start the local server:

```bash
php artisan serve
```

Open:

```text
http://127.0.0.1:8000
```

## Screenshot-Ready Pages

The seeded demo data prepares these pages for portfolio screenshots:

- Dashboard
- Services
- Customers
- Appointments
- Calendar
- Reports
- Settings

## Customization Options

This project can be adapted for:

- Beauty salons
- Spas and wellness studios
- Clinics
- Consultants and coaches
- Repair or maintenance booking offices
- Internal team scheduling

Common customizations:

- Update business settings from the Settings page
- Add or edit services and prices
- Replace demo staff and customers with real records
- Adjust appointment statuses or workflows
- Extend reports with charts or exports
- Add a public booking frontend in a future phase
- Add notifications, reminders, or payment integrations later

## Fiverr Use Cases

This project is suitable as a portfolio base for gigs such as:

- Laravel appointment booking system
- Salon booking admin dashboard
- Spa appointment management system
- Clinic scheduling dashboard
- Consultant booking CRM
- Tailwind admin dashboard development
- Laravel Breeze authentication setup
- CRUD admin panel development

## Testing

Run the automated test suite:

```bash
php artisan test
```

## Notes

- This is a clean admin booking system portfolio project.
- Payment gateway integration is not included.
- Public customer booking frontend is not included.
- The project intentionally uses Blade and Tailwind CSS only.
