


## Setup

Same way you would install a typical laravel application.

    composer install

    npm install

    npm run dev

    php artisan serve

The UI is displayed on the root page

## Extra Notes

    Clone `.env.example` and rename as `.env`

    Set up database connection

    ``
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=curacel
    DB_USERNAME=
    DB_PASSWORD=
    ``

    Set mailer connection

    `` 
    MAIL_MAILER=smtp
    MAIL_HOST=sandbox.smtp.mailtrap.io
    MAIL_PORT=2525
    MAIL_USERNAME=
    MAIL_PASSWORD=
    MAIL_ENCRYPTION=null
    MAIL_FROM_ADDRESS="hello@example.com"
    MAIL_FROM_NAME="${APP_NAME}" 
    ``
    Run `php artisan migrate` for DB migrations

    Run `php artisan db:seed HmoSeeder` to seed HMO table

    Run Queue with `php artisan queue:work`

    For tests, run `php artisan test`
