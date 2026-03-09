## Проект состоит из Front-End и Back-End.

#### Front-End выполнен на Vue3.  
#### Back-End выполнен на Laravel.

## Запуск приложения:
Убедиться в том, что у Вас в .env все переменные корректны, например, что DB_CONNECTION выставлена со значением для Вашей базы данных.

В директории frontend выполнить команды:
```
npm run install
```
```
npm run build
```

В директории backend выполнить команды:
```
composer install
```
```php
php artisan migrate
php artisan migrate --seed
```

### Education:
#### Commands:
```php
php artisan make:migration create_posts_table - создание миграции posts
```
Причем по этой команде laravel поймет, что нужно создать таблицу posts и одноименный класс.

```php
php artisan migrate - запуск миграция
php artisan migrate:rollback - откат последней миграции
php artisan migrate:reset - откат всех миграций
```
```php
php artisan migrate - запуск только миграций
php artisan migrate --seed - запуск миграций с сидерами
php artisan db:seed - запуск только сидеров

php artisan migrate:fresh - перезапуск миграций, откат миграций и запуск
php artisan migrate:fresh --seed - перезапуск с сидерами
```

#### Materials
В версии 12 Laravel удобно создавать [контроллеры ресурсов](https://laravel.com/docs/12.x/controllers#resource-controllers).  

Генерируется контроллер с помощью команды:
```php
php artisan make:controller ExampleController --resource
```

С помощью команды генерируется констроллер в app/Http/Controllers/, где будут все необходимые методы для всех маршрутов.
То есть прописывать множество маршрутов самостоятельно не нужно.

Все маршрут можно посмотреть по команде:
```php
php artisan route:list
```