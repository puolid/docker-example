# Docker example project


The purpose of this project is present how to create two [Docker](https://www.docker.com/) containers and run [Apache](https://httpd.apache.org/), [PHP](https://www.php.net/) and our web-application in one of them and in the other [MySQL](https://www.mysql.com/) database. The application which we are using in this example is simple [url shortener](https://en.wikipedia.org/wiki/URL_shortening).


## Installation

Install [docker](https://docs.docker.com/install/) and [docker-compose](https://docs.docker.com/compose/install/) if you dont have them already installed.

Clone this repository
```bash
$ git clone https://github.com/puolid/docker-example.git
```

## Usage & config

To run this project you can use [docker](https://docs.docker.com/engine/docker-overview/) or [docker-compose](https://docs.docker.com/compose/). This project uses default http&mysql server ports (80 and 3306) so if them already in use, remember to change them.


### Docker

To get our containers running I recommend to look first our [Dockerfile](https://github.com/puolid/docker-example/blob/master/Dockerfile). After that follow this instruction

#### Docker network

Create new [docker network](https://docs.docker.com/network/) so our application server can find/connect to MySQL server. Containers in same network can call each other by container name.

To create new network type following command:
``` bash
$ docker network create mynetwork
```

#### Apache-PHP container

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


#### MySQL container

For our MySQL container we are using offical [MySQL 5.7 image from docker hub](https://hub.docker.com/_/mysql). We are not using our own dockerfile to create image beacuse in this example we dont need to install anything else on it. 

So you might thinking now what happens to our database after we stop our container. With command [-v we are creating volume](https://docs.docker.com/storage/volumes/) which store our database to our local system. You can find this volume in that directory where you are at the moment when running command  below or change path what ever you wish to save that database replacing [$(pwd)](https://en.wikipedia.org/wiki/Pwd) which is variable se to the present working directory.

To run our MySQL server container type following command.
``` bash
$ docker run -p 3306:3306 -d --rm --name myproject-db --net my-network -e MYSQL_USER=admin -e MYSQL_DATABASE=test -e MYSQL_PASSWORD=passwd -e MYSQL_RANDOM_ROOT_PASSWORD=true -v $(pwd)/.data:/var/lib/mysql mysql:5.7
```

Now you should have MySQL container up and running, because we dont currently have database which our application uses lets create it.

To get [inside of docker container](https://docs.docker.com/engine/reference/commandline/exec/) type following command:
``` bash
$ docker exec -it myproject-db bash
```

Next run MySQL cli with command:
``` bash
$ mysql -u admin -p
```

> When we started our container we set username to "admin" and password to "passwd"

Create database for our application:
```SQL
CREATE DATABASE IF NOT EXISTS test;
USE test;
CREATE TABLE IF NOT EXISTS test (
    ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    url VARCHAR(255) NOT NULL,
    shorturl VARCHAR(14)
);
```

---

That's it. Now you should be able to use our application on your web browser: [127.0.0.1](http://127.0.0.1).

To stop containers type following command 
``` bash 
$ docker stop myproject-app
$ docker stop myproject-db
```
You can also stop container by id which you can see with: "docker ps" -command.

---

### Docker-compose

Running containers with docker compose is pretty straight forward. To understand the [logic behind docker-compose.yml file](https://docs.docker.com/compose/compose-file/) which is used to run our containers I recommend to get containers running without compose first if you havent already done it.

#### Docker-compose

To run this example project on [docker compose](https://docs.docker.com/compose/) you need just first to build image of our Apache-PHP container. 

To build our image type following command:
``` bash
$ docker build -t myproject-app .
```

Docker-compose automatically builds, (re)creates, starts, and attaches to containers for a service.

``` bash
$ docker-compose up
```

That's it. Now you should be able to use our application on your web browser: [127.0.0.1](http://127.0.0.1)

To stop use: "docker-compose stop" -command or use to stop and remove container, networks, volumes and images created by up type: "docker-compose down" -command.

---

## List of some useful docker commands

### Docker [Command]
| Command | Meaning                                                 |
|---------|:--------------------------------------------------------|
| build   | Build an image from a Dockerfile                        |
| run     | Run a command in a new container                        |
| exec    | Run a command in a running container                    |
| ps      | List containers                                         |
| stop    | Stop one or more running containers                     |
| rm      | Remove one or more containers                           |


### Docker build [Options]
| Option  | Meaning                                                 |
|---------|:--------------------------------------------------------|
| -t      | Name and optionally a tag in the ‘name:tag’ format      |
| -rm     | Remove intermediate containers after a successful build |

### Docker run [Options]
| Option | Meaning                                                  |
|--------|:---------------------------------------------------------|
| --rm   | Automatically remove the container when it exits         |
| --name | Assign a name to the container                           |
| --net  | Connect a container to a network                         |
| -p     | Publish a container’s port(s) to the host                |
| -e     | Set environment variables                                |
| -d     | Run container in background and print container ID       |
| -v     | Bind mount a volume                                      |
