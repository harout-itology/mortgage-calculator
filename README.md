# Mortgage Loan Calculator - Laravel Application

A web application built with Laravel 9 that allows users to calculate mortgage loans with an option for extra repayments. It displays an amortization schedule and also provides a recalculated schedule for loans shortened due to extra repayments.

## Table of Contents
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Sample Input/Output](#sample-inputoutput)
- [Testing](#testing)
- [Contribution](#contribution)

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

## Usage

1. Visit `http://localhost:8000`.
2. Provide the loan details: amount, interest rate, term, and any extra monthly payment.
3. View the generated amortization schedule and, if applicable, the recalculated schedule with extra repayments.

## Sample Input/Output

> **Input:**
> - Loan amount: 1000
> - Interest rate: 10%
> - Term: 1 year
> - Extra monthly payment: 25

> **Output:**
> - [Amortization Schedule Table]
> - [Recalculated Schedule Table with Extra Repayments]

## Testing

To run the unit tests:

```bash
php artisan test
