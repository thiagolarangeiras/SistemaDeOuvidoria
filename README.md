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


## Referencias

https://medium.com/@maravondra/mysql-in-docker-d7bb1e304473  
https://hub.docker.com/_/mysql  
https://hub.docker.com/r/mysql/mysql-server  

# Configurando o PHP com PDO

https://www.php.net/manual/en/pdo.installation.php  

criar um arquivo php.ini na pasta local do php