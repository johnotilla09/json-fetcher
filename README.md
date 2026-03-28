# JSON Fetcher API

A Laravel-based REST API that fetches and serves data from JSONPlaceholder.

## Prerequisites

- Docker & Docker Compose
- Or PHP 8.2+ and Composer (for local development)

## Setup Instructions (Docker)

1. Clone the repository and navigate to the project directory:

    ```bash
    cd json-fetcher
    ```

2. Copy the environment file:

    ```bash
    cp .env.example .env
    ```

3. Build and start the Docker containers:

    ```bash
    docker-compose up -d --build
    ```

4. Install PHP dependencies:

    ```bash
    docker exec json_fetcher_app composer install
    ```

5. Generate the application key:

    ```bash
    docker exec json_fetcher_app php artisan key:generate
    ```

6. Run database migrations:

    ```bash
    docker exec json_fetcher_app php artisan migrate:fresh
    ```

7. Fetch and seed the data from JSONPlaceholder:
    ```bash
    docker exec json_fetcher_app php artisan app:fetch-api-data
    ```

The API will now be available at `http://localhost:8000`.

## Authentication Guide

This API uses Laravel Sanctum for authentication. To access protected routes, you need an API token.

### 1. Get a Token

To get a token, you need to create a user and log in (or manually generate a token using Tinker if no registration route is exposed).

Using Tinker to quickly generate a token for testing:

```bash
docker exec -it json_fetcher_app php artisan tinker

// Inside tinker, run:
$user = App\Models\User::first();
$token = $user->createToken('test-token')->plainTextToken;
echo $token;
```

### 2. Using the Token

Include the token in the `Authorization` header of your HTTP requests as a Bearer token:

```http
Authorization: Bearer YOUR_GENERATED_TOKEN
```

### Example Request using cURL

```bash
curl -H "Accept: application/json" \
     -H "Authorization: Bearer YOUR_GENERATED_TOKEN" \
     http://localhost:8000/api/user
```

## Available Endpoints

- `GET /api/users` - Get all users
- `GET /api/posts` - Get all posts (Supports `?userId=1` filter)
- `GET /api/comments` - Get all comments (Supports `?postId=1` filter)
- `GET /api/albums` - Get all albums
- `GET /api/photos` - Get all photos
- `GET /api/todos` - Get all todos

_(Note: Wrap your `APP_NAME` in double quotes in your `.env` file to prevent build errors)_
