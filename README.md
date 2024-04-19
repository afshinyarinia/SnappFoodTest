<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## About Project

The project assigned to me for consideration at SnappFood involves the development of a web application using the Laravel framework.Through this project, I look forward to showcasing my skills and creativity to contribute to the success of SnappFood's digital presence.


# Running Project With Docker

## Prerequisites
* Docker installed on your machine
* Docker Compose installed on your machine
## Setup Instructions
* Clone this repository to your local machine
* Navigate to the project directory
Run the following command to build the Docker containers:

```
docker-compose up -d
```

* Once the containers are built and running, you can access the Laravel project at http://localhost:8000

## Additional Notes
* The project uses Docker Compose to set up the necessary containers for running the Laravel application.
* Make sure to update the .env file with the appropriate configurations for your Laravel project.
* You can stop the containers by running docker-compose down in the project directory.

# Running Laravel App Locally

This repository contains a Laravel application that can be easily set up and run locally on your machine.

## Prerequisites
- PHP installed on your machine
- Composer installed on your machine
- MySQL or any other database management system installed on your machine

## Setup Instructions
1. Clone this repository to your local machine
2. Navigate to the project directory
3. Install PHP dependencies by running:
   ```
   composer install
   ```
4. Copy the `.env.example` file to `.env` and update the database configurations
5. Generate a new application key by running:
   ```
   php artisan key:generate
   ```
6. Run the database migrations to set up the database schema:
   ```
   php artisan migrate --seed
   ```
7. Start the Laravel development server by running:
   ```
   php artisan serve
   ```
8. You can now access the Laravel application at `http://localhost:8000`

## Additional Notes
- Make sure to have the necessary PHP extensions and dependencies installed as per Laravel requirements.
- You can customize the application further by modifying the existing codebase.
- Remember to secure your application by setting up proper authentication and authorization mechanisms.

Happy coding!
