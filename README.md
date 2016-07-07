# CAPI PHP SDK

Project supports PHP >= 5.5.

## Create project using vagrant

Just type:

```vagrant up```

and after that

```vagrant ssh```

Vagrant machine delivers multiple php verions following project requirements:

```php5.6``` - to use PHP 5.6

```php5.7``` - to use PHP 5.7

```php7.0``` - to use PHP 7.0

Keep in mind that ```php``` is pointed to ```php7.0```

If you want to change easily php version for running commands type ```sudo update-alternatives --config php``` and follow instructions.

## Quality and tests

To run tests just type:

```bin/phing quality``` - to run phpmd, phpcs and phpcpd

```bin/phing tests``` - to run phpspec and behat

```bin/phing [all]``` - to run quality and tests
