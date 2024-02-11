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

To run the Laravel application, execute the following command:

```bash
php artisan serve
```
