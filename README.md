Adress Book
=========
## Installation

Update your composer 

```bash
$ composer update
```
Create the database
```bash
php bin/console doctrine:database:create
```
validate the mappings
```bash
 php bin/console doctrine:schema:validate
```
To upload the pictures i used VichUploaderBundle 
https://github.com/dustin10/VichUploaderBundle




