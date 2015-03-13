#### Navigation
- [Installation](installation.md)
- [Examples](examples.md)
- [➻ Available Validators](validators.md)
- [Error Messages](messages.md)


# Validation for ProcessWire: Validators

## quick access

- ✍ [general behaviour](#general-behaviour)
- [containsAtLeast](#containsatleast)
- [isEmail](#isemail)
- [isEmpty](#isempty)
- [isEqual](#isequal)
- [isEqualLength](#isequallength)
- [isUnique](#isunique)
- [maxLength](#maxlength)
- [minLength](#minlength)
- [noWhitespace](#nowhitespace)
- [range](#range)

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

## isEmail

### options

- ``messages``
    * **optional**
    * array
    * possible replacements: ``%value%``

    | key        | description      |
    | ---------- | -------------    |
    | invalid    | email is invalid |

### example

```php
'pass' => array(
  'isEmail' => array(
    'messages' => array(
      'invalid' => 'This %value% email address is invalid',
    )
  )
)
```

## isEmpty

- ``messages``
    * **optional**
    * array
    * possible replacements: none

    | key        | description    |
    | ---------- | -------------  |
    | empty      | field is empty |

### example

```php
'pass' => array(
  'isEmpty' => array(
    'messages' => array(
      'empty' => 'This is another error message'
    )
  )
)
```

## isEqual

- ``equal``
    * **required**
    * string
    * values: fieldname to match
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%equal%``

    | key        | description   |
    | ---------- | ------------- |
    | equal      | is not equal  |

### example

```php
'pass' => array(
  'isEqual' => array(
    'equal' => 'pass_confirm',
    'messages' => array(
      'equal' => 'The fields does not match'
    )
  )
)
```

## isEqualLength

- ``equal``
    * **required**
    * integer
    * values: number
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%equal%``

    | key        | description         |
    | ---------- | -------------       |
    | length     | is not equal length |

### example

```php
'pass' => array(
  'isEqualLength' => array(
    'equal' => 8,
    'messages' => array(
      'equal' => 'This is another error message'
    )
  )
)
```

## isUnique

- ``ident``
    * **required**
    * string
    * values: fieldname to check against
- ``sanitize``
    * **required**
    * string
    * possible values: ``email`` ``username`` ``text``
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%value%``

    | key        | description            |
    | ---------- | -------------          |
    | text       | text is not unique     |
    | email      | email is not unique    |
    | username   | username is not unique |

### example

```php
'pass' => array(
  'isUnique' => array(
    'ident' => 'emailaddress',
    'sanitize' => 'email',
    'messages' => array(
      'text' => 'This is another error message',
      'email' => 'This is another error message',
      'username' => 'This is another error message'
    )
  )
)
```

## maxLength

- ``max``
    * **optional**
    * integer
    * default: 10
    * values: number
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%max%``

    | key        | description        |
    | ---------- | -------------      |
    | length     | must be at maximum |

### example

```php
'pass' => array(
  'maxLength' => array(
    'max' => 12,
    'messages' => array(
      'length' => 'This is another error message'
    )
  )
)
```

## minLength

- ``min``
    * **optional**
    * integer
    * default: 0
    * values: number
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%min%``

    | key        | description        |
    | ---------- | -------------      |
    | length     | must be at least |

### example

```php
'pass' => array(
  'minLength' => array(
    'min' => 6,
    'messages' => array(
      'length' => 'This is another error message'
    )
  )
)
```

## noWhitespace

- ``messages``
    * **optional**
    * array
    * possible replacements: none

    | key        | description               |
    | ---------- | -------------             |
    | whitespace | whitespace is not allowed |

### example

```php
'pass' => array(
  'noWhitespace' => array(
    'messages' => array(
      'whitespace' => 'This is another error message'
    )
  )
)
```

## range

- ``min``
    * **optional**
    * integer
    * default: 0
    * values: number
- ``max``
    * **optional**
    * integer
    * default: 10
    * values: number
- ``messages``
    * **optional**
    * array
    * possible replacements: ``%min%``  ``%max%``

    | key        | description   |
    | ---------- | ------------- |
    | range      | out of range  |

### example

```php
'pass' => array(
  'range' => array(
    'min' => 5,
    'max' => 12,
    'messages' => array(
      'range' => 'This is another error message'
    )
  )
)
```
