#docker stop teste3
#docker rm teste3
docker rm -f php
docker build -t php .

docker run -d -p 8000:80 \
-e PHP_SERVER_NAME="host.docker.internal:3306" \
-e PHP_USERNAME="php" \
-e PHP_PASSWORD="php" \
-e PHP_DATABASE="ouvidoria" \
-e PHP_EMAIL_TOKEN_PASSWORD="" \
-e PHP_MAILLER_KEY="" \
-e PHP_MAILLER_EMAIL="" \
--name php php

echo "ok"