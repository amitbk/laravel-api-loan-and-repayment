<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/amitbk/laravel-api-loan-and-repayment/blob/main/public/images/laravel.png?raw=true" width="400"></a></p>

<p align="center">

</p>

## About Project

It is an app that allows authenticated users to go through a loan application. It doesn’t have to contain too many fields, but at least “amount
required” and “loan term.” All the loans will be assumed to have a “weekly” repayment frequency.

After the loan is approved, the user must be able to submit the weekly loan repayments. It can be a simplified repay functionality, which won’t
need to check if the dates are correct but will just set the weekly amount to be repaid.

## Setup

#### 1. Clone the Repo
```
git clone git@github.com:amitbk/laravel-api-loan-and-repayment.git
```

#### 2. Setup .env file
Rename **.env.example** to **.env**

Default Database configuration is:
```
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

#### 3. Change directory
```
cd laravel-api-loan-and-repayment
```

#### 4. Initialize the project
```
npm run init
```
(Wait for some time to complete process.)

#### 5. App is ready now!
```
http://127.0.0.1:8000
```

## API List

#### Login API

```/api/login```

Request Type: POST

Parameters Required=> email, password

Headers Required => Accept: application/json


#### Apply For Loan

```/api/loans/apply```

Request Type: POST

Parameters Required=> amount, term (in years)

Headers Required => Accept: application/json

*Authorization reuired with bearer token


#### Approve Loan

```/api/loans/approve```

Request Type: POST

Parameters Required=> loan_id

Headers Required => Accept: application/json

*Authorization reuired with bearer token

(For now, any loged in used can approve loan, no any check added)


#### Repay Loan

```api/transactions/loan/repay```

Request Type: POST

Parameters Required=> loan_id

(Payment amount will be calculated automatically, because we need to repay weekly. So there will be fixed payment for each week.

amount_to_pay = amount/(52*term)
)

Headers Required => Accept: application/json

*Authorization reuired with bearer token


#### Check Balance
```api/users/{id}/balance```

Request Type: GET

Headers Required => Accept: application/json

(This API is open, because it can be used for testing)

## Unit Tests
```
php artisan test
```

## My Profile
[LinkedIn](https://www.linkedin.com/in/amitkadam03/).
