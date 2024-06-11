#!/bin/bash

service php8.2-fpm start
service nginx start
tail -f /dev/null