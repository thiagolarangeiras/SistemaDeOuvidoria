#!/bin/bash

printf \
"[www] \n\
env[PHP_SERVER_NAME] =  %s \n\
env[PHP_USERNAME] = %s \n\
env[PHP_PASSWORD] = %s \n\
env[PHP_DATABASE] = %s \n\
env[PHP_EMAIL_TOKEN_PASSWORD] = \"%s\" \n\
env[PHP_MAILLER_KEY] = %s \n\
env[PHP_MAILLER_EMAIL] = %s \n\
" $PHP_SERVER_NAME $PHP_USERNAME $PHP_PASSWORD $PHP_DATABASE $PHP_EMAIL_TOKEN_PASSWORD $PHP_MAILLER_KEY $PHP_MAILLER_EMAIL >> /etc/php/"8.2"/fpm/php-fpm.conf
service php8.2-fpm start
service nginx start
tail -f /dev/null