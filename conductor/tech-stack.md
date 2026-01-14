# Rena Calibration - Tech Stack

## Backend
- **Language:** PHP 8.4
- **Framework:** Laravel 12
- **Core Packages:**
    - `laravel/tinker`: REPL for Laravel
    - `spatie/laravel-permission`: Role-based access control (RBAC)
    - `maatwebsite/excel`: Excel import/export functionality
    - `milon/barcode`: Barcode and QR code generation

## Admin & UI
- **Admin Panel:** Filament v4 (built on Livewire 3 and Alpine.js)
- **Frontend Tools:**
    - **Tailwind CSS v4:** Utility-first CSS framework
    - **Vite:** Asset bundling and development server
    - **torgodly/html2media**: HTML to Image/PDF conversion
    - **bezhansalleh/filament-language-switch**: Multi-language support for the dashboard

## Reporting & Utilities
- **PDF Generation:** `barryvdh/laravel-dompdf` and `spatie/browsershot` (Puppeteer-based)
- **Asset Discovery:** Automatic package discovery via Laravel

## Development & Testing
- **Testing Framework:** Pest v4 (with `pest-plugin-laravel`)
- **Code Style:** Laravel Pint
- **Environment:** Laravel Sail (Docker-based development)
- **Debugging:** Laravel Pail (log tailing)
