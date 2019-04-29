# BileMo API
BileMo is a company offering a selection of high-end mobile phones.
This API is a service for BileMo's clients to access BileMo's phone.

## Installation

### Install the project on your computer:

	- Clone this project on your computer
	- Open a command prompt ( cmd in the project's folder )
	- paste this command " composer install"
	  
  #### JWT
	
Set up JWT by executing the following commands	

	- mkdir config/jwt 
	- openssl genrsa -out config/jwt/private.pem -aes256 4096
	- openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

"openssl genrsa -out config/jwt/private.pem -aes256 4096" this command want you to enter a code.
"openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem" this command want this code.

### Database configuration
In the file ".env" :

	- DATABASE_URL=mysql://'db_user':'db_password'@127.0.0.1:3306/db_name

"db_user" and "db_password" is your database's username and password.
"db_name" is the name of the project.
