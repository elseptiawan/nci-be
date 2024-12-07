# Laravel Application Installation Guide

Welcome to the Laravel application! Follow these steps to set up and run the project on your local machine.

## Prerequisites

Ensure you have the following installed on your system:

- **PHP**: Version 8.1 or later
- **Composer**: Dependency Manager for PHP
- **MySQL** or another supported database
- **Git**: For cloning the repository

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/elseptiawan/nci-be
cd nci-be
```

### 2. Install Dependencies

Run the following command to install PHP dependencies:

```bash
composer install
```

### 3. Configure Environment Variables

Copy the `.env.example` file to create your `.env` file:

```bash
cp .env.example .env
```

Edit the `.env` file to configure your application settings, such as the database connection:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 4. Generate Application Key

Run the following command to generate a unique application key:

```bash
php artisan key:generate
```

### 5. Set Up the Database

Run the following commands to migrate the database and seed it with initial data (if applicable):

```bash
php artisan migrate
php artisan db:seed
```

### 6. Generate JWT Secret

If your application includes frontend assets, build them using:

```bash
php artisan jwt:secret
```

### 7. Start the Development Server

Use the Artisan command to start the local development server:

```bash
php artisan serve
```

Access api at:

```
http://localhost:8000/api
```

---

Thank you for using this Laravel application!

