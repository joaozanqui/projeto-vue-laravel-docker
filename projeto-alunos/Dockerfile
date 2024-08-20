FROM wyveo/nginx-php-fpm:latest

COPY . /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/html

RUN [ ! -L html ] && ln -s public html || echo "Link 'html' already exists"
RUN apt update; \
    apt install vim -y

EXPOSE 80
