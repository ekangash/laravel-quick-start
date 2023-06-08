# Образ certbot/certbot, 

Монтирует директорию `./certbot/conf` для сохранения файлов сертификатов, монтирует директорию`./certbot/www` для проверки 
доменного имени и использует переменные среды для настройки email и доменов. Также в этом примере используется переменная 
`CERTBOT_STAGING` для того, чтобы использовать песочницу `Let's Encrypt` для тестирования. 
Если вы хотите получить реальный сертификат, вы можете удалить эту переменную или установить ее значение в false.


# Конфигурационные команды certbot

```shell
certbot certonly --email kangash1996@gmail.com --agree-tos --nginx --staging -d {domainname}
```

```shell
certbot certonly --email kangash1996@gmail.com --standalone --preferred-challenges http -d localhost
```

* где:

- `certonly` — запрос нового сертификата;
- `webroot` — проверка будет выполняться на основе запроса к корню сайта;
- `agree-tos` — даем согласие на лицензионное соглашение;
- `email` — почтовый адрес администратора домена;
- `webroot-path` — каталог в системе Linux, который является корневым для сайта;
- `d` — перечисление доменов, для которых запрашиваем сертификат.


### Пример запроса при использовании веб-сервера NGINX:

```shell
certbot certonly --webroot --agree-tos --email postmaster@dmosk.ru --webroot-path /usr/share/nginx/html/ -d dmosk.ru -d www.dmosk.ru
```

[Руководство по настройке](https://www.digitalocean.com/community/tutorials/how-to-secure-nginx-with-let-s-encrypt-on-ubuntu-20-04-ru)

[Certbot документация](https://eff-certbot.readthedocs.io/en/stable/using.html#nginx)
