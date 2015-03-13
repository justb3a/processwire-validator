<?php

namespace Kfi\Validator;

class IsUniqueValidator extends AbstractValidator implements ValidatorInterface {

  const IS_NOT_UNIQUE_TEXT = 'isNotUniqueText';
  const IS_NOT_UNIQUE_EMAIL = 'isNotUniqueEmail';
  const IS_NOT_UNIQUE_USERNAME = 'isNotUniqueUsername';

  protected $_messageTemplates = array(
    self::IS_NOT_UNIQUE_TEXT => "This value '%value%' is already taken. Please choose another one.",
    self::IS_NOT_UNIQUE_EMAIL => "This email address '%value%' is already taken. Please choose another one.",
    self::IS_NOT_UNIQUE_USERNAME => "This username '%value%' is already taken. Please choose another one."
  );

  public function validate($value, $conf = array()) {
    $ident = is_array($conf) && array_key_exists('ident', $conf) ? $conf['ident'] : '';
    $this->setValue($value);

    if (!empty($ident)) {
      $sanitize = array_key_exists('sanitize', $conf) ? $conf['sanitize'] : 'text';
      $value = $this->sanitizeValue($sanitize, $value);

      // after sanitizing the value may be empty
      // (for example: invalid email returns empty string)
      if (!empty($value)) {
        if (wire('users')->get("$ident=$value")->id) {
          $this->setIsValid(false);
          $this->addError(constant('self::IS_NOT_UNIQUE_' . strtoupper($sanitize)));
          $this->checkOwnMessage($conf);
        }
      }
    }
  }

  private function sanitizeValue($sanitize, $value) {
    $sanitizer = wire('sanitizer');

    switch($sanitize) {
      case 'username':
        $value = $sanitizer->username($value);
        break;
      case 'email':
        $value = $sanitizer->email($value);
        break;
      default:
        $value = $sanitizer->text($value);
    }

    return $value;
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::IS_NOT_UNIQUE_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
