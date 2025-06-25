# 🚀 Docker Quick Reference Guide

## 📁 Files và cách sử dụng

### 🔵 **docker-compose.yml** - Development
**Khi nào dùng:** Phát triển local, test trên Windows/macOS
```bash
# Start development environment
docker-compose up -d

# View logs
docker-compose logs -f

# Stop
docker-compose down
```

### 🟢 **docker-compose.prod.yml** - Production  
**Khi nào dùng:** Deploy lên server Linux production
```bash
# Start production environment
docker-compose -f docker-compose.prod.yml up -d --build

# View logs
docker-compose -f docker-compose.prod.yml logs -f

# Stop
docker-compose -f docker-compose.prod.yml down
```

---

## 🎯 **Chọn file nào?**

### 💻 **Development (Local):**
```bash
# Đơn giản
docker-compose up -d
```
- ✅ Code hot reload
- ✅ Debug enabled  
- ✅ Database exposed ports
- ✅ Easy development

### 🌐 **Production (Server):**
```bash
# Sử dụng production file
docker-compose -f docker-compose.prod.yml up -d

# Hoặc dùng deploy script (tự động)
./deploy-linux.sh production
```
- ✅ Optimized for production
- ✅ Security hardened
- ✅ Environment variables
- ✅ Proper volume management
- ✅ Backup service included

---

## 📊 **Khác biệt chính:**

| Feature | Development | Production |
|---------|-------------|------------|
| **Ports** | All exposed | Secured (localhost only) |
| **Debug** | Enabled | Disabled |
| **Volumes** | Code mounting | Separated data volumes |
| **SSL** | Optional | Required |
| **Environment** | .env optional | .env required |
| **Performance** | Fast rebuild | Optimized |

---

## ⚡ **Commands thường dùng:**

### **Development:**
```bash
# Start
docker-compose up -d

# Rebuild after code changes
docker-compose up -d --build

# View app logs
docker-compose logs app -f

# Enter container
docker-compose exec app bash

# Stop everything
docker-compose down
```

### **Production:**
```bash
# Deploy script (recommended)
./deploy-linux.sh production

# Manual deployment
docker-compose -f docker-compose.prod.yml up -d --build

# View logs
docker-compose -f docker-compose.prod.yml logs -f

# Enter app container
docker-compose -f docker-compose.prod.yml exec app bash

# Stop production
docker-compose -f docker-compose.prod.yml down
```

---

## 🔧 **Environment Setup:**

### **Development (.env optional):**
```env
APP_DEBUG=true
APP_ENV=local
DB_HOST=mysql
```

### **Production (.env required):**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_PASSWORD=strong_password_here
MYSQL_ROOT_PASSWORD=root_password_here
REDIS_PASSWORD=redis_password_here
```

---

## 🎯 **Tóm tắt:**

### 🖥️ **Local Development:**
```bash
git clone <repo>
cd shop-appliances
docker-compose up -d
# Access: http://localhost
```

### 🌐 **Server Production:**
```bash
git clone <repo>
cd shop-appliances
cp .env.example .env
nano .env  # Edit config
./deploy-linux.sh production
# Access: http://your-server-ip
```

**Just 2 files, simple choice! 🎉** 