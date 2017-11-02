# Online Library project
## Installation
```bash
git clone https://github.com/DCzajkowski/library.git
cd library
composer install
cp .env.example .env
php artisan key:generate
# Fill MySQL or PostgreSQL database credentials in .env file
php artisan migrate --seed
php artisan serve --host=localhost --port=8080
# Navigate to http://localhost:8080
```

## Authentication
There are two users already in place:
#### User
- Login: `miranda@example.com`
- Password: `password`

#### Librarian
- Login: `john@example.com`
- Password: `password`

## Demo
The demo is previewable at https://library-web-project.herokuapp.com

## Overview
### Technologies:
- **Back-end**
    - **PHP** — All of the back-end code is written in PHP – version is 7.1 (current stable).
    - **Laravel** — I have decided to use a Web Framework (Laravel), because it is [the most popular framework for PHP at the moment](https://trends.google.com/trends/explore?q=Laravel,Symfony,CakePHP,Codeigniter,Yii).
    - **SQLite / MySQL** — The database used was MySQL for development, but I have switched to SQLite for simple set-up and easy shareability.
- **Front-end**
    - **JavaScript / ES6** — At the front-end I have used simple JavaScript in the ECMA Script 6 standard.
    - **Vue.js** — Vue.js is quite a new web framework that gains on popularity. I have used it because of its reactivity model. It was used for a data table, sorting it, dynamic search and pagination.
    - **axios** - Simple promise-based wrapper for Ajax requests. Used for checking availability of a book on-the-fly.
    - **Sass** — As a compilation phase for my CSS I have used Sass for use of variables, nesting and more.
    - **Bootstrap** — Since Laravel ships with Bootstrap out-of-the-box I have decided to go with it as a main, industrial visual language.
    - **Webpack** — Used as a compilator for all of my front-end assets I have used Webpack and Laravel Mix. That allows for backward-compatibility compilation of assets, minification, uglification and prefixing of CSS.

### Features
- Librarian:
    - Can add new users,
    - Can add new books,
    - Can view all books,
    - Can search through books,
    - Can preview availability of a book at a moment,
    - Can lend books to users based on e-mail address.
- User:
    - Can view all books,
    - Can search through books,
    - Can preview availability of a book at a moment.
