#### Navigation
- [Installation](installation.md)
- [➻ Examples](examples.md)
- [Available Validators](validators.md)
- [Error Messages](messages.md)


# Validation for ProcessWire: Examples

## How to

1. build configuration array         ``$validatorConf = array( ... );``
2. get validator                     ``$validator = new Validator;``
3. set config                        ``$validator->setConfig($validatorConf);``
4. validate
    - check if it's valid {boolean}  ``$validator->isValid();``
    - get errors {array}             ``$validator->getErrors();``
    - get error messages {array}     ``$validator->getMessages();``

```php
$validatorConf = array( ... );
$validator = new Validator;
$validator->setConfig($validatorConf);
$validator->isValid();
$validator->getErrors();
$validator->getMessages();
```

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
