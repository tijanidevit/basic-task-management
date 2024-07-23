## Setup

-   Pull/Clone the Repo
-   Run `composer install` to install all packages
-   Copy the .env.example file and save as .env
-   Run `php artisan key:generate` to generate the app key
-   Setup the environment (Database) in the .env file
-   Setup the AUTH_KEY and API_KEY in the .env file
-   Create a `database.sqlite` file in database folder (`touch database/database.sqlite`)
-   Run `php artisan migrate` to create needed database tables and seed records
-   Run `php artisan serve` to start the backend service
-   Run `php artisan test` to test the backend service
-   Find the link to the documentation [the documentation here](https://documenter.getpostman.com/view/11547438/2sA3kXCzfZ). Please set the postman environment before testing

### Other Info

-   I used uuid for tables' id for security purposes
-   Task can be CRUD. You can also set tasks as completed
-   I used search/filterBy/filterByDate Builder macros in the AppServiceProvider to help optimize code
-   I used x-api-key header which is the value of the API_KEY in .env file across all requests to avoid external access (security)
