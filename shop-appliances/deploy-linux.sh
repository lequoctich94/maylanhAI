#!/bin/bash

# Deploy script cho Linux Server
# Sử dụng: ./deploy-linux.sh [production|staging]

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Functions
log_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

log_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

log_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

log_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Configuration
ENVIRONMENT=${1:-production}
APP_NAME="shop-appliances"
BACKUP_DIR="./backups"
SSL_DIR="./docker/nginx/ssl"

log_info "🚀 Starting deployment for environment: $ENVIRONMENT"

# Check if running as root
if [[ $EUID -eq 0 ]]; then
   log_error "This script should not be run as root for security reasons"
   exit 1
fi

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    log_error "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker Compose is installed
if ! command -v docker-compose &> /dev/null; then
    log_error "Docker Compose is not installed. Please install Docker Compose first."
    exit 1
fi

# Create necessary directories
log_info "📁 Creating necessary directories..."
mkdir -p $BACKUP_DIR
mkdir -p $SSL_DIR
mkdir -p ./docker/nginx/ssl
mkdir -p ./storage/logs

# Set permissions
log_info "🔐 Setting proper permissions..."
sudo chown -R $USER:$USER .
chmod +x deploy-linux.sh
chmod +x docker-entrypoint.sh

# Check if .env file exists
if [ ! -f .env ]; then
    log_warning ".env file not found. Creating from .env.example..."
    if [ -f .env.example ]; then
        cp .env.example .env
        log_info "Please edit .env file with your configuration"
        read -p "Press enter to continue after editing .env file..."
    else
        log_error ".env.example not found. Please create .env file manually."
        exit 1
    fi
fi

# Load environment variables
source .env

# Check SSL certificates for production
if [ "$ENVIRONMENT" = "production" ]; then
    if [ ! -f "$SSL_DIR/cert.pem" ] || [ ! -f "$SSL_DIR/private.key" ]; then
        log_warning "SSL certificates not found!"
        log_info "For production, you need SSL certificates."
        log_info "You can:"
        log_info "1. Use Let's Encrypt (recommended)"
        log_info "2. Use your own certificates"
        log_info "3. Continue without SSL (not recommended for production)"
        
        read -p "Continue without SSL? (y/N): " -n 1 -r
        echo
        if [[ ! $REPLY =~ ^[Yy]$ ]]; then
            log_info "Please add SSL certificates to $SSL_DIR/ and run again"
            exit 1
        fi
    fi
fi

# Backup existing database if containers are running
if docker ps -q --filter "name=${APP_NAME}_mysql" | grep -q .; then
    log_info "📦 Creating database backup..."
    BACKUP_FILE="$BACKUP_DIR/backup_before_deploy_$(date +%Y%m%d_%H%M%S).sql"
    docker exec ${APP_NAME}_mysql mysqldump -u ${DB_USERNAME} -p${DB_PASSWORD} ${DB_DATABASE} > $BACKUP_FILE
    log_success "Database backup created: $BACKUP_FILE"
fi

# Stop existing containers
log_info "🛑 Stopping existing containers..."
if [ "$ENVIRONMENT" = "production" ]; then
    docker-compose -f docker-compose.prod.yml down
else
    docker-compose down
fi

# Pull latest images
log_info "📥 Pulling latest Docker images..."
docker-compose pull

# Build application
log_info "🔨 Building application..."
if [ "$ENVIRONMENT" = "production" ]; then
    docker-compose -f docker-compose.prod.yml build --no-cache
else
    docker-compose build --no-cache
fi

# Start containers
log_info "🚀 Starting containers..."
if [ "$ENVIRONMENT" = "production" ]; then
    docker-compose -f docker-compose.prod.yml up -d
else
    docker-compose up -d
fi

# Wait for services to be ready
log_info "⏳ Waiting for services to be ready..."
sleep 30

# Check if containers are running
if ! docker ps -q --filter "name=${APP_NAME}_app" | grep -q .; then
    log_error "Application container failed to start"
    docker-compose logs app
    exit 1
fi

# Run Laravel setup commands
log_info "⚙️ Running Laravel setup commands..."

# Generate app key if not set
if ! grep -q "APP_KEY=base64:" .env; then
    log_info "Generating application key..."
    docker exec ${APP_NAME}_app php artisan key:generate
fi

# Run migrations
log_info "Running database migrations..."
docker exec ${APP_NAME}_app php artisan migrate --force

# Clear and cache configuration
log_info "Caching configuration..."
docker exec ${APP_NAME}_app php artisan config:cache
docker exec ${APP_NAME}_app php artisan route:cache
docker exec ${APP_NAME}_app php artisan view:cache

# Create storage link
log_info "Creating storage link..."
docker exec ${APP_NAME}_app php artisan storage:link

# Set proper permissions
log_info "Setting storage permissions..."
docker exec ${APP_NAME}_app chown -R www:www /var/www/storage /var/www/bootstrap/cache
docker exec ${APP_NAME}_app chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Health check
log_info "🏥 Performing health check..."
sleep 10

if curl -f http://localhost/health-check 2>/dev/null; then
    log_success "Health check passed!"
else
    log_warning "Health check failed, but containers are running"
fi

# Display status
log_info "📊 Container status:"
if [ "$ENVIRONMENT" = "production" ]; then
    docker-compose -f docker-compose.prod.yml ps
else
    docker-compose ps
fi

# Display access information
log_success "🎉 Deployment completed successfully!"
echo ""
log_info "🌐 Access your application:"
if [ "$ENVIRONMENT" = "production" ]; then
    log_info "   Website: https://$(hostname -I | awk '{print $1}')"
    log_info "   Website: https://your-domain.com"
else
    log_info "   Website: http://$(hostname -I | awk '{print $1}')"
    log_info "   PHPMyAdmin: http://$(hostname -I | awk '{print $1}'):8080"
fi

echo ""
log_info "📝 Useful commands:"
echo "   View logs: docker-compose logs -f"
echo "   Enter app container: docker exec -it ${APP_NAME}_app bash"
echo "   Stop services: docker-compose down"
echo "   Restart services: docker-compose restart"

# Cleanup old images
log_info "🧹 Cleaning up old Docker images..."
docker image prune -f

log_success "Deployment script completed! 🚀" 