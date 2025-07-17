# Laravel 8 Project

This is a Laravel 8 application. Follow the steps below to install, configure, and run it on your local machine.

---

## 🧰 Requirements

Make sure the following are installed on your system:

- PHP >= 7.3
- Composer
- MySQL (or any supported database)
- Node.js and npm (for frontend dependencies)
- Git

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/saimon-cse/kiu-job-portal
cd kiu-job-portal
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy the Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure `.env` File

Open the `.env` file and update the following sections:

#### 🔧 Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

#### 📧 Mail Configuration (using Gmail SMTP)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_email_password_or_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your_email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

> ⚠️ **Important**: If using Gmail, enable "Less secure app access" or use an App Password if 2FA is enabled.

### 6. Run Database Migrations

```bash
php artisan migrate
# Optional: php artisan db:seed
```

### 7. Install Node Modules (for Laravel Mix, Vue, or React)

```bash
npm install
npm run dev
```

### 8. Serve the Application

```bash
php artisan serve
```

Then visit the app in your browser:

```
http://127.0.0.1:8000
```

---

## 🛠 Common Artisan Commands

| Command                                           | Description                                 |
|--------------------------------------------------|---------------------------------------------|
| `php artisan migrate`                            | Run database migrations                     |
| `php artisan db:seed`                            | Seed the database                           |
| `php artisan config:clear`                       | Clear cached config                         |
| `php artisan route:list`                         | View all registered routes                  |
| `php artisan make:model ModelName -mcr`          | Create a model with migration, controller, and resource |

---

## 📁 Project Structure Overview

- `app/` – Application logic  
- `routes/web.php` – Web routes  
- `resources/views/` – Blade templates  
- `public/` – Public-facing files  
- `.env` – Environment configuration  

---

## 🧪 Testing

Run tests with:

```bash
php artisan test
```

---

## 📤 Deployment Notes

- Set proper permissions for `storage/` and `bootstrap/cache/`:

```bash
chmod -R 775 storage bootstrap/cache
```

- Optimize your app for production:

```bash
php artisan config:cache
php artisan route:cache
```

---


## 🤝 Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you'd like to change.

---

## 📬 Contact

**Saimon Islam**  
📧 saimonislam.cse@gmail.com  
<!-- 🔗 [yourwebsite.com](https://yourwebsite.com) -->
