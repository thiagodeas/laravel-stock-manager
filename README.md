# Laravel Stock Manager

**Laravel Stock Manager** is an inventory management system built with Laravel 11 and PHP 8.3. It allows you to manage products, categories, stock entries, stock exits, and generate reports based on these transactions. The system uses a MySQL database to store all the necessary information about products and their movements.

This project is containerized with Docker to ensure easy setup and development. It includes all the dependencies needed to run the Laravel application.

## 🚀 Project Setup

This project uses the Docker template from [especializati/setup-docker-laravel](https://github.com/thiagodeas/setup-docker-laravel) with Laravel 11 and PHP 8.3.

### Clone the repository

```bash
git clone https://github.com/thiagodeas/laravel-stock-manager.git laravel-stock-manager
cd laravel-stock-manager
```

### Start Docker containers

```bash
docker-compose up -d
```
### Create .env file

```bash
cp .env.example .env
```

### Access the app container

```bash
docker-compose exec app bash
```

### Install dependencies

```bash
composer install
```

### Generate Laravel App key

```bash
php artisan key:generate
```

### Run migrations

```bash
php artisan migrate
```

### Generate JWT secret

Run the following command to generate the JWT secret key:

```bash
php artisan jwt:secret
```

This will add a JWT_SECRET key to your .env file, which is required for authentication.

Access the project at [http://localhost:8000](http://localhost:8000).