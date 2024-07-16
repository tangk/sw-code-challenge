# SW API for Voucher Code Generation

## Description

### Endpoints
   - `/api/v1/login`
     - `GET`
       - Generate token for authentication
   - `/api/v1/user`
     - `POST`
       - Create User and generate first voucher code
   - `/api/v1/voucher`
     - `GET`
       - List all voucher codes for user
     - `POST`
       - Create a voucher code for user
   - `/api/v1/voucher/{id}`
     - `DELETE`
       - Delete a voucher code for user

## Requirements

- Laravel 11.x (and dependencies)
- Laravel Sail and Horizon (optional)
- PhpUnit (for testing) and XDebug (optional for test coverage)
- Any DB driver (MySQL, SQLite, etc.)
- Mailpit or any other mail service credentials

## Installation

1. Clone the repository.
2. Copy `.env.example` to `.env`.
3. Update the `.env` file with your mail service credentials.
4. Run `composer install` to install dependencies.
5. Run `php artisan key:generate` to generate the application key.
6. Run `php artisan migrate` to create the database tables.
7. Run `php artisan serve` to start the server.
8. Run `php artisan queue:work` in the background to process email queues.
8. Use Postman or any other API client to test the endpoints.

## Testing

Run `php artisan test` to run the tests.
