# CONTACTS APP

## About the app
This is very small demo app created for the purpose of a job interview.  
It holds records of "contact" - people with their phone numbers.  
Registered users can only view the records.  
Administrators can view, create, delete and modify them.  
  
Layout and features are implemented according to instructions given by the interviewer.

## Version requirements
- PHP – 8.0.13
- DB - 10.4.22-MariaDB
- Laravel – 8.77.1

## Installation

1. Pull in the project using the following link:
```
https://github.com/drago1979/contacts.git

```
2. Create .env file with valid data (DB credentials etc.).  
3. In your terminal (working folder) run
```
composer install
```  

```
npm install
```


```
npm run prod
```


```
php artisan key:generate
```


```
php artisan migrate
```

```
php artisan db:seed
```

## Using the app
Login credentials:  
* admin user:  
  - email: orson@gmail.com
  - pass: password
* user:
  - email: francis@gmail.com
  - pass: password
