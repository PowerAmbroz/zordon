# zordon

#1. Database Config

## Rename the .env-sample to .env and uncomment the database that you are using. For Example:
* DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=5.7" 
* Chcnage your db_user to your database username, db_password to ypur password, dv_name to your database name

## Create your database and in the terminal use the command php bin/console doctrine:migrations:migrate