# Rush User Management CMS

## Requirements
- PHP 8.1+
- Node.js
- Composer
- MySQL

## Setup

```bash
# Clone the repository
git clone https://github.com/karltanjuan/rush-technical-exam

# Navigate to the project directory
cd rush-technical-exam

# Install PHP dependencies
composer install

# Copy the environment configuration file
cp .env.example .env

# Update your .env file with the following settings:
# SESSION_DRIVER=cookie
# SANCTUM_STATEFUL_DOMAINS=localhost:8000,127.0.0.1:8000

# Generate the application key
php artisan key:generate

# Run database migrations and seed initial data
php artisan migrate --seed

# Install Node.js dependencies
npm install

# Build front-end assets
npm run dev

# Start the Laravel development server
php artisan serve
