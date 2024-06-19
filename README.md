# Sistema De Ouvidoria
Projeto/Desafio de um sistema de ouvidoria em PHP   
[Requesitos do desafio](./docs/requesitos.md)   
Teste online: https://php-cg05.onrender.com

# Como rodar localmente
## pré-requisitos

### 1 Baixar o Docker 

### 2 Criar uma conta no [MailerSend](https://www.mailersend.com)  

* Criar um novo Dominio
* Criar um API token nesse dominio
* Criar um SMTP nesse dominio e pegar o username

## windows
```sh
cd src
php -S localhost:8000
```

## Docker 
### Criar uma banco mysql no docker
* [criar o servidor mysql](./mysql/readme.md)
* Criar a database com o [script](./mysql/database.sql)

### Buildar a imagem
```sh
docker build -t php .
```

### Rodar a imagem 
Alterar os valores das variaveis:   
> **PHP_SERVER_NAME:** local do servidor MYSQL. `host.docker.internal` é o servidor caso for docker local   

> **PHP_USERNAME:** nome de usuario para o MYSQL  

> **PHP_PASSWORD:** senha do usuario para o MYSQL     

> **PHP_DATABASE:** database que sera utilizada   

> **PHP_EMAIL_TOKEN_PASSWORD:** senha usada para gerar os tokens do email de confirmação (qualquer valor pode ser usado EX:123456)

> **PHP_MAILLER_KEY:** chave de acesso ao sistema que envia emails (https://www.mailersend.com) API token do dominio   

> **PHP_MAILLER_EMAIL:** email utilizado para enviar emails (https://www.mailersend.com) username do dominio
```
docker run -d -p 8000:80 \
-e PHP_SERVER_NAME="host.docker.internal:3306" \
-e PHP_USERNAME="php" \
-e PHP_PASSWORD="php" \
-e PHP_DATABASE="ouvidoria" \
-e PHP_EMAIL_TOKEN_PASSWORD="" \
-e PHP_MAILLER_KEY="" \
-e PHP_MAILLER_EMAIL="" \
--name php php
```

### Acessar
Em um navegador acesar: `localhost:8080/`