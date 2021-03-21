## Install:

```
$ git clone https://github.com/AleksandrTkach/WebMagic.git webmagic
$ cd ./webmagic/docker
$ docker-compose up -d
$ docker-compose exec php bash
$ composer update
$ cp .env.example .env

// set now .env variable and create db

$ php artisan key:generate
$ php artisan migrate
$ exit
```

#### ENV for tests:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=webmagic
DB_USERNAME=root
DB_PASSWORD=root

PARSE_DOMAIN=https://laravel-news.com
PARSE_MONTHS=4
```

#### The site is available at:
```
127.0.0.1
```

#### Command for updating the articles:
```
docker-compose exec php bash

// write new articles
php artisan parse 

// clear db and write new articles
php artisan parse refresh 
```

#### Docker containers:
```
nginx
mysql
php 7.4
phpMyAdmin (127.0.0.1:8080)
```

####  phpMyAdmin
```
host:mysql
user:root
password:root
```
## Task:
Create a web parsing basis functionality with the next logic:

1. Load data about articles from https://laravel-news.com/blog with tag 'news' for the last 4 months
2. Show loaded data on the main page as a table with the next fields:
    * publication date in a format - 'd.m.Y'
    * title as a link to the article page
    * author name
    * all tags associated with article separated by a comma
3. Articles should be sorted alphabetically by author name
4. A possibility of manual sorting by title and date should be available also
5. Articles should be loaded once and saved in DB
6. Every page reload should show data from DB
7. Additionally add a command for updating the articles' data
8. The project should be built using docker containers

#### Requirements
Functionality should be built by using Laravel

OOP and SOLID principles should be used

Code should be well commented
