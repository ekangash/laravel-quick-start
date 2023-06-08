FROM nginx

# Обновление индексов пакетов и установка необходимых пакетов
RUN apt-get update && apt-get install -y nano certbot python3-certbot-nginx

# Создание каталога для хранения сертификатов
RUN mkdir -p /etc/letsencrypt/

# Создание каталога для хранения Let's Encrypt сертификатов
RUN mkdir -p /var/www/certbot

# Копирование конфигурационного файла nginx
ADD ./default.conf /etc/nginx/conf.d/default.conf

# Открытие портов
EXPOSE 80
EXPOSE 443

# Назначение корневого каталога
WORKDIR /var/www

# Запуск команды для старта Nginx в фоновом режиме
CMD ["nginx", "-g", "daemon off;"]
