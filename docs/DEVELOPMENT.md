# CAPI SDK DEVELOPMENT

## How to run project?

Just type:

```vagrant up```

```vagrant ssh```

```composer install```

### Remarks

Vagrant machine delivers multiple php verions following project requirements:

```php5.5``` - to use PHP 5.5

```php5.5``` - to use PHP 5.6

```php7.0``` - to use PHP 7.0

Keep in mind that ```php``` is pointed to ```php7.0``` at the beginning.

## Quality and tests

Available commands:

```bin/phing phpmd``` - to run phpmd

```bin/phing phpcs``` - to run phpcs

```bin/phing phpcpd``` - to run phpcpd

```bin/phing quality``` - to run all above: phpmd, phpcs and phpcpd

```bin/phing phpspec``` - to run phpspec

```bin/phing behat``` - to run behat

```bin/phing tests``` - to run all tests: phpspec and behat

```bin/phing all``` - to run both: quality and tests

Only for Vagrant machine:

```bin/phing php``` - to choose PHP version should be used (`5.5`, `5.6` or `7.0`)

```bin/phing vagrant``` - to run ```all`` tasks for all supported PHP versions (`5.5`, `5.6`, `7.0`)

