# 🐧 Hướng dẫn Deploy Laravel trên Linux Server

## 📋 Yêu cầu hệ thống

### Server Requirements
- **OS**: Ubuntu 20.04 LTS / CentOS 8 / Debian 11 trở lên
- **RAM**: Tối thiểu 2GB (khuyến nghị 4GB+)
- **Storage**: Tối thiểu 20GB free space
- **Network**: Public IP address với ports 80, 443 mở

### Software Requirements
- Docker Engine 20.10+
- Docker Compose 2.0+
- Git
- Curl/wget

---

## 🔧 Cài đặt Dependencies

### 1. Cập nhật hệ thống

**Ubuntu/Debian:**
```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl wget git vim ufw
```

**CentOS/RHEL:**
```bash
sudo yum update -y
sudo yum install -y curl wget git vim firewalld
```

### 2. Cài đặt Docker

**Ubuntu/Debian:**
```bash
# Gỡ bỏ Docker cũ nếu có
sudo apt remove docker docker-engine docker.io containerd runc

# Cài đặt Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# Thêm user vào docker group
sudo usermod -aG docker $USER

# Start và enable Docker
sudo systemctl start docker
sudo systemctl enable docker
```

**CentOS/RHEL:**
```bash
# Cài đặt Docker
sudo yum install -y yum-utils
sudo yum-config-manager --add-repo https://download.docker.com/linux/centos/docker-ce.repo
sudo yum install -y docker-ce docker-ce-cli containerd.io

# Start và enable Docker
sudo systemctl start docker
sudo systemctl enable docker
sudo usermod -aG docker $USER
```

### 3. Cài đặt Docker Compose

```bash
# Download Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

# Cấp quyền execute
sudo chmod +x /usr/local/bin/docker-compose

# Tạo symlink
sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose

# Verify installation
docker-compose --version
```

### 4. Logout và login lại để áp dụng docker group

```bash
logout
# Login lại qua SSH
```

---

## 🚀 Deploy Application

### 1. Clone repository

```bash
cd /opt  # hoặc thư mục bạn muốn
sudo git clone <your-repository-url> shop-appliances
sudo chown -R $USER:$USER shop-appliances
cd shop-appliances
```

### 2. Cấu hình Environment

```bash
# Copy và edit file .env
cp .env.example .env
nano .env
```

**Cấu hình .env cho production:**
```env
APP_NAME="Shop Appliances"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=shop_db
DB_USERNAME=shop_user
DB_PASSWORD=your_strong_password_here

# Cache & Session
CACHE_STORE=redis
SESSION_DRIVER=redis
REDIS_HOST=redis
REDIS_PASSWORD=your_redis_password

# Mail (configure based on your provider)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### 3. Cấu hình SSL Certificate (Production)

**Option 1: Let's Encrypt (Khuyến nghị)**
```bash
# Cài đặt Certbot
sudo apt install -y certbot

# Generate certificate
sudo certbot certonly --standalone -d yourdomain.com -d www.yourdomain.com

# Copy certificates
sudo cp /etc/letsencrypt/live/yourdomain.com/fullchain.pem docker/nginx/ssl/cert.pem
sudo cp /etc/letsencrypt/live/yourdomain.com/privkey.pem docker/nginx/ssl/private.key
sudo chown $USER:$USER docker/nginx/ssl/*
```

**Option 2: Self-signed certificate (Development)**
```bash
mkdir -p docker/nginx/ssl
openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
    -keyout docker/nginx/ssl/private.key \
    -out docker/nginx/ssl/cert.pem \
    -subj "/C=VN/ST=HCM/L=HCM/O=Company/CN=yourdomain.com"
```

### 4. Cấu hình Firewall

**Ubuntu (UFW):**
```bash
sudo ufw enable
sudo ufw allow ssh
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw status
```

**CentOS (Firewalld):**
```bash
sudo systemctl start firewalld
sudo systemctl enable firewalld
sudo firewall-cmd --permanent --add-service=ssh
sudo firewall-cmd --permanent --add-service=http
sudo firewall-cmd --permanent --add-service=https
sudo firewall-cmd --reload
```

### 5. Run Deployment Script

```bash
# Cấp quyền execute
chmod +x deploy-linux.sh

# Deploy production
./deploy-linux.sh production

# Hoặc deploy staging
./deploy-linux.sh staging
```

---

## 🔧 Cấu hình bổ sung

### 1. Auto-renewal SSL Certificate

**Tạo cron job cho Let's Encrypt:**
```bash
sudo crontab -e

# Thêm dòng sau (renew mỗi tháng)
0 3 1 * * /usr/bin/certbot renew --quiet && docker-compose restart nginx
```

### 2. Log Rotation

**Tạo file `/etc/logrotate.d/shop-appliances`:**
```bash
sudo nano /etc/logrotate.d/shop-appliances
```

**Nội dung:**
```
/opt/shop-appliances/storage/logs/*.log {
    daily
    rotate 30
    compress
    delaycompress
    missingok
    notifempty
    create 644 www-data www-data
    postrotate
        docker exec shop_app php artisan queue:restart > /dev/null 2>&1 || true
    endscript
}
```

### 3. System Monitoring

**Cài đặt monitoring tools:**
```bash
# htop để monitor system
sudo apt install -y htop

# ctop để monitor containers
sudo wget https://github.com/bcicen/ctop/releases/download/0.7.7/ctop-0.7.7-linux-amd64 -O /usr/local/bin/ctop
sudo chmod +x /usr/local/bin/ctop
```

### 4. Backup Script

**Tạo script backup tự động:**
```bash
nano backup-script.sh
```

**Nội dung:**
```bash
#!/bin/bash
BACKUP_DIR="/opt/backups"
DATE=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
docker exec shop_mysql mysqldump -u shop_user -p$DB_PASSWORD shop_db > $BACKUP_DIR/db_backup_$DATE.sql

# Backup uploaded files
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz storage/app/public/

# Keep only 7 days of backups
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Backup completed: $DATE"
```

**Setup cron job:**
```bash
chmod +x backup-script.sh
crontab -e

# Backup hằng ngày lúc 2:00 AM
0 2 * * * /opt/shop-appliances/backup-script.sh >> /var/log/backup.log 2>&1
```

---

## 📊 Monitoring và Maintenance

### 1. Container Status

```bash
# Check container status
docker-compose ps

# View logs
docker-compose logs -f
docker-compose logs app
docker-compose logs nginx
docker-compose logs mysql

# Resource usage
ctop
docker stats
```

### 2. Performance Tuning

**MySQL Optimization:**
- Điều chỉnh `docker/mysql/my.cnf` dựa trên RAM server
- Monitor slow queries

**Nginx Optimization:**
- Enable HTTP/2
- Configure worker processes
- Tune buffer sizes

**PHP-FPM Optimization:**
- Điều chỉnh `pm.max_children` trong PHP-FPM config
- Monitor memory usage

### 3. Security Best Practices

```bash
# Update containers regularly
docker-compose pull
docker-compose up -d

# Remove unused images
docker image prune -f

# Check for vulnerabilities
docker scan shop-appliances_app
```

---

## 🆘 Troubleshooting

### Common Issues

**1. Permission Errors:**
```bash
sudo chown -R $USER:$USER /opt/shop-appliances
docker exec shop_app chown -R www:www /var/www/storage
```

**2. Database Connection Issues:**
```bash
# Check MySQL container
docker-compose logs mysql

# Test connection
docker exec shop_app php artisan tinker
# Trong tinker: DB::connection()->getPdo();
```

**3. SSL Certificate Issues:**
```bash
# Check certificate validity
openssl x509 -in docker/nginx/ssl/cert.pem -text -noout

# Test SSL
curl -I https://yourdomain.com
```

**4. Out of Disk Space:**
```bash
# Clean Docker
docker system prune -af

# Clean logs
sudo journalctl --vacuum-time=7d
```

### Emergency Recovery

**Quick restart:**
```bash
docker-compose down
docker-compose up -d
```

**Full reset (⚠️ Data loss):**
```bash
docker-compose down -v
./deploy-linux.sh production
```

---

## 📈 Scaling và Optimization

### 1. Load Balancer Setup

**Nginx Load Balancer config:**
```nginx
upstream php_backend {
    server app1:9000;
    server app2:9000;
    server app3:9000;
}
```

### 2. Database Replication

- Setup MySQL Master-Slave
- Use read replicas cho queries

### 3. CDN Integration

- AWS CloudFront
- Cloudflare
- Configure static file serving

---

## ✅ Checklist Deploy Production

- [ ] Server có đủ resources (RAM, Storage)
- [ ] Firewall được cấu hình đúng
- [ ] SSL certificate valid
- [ ] .env file được cấu hình đúng
- [ ] Database backup được setup
- [ ] Log rotation được cấu hình
- [ ] Monitoring tools được cài đặt
- [ ] Auto-renewal SSL được setup
- [ ] Performance testing completed

---

## 🔗 Useful Commands

```bash
# One-liner để check tất cả
docker-compose ps && docker-compose logs --tail=50 && df -h && free -h

# Update application
git pull && ./deploy-linux.sh production

# Quick backup
docker exec shop_mysql mysqldump -u shop_user -p$DB_PASSWORD shop_db > backup_$(date +%Y%m%d).sql

# Monitor real-time logs
docker-compose logs -f app | grep ERROR

# Check application health
curl -I http://localhost/health-check
```

Chúc bạn deploy thành công! 🚀🐧 