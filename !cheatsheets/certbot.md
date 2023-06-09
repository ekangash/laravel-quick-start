# Запуск Certbot

Свойство certonly в команде Certbot указывает, что вы хотите получить только SSL-сертификаты, но не хотите, чтобы Certbot 
автоматически настраивал веб-сервер (в данном случае Nginx) для использования полученных сертификатов.

Когда вы используете команду `certbot --nginx`, Certbot помимо получения сертификатов автоматически изменяет конфигурацию Nginx,
чтобы использовать новые сертификаты и настроить перенаправление с HTTP на HTTPS.

Однако, если вы хотите иметь полный контроль над настройками веб-сервера и предпочитаете настраивать его вручную, 
вы можете использовать certonly. Это означает, что Certbot только выполняет процесс получения сертификатов и сохраняет 
их на вашем сервере, но не изменяет конфигурацию веб-сервера.

После выполнения команды certonly вы можете самостоятельно настроить Nginx (в вашем случае) или любой другой веб-сервер
для использования полученных сертификатов и обеспечения поддержки HTTPS.

Использование certonly полезно, когда у вас уже есть настроенный веб-сервер, и вы хотите получить и 
установить SSL-сертификаты, не меняя его конфигурацию автоматически.

Команда certbot имеет множество опций и флагов для настройки процесса получения и управления сертификатами. 
Ниже приведен список основных опций с их объяснением:

1. certonly: Получение сертификата без автоматической настройки веб-сервера.
- `--webroot`: Использование каталога веб-корня для верификации домена.
- `--standalone`: Запуск временного веб-сервера Certbot для верификации домена.
- `--manual`: Ручная верификация домена с помощью пользовательских инструкций.
- `--nginx`: Использование Nginx для верификации домена и настройки сертификата.
- `--apache`: Использование Apache для верификации домена и настройки сертификата.
- `--dns`: Использование DNS-записей для верификации домена.
- и другие опции.

2. register: Регистрация нового аккаунта Let's Encrypt.
- `--email`: Указание адреса электронной почты для регистрации аккаунта.
- и другие опции.

3. update_account: Обновление информации о зарегистрированном аккаунте.
4. revoke: Отзыв сертификата.
- `--cert-path`: Путь к сертификату, который требуется отозвать.
- и другие опции.
5. delete: Удаление зарегистрированного аккаунта и связанных с ним данных.
6. certificates: Вывод списка установленных сертификатов.
7. renew: Обновление всех установленных сертификатов, которые приближаются к истечению.
8. rollback: Откат к предыдущей версии установленных сертификатов.
9. plugins: Вывод списка доступных плагинов Certbot и их статуса.

Чтобы получить подробную справку по каждой команде, вы можете использовать следующий синтаксис: certbot <команда> --help.
--version: Вывод версии Certbot.

# Опция certonly
certonly - это опция команды certbot, которая указывает Certbot выполнять только процесс генерации сертификата, 
без автоматической настройки веб-сервера. При использовании опции `certonly`, Certbot будет запрашивать и получать сертификат, 
но не будет вносить изменения в конфигурацию веб-сервера. Это полезно, если уже есть настроенный веб-сервер и нужно только
получить новый или обновить существующий сертификат.

При использовании certonly вместе с другими опциями, такими как `--nginx` или `--apache`, Certbot будет использовать указанный 
веб-сервер для верификации владения доменом и получения сертификата, но не будет автоматически изменять конфигурацию сервера.

Важно отметить, что `certonly` команда не настраивает автоматически веб-сервер на использование сертификатов.
После успешной генерации сертификатов, необходимо настроить веб-сервер на использование этих сертификатов.
Либо использовать соответствующие плагины которые выполняют эту функцию автоматически.

Запуск Certbot с помощью `certonly` команды приведет к получению сертификата и размещению его в каталоге `/etc/letsencrypt/live`. 

```shell
certbot certonly --nginx --agree-tos --email kangash1996@gmail.com --preferred-challenges http -d {your domain name} --staging
```

## Флаг --staging

Флаг `--staging` в команде Certbot используется для запроса сертификата в тестовой среде Let's Encrypt, которая имитирует
среду продакшн, но не выпускает реальных сертификатов, а использует тестовые сертификаты, которые не являются доверенными д
ля браузеров. Это позволяет проверить, работает ли настройка Certbot и среда вашего сервера до того, как запросить и
установить настоящий SSL-сертификат. Это очень полезно для тестирования настройки Certbot и обеспечения правильной работы
скриптов автоматического обновления сертификатов перед их выкаткой на продакшн.

### Можно ли certbot сертификат настроить для тестового окружения на локальной машине?

Да, можно настроить certbot для тестового окружения на локальной машине. Certbot предоставляет возможность использовать
тестовые сертификаты, которые не будут включать реальных доменных имен и не будут иметь ограничений на количество запросов.

Чтобы использовать тестовый режим, вам нужно добавить флаг `--staging` к команде certbot. Например, использовать следующую команду:

```shell
sudo certbot --nginx -d example.com -d www.example.com --staging
```
Флаг --staging указывает Certbot использовать тестовое окружение ACME, где вы можете выполнять тестовые запросы на сертификаты.
В противном случае Certbot будет работать в боевом окружении и попытается получить действующий сертификат.

Когда вы используете тестовый режим, Certbot выдает сертификаты, которые не являются действительными для настоящих доменных имен.
Однако, можно использовать эти сертификаты для тестирования веб-сайта на локальной машине.

Обратите внимание, что тестовые сертификаты имеют срок действия 90 дней, как и настоящие сертификаты, но вам не нужно ждать 90 дней,
чтобы получить новый тестовый сертификат. Вы можете запросить новый тестовый сертификат в любое время, когда вам это нужно.

## Флаг --nginx
Аргумент --nginx в команде certbot certonly указывает Certbot'у использовать Nginx для проверки владения доменом и 
автоматической настройки SSL-сертификата.

При использовании `--nginx`, Certbot будет взаимодействовать с Nginx сервером, чтобы установить временный файл конфигурации,
который выполняет проверку владения доменом. Certbot временно изменит конфигурацию Nginx для добавления указанных доменов
и настроит виртуальные хосты для обработки ACME-запросов для подтверждения владения доменом. После успешной проверки Certbot
удалит временные файлы конфигурации и вернет Nginx в исходное состояние.

Использование --nginx упрощает процесс получения и установки SSL-сертификатов для Nginx серверов, особенно если у вас 
уже настроен Nginx и есть виртуальные хосты для ваших доменов. 
Certbot будет автоматически настраивать и обновлять конфигурацию Nginx для вас.

Для использования флага `--nginx` в Certbot должен быть установлен плагин `python3-certbot-nginx`.

## Флаг --webroot

Указывает, что используется метод проверки владения доменом через webroot. Этот метод предполагает, что на сервере уже
есть установленный веб-сервер, который хостит сайт и с которым можно взаимодействовать через файловую систему.

Когда `certbot` запускается с параметром `--webroot`, он создает временные файлы в папке webroot, которые служат для
подтверждения владения доменом. Затем он обращается к этим файлам через веб-сервер, чтобы убедиться, что они действительно 
доступны из Интернета. Если файлы доступны, certbot продолжает процедуру выдачи сертификата.

Таким образом, использование `--webroot` позволяет certbot автоматически создавать и удалять временные файлы на сервере 
для проверки владения доменом, что упрощает процесс выдачи сертификата.

Также стоит указать путь хранения временных фалов флагом `--webroot-path=/var/www/certbot`

## Флаг --break-my-certs

Аргумент `--break-my-certs` для команды `certbot certonly` предоставляет возможность перезаписать (сломать) существующий 
сертификат и заменить его тестовым сертификатом.

Обычно Certbot не перезаписывает действующие сертификаты без явного указания, чтобы избежать непреднамеренного удаления 
или замены сертификатов в продакшен-среде. Однако, если вы хотите сделать это намеренно для тестовых или отладочных целей, 
вы можете использовать `--break-my-certs`.

Этот аргумент предупреждает о том, что сертификат будет сломан (заменен тестовым сертификатом), и запрашивает ваше
подтверждение для продолжения операции. Будьте осторожны при использовании этого аргумента, так как он может негативно 
повлиять на работу вашего веб-сервера и безопасность веб-сайта.

## Флаг --preferred-challenges http

Флаг `--preferred-challenges` в команде certbot позволяет указать предпочитаемые методы проверки владения доменом при 
получении сертификата. Этот флаг принимает список значений, разделенных запятыми, которые определяют порядок предпочтительности методов.

от некоторые из наиболее часто используемых значений для флага --preferred-challenges:

- `http` - метод HTTP-01, который использует запросы по протоколу HTTP для проверки владения доменом. Certbot ожидает, 
  что ваш веб-сервер предоставит определенный файл по определенному пути для подтверждения владения доменом.

- `dns` - метод DNS-01, который требует внесения определенной DNS-записи в вашу зону DNS для подтверждения владения доменом. 
  Certbot предоставит вам инструкции о том, какую DNS-запись необходимо добавить.

### Значение http

Аргумент `--preferred-challenges http` в команде **certbot certonly** указывает Certbot'у, что предпочтительным методом
для проверки владения доменом является использование протокола HTTP-01.

При запросе сертификата Certbot должен доказать, что вы имеете контроль над доменом, для которого запрашивается сертификат. 
Для этого Certbot выполняет специальные вызовы к вашему серверу и ожидает ответа с определенными данными.

Метод `http` означает, что Certbot отправит запрос на ваш веб-сервер по HTTP протоколу, чтобы проверить доступность домена.
Certbot ожидает, что ваш веб-сервер предоставит определенный файл с заданным содержимым по определенному пути. 
Если ваш сервер правильно отвечает на этот запрос, Certbot считает, что вы контролируете домен и может выпустить сертификат.

Использование метода http часто является удобным и простым способом проверки домена, особенно при настройке Let's Encrypt сертификатов. 
Он не требует дополнительной конфигурации DNS и может быть реализован на большинстве веб-серверов.

Однако, чтобы использовать метод http, ваш веб-сервер должен быть `доступен извне` и иметь `публичный IP-адрес` или быть настроенным 
с использованием прокси или порт-форвардинга, чтобы Certbot мог успешно выполнить проверку.

# Как указать куда нужно складывать файлы сертификата?

По умолчанию Certbot сохраняет файлы сертификата в директорию `/etc/letsencrypt/live/`, а символические ссылки на последнюю 
версию сертификата создаются внутри поддиректории с именем домена.
Например, для домена example.com, файлы сертификата будут находиться в `/etc/letsencrypt/live/example.com/`.

Вы можете указать путь для хранения сертификатов с помощью опции `--config-dir` в команде certbot certonly. Например:

```shell
certbot certonly --nginx --agree-tos --staging --config-dir /path/to/custom/directory
```
В этом случае Certbot будет сохранять файлы сертификата в указанной пользователем директории.

После успешной генерации сертификата Certbot сохраняет несколько файлов в директории, которую вы указали. Эти файлы включают:

- `privkey.pem` - приватный ключ SSL-сертификата.
- `cert.pem` - публичный ключ SSL-сертификата.
- `chain.pem` - цепочка сертификатов содержащая сертификаты промежуточных удостоверяющих центров, которые были использованы 
  для проверки валидности SSL-сертификата.
- `fullchain.pem` - полная цепочка сертификатов, включая SSL-сертификат и промежуточные сертификаты.

Эти файлы могут быть использованы для настройки сервера веб-приложений, такой как Nginx, чтобы обеспечить HTTPS-защиту для сайта.


# Что такое самочинный SSL сертификат?

## Можно ли certbot сертификат настроить для тестового окружения на локальной машине?

Certbot требует наличия доменного имени, даже в тестовом режиме, и не может выдать сертификат для домена "localhost",
так как он не содержит хотя бы одной точки в имени.

Вместо использования домена "localhost" в качестве цели для сертификата, вы можете зарегистрировать тестовый домен, 
который не используется в реальности, чтобы получить тестовый сертификат. Например, вы можете использовать доменное 
имя "example.com" или любое другое доменное имя, которое вам удобно. Затем вы можете настроить свой сервер и DNS,
чтобы указать этот тестовый домен на вашу локальную машину.

# Использовать контейнер certbot или устанавливать окружение в контексте контейнера сервера nginx

Контейнер certbot используется для автоматического получения и обновления SSL-сертификатов Let's Encrypt для приложения, 
которое работает в контейнере nginx. Этот контейнер выполняет задачу получения сертификата от Let's Encrypt и сохранения 
его в определенных директориях, на которые монтируются тома в контейнере nginx. 
Это позволяет приложению в контейнере nginx использовать защищенное соединение HTTPS.

В другом случае нужно установить certbot в контейнер nginx и настроить его для автоматического получения и обновления
SSL-сертификатов Let's Encrypt. Это может потребовать изменения файла Dockerfile для контейнера nginx и изменения настроек его конфигурации.
