# myproject

This project contains simple (and currently not so good) url shortener. 

## Usage & config

### Docker network

Create new docker network with following command:
``` bash
docker network create mynetwork
```

### Docker

#### Apache-PHP container

For Apache-PHP container we use our own image see Dockerfile. To run it use following command:

``` bash
docker run --rm --name myproject-app --net my-network -p 80:80 -d -e MYSQL_HOST=myproject-db -e MYSQL_USER=admin -e MYSQL_DATABASE=test -e MYSQL_PASSWORD=passwd myproject-app
```

Note. PHP application database class gets database settings from enviroinment (-e) variables so if you decied to change them remeber change them for mysql container too.

#### MySQL container

For MySQL container we use mysql 5.7 image from docker hub. You get container running with following command.

``` bash
docker run -p 3306:3306 -d --rm --name myproject-db --net my-network -e MYSQL_USER=admin -e MYSQL_DATABASE=test -e MYSQL_PASSWORD=passwd -e MYSQL_RANDOM_ROOT_PASSWORD=true -v $(pwd)/.data:/var/lib/mysql mysql:5.7
```
Command above creates volume for database which is saved to local computer.

### Docker-compose

