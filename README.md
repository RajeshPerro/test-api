# API

Before you start anything Please read [PROJECT GUIDE]( https://drive.google.com/uc?export=view&id=11wA9KtMVdpOPOqai-qW0NQWJFduvX8qz ) highly recommended! <br>
Project guide will help you understand W.W.H : Why? What? and How? <br>
Why and How the architecture / system design has been done, <br> Based on What all the decisions has been taken, <br> and then how it has been implemented. <br>

How to use the APIs?<br>
If you already have a LAMP Server then you are almost done!<br>
If no then based on your Operating system please install these<br>

- Apache 
- Mysql
- PHP

Windows : You can use XAMPP. It's very simple. <br>
Instructions can be found here <br>
* [Windows](https://www.configserverfirewall.com/windows-10/install-xampp-on-windows/) <br>
* [Linux](https://www.digitalocean.com/community/tutorials/how-to-install-linux-apache-mysql-php-lamp-stack-ubuntu-18-04) <br>
* [OSX](https://betterprogramming.pub/install-apache-mysql-php-macos-mojave-10-14-b6b5c00b7de)  <br>

Now, once you are done with installation, clone the repo to your localhost <br>
* Windows & Xampp => htdocs directory
* Linux (Ubuntu) => /var/www/html
* Mac => /Library/WebServer/Documents/

*** Create a database in your mysql server <br> 
- If necessary check [How to create database from MySQL CLI](https://www.inmotionhosting.com/support/server/databases/create-a-mysql-database/)
- Once you have the database import the sql file
* To load the sql in your newly created DB For Unix
```
mysql db_name < rest_api_demo.sql

```
<br>

****YES!! you are ready to run the APIs****<br><br>
Go to your browser / any other application which can run API as like Postman<br>
if you have already working ```localhost (127.0.0.1)```<br>
- In URL : 
``` localhost/test-api/index.php/{module_name}/{action_name} ``` <br>
Example : ``` localhost/test-api/index.php/user/get``` <br> It will return all the users you have in your DB<br><br>

********* List of APIs we have *********<br>
We have API for<br>
* USER ## 
- GET : ``` $host/test-api/index.php/get ```
- GET : ``` $host/test-api/index.php/get/{id} ```
- POST : ``` $host/test-api/index.php/user/create ``` <br>
```
JSON input 
{
"user_name": "Mr.Test",
"user_email": "test@myapp.com",
"password": "TheEarthIsAwesome#123",
"mobile_number": "+4478267262",
"address": "Lodz, Poland"
}
```
- PUT : ``` $host/test-api/index.php/user/update/{id} ``` <br>
```
JSON input 
{
"password": "IamNotGointToMars#123",
"mobile_number": "+48987344009",
"address": "Munich, Germany"
}
```
- DELETE : ``` $host/test-api/index.php/user/delete/{id} ```
<br>

* TRIP ##
- GET : ``` $host/test-api/index.php/trips/get ``` <br>
- GET : ``` $host/test-api/index.php/trips/get/{id} ``` <br>
- POST : ``` $host/test-api/index.php/trips/create ``` <br>
```
JSON input 
{
"name":"Trip to Munich",
"start_from":"Łódź",
"end_to":"Munich",
"total_spot": 2,
"trip_date":"2022-03-11 11:00:00"
}
```
- PUT : ``` $host/test-api/index.php/trips/update/{id} ``` <br>
```
JSON input 
{
"trip_date":"2022-05-10 11:00:00"
}
```
<br>

* Reserve ##
- POST : ``` $host/test-api/index.php/reserve/create ``` <br>
```

JSON input 
{
"user_id": 1,
"trip_id": 1,
"number_of_spots": 2
}

```
- PUT : ``` $host/test-api/index.php/reserve/cancel/{id}``` <br>
- IF Flexible cancellation<br>
```
JSON input 
{
"number_of_spots": 1
}

```

- ELSE : ``` $host/test-api/index.php/reserve/cancel/{id}``` <br>

**** IF YOU ARE USING POSTMAN ****** <br>
- Download the [API.JSON](https://drive.google.com/uc?export=view&id=1qPSp-05s4PXqw6PbsmRcKJVCul4jbyTX) and import it into your POSTMAN

<br><br>
********* Run the Tests *********<br>
We have api tests implemented for critical part of the project.
To Test ReservationActions : 

     * Step - 1 : We try to create a User
     * Step - 2 : We try to create a Trip
     * Step - 3 : We Grab those User and Trip IDs and Crate Reserve with that
But while creating Reservation we also have test coverage for differnt business logics.

* Test #1 :
        Test Create Reserve, we are trying to create<br>
        with more space that we have created in Trip above<br>
* Test #2 :
         Test Create Reserve, with proper data<br>
          We have created Trip above with total_spot = 1<br>
          So, this request should work, and we should be able to reserve the spot.   
* Test #3 :
          Test Create Reserve, with proper data<br>
          We have created Trip above with total_spot = 1<br>
          and in previous request we have successfully reserved that spot!<br>
          So, this spot should show us the error message<br>
          
* Test #4 : We are trying to cancel more spots than we have! <br>
 
* Test #5 : We are actually Cancelling the reservation this time!<br>
            also testing flexible reservation by passing params
            
* Test #6: Now we are booking that cancelled spot<br>
            by the logic it should allow us to do such operation   
            
* Test ## : In addition we have some other tests for user endpoint <br>
  - get all user
  - get 1 user
  - check for invalid id / No data
<br><br>  
            
Tests Results : 
```
RajeshGhoshs-MacBook-Pro:test-api rajesh$ php vendor/bin/codecept run
Codeception PHP Testing Framework v4.1.28
Powered by PHPUnit 9.5.12 by Sebastian Bergmann and contributors.

Api Tests (7) ----------------------------------------------------------------------------------
✔ ApiCest: Try user get api (0.02s)
✔ ApiCest: Try get one user api (0.01s)
✔ ApiCest: Try get invalid user api (0.00s)
✔ ReserveActionsCest: Create user test (0.28s)
✔ ReserveActionsCest: Create trip test (0.01s)
✔ ReserveActionsCest: Create reserve test (0.02s)
✔ ReserveActionsCest: Cancel and reserve again test (0.02s)
--------------------------------------------------------------------------------------------------


Time: 00:00.394, Memory: 10.00 MB

OK (7 tests, 103 assertions)
```
