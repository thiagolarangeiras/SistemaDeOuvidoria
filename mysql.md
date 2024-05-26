# Iniciando o container
`Atenção tudo pode ser feito usando o aplicativo tambem mas vou colocar os comandos tbm`

Puxar a ultima versão do mysql
```
docker pull mysql
```

Rodar o container
```
docker run --name mysql1 -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql:latest
```

Entrar no bash do container
```
docker exec -it mysql1 bash
```

Conectar no mysql por terminal  
ele vai pedir a senha depois do comando
```
mysql -u root -p
```

Mesmo assim o root ainda não tem permissão para ser acessado de fora do container  
pode se criar outro usuario com todas as rotas/ips liberadas "%"
```
CREATE USER 'php'@'%' IDENTIFIED BY 'php'; 
GRANT ALL PRIVILEGES ON *.* TO 'php'@'%' WITH GRANT OPTION; 
FLUSH PRIVILEGES;
```

## Referencias

https://medium.com/@maravondra/mysql-in-docker-d7bb1e304473  
https://hub.docker.com/_/mysql  
https://hub.docker.com/r/mysql/mysql-server  


# Configurando o PHP com PDO

https://www.php.net/manual/en/pdo.installation.php  

criar um arquivo php.ini na pasta local do php