JoyReactor
==========

*Open microblogging engine on PHP/Symfony Framework*


Reactor — движок с открытым исходным кодом, позволяющий организовать собственный сервис микроблоггинга. Кроме того, архитектура Реактора обладает достаточно гибкостью, что дает возможность реализовать массу идей, в основе которых лежит общение пользователей друг с другом в формате коротких сообщений и комментариев.

## Возможности Реактора

 1. Ведение собственного микроблога 
   * постинг сообщений
   * картинок и видео
   * древовидные комментарии
   * почтовые уведомления
 2. Возможность указать настроение сообщения и следить за настроением других участников
 3. Социализация 
   * лента «друзей»
   * избранное
   * рейтинг пользователя
 4. Подписка на RSS

Проект живет здесь: https://github.com/Gropher/joyreactor

Пример работы системы: http://joyreactor.ru

Система находится в стадии перманентной доработки и активного бета-тестирования. Замечания, пожелания и помощь в развитии приветствуются.


## Рекомендуемые требования к ПО

1. ОС Linux/FreeBSD/Windows
2. Mysql 5.0 или выше
3. PHP 5.2 или выше
    * pdo
    * mod_pdo_mysql
    * gd
    * mbstring
4. Apache 2.2
    * mod_rewrite
5. Sendmail для рассылки уведомлений
6. SVN


## Инструкция по установке и настройке

1. Создаем базу данных с произвольным названием. Желательно также создать отдельного пользователя для этой базы данных (на локальном сервере можно ограничиться общим с правами админа всего на свете).

2. Скачиваем последнюю версию Реактора:

Понадобится GIT: `git clone https://github.com/Gropher/joyreactor`

3. Создаем для Реактора отдельный виртуальный хост (подробнее о настройке Apache под Windows можно почитать здесь — http://php-myadmin.ru/learning/instrument-apache.html). При установке под Windows httpd-vhosts.conf выглядит так:

```

<VirtualHost *:80>
  # Папка, в которой будет корень вашего хоста, где empaty — название хоста и адрес сайта соответственно. Важно дописать /web/ после www.
  DocumentRoot "C:/apache/empaty/www/web"
  DirectoryIndex index.php
  # Домен по которому вы сможете обращаться к виртуальному хосту.
  ServerName empaty
  # Алиас (добавочное имя) домена.
  ServerAlias www.empaty.ru
  # Файл, в который будут записываться ошибки.
  ErrorLog "C:/apache/empaty/error.log"
  # Файл журнала доступа к хосту.
  CustomLog "C:/apache/empaty/access.log" common
  <Directory "C:/apache/empaty/www/web">
    AllowOverride All
    allow from all
  </Directory>
  <Directory />
    AllowOverride All
    Allow from All
  </Directory>
  Alias /sf "C:/apache/empaty/www/lib/vendor/symfony/data/web/sf"
</VirtualHost>
```

При установке под Linux в настройки Apache дописываем примерно следующее.

```

DirectoryIndex index.php
DocumentRoot /var/www/vhosts/empaty/httpdocs/web
<Directory /var/www/vhosts/empaty/httpdocs/web>
  AllowOverride All
  from all
</Directory>
<Directory />
  AllowOverride All
  Allow from All
</Directory>
Alias /sf /var/www/vhosts/empaty/httpdocs/lib/vendor/symfony/data/web/sf
```

Это пишется вместо стандартного DirectoryIndex и DocumentRoot (их, соответственно, удаляем). При этом обратите внимание на то, что часто при работе с готовыми панелями управления сервером (например PLESK) и создании хоста с их помощью, в папке /var/www/vhosts/empaty/ содержится папка conf, в который и находятся настройки Apache применительно к данному хосту. В этом случае изменения вносить надо именно здесь.

4. При установке под Windows открываем консоль (Пуск - Выполнить - cmd) и переходим в папку с движком командой cd c:\apache\empaty\www\
При установке под Linux делаем то же самое: cd /var/www/vhosts/empaty/httpdocs/

Устанавливаем фреймворк Symfony следующим набором команд:

5. 
  - Под Windows: `symfony`
  - Под Linux: `sudo chmod 777 symfony`

6. 
  - Под Windows: `symfony project:permissions`
  - Под Linux: `sudo ./symfony project:permissions`

7. 
  - Под Windows: `symfony plugin:publish-assets`
  - Под Linux: `./symfony plugin:publish-assets`

8. Привязываем Реактор к созданной в шаге 1 базе данных: 
  -  Под Windows (необходимо подставить нужные данные и четко соблюдать синтаксис): `symfony configure:database --name=doctrine --class=sfDoctrineDatabase "mysql:host=localhost;dbname=ИМЯ_БАЗЫ" ИМЯ_ПОЛЬЗОВАТЕЛЯ ПАРОЛЬ`
  - Под Linux: `./symfony configure:database --name=doctrine --class=sfDoctrineDatabase "mysql:host=localhost;dbname=ИМЯ_БАЗЫ" ИМЯ_ПОЛЬЗОВАТЕЛЯ ПАРОЛЬ`

9. Устанавливаем дефолтную базу данных (в ответ на вопрос о перезаписи базы нажимаем 'y' и Enter)
  - Под Windows: `symfony doctrine:build-all-reload`
  - Под Linux: `./symfony doctrine:build-all-reload` — в ответ на вопрос о перезаписи базы нажимаем 'y' и Enter

10. Завершаем установку.
  - Под Windows: `symfony cc`
  - Под Linux: `./symfony cc`


## Настройка и администрирование Реактора.

Шаблон дизайна находится в папке /apps/frontend/templates/.

CSS-стили находятся в папке /web/css/.

По умолчанию панель администратора находится по адресу: http://empaty/backend.php

Данные администратора: логин: admin, пароль: admin

Сразу же после установки движка настоятельно рекомендуется изменить их через профиль пользователя admin.


## Спасибо за внимание
Надеемся, что Реактор окажется Вам полезен. 
Напоминаем также, что движок находится в стадии разработки и тестирования. В следующих публикациях попробуем более подробно остановиться на внешнем оформлении и настройке модулей Реактора.
