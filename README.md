# Laravel API: Заказы и Исполнители

## Установка

1. Клонировать репозиторий:
```bash
git clone https://github.com/nikitab76/testApi.git

```

2. Установить зависимости:
```bash
composer install
```
3. Создать .env:
```bash
cp .env.example .env
```

4. Настроить .env и подключение к БД, затем:
``` bash
php artisan key:generate
php artisan migrate --seed
php artisan passport:install
```

## Основные эндпоинты
## Аутентификация (Passport)
| Метод | URL | Описание |
|-------|-----|----------|
| POST  | /api/passport/token | Получение токена |
| POST  | /api/passport/token/refresh | Обновление токена |
| GET   | /api/passport/tokens | Все токены пользователя |
| DELETE| /api/passport/tokens/{id} | Удаление токена |
| GET   | /api/passport/clients | Получение клиентов |
| POST  | /api/passport/clients | Создание клиента |
| PUT   | /api/passport/clients/{id} | Обновление клиента |
| DELETE| /api/passport/clients/{id} | Удаление клиента |

## Заказы
| Method	 | URL                       | Описание   |
|---------|---------------------------|------------------|
| POST    | 	/api/orders              | 	Создание заказа |
| POST    | 	/api/orders/{id}/assign	 |Назначение исполнителя|
| PATCH	  | /api/orders/{id}/status   | 	Обновление статуса (WS событие) |
## Исполнители
|Method| 	URL	               | Описание                      |
|------|---------------------|-------------------------------|
|POST	| /api/workers/filter | 	Фильтрация по типам заказов  |
