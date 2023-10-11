# Mortgage Loan Calculator - Laravel Application

A web application built with Laravel 9 that allows users to calculate mortgage loans with an option for extra repayments. It displays an amortization schedule and also provides a recalculated schedule for loans shortened due to extra repayments.

## Table of Contents
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Web Usage](#web-usage)
- [Web Sample Input/Output](#web-sample-inputoutput)
- [API Usage](#api-usage)
- [API Sample Input/Output](#api-sample-inputoutput)
- [Testing](#testing)

## Requirements

1. **PHP >= 8.0**
2. **Composer**
3. **A Google Cloud account with the Sheets API enabled**
4. **A service account key from Google Cloud**

## Installation

1. **Clone the Repository**
    ```bash
    git clone https://github.com/harout-itology/mortgage-calculator.git
    cd mortgage-calculator
    ```

2. **Install Dependencies**
    ```bash
    composer install
    ```

3. **Set up Environment File**
    - Copy the `.env.example` file to create your own `.env` file.
    ```bash
    cp .env.example .env
    ```

4. **Database Setup**
    - Modify the `.env` file to add your database configurations.
    - Create the database and run migrations.
    ```bash
    php artisan migrate
    ```

## Configuration

- Generate an application key:
    ```bash
    php artisan key:generate
    ```

- Start the Laravel development server:
    ```bash
    php artisan serve
    ```

The application should now be accessible at `http://localhost:8000`. but if the address already in use, the server will run on `http://localhost:8001`.

## Web Usage

1. Visit `http://localhost:8000`.
2. Provide the loan details: amount, interest rate, term, and any extra monthly payment.
3. View the generated amortization schedule and, if applicable, the recalculated schedule with extra repayments.

## Web Sample Input/Output

> **Input:**
> - Loan amount: 1000
> - Interest rate: 10
> - Term: 1 year
> - Extra monthly payment: 25

> **Output:**
> - [Amortization Schedule Table]
> - [Recalculated Schedule Table with Extra Repayments]

## API Usage

1. Request URL `http://localhost:8000/api/calculate`.
2. Request method `POST`
2. Provide the loan details: amount, interest rate, term, and any extra monthly payment.
3. View the generated amortization schedule and, if applicable, the recalculated schedule with extra repayments.

## API Sample Input/Output

> **Input:**
curl --location --request POST 'http://localhost:8000/api/calculate' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
"loan_amount": 1000,
"annual_interest_rate": 10,
"loan_term": 1
}'

> **Output:**
{
"schedules": {
"regular": [
{
"loan_id": 59,
"month_number": 1,
"starting_balance": 1000,
"monthly_payment": 87.92,
"principal_component": 79.58,
"interest_component": 8.33,
"ending_balance": 920.42
},
...
],
"extra": []
},
"request": {
"loan_amount": 1000,
"annual_interest_rate": 10,
"loan_term": 1
}
}

## Testing

To run the unit tests:

```bash
php artisan test
