# Testar local windows
```sh
cd src
php -S localhost:8000
```

# Docker 
```sh
docker build -t ouvidoria-image .

docker run -d -p 80:80 --name ouvidoria-container ouvidoria-image

docker-compose -f "docker-compose.yml" up -d --build

docker build --no-cache -t u12_core -f u12_core .

docker build --no-cache -t teste3 .

docker run -d -p 8000:80 --name teste3 teste3
docker run -d -p 8000:80 teste3
```

# util
```sh
service nginx status #checa se esta rodando
nginx #roda
service php8.2-fpm status

service", "", 
```

  docker exec -it teste3 bash

/usr/sbin/php-fpm8.2