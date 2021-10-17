# FZF-LUMEN-API-DEMO
Essa é uma API demo tendo como base de sua construção o micro framework PHP Lumen.

## Estrutura do Projeto

Na raiz do diretório encontra-se o arquivo do `docker-compose.yml` o qual está definida a configuração de como será carregado o ambiente.

Já no diretório `app` está a aplicação desenvolvida utilizando o framework de PHP Lumen.


## Requests

### Autenticação

```
curl -i -X POST -H "Content-Type:application/json" http://localhost:3000/api/auth/login -d '{"email":"admin@admin.com","password":"admin"}'
```

### Posts

A consulta não requer uso do token
```
curl -i -X GET -H "Content-Type:application/json" http://localhost:3000/api/posts
```


## Informações sobre os comandos Docker

Os comandos abaixo servem para utilização do docker-compose.

```
# image build 
docker-compose up

# start all services
docker-compose start

# stop all services
# docker-compose stop

# launch a specific service
# docker-compose up application

# restart a single service 
# docker-compose restart application

# logs from a specific service
# docker-compose logs -f application

# ssh into a particular service container
# docker-compose exec application bash

# when change the docke compose, you need run
# docker-compose up --build

# volumes are stored in
/var/lib/docker/volumes/

#mysql data to this project will be
/var/lib/docker/volumes/fzflumenapidemo_my-data-volume/
```


## Estrutura da Aplicação

### Configuration
Na raiz do diretório da aplicação encontra-se o arquivo `.env`. Nesse arquivo que devem estar defindias as configurações de conexão com banco de dados e cache.

### Instalação
Realizar a clonagem do repositório e rodar o comando `composer update` para que sejam baixados os componentes do **Lumen** no diretório `vendor`.

### Inicialização da Aplicação
Atentar para a inicialização da aplicação de acordo com o ambiente.

#### Local
Para inicialização em ambiente local deve ser executado o comando abaixo:
`php -S localhost:8080 -t public/`

#### Production
Para inicialização em ambiente produtivo:
`...`

#### Conteúdo Estático
...


### Controllers
Os controllers encontram-se no diretório `app/Http/Controllers/`. É nesse diretório que deverão ser definidos os controllers da aplicação.
O controller `AuthController.php`  é um controller base e utiliza o modelo `User` como apoio.

### Models
Os modelos devem ser adicionados no diretório `app/`. Nesse diretório já encontrará-se um exemplar do objeto `User.php`, com os campos base de definições para autenticação e registro de token.

### Routes
As rotas da aplicação estão definidas no arquivo `routes/web.php`, permitindo torná-las de acesso público ou restrito, bastando para isso, apenas adicionar o middleware de autenticação.

É no arquivo de rotas que fica a definição do **contexto** da api.

### Authentication
O controller `app/Http/Controllers/AuthController.php` é quem expõe os métodos de login e logout. Utiliza o model `User.php`, utilizando campos na tabela de usuário como: email, password e access_token. Atualmente a senha é registrada com um md5.

O middleware `app/Http/Middleware/Authenticate.php` é invocado a cada request para validar a autenticação do usuário.

Também possui um provide definido em `app/Http/Providers/AuthServiceProvider.php`, onde é validado se a requisição está chegando por basic autentication ou por token.

### Bootstrap
O arquivo `bootstrap/app.php` possui a definição da utilização do `middleware`, `service provider` e o arquivo de rotas (`web.php`) da aplicação.

### Exceptions
O formato de lançamento de exceção é definido no handler `app/Exceptions/Hanlder.php`. É nesse arquivo que pode-se definir status e códigos de retorno http, etc...

### Utilização
Abaixo descreve-se um pouco sobre a utilização da aplicação.

#### Registro de Usuário
Para criação de um usuário no sistema, deve ser feito um post com as informações para a action register.
`curl -i -X POST -H "Content-Type:application/json" http://localhost:8080/api/auth/register -d '{"first_name":"Peter","last_name":"Parker","email":"test@test.com","password":"mypass"}'`

#### Autenticação
Utilizar login e senha conforme exemplo:
`curl -i -X POST -H "Content-Type:application/json" http://localhost:8080/api/auth/login -d '{"email":"admin@admin.com","password":"1234"}'`

Será retornado um token que deverá ser encaminhado nas chamadas que requerem autenticação no atributo de cabeçalho `access_token`.

#### Término de Sessão
Para encerrar a sessão e invalidar o token, deve ser feito um request conforme abaixo para logout.
`curl -i -X POST -H "access_token:4bf7a9ed510a11f1a2b981984f643b70" http://localhost:8080/api/auth/logout`

### Experimentos de Configuração

```

#   db:
#     image: mysql
#     container_name: banco_mysql
#     volumes:
#       - my-db:/home/mysql
#     ports:
#       - '3306:3306'
#     environment:
#       MYSQL_DATABASE: 'demo'
#       #MYSQL_USER: 'root'
#       MYSQL_PASSWORD: 'r00t#2019'
#       MYSQL_ROOT_PASSWORD: 'r00t#2019'
# volumes:
#   my-db:

  # db:
  #   image: mysql:5.7
  #   restart: always
  #   environment:
  #     MYSQL_DATABASE: 'db'
  #     # So you don't have to use root, but you can if you like
  #     MYSQL_USER: 'root'
  #     # You can use whatever password you like
  #     MYSQL_PASSWORD: 'root#2019'
  #     # Password for root access
  #     MYSQL_ROOT_PASSWORD: 'root#2019'
  #   ports:
  #     # <Port exposed> : < MySQL Port running inside container>
  #     - '3306:3306'
  #   expose:
  #     # Opens port 3306 on the container
  #     - '3306'
  #     # Where our data will be persisted
  #   volumes:
  #     - my-db:/home/mysql

# Names our volume
# volumes:
#   my-db:      

# The Database
  # database:
  #   image: mysql:5.7
  #   volumes:
  #     - dbdata:/var/lib/mysql
  #   environment:
  #     - "MYSQL_ROOT_PASSWORD=root#2009"
  #     - "MYSQL_DATABASE=demo"
  #     - "MYSQL_USER=demo"
  #   ports:
  #       - "33061:3306"

# volumes:
  #  dbdata:
```  

# Removing all volumes

i had the same issue when i deleted the directory manually

rm -fr /var/lib/docker/volumes/[your_volume]

The solution for me was to delete the volume in docker First list the existing volume

docker volume ls

find the one you want to delete then

docker volume rm [your_volume]

Then i was able to do the docker-compose

https://docs.docker.com/compose/reference/up/


O que realmente funcionou para recriar os volumes foi o comando abaixo
docker-compose down -v

# Tools

> Telnet
```
apt-get update && apt-get install telnet -y
```
# volumes

> suporta o mapeamento de arquivo diretamente ou diretório

> esse diretório docker-entrypoint-initdb.d  executa comandos
```
volumes:
 # HOST : INSTANCIA_CONTAINER
 #diretório do host .docker para caminho na instancia /docker/setup.sql
 - .docker/setup.sql/:/docker/setup.sql

 #mapeia para o volume do host o path do argumento?   
 - my-db-volume:/var/lib/mysql

```

> lembrando

Antes do ":"
* path locais sempre começam com "./"
* se ele nao encontrar o path, ele cria o diretório vazio na raiz do projeto
* se nao tiver prefixo, é um ponto de montagem

version: '2'
services:

  common_db:
    image: postgres:10.4
    restart: always
    environment:
      - POSTGRES_USER=postgres
      - POSTGRES_PASSWORD=postgres123
      - POSTGRES_MULTIPLE_DATABASES=db1,db2
    volumes:
      - ./db.sql:/docker-entrypoint-initdb.d/db.sql
      - ./postgres-data:/var/lib/postgresql/data
    ports:
      - 5436:5432
    networks:
       - app-network

volumes:
  postgres-data:
networks:
  app-network:
    driver: bridge`


definir locais fora da estrutura do docker, utilizar bind

https://docs.docker.com/compose/compose-file/#volumes

version: "3.8"
services:
  web:
    image: nginx:alpine
    ports:
      - "80:80"
    volumes:
      - type: volume
        source: mydata
        target: /data
        volume:
          nocopy: true
      - type: bind
        source: ./static
        target: /opt/app/static

networks:
  webnet:

volumes:
  mydata:

usado para arquivo de configuração 
e databases  

# Configuração da API

A configuração encontra-se no diretório abaixo

```
application/.env
```

# Requests

## Autenticação

```
curl -i -X POST -H "Content-Type:application/json" http://localhost:3000/api/auth/login -d '{"email":"admin@admin.com","password":"admin"}'
```

-- exibe o ip da imagem
docker inspect api_db | grep IPAddress
            "SecondaryIPAddresses": null,
            "IPAddress": "",
                    "IPAddress": "192.168.192.2",



 exemplo de uso de docker-file
 https://stackoverflow.com/questions/47903079/how-to-install-packages-from-docker-compose

 https://semaphoreci.com/community/tutorials/dockerizing-a-php-application

 

# Pendencias

* Conectar app php ao banco de dados
* Definição de environments (não usar docker para banco de produção)
* Utilizar arquivo docker externo para complemento de ferramentas nas imagens
* Ajustar o arquivo readme
* utilizar volumes externos fixos para bundles, configs e databases (avaliar impacto de subir mais de uma instancia se explicitar por bind)
* Adicionar a utilização de migrations
* Criar uma pasta docker e mover tudo para lá de docker, mantendo apenas o docker compose fora dela.

# Lumen PHP Framework
[![Build Status](https://travis-ci.org/laravel/lumen-framework.svg)](https://travis-ci.org/laravel/lumen-framework)
[![Total Downloads](https://poser.pugx.org/laravel/lumen-framework/d/total.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Stable Version](https://poser.pugx.org/laravel/lumen-framework/v/stable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![Latest Unstable Version](https://poser.pugx.org/laravel/lumen-framework/v/unstable.svg)](https://packagist.org/packages/laravel/lumen-framework)
[![License](https://poser.pugx.org/laravel/lumen-framework/license.svg)](https://packagist.org/packages/laravel/lumen-framework)