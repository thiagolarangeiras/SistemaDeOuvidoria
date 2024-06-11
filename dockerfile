FROM ubuntu:latest
RUN apt update -y 
RUN apt upgrade -y
RUN apt install -y ca-certificates apt-transport-https
RUN apt install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php

RUN apt install -y php8.2 php8.2-fpm
#RUN apt-get install -y php-fpm
RUN apt install -y nginx


COPY default.conf /etc/nginx/sites-available/default
#COPY default.conf /etc/nginx/conf.d

COPY src /var/www/ouvidoria

COPY commands.sh /scripts/commands.sh
RUN ["chmod", "+x", "/scripts/commands.sh"]
EXPOSE 80

ENTRYPOINT ["/scripts/commands.sh"]