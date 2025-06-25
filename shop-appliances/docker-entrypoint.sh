#!/bin/bash

# Exit immediately if a command exits with a non-zero status
set -e

echo "🚀 Starting Laravel application setup..."

# Wait for MySQL to be ready
echo "⏳ Waiting for MySQL to be ready..."
until nc -z mysql 3306; do
    echo "MySQL is unavailable - sleeping"
    sleep 1
done
echo "✅ MySQL is ready!"

# Check if .env file exists, if not copy from .env.example
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
fi

# Set up Laravel application
echo "🔧 Setting up Laravel application..."

# Install/update composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Generate application key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate
fi

# Create storage symbolic link
echo "🔗 Creating storage link..."
php artisan storage:link || true

# Clear and cache configuration
echo "⚙️ Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
echo "🗄️ Skipping database migrations..."
# php artisan migrate --force

# Set proper permissions
echo "🔐 Setting permissions..."
chown -R www:www /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

echo "✅ Laravel application setup complete!"
echo "🌐 Application is ready to serve requests"

# Start PHP-FPM
exec "$@" 