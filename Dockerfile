FROM php:8.2-apache

# 将项目文件复制到容器
COPY . /var/www/html

# 设置工作目录
WORKDIR /var/www/html

# 如果需要 MySQL 支持，可添加扩展
RUN docker-php-ext-install mysqli
