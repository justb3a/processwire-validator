# WARNING: This repository is no longer maintained :warning:

> This repository will not be updated. The repository will be kept available in read-only mode.

# Validation for ProcessWire

This module provides a set of useful validation methods.

## Example Usage

```php
$conf = array(
  'username' => array('isEmpty', 'isUnique' => array('ident' => 'name', 'sanitize' => 'username')),
  'pass' => array('range' => array('min' => 6, 'max' => 20))
);

$validator = new Validator;
$validator->setConfig($conf);
if (!$validator->isValid()) $errors = $validator->getErrors();
```

[Read more!](doc/examples.md)

# The Guides

- [Installation] (doc/installation.md)
- [Usage](doc/examples.md)
- [Available Validators](doc/validators.md)
- [Error Messages](doc/messages.md)
- [phpunit Testing](doc/phpunit.md)
