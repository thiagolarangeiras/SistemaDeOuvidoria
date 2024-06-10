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
```