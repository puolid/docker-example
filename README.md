# Docker example project

This project purpose is to represent how to create two Docker containers and run Apache, PHP and our web-application in one of them and in the other MySQL database. The application which we are using in this example is simple url shortener.


## Installation

Install [docker](https://docs.docker.com/install/) and [docker-compose](https://docs.docker.com/compose/install/) if you dont have them already installed.

Clone this repository
```bash
$ git clone https://github.com/puolid/docker-example.git
```

## Usage & config

To run this project you dont actually need to configurate anything just to build our web-application image and start the containers. If you want you can also give your own container names, sql usernames, passwords etc. on the cli and/or editing docker-compose.yml file.


### Docker network

Create new [docker network](https://docs.docker.com/network/) so our application server can connect to MySQL server.

To create new network type following command:
``` bash
$ docker network create mynetwork
```

### Apache-PHP container

For our Apache-PHP container we are using own [docker image](https://docs.docker.com/engine/reference/commandline/image/) which is created with [Dockerfile](https://docs.docker.com/engine/reference/builder/). To use it you need first to [build it](https://docs.docker.com/engine/reference/commandline/build/). 

To build our image type following command:
``` bash
$ docker build -t myproject-app .
```

After you have build our application image we can [run our container](https://docs.docker.com/engine/reference/run/).

To run our application container type following command.
``` bash
$ docker run --rm --name myproject-app --net my-network -p 80:80 -d -e MYSQL_HOST=myproject-db -e MYSQL_USER=admin -e MYSQL_DATABASE=test -e MYSQL_PASSWORD=passwd myproject-app
```

> Note. Our PHP-Application database class gets database settings from enviroinment (-e) variables so if you decied to change them remeber change them for mysql container too.


### MySQL container

For our MySQL container we are using offical [MySQL 5.7 image from docker hub](https://hub.docker.com/_/mysql). We are not using our own dockerfile to create image beacuse in this example we dont need to install anything else on it. 

So you might thinking now what happens to our database after we stop our container. With command [-v we are creating volume](https://docs.docker.com/storage/volumes/) which store our database to our local system. You can find this volume in that directory whuch you are at the moment when running command  below or change path what ever you wish to save that database replacing [$(pwd)](https://en.wikipedia.org/wiki/Pwd) which is variable se to the present working directory.

To run our MySQL server container type following command.
``` bash
$ docker run -p 3306:3306 -d --rm --name myproject-db --net my-network -e MYSQL_USER=admin -e MYSQL_DATABASE=test -e MYSQL_PASSWORD=passwd -e MYSQL_RANDOM_ROOT_PASSWORD=true -v $(pwd)/.data:/var/lib/mysql mysql:5.7
```

### Docker-compose

To run this example project on [docker compose](https://docs.docker.com/compose/) you need just first to build image of our Apache-PHP container. 

To build our image type following command:
``` bash
docker build -t myproject-app .
```

Docker-compose automatically builds, (re)creates, starts, and attaches to containers for a service.

``` bash
docker-compose up
```

## More depth tutorial what is happening

Its not here yet :|