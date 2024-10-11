## COVID Vaccine Application

A COVID vaccine registration system where people can register and get vaccine.

## Instractions for Installation

### Local development server requirements

-   PHP >= 8.2
-   Composer >= 2.4
-   NodeJS >= 20.16

### Then,

-   Clone this repository to your local machine in your preferred directory.

-   Go to your project directory and open a terminal.

-   Run `composer install` to install all the dependencies.

-   Run `cp .env.example .env` to create a copy of the environment file.

-   Update the `.env` file with your database, Mail credentials and make sure your database is created.

-   Also make sure that `APP_TIMEZONE="Asia/Dhaka"` and `APP_URL` is valid.

-   Run `php artisan key:generate` to generate a new application key.

-   Run `php artisan migrate:fresh --seed` to migrate the database.

-   Run `npm install` to install all the frontend dependencies.

-   Run `php artisan serve` to start the development server.

-   Run `npm run dev` to build the frontend in a separate terminal.

-   Run `php artisan schedule:work` in a separate terminal.

-   Run `php artisan queue:work` in a separate terminal.

-   Go to your browser and navigate to `http://127.0.0.1:8000` to access the application.

-   Now, you can register for vaccine and others.

## SMS Notification Feature
If an additional requirement of sending ‘SMS’ notification along with the email notification for vaccine schedule date is given in the future, what changes need to be make on my code. 
- Setup SMS providers gateway.
- Just have to add a new line to send SMS in the `App\Services\VaccineScheduleService` class after sending the email notification or we can add a notification route (Example ` ->route('vonage', '5555555555')`) to send SMS via Laravel Notification Facade.

## Thank you!
