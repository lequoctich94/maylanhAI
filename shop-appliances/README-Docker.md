# Docker Setup cho Shop Appliances

Hướng dẫn setup và deploy dự án Laravel Shop Appliances bằng Docker.

## Yêu cầu hệ thống

- Docker Desktop
- Docker Compose
- Git

## Cấu trúc Docker

Dự án bao gồm các services sau:
- **nginx**: Web server (port 80)
- **app**: Laravel application (PHP 8.2 FPM)
- **mysql**: MySQL 8.0 database (port 3306)
- **redis**: Redis cache (port 6379)
- **phpmyadmin**: Database management tool (port 8080)

## Hướng dẫn cài đặt

### 1. Clone repository và setup

```bash
git clone <repository-url>
cd shop-appliances
```

### 2. Tạo file .env

```bash
# Copy từ .env.example nếu chưa có
cp .env.example .env

# Hoặc sử dụng cấu hình Docker đề xuất
```

**Cấu hình .env cho Docker:**
```env
APP_NAME="Shop Appliances"
APP_ENV=production
APP_DEBUG=false
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shop_db
DB_USERNAME=shop_user
DB_PASSWORD=shop_password

CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
REDIS_PORT=6379
```

### 3. Build và start containers

```bash
# Build và start tất cả services
docker-compose up -d --build

# Hoặc chỉ build
docker-compose build

# Start services
docker-compose up -d
```

### 4. Setup Laravel application

```bash
# Vào container app
docker-compose exec app bash

# Hoặc chạy setup commands
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
docker-compose exec app php artisan storage:link
```

## Các lệnh hữu ích

### Quản lý containers

```bash
# Xem status các services
docker-compose ps

# Xem logs
docker-compose logs
docker-compose logs app
docker-compose logs nginx

# Stop tất cả services
docker-compose down

# Restart specific service
docker-compose restart app
```

### Laravel commands

```bash
# Chạy migrations
docker-compose exec app php artisan migrate

# Seed database
docker-compose exec app php artisan db:seed

# Clear cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan view:clear

# Install packages
docker-compose exec app composer install
docker-compose exec app npm install
```

### Database operations

```bash
# Backup database
docker-compose exec mysql mysqldump -u shop_user -pshop_password shop_db > backup.sql

# Restore database
docker-compose exec -T mysql mysql -u shop_user -pshop_password shop_db < backup.sql
```

## Truy cập services

- **Website**: http://localhost
- **PHPMyAdmin**: http://localhost:8080
  - Server: mysql
  - Username: shop_user
  - Password: shop_password
- **Database**: localhost:3306
- **Redis**: localhost:6379

## Cấu hình production

### 1. Sửa docker-compose.yml cho production

```yaml
# Bỏ volumes mapping để tránh ghi đè code
# Thêm environment variables
# Cấu hình SSL cho nginx
```

### 2. Environment variables

Tạo file `.env.production`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database credentials
DB_PASSWORD=<strong-password>
MYSQL_ROOT_PASSWORD=<strong-root-password>

# Cache và session
CACHE_STORE=redis
SESSION_DRIVER=redis
```

### 3. SSL Certificate

Thêm SSL certificate vào `docker/nginx/`:
- `ssl/cert.pem`
- `ssl/private.key`

Và cập nhật `nginx.conf` cho HTTPS.

## Troubleshooting

### Lỗi thường gặp

1. **Permission denied errors**:
   ```bash
   docker-compose exec app chown -R www:www /var/www/storage
   docker-compose exec app chmod -R 775 /var/www/storage
   ```

2. **Database connection errors**:
   - Kiểm tra MySQL container đã start chưa
   - Verify database credentials trong .env

3. **502 Bad Gateway**:
   - Kiểm tra PHP-FPM container
   - Xem logs: `docker-compose logs app`

### Reset toàn bộ

```bash
# Stop và xóa containers
docker-compose down

# Xóa volumes (⚠️ sẽ mất data)
docker-compose down -v

# Rebuild
docker-compose up -d --build
```

## Backup và Recovery

### Backup

```bash
# Backup code
tar -czf backup-code.tar.gz --exclude=node_modules --exclude=vendor .

# Backup database
docker-compose exec mysql mysqldump -u shop_user -pshop_password shop_db > backup-db.sql

# Backup uploaded files
tar -czf backup-storage.tar.gz storage/app/public/
```

### Recovery

```bash
# Restore code
tar -xzf backup-code.tar.gz

# Restore database
docker-compose exec -T mysql mysql -u shop_user -pshop_password shop_db < backup-db.sql

# Restore files
tar -xzf backup-storage.tar.gz
```

## Notes

- File `docker-entrypoint.sh` tự động setup Laravel application khi container start
- Database data được lưu trong Docker volume `mysql_data`
- Redis được sử dụng cho cache và sessions
- Nginx được cấu hình để serve static files hiệu quả 

## ✅ **CÓ! Hoàn toàn có thể chạy trên Linux server!**

Docker setup của bạn **hoàn toàn tương thích với Linux**. Thực tế, Linux là môi trường **tốt nhất** để chạy Docker containers. Tôi đã tạo thêm:

## 🆕 **Files mới cho Linux deployment:**

1. **`docker-compose.prod.yml`** - Cấu hình production cho Linux
2. **`docker/mysql/my.cnf`** - Tối ưu MySQL cho production
3. **`docker/nginx/nginx-ssl.conf`** - Nginx với SSL/HTTPS
4. **`deploy-linux.sh`** - Script tự động deploy trên Linux
5. **`Linux-Deployment-Guide.md`** - Hướng dẫn chi tiết

## 🚀 **Ưu điểm khi chạy trên Linux:**

### ✅ **Better Performance**
- Container startup nhanh hơn
- Resource usage tối ưu hơn
- Native Docker support

### ✅ **Production Ready**
- SSL/HTTPS tự động
- Auto-renewal certificates (Let's Encrypt)
- Security headers và firewall
- Log rotation và monitoring

### ✅ **Easy Deployment**
```bash
# Chỉ cần chạy 1 lệnh!
./deploy-linux.sh production
```

## 🔧 **Quick Setup trên Linux:**

```bash
# 1. Cài Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# 2. Clone project
git clone <repo> shop-appliances
cd shop-appliances

# 3. Setup environment
cp .env.example .env
nano .env  # Edit cấu hình

# 4. Deploy
chmod +x deploy-linux.sh
./deploy-linux.sh production
```

## 🌐 **Access sau khi deploy:**
- **Website**: `https://your-server-ip`
- **Database**: `your-server-ip:3306`
- **Monitoring**: Built-in health checks

## 🔒 **Security Features:**
- ✅ Firewall configuration
- ✅ SSL/TLS encryption
- ✅ Rate limiting
- ✅ Security headers
- ✅ Non-root containers

**Docker này được thiết kế để production-ready trên Linux server!** 🐧🚀

Bạn có server Linux nào đặc biệt (Ubuntu, CentOS, Debian) để tôi tùy chỉnh thêm không? 