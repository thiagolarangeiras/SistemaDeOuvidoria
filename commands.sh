#!/bin/bash

printf \
"[www] \n\
env[PHP_SERVER_NAME] =  %s \n\
env[PHP_USERNAME] = %s \n\
env[PHP_PASSWORD] = %s \n\
" $PHP_SERVER_NAME $PHP_USERNAME $PHP_PASSWORD >> /etc/php/"8.2"/fpm/php-fpm.conf
service php8.2-fpm start
service nginx start
tail -f /dev/null