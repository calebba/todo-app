# Laravel Application

This is a basic guide on how to set up and run this Laravel application.

## Prerequisites

Before running the application, ensure you have the following installed:

-   PHP >= 7.4
-   Composer
-   MySQL

## Installation

1. Clone this repository to your local machine/ Download zip onto your local machine then unzip:

    ```bash
    git clone <repository-url>
    ```

2. Navigate to the project directory:

    ```bash
    cd <project-directory>
    ```

3. Install Composer dependencies:

    ```bash
    composer install
    ```

4. Generate application key:

    ```bash
    php artisan key:generate
    ```

## Database Setup

1. Install and set up MySQL if you haven't already.

2. Create a new MySQL database for this application.

3. Update the `.env` file with your MySQL database connection details:

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=<database-name>
    DB_USERNAME=<database-username>
    DB_PASSWORD=<database-password>
    ```

    Replace `<database-name>`, `<database-username>`, and `<database-password>` with your MySQL database name, username, and password respectively.

4. Run database migrations to set up your database schema:

    ```bash
    php artisan migrate
    ```

5. Optionally, you can seed the database with dummy data:

    ```bash
    php artisan db:seed
    ```

## Running the Application

---
To run the Laravel application, execute the following command:

```bash
php artisan serve
```

# Todo API Documentation

This document provides an overview and usage instructions for the Todo-app API.

## Authentication

The Todo API requires authentication using custom laravel authentication with tokens. To authenticate, users must first register and then login to obtain an api_token. This token must be included as Bear token of all  todos, logout and refreshtoken requests to protected endpoints. Also, add an Accept: application/json to headers.

### Register
```http
POST /api/auth/register
```
Register a new user with the following parameters:
- `name`: Name of the user (required)
- `email`: Email address of the user (required)
- `password`: Password for the user (required)

### Login
```http
POST /api/auth/login
```
Login with an existing user to obtain a JWT token. Requires the following parameters:
- `email`: Email address of the user (required)
- `password`: Password for the user (required)

## Todo Endpoints

The following endpoints are available for managing todos:

### Create Todo
```http
POST /api/v1/todos
```
Create a new todo with the following parameters:
- `title`: Title of the todo (required)
- `user_id`: Id of the user creating the record (required)
- `description`: Description of the todo

Requires authentication with a valid api token.

### Get All Todos
```http
GET /api/v1/todos
```
Get a list of all todos.

Requires authentication with a valid api token.

### Get Todo by ID
```http
GET /api/v1/todos/{id}
```
Get a specific todo by its ID.

Requires authentication with a valid api token.

### Update Todo
```http
PUT /api/v1/todos/{id}
```
Update an existing todo by its ID. Requires the following parameters:
- `title`: Updated title of the todo
- `user_id`: Updated user of the todo
- `description`: Updated description of the todo
- `status`: Updated status of the todo to New, Under Review, In Progress or Completed
- `completed`: Updated todo to completed

Requires authentication with a valid api token.

### Delete Todo
```http
DELETE /api/v1/todos/{id}
```
Delete a todo by its ID.

Requires authentication with a valid api token.

## Error Handling

If a request fails due to validation errors or authentication issues, the API will return an appropriate error response with a corresponding status code.

---
