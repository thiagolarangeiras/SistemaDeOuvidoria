#docker stop teste3
#docker rm teste3
docker rm -f teste3
docker build -t teste3 .
docker run -d -p 8000:80 --name teste3 teste3
echo "ok"