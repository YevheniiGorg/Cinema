<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 Basic My Cinema</h1>
    <br>
</p>

Yii 2 Basic Project Template is a skeleton [Yii 2](http://www.yiiframework.com/) application best for
rapidly creating small projects.

The template contains the basic features including user login/logout and a contact page.
It includes all commonly used configurations that would allow you to focus on adding new
features to your application.

DIRECTORY STRUCTURE
-------------------

      assets/             contains assets definition
      commands/           contains console commands (controllers)
      config/             contains application configurations
      controllers/        contains Web controller classes
      mail/               contains view files for e-mails
      models/             contains model classes
      runtime/            contains files generated during runtime
      tests/              contains various tests for the basic application
      vendor/             contains dependent 3rd-party packages
      views/              contains view files for the Web application
      web/                contains the entry script and Web resources



REQUIREMENTS
------------

The minimum requirement by this project template that your Web server supports PHP 5.6.0.


INSTALLATION
------------

### Install

[Install composer](http://getcomposer.org/)

### Download sources

[https://github.com/YevheniiGorg/Cinema/archive/master.zip](/YevheniiGorg/Cinema/archive/master.zip)

### Or clone repository manually
~~~
git clone https://github.com/YevheniiGorg/Cinema.git
~~~

### Install composer dependencies
~~~
composer update
~~~

### Apply migrations
~~~
yii migrate --migrationPath=@yii/rbac/migrations
yii migrate
~~~

CONFIGURATION
-------------

### Database

Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2cinema',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```
DEMO DATA
------------
### Demo Users
~~~
Login: webmaster
Password: webmaster

Login: user
Password: user
~~~