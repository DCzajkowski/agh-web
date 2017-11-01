# Online Library project
## Installation
```bash
git clone https://github.com/DCzajkowski/library.git
cd library
cp .env.example .env
php artisan key:generate
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
