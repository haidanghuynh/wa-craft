# Hướng Dẫn Triển Khai

Tài liệu này hướng dẫn cách triển khai ứng dụng SPA trên bất kỳ máy tính nào mà không cần XAMPP hay MAMP.

## Chọn Database

Ứng dụng hỗ trợ **2 loại database**:

### 1. SQLite (Đơn giản - Development)
- ✅ Không cần cài MySQL
- ✅ Zero configuration
- ✅ Dễ deploy và test
- ❌ Không phù hợp production lớn

### 2. MySQL (Chuyên nghiệp - Production)
- ✅ Hiệu suất cao
- ✅ Hỗ trợ concurrent users tốt
- ✅ Phù hợp production
- ❌ Cần cài và config MySQL

---

## Triển Khai với SQLite

### Windows (PowerShell)

```powershell
.\deploy.ps1
```

### Ubuntu/Linux

```bash
chmod +x deploy.sh
./deploy.sh
```

---

## Triển Khai với MySQL

### Windows (PowerShell)

```powershell
.\deploy-mysql.ps1
```

**Lưu ý:** Script sẽ hỏi MySQL root password để tạo database.

### Ubuntu/Linux

```bash
chmod +x deploy-mysql.sh
./deploy-mysql.sh
```

**Nếu chưa có MySQL**, script sẽ **tự động cài đặt** và config.

---

## Thông Tin Database (MySQL)

Sau khi chạy script MySQL thành công:

```
Database: spa_db
User: spa_user
Password: spa_password123
Host: localhost
```

**Đổi thông tin:** Sửa biến trong script trước khi chạy:
```bash
DB_NAME="spa_db"
DB_USER="spa_user"
DB_PASS="your_password"
```

---

## Script Làm Gì

### SQLite Scripts (`deploy.ps1` / `deploy.sh`)

1. ✅ Check PHP & extensions (sqlite3, pdo_sqlite)
2. ✅ Tạo file `database/app.db`
3. ✅ Import `database/seed.sql`
4. ✅ Start server tại `http://localhost:8000`

### MySQL Scripts (`deploy-mysql.ps1` / `deploy-mysql.sh`)

1. ✅ Check PHP & extensions (mysqli, pdo_mysql)
2. ✅ Check/Install MySQL server
3. ✅ Tạo database `spa_db` và user `spa_user`
4. ✅ Convert SQLite SQL → MySQL SQL
5. ✅ Import seed data
6. ✅ Tạo `config/database.php`
7. ✅ Start server

---

## Cài PHP Thủ Công (Windows)

Nếu PHP chưa được cài:

1. Tải từ: https://windows.php.net/download
2. Chọn "Thread Safe" ZIP
3. Giải nén vào `C:\php`
4. Thêm `C:\php` vào PATH
5. Copy `php.ini-development` → `php.ini`
6. Bật extensions trong `php.ini`:

**SQLite:**
```ini
extension=sqlite3
extension=pdo_sqlite
extension=mbstring
extension=json
```

**MySQL:**
```ini
extension=mysqli
extension=pdo_mysql
extension=mbstring
extension=json
```

---

## Cài MySQL (Windows)

1. Tải từ: https://dev.mysql.com/downloads/installer/
2. Chạy MySQL Installer
3. Chọn **"Developer Default"**
4. Đặt root password (ghi nhớ để dùng với script)
5. Hoàn tất cài đặt

---

## Chuyển Đổi Database

### SQLite → MySQL

```bash
# Chạy script MySQL lại
./deploy-mysql.sh
```

Data sẽ được import lại từ `seed.sql`.

### MySQL → SQLite

```bash
# Chạy script SQLite
./deploy.sh
```

---

## Xử Lý Lỗi

### Lỗi MySQL Root Password

**Ubuntu:**
```bash
sudo mysql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'yourpassword';
FLUSH PRIVILEGES;
exit
```

**Windows:**
- Reset password qua MySQL Installer
- Hoặc dùng mysqladmin

### Lỗi Permission Database

**SQLite:**
```bash
chmod 666 database/app.db
chmod 777 database
```

**MySQL:**
```sql
GRANT ALL PRIVILEGES ON spa_db.* TO 'spa_user'@'localhost';
FLUSH PRIVILEGES;
```

### Port 8000 Đã Dùng

Đổi port trong script:
```bash
php -S localhost:3000 router.php  # Thay 8000 → 3000
```

### PHP Extensions Thiếu

**Windows:**
- Mở `php.ini`
- Bỏ comment (xóa `;`) trước `extension=...`
- Restart terminal

**Ubuntu:**
```bash
sudo apt install php-sqlite3 php-mysql php-mbstring
```

---

## Kiểm Tra Ứng Dụng

Sau khi deploy:

1. Mở trình duyệt: `http://localhost:8000`
2. Test các trang:
   - 🏠 Trang chủ
   - 🛠️ Dịch vụ
   - 📝 Blog
   - 👥 Team
   - 📧 Liên hệ
3. Test chuyển ngôn ngữ (VI ⇄ JA)

---

## Dừng & Khởi Động Lại

**Dừng server:** `Ctrl + C`

**Khởi động lại:**

SQLite:
```bash
./deploy.sh        # Linux
.\deploy.ps1       # Windows
```

MySQL:
```bash
./deploy-mysql.sh     # Linux
.\deploy-mysql.ps1    # Windows
```

---

## Production Deployment

Khi deploy lên production:

1. ✅ Dùng **MySQL** thay vì SQLite
2. ✅ Đổi password mạnh trong `config/database.php`
3. ✅ Dùng Nginx/Apache thay vì PHP built-in server
4. ✅ Bật OPcache để tăng tốc
5. ✅ Setup HTTPS với SSL certificate
6. ✅ Tạo user MySQL riêng với quyền hạn chế
7. ✅ Backup database định kỳ

**Ví dụ Nginx config:**
```nginx
server {
    listen 80;
    server_name example.com;
    root /var/www/spa/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
    }
}
```

---

## Hỗ Trợ

Nếu gặp vấn đề:
- Kiểm tra log lỗi trong terminal
- Xem file `config/database.php`
- Test MySQL connection: `mysql -u spa_user -p spa_db`
- Liên hệ team phát triển

---

**Khuyến nghị:**
- Development: Dùng **SQLite** (nhanh, đơn giản)
- Production: Dùng **MySQL** (tin cậy, scalable)
