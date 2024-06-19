# Comandos utilitarios
Buildar uma imagem com um nome
```
docker build -t thiagolarangeira/php:3 . 
```

Buildar ignorando o cache
```
docker build --no-cache -t teste3 .
``` 

Trocar o nome da imagem (usar para dar push em uma imagem)
```
docker tag php thiagolarangeira/php:1
```

Dar push na imagem
```
docker push thiagolarangeira/php:1
```
Rodar um container com base em uma imagem passando variaveis de ambiente
```
docker run -d -p 8000:80 \
-e PHP_SERVER_NAME="a" \
-e PHP_USERNAME="a" \
-e PHP_PASSWORD="a" \
--name php thiagolarangeira/php:3
```

Entrar dentro do bash do container
```
docker exec -it php bash
```

Iniciar servicos dentro do container
```sh
service nginx statuss
service php8.2-fpm status
nginx
```


```
docker-compose -f "docker-compose.yml" up -d --build
docker build --no-cache -t u12_core -f u12_core .
```