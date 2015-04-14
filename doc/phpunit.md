#### Navigation
- [Installation](installation.md)
- [Usage](examples.md)
- [Available Validators](validators.md)
- [Error Messages](messages.md)
- [➻ phpunit Testing](phpunit.md)


# Validation for ProcessWire: phpunit

## Quick Test

- no logging
- no code coverage
- configuration file phpunit.xml

```
❯ phpunit
PHPUnit 4.6.2 by Sebastian Bergmann and contributors.

Configuration read from /.../public/site/modules/Validator/phpunit.xml

 34  -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_,------,
 0   -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_|  /\_/\
 0   -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-~|_( ^ .^)
     -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_- ""  ""


Time: 445 ms, Memory: 28.50Mb

OK (34 tests, 114 assertions)
```

## Test including Code Coverage

- logging
- code coverage
- configuration file phpunit-log.xml
- target log/

```
❯ phpunit --configuration phpunit-log.xml
PHPUnit 4.6.2 by Sebastian Bergmann and contributors.

Configuration read from /.../public/site/modules/Validator/phpunit-log.xml

 34  -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_,------,
 0   -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_|  /\_/\
 0   -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-~|_( ^ .^)
     -_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_-_- ""  ""


Time: 20.51 seconds, Memory: 50.75Mb

OK (34 tests, 114 assertions)

Generating code coverage report in HTML format ... done
```
