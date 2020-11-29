# Timesheet

A Simple timesheet/attendance application.

## Setup

Steps to setup the application on your development environment.

-   Requirements - The PHP extensions at [Laravel Requirements Page](https://laravel.com/docs/8.x/installation#server-requirements) and [Laravel Excel Package Page](https://docs.laravel-excel.com/3.1/getting-started/installation.html#requirements) are required.

-   Clone the repository into your desired folder

-   Create an `env` file for the environment variables to be utilized by the application. The `env.example` file should be referenced.

-   Create a database for the application and update the `DB_*` environment variables as required.

-   Install composer dependencies.

```shell
$ composer install
```

-   Install JavaScript dependecies and create a dev build.

```shell
$ npm install && npm run dev
```

-   Generate application key and run Database Migrations.

```shell
$ php artisan key:generate

$ php artisan migrate
```

-   Set up an Administrator for the application. Respond to the prompts from the following command to ensure a smooth administrator setup.

```shell
$ php artisan admin:create
```

-   Serve the application with your development server. However, you could use the built-in Artisan Server by running

```shell
$ php artisan serve
```

-   Database factories have been written to generate users and subsequent attendances. This would provide necessary data to generate a sample travel compensation report. To seed the database, run

```shell
$ php artisan db:seed
```

-   Visit the app url and Login using the email and password you provided while setting up the administrator.

## Utilized Technologies

-   [Laravel Framework](https://laravel.com/)

-   [Tailwindcss](https://tailwindcss.com/)

-   [AlpineJS](https://github.com/alpinejs/alpine/)
