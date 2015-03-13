#### Navigation
- [Examples](examples.md)
- [➻ Available Validators](validators.md)
- [Error Messages](messages.md)


# Validation for ProcessWire: Validators

## quick access

- [general behaviour](#general-behaviour)
- [containsAtLeast](#containsatleast)

## general behaviour

- if you don't need any options

```php
'fieldname' => array(
  'validatorName'
)
```

- if you need some options

```php
'fieldname' => array(
  'validatorName' => array(
    'ident1' => 'value',
    'ident2' => 'value'
  )
)
```

- if you want to overwrite messages

```php
'fieldname' => array(
  'validatorName' => array(
    'ident1' => 'value'
  ),
  'messages' => array(
    'ident1' => 'new message, may include replacement parameters like %value% or %min%',
    'ident2' => 'just another error message for ident2'
)
```

## containsAtLeast

### options

- ``contains``
    * **required**
    * string
    * comma separated list
    * possible values: ``digit`` ``letter`` ``specialsign`` ``uppercase``
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%value%``

    | key         | description                                       |
    | ----------  | -------------                                     | 
    | digit       | contains at least one digit                       |
    | letter      | contains at least one letter (upper or lowercase) |
    | specialsign | contains at least one special sign                |
    | uppercase   | contains at least one uppercase letter            |

### example

```php
'pass' => array(
  'containsAtLeast' => array(
    'contains' => 'digit, letter',
    'messages' => array(
      'digit' => 'This is another error message',
      'letter' => '%value% must ..'
    )
  )
)
```

## isEmpty

### options

### messages

## minLength
## maxLength

## noWhitespace
## isUnique
## isEmail
## isEqual
## isEqualLength
## range
## matchField

