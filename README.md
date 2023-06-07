# Taskapp

Task management app to manage project tasks


## Installation and Setup

Clone Project

`$ git clone https://github.com/geraldokandonga/taskapp`

## Docker

To run the application locally, using docker, ensure docker is already installed on your system, run the following commands.

```
> docker-compose up --build
```

or

```
> docker-compose up -d
```


## Migrations

Run `docker ps` find application and run `docker exec -it --appId` bash

Run the below commands while logged in docker.

```
> php artisan migrate
```

Open in browser http://localhost:8888

## Server Requirements

PHP version 7.4 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php) if you plan to use MySQL
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library
