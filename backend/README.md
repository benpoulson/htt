## Huel Tech Test - Serverside

### Overview
Authentication uses JWT tokens

### Installation
```
composer install
php artisan migrate:refresh --seed
php artisan serve
```

### Automated Testing
```
Unit Tests: php artisan test --testsuite=Unit
Feature Tests (Requires DB): php artisan test --testsuite=Feature
```

#### CI tests
```
all: composer run-script ci
phpstan: ./vendor/bin/phpstan analyse --memory-limit=2G
phpcs: ./vendor/bin/phpcs app --standard=phpcs.xml --report=full
phpmd: ./vendor/bin/phpmd app text phpmd.xml
```

#### Unit Tests:


#### Feature Tests (Requires migrations to be run):


