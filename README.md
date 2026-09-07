![PHP Version](https://img.shields.io/badge/PHP-8.2-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![PDO](https://img.shields.io/badge/PDO-Enabled-brightgreen)

<img width="464" height="29" alt="logo" src="https://create.online-letters.ru/letters/i/cyrillictechno/3688/51b749/60/0/jp8w6unpeijigtkqe7nir.png" />

<img width="1316" height="646" alt="cover" src="https://github.com/koolkid90/koolmessenger/blob/main/cover.png" />
<img width="1319" height="640" alt="cover2" src="https://github.com/koolkid90/koolmessenger/blob/main/cover2.png" />

**Обработка ошибок:** Все PDO-запросы обёрнуты в `try-catch`. В случае ошибки соединения или выполнения запроса пользователь увидит понятное сообщение, а детали ошибки пишутся в лог сервера (`error_log`). Это предотвращает появление "белого экрана" (WSOD).

**Безопасность:** Пароли хешируются с помощью `password_hash()`, используется CSRF-защита, а все SQL-запросы выполняются через PDO с подготовленными выражениями для защиты от инъекций. Также присутствует защита от XSS-атак.

**Архитектура:** Код организован в классы (ООП) и разделён по логическим модулям (авторизация, чат, поиск, стартер), что упрощает его поддержку.



**Есть функции:**

:boom: Защита от SQL-инъекций

:boom: Защита от XSS-атак

:boom: Отладка ошибок Try/Catch всего мессенджера

:boom: Адаптивный дизайн с анимированными alert и Confirm

:boom: Регистрации

:boom: Поиска диалогов

:boom: Проверки логина и пароля

:boom: Создания диалогов

:boom: Удаления диалогов

:boom: Удаления сообщений

:boom: Отправки сообщений

:boom: Автоматического создания всех баз данных при их отсутствии

:boom: Без перехода по страницам, все в одном окне

:boom: Добавлена функция избранного в чате

:boom: Добавлена защита от CSRF-атак

:boom: Добавлено хэширование паролей в БД

Настройки БД - settings/settings.php

Пока реализовано в базовом варианте на Long Poliing, в дальнейшем планируется переход на сокеты

🚀 Установка

1. Клонируйте репозиторий
2. Настройте `settings/settings.php`
3. Запустите в браузере `index.php`
