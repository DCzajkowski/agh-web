# Online Library project
## Installation
```bash
git clone https://github.com/DCzajkowski/library.git
cd library
cp .env.example .env
php artisan key:generate
# Fill APP_URL and DB_-connected variables in .env file
php artisan migrate --seed
php -S localhost:8080 # Only if no server is running yet
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
