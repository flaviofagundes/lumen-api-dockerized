# LUMEN-API-DOCKERIZED
This project is a demo of a basic API using micro framework PHP Lumen, mysql and docker-compose.

# Docker commands

All commands must be executed in root project directory.

```
# build and starts application stack
docker-compose up -d

# stop all services
docker-compose stop

# start all services
docker-compose start

# launch a only app service
# docker-compose start app

# launch a only mysql service
# docker-compose start db

# restart app service
# docker-compose restart app

# restart db service
# docker-compose restart db

# consulting app logs
# docker-compose logs -f app

# consulting app logs
# docker-compose logs -f db

# ssh into a php container
# docker-compose exec app bash

# ssh into a mysql container
# docker-compose exec db bash

# volumes are stored in
/var/lib/docker/volumes/
```

# Application configuration

```
application/.env
```

# Additional Project Information
You can find more information about this project in its post at my personal blog.


# Lumen PHP Framework
[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)