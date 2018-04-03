INSTALLATION
------------

~~~
composer install
~~~

CONFIGURATION
-------------

### Database

Copy file `config/db.sample.php` to `config/db.php` and edit it with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

ADD USER MODULE, RBAC MODULE
----------------------------

~~~
composer require dektrium/yii2-user
php yii migrate/up --migrationPath=@vendor/dektrium/yii2-user/migrations
php yii migrate --migrationPath=@yii/rbac/migrations
~~~

MIGRATE
-------

~~~
php yii migrate
~~~

ADD RBAC ROLES
--------------

~~~
php yii rbac/init
~~~

This command add "manager" and "admin" roles

### Optional

Example: Assign role "admin" to user id=1

~~~
php yii rbac/assign 1 admin
~~~