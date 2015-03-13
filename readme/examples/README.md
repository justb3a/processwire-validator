- [back](..)

# Validation for ProcessWire: Examples

## Example I (form)

Build configuration array:
```php
$validatorConf = array(
  'username' => array(
    'isEmpty',
    'isUnique' => array('ident' => 'name', 'sanitize' => 'username')
  ),
  'pass' => array(
    'isEmpty',
    'minLength' => array('min' => 6),
    'containsAtLeast' => array('contains' => 'digit, letter'),
    'noWhitespace'
  ),
  'email' => array(
    'isEmpty',
    'isEmail',
    'isUnique' => array('ident' => 'email', 'sanitize' => 'email')
  )
);
```

Execute validation:
```php
$validator = new Validator;
$validator->setConfig($validatorConf);

if (!$validator->isValid()) {
  $errors = $validator->getErrors();
  $errorMessages = $validator->getMessages();
}
```

## Example II (REST)

Example Request
```php
$validator = new Validator;
$validator->setConfig($validatorConf);

// validation failed
if (!$validator->isValid()) {
  $data = array(
    'success' => false,
    'reason' => self::VALIDATION_FAILED,
    'errors' => $validator->getMessages() // $validator->getErrors()
  );
  $this->returnJson($data, 400);
}
```
```json
❯ http -f POST http://pw.dev/v1/user/ email=info@com username=exampleUser pass=short firstname=Jane lastname=Doe
```


Example Response - getMessages()
```json
{
    "errors": {
        "email": [
            "Please enter a valid email address."
        ],
        "pass": [
            "This field must be at least '6' characters.",
            "'short' must contain at least one digit character"
        ]
    },
   "reason": "Required fields are missing and/or email/username already exists",
   "success": false
}
```


Example Response - getErrors()
```json
{
    "errors": {
        "email": [
            "emailIsInvalid"
        ],
        "pass": [
            "minLength",
            "mustContainDigit"
        ]
    },
    "reason": "Required fields are missing and/or email/username already exists",
    "success": false
}
```