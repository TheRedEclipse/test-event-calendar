Test work to with Event Calendar and relation to Departments and Users


To start test work perfom:

    rename .env.example to .env and fill with required credentials
    composer install
    php artisan jwt:secret
    php artisan migrate --seed
    npm run install
    npm run build

Prefilled users:

    name: admin
    password: password
    role: admin

    name: user
    password: password
    role: user