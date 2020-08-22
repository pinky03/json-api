# Инструкция по работе 
---

## Требования 

- Платформа: Lumen (7.2.1) (Laravel Components ^7.0)
- PHP: 7.3.9
- MariaDB 10.3
- Composer


## Установка

1. Клонировать репозиторий: `` git clone https://github.com/pinky03/json-api ``
2. Установить зависимости: `` composer install ``
3. Скопировать настройки окружения из *.env.example* в *.env*
3. Настроить подключение к БД в *.env*
3. Выполнить миграции: `` php artisan migrate:fresh ``
4. Сделать посев тестовых данных: `` php artisan db:seed ``

## Использование

1. Запустить тестовый сервер: `` php -S localhost:8001 -t public ``
 
2. Залогиниться под тестовым пользователем:  
Послать(POST) почту(*email*) и пароль(*password*) на *http://localhost:8001/login*.  
В ответе придёт *api_token* - токен доступа для запрошенного пользователя.  
**Данные тестового пользователя можно получить из .env(TEST_USER_EMAIL, TEST_USER_PASSWORD).** 
  
3. Используя полученный токен можно успешно обращаться по адресам:  
(GET) *http://localhost:8001/users* - получить всех пользователей. Есть фильтрация по параметру event(event_id).  
(GET) *http://localhost:8001/users/{id}* - получить пользователя по его id.  
(PUT) *http://localhost:8001/users* - сохранить нового пользователся. В логи выводится его почта.  
(POST) *http://localhost:8001/users/{id}* - обновить данные пользователя.  
(DELETE) *http://localhost:8001/users/{id}* - удалить пользователя.  

## Тесты
- Выполнить phpunit
