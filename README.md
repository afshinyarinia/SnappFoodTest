<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## About Project

The project assigned to me for consideration at SnappFood involves the development of a web application using the Laravel framework.Through this project, I look forward to showcasing my skills and creativity to contribute to the success of SnappFood's digital presence.

## Project Additional Packages
* postman collection at `docs/postman`
* swagger documentation at `http://localhost:8000/api/docs`


## Api Call Order To Test All Tasks
* order(id:51) can be report as delayed
* then an agent(id:1) can get that report
* then you can see the delayed vendors report

## Things that can be Improved
* better swagger docs with better request and response data
* more edge case tests
* using repository for estimation clients 
* cache queries like the get report (probably using redis)
* I didn't have enough time for it :)

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
* If The 8000 port didn't work use 9000 (some unresolved problem with nginx)

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

9. uou can run the tests with
    ```
    php artisan test
   ```

## Additional Notes
- Make sure to have the necessary PHP extensions and dependencies installed as per Laravel requirements.
- You can customize the application further by modifying the existing codebase.
- Remember to secure your application by setting up proper authentication and authorization mechanisms.

# Getting Postman Collection from Docs/Postman

This repository includes a Postman collection that can be used to test the APIs of this project. Follow the steps below to access and import the Postman collection.

## Steps to Get Postman Collection
1. Navigate to the `docs/postman` directory in this repository.
2. Locate the Postman collection file (usually with a `.json` extension).
3. Click on the file to view its contents.
4. Copy the content of the file to your clipboard.

## Importing Postman Collection
1. Open Postman application on your machine.
2. Click on the "Import" button in the top left corner.
3. Select the "Paste Raw Text" option.
4. Paste the copied content from the Postman collection file.
5. Click on the "Import" button to import the collection into your Postman workspace.

## Using Postman Collection
1. Once imported, you will see the collection in your Postman workspace.
2. You can now use the collection to test the APIs of this project by sending requests to the specified endpoints.
3. Make sure to update any necessary variables or headers in the collection before sending requests.

# Implementing Swagger Documentation in Laravel

This repository includes Swagger documentation for the Laravel project to document and test API endpoints effectively.

## Steps to Implement Swagger Documentation

1. **Configuration File**: Create a `swagger.php` configuration file in the `config` directory of your Laravel project. Define the necessary settings for Swagger, such as API versions, base URL, security definitions, etc.

2. **API Endpoint Documentation**: Document your API endpoints by adding comments or annotations to your controller methods. Include details such as route, parameters, responses, etc., directly in your code.

3. **Generate Swagger Documentation**: Create a route in your Laravel application that will serve the Swagger documentation. This route should read the configuration file and generate the Swagger documentation dynamically based on your API endpoints.

4. **Render Swagger UI**: Create a view or blade template that will render the Swagger UI in your application. Include the necessary JavaScript and CSS files to display the Swagger documentation.

5. **Access Swagger Documentation**: Once the Swagger documentation is set up, you can access it in your browser in this address `http://localhost:8000/api/docs`. Use the Swagger UI to test your APIs and explore the available endpoints.
