> <h1 align="center">ARKDivision</h1>
> <p align="center">
>   <img src="https://cdn.discordapp.com/attachments/636575768809439232/637432715901403137/logo-ark-france-division2.png" alt="ARKDivision Logo" height="80"/>
> </p>

> |PHP|PHP Extension|DBMS|NodeJS|npm|Others
> |---|---|---|---|---|---|
> |![PHP](https://img.shields.io/badge/PHP->=7.3-0e7fbf.svg?style=flat-square)|![OpenSSL](https://img.shields.io/badge/PHP%20ext-OpenSSL-44CB12.svg?style=flat-square)<br>![PDO](https://img.shields.io/badge/PHP%20ext-PDO-44CB12.svg?style=flat-square)<br>![Mbstring](https://img.shields.io/badge/PHP%20ext-Mbstring-44CB12.svg?style=flat-square)<br>![Tokenizer](https://img.shields.io/badge/PHP%20ext-Tokenizer-44CB12.svg?style=flat-square)<br>![XML](https://img.shields.io/badge/PHP%20ext-XML-44CB12.svg?style=flat-square)<br>![Ctype](https://img.shields.io/badge/PHP%20ext-Ctype-44CB12.svg?style=flat-square)<br>![JSON](https://img.shields.io/badge/PHP%20ext-JSON-44CB12.svg?style=flat-square)<br>![GD](https://img.shields.io/badge/PHP%20ext-GD-44CB12.svg?style=flat-square)<br>![CURL](https://img.shields.io/badge/PHP%20ext-CURL-44CB12.svg?style=flat-square)|![MySQL](https://img.shields.io/badge/MySQL->=5.7-44CB12.svg?style=flat-square)|![NodeJS](https://img.shields.io/badge/NodeJS->=8-44CB12.svg?style=flat-square)|![npm](https://img.shields.io/badge/npm->=5.6-44CB12.svg?style=flat-square)|![Analytics](https://img.shields.io/badge/Google-Analytics-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-Server-44CB12.svg?style=flat-square)<br>![Redis](https://img.shields.io/badge/Redis-PHPRedis-44CB12.svg?style=flat-square)
>

> ## Install
> After ServerPilot is installed : 
> - Install PhpRedis for PHP 7.3 (Client): https://serverpilot.io/community/articles/how-to-install-the-php-redis-extension.html
> - Install Redis (Server) : https://serverpilot.io/community/articles/how-to-install-redis.html
> - Install Supervisor : https://laravel.com/docs/5.6/queues#supervisor-configuration
> ```bash
> [program:xetaravel-worker]
> process_name=%(program_name)s_%(process_num)02d
> command=php /srv/users/serverpilot/apps/0website/artisan queue:work sqs --sleep=3 --tries=3
> autostart=true
> autorestart=true
> user=serverpilot
> numprocs=4
> redirect_stderr=true
> stdout_logfile=/srv/users/serverpilot/apps/0website/storage/logs/xetaravel-worker.log
> ```
>
> Then install the application :
> ```bash
> composer create-project xety/arkdivision
> ```
> Then you will need to migrate and seed your application:
> ```bash
> php artisan migrate
> php artisan db:seed
> ```
> Finally, you need to install and build the JS, CSS etc :
> ```bash
> php artisan vendor:publish --provider="Xetaio\Editor\EditorServiceProvider"
> npm run install
> npm run production
> ```
>
