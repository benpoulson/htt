## Huel Tech Test

### Overview
Authentication uses JWT tokens

### Installation via Docker
1. Run `docker network create laravel`

2. Run `docker-compose up`

Navigate to http://localhost:4200 for the frontend Angular App

Navigate to http://localhost:8080 for the backend Laravel API

### Manual installation

Backend: 
```
cd backend
composer install
php artisan migrate:refresh --seed
php artisan serve
```

Frontend
```
cd frontend
npm install
npm start
```


### Automated Testing (Backend)
```
Unit Tests: php artisan test --testsuite=Unit
Feature Tests (Requires DB): php artisan test --testsuite=Feature
```

#### CI tests (Backend)
```
all: composer run-script ci
phpstan: ./vendor/bin/phpstan analyse --memory-limit=2G
phpcs: ./vendor/bin/phpcs app --standard=phpcs.xml --report=full
phpmd: ./vendor/bin/phpmd app text phpmd.xml
```

