<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="100" height="100"></a>
<a href="https://github.com/vuejs" target="_blank"><img src="https://avatars.githubusercontent.com/u/6128107?s=200&v=4" width="100" height="100"></a>
</p>
<p>
<img src="./public/images/ss1.PNG" width="300" />
<img src="./public/images/ss2.PNG" width="300" />
<img src="./public/images/ss3.PNG" width="300" />
<img src="./public/images/ss4.PNG" width="300" />
<img src="./public/images/ss5.PNG" width="300" />
</p>

## About Project

A simple subscription platform (RESTful APIs with MySQL, Vue.js UI) in which users
can subscribe to one or more websites
Whenever a new post is published on a particular website, all its subscribers shall receive an
email with the post title and description in it. No authentication of any kind is required.

## Environment Setup

In project root directory create copy of .env.example file named it as .env
Then define APP_URL, MIX_API_URL, database, & smtp details with your local configuration.

## Database Setup
For setting up database tables run below command:
- php artisan migrate

This command will create dummy websites in website table.
- php artisan db:seed --class=WebsitesTableSeeder

## Laravel Setup

In project root dorectory run below command to install all laravel dependencies:
- composer install

## VueJs Setup

In project root dorectory run below command to install VueJs dependencies:
- npm install


## Rest API

- v1/website
    - get all records
        - GET v1/website
    - get single record 
        - GET v1/website/{id}
    - post request
        - POST v1/website
- v1/user
    - get all records
        - GET v1/user
    - get single record 
        - GET v1/user/{id}
    - post request
        - POST v1/user
- v1/posts
    - get all records
        - GET v1/posts
    - get single record 
        - GET v1/posts/{id}
    - post request
        - POST v1/posts
- v1/subscribe
    - get all records
        - GET v1/posts
    - get single record 
        - GET v1/posts/{id}
    - post request
        - POST v1/posts