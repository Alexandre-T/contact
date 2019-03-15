# Contact application [![Build Status](https://travis-ci.org/Alexandre-T/contact.svg?branch=master)](https://travis-ci.org/Alexandre-T/contact)
Contact is an application for a commercial team to store contacts. 

## Requirements
Software recommended :
* git (optional)
* composer (optional)
* Database server postgresql (necessary)
* An access to create a new database or an owner-access to a dedicated database 

## Installation
```
git clone https://github.com/Alexandre-T/contact.git contact
cd contact
composer install
composer update
```

Create database if it does not exists:
```
CREATE DATABASE bd_contact
    WITH 
    OWNER = symfony
    ENCODING = 'UTF8'
    LC_COLLATE = 'French_France.1252'
    LC_CTYPE = 'French_France.1252'
    TABLESPACE = pg_default
    CONNECTION LIMIT = -1;
```

Edit `.env` file to complete access

Load database model:
```
php bin/console doctrine:migrations:migrate -n
```

Load database data:
```
php bin/console doctrine:fixtures:load -n
```

Launch application (start have to be replaced by start on linux, but it will be better to use an apache server):
```
php bin/console server:start
```

Launch unit test:
```
php bin/codecept run unit
```

Launch functional test:
```
php bin/codecept run functional
```

Launch acceptance test:
```
php bin/codecept run acceptance
```
