# Employee Management System Backend

## Requirements

-   composer version 2.6.5 or higher

-   php version 8.2 or higher

## Installation

-   clone the backend repo to your machine

-   create a database on xamp named it "ems"

-   copy paste the .env.example or rename the .env.example to ".env"

-   composer install

-   php artisan key:generate

-   php artisan migrate:fresh --seed

-   php artisan serve

## Notes

-   dont modify the .env cause I set it up all based on the installation I made above, but feel free to modify

-   dont use the smtp I made on .env that is for testing purposes only, ill change that soon
