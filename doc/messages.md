#### Navigation
- [Installation](installation.md)
- [Examples](examples.md)
- [Available Validators](validators.md)
- [➻ Error Messages](messages.md)


# Validation for ProcessWire: Error Messages

| validator       | key         | default                                                                   |
| ---             | ---         | ---                                                                       |
| containsAtLeast | digit       | '%value%' must contain at least one digit character                       |
| "               | letter      | '%value%' must contain at least one letter                                |
| "               | specialsign | '%value%' must contain at least one special sign                          |
| "               | uppercase   | '%value%' must contain at least one uppercase letter                      |
| isEmail         | invalid     | Please enter a valid email address.                                       |
| isEmpty         | empty       | This field is required.                                                   |
| isEqual         | equal       | This field must be equal to '%equal%'.                                    |
| isEqualLength   | length      | This field must be equal to %equal%.                                      |
| isUnique        | text        | This value '%value%' is already taken. Please choose another one.         |
| "               | email       | This email address '%value%' is already taken. Please choose another one. |
| "               | username    | This username '%value%' is already taken. Please choose another one.      |
| maxLength       | length      | This field must be at maximum '%max%' characters.                         |
| minLength       | length      | This field must be at least '%min%' characters.                           |
| noWhitespace    | whitespace  | This field may not have whitespace.                                       |
| range           | range       | This field must be at least '%min%' and at maximum '%max%' characters.    |
