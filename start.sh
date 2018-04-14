#/bin/bash

// map "something.in" and "auth.something.in" to 127.0.0.1

docker network create outnet

cd authService
docker-compose up -d

cd ../service
docker-compose up -d

cd ../lb
docker-compose up -d

echo "Browse http://something.in/service, user:secret"