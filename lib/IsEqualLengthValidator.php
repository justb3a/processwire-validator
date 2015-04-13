<?php

namespace Kfi\Validator;
use WireException;

class IsEqualLengthValidator extends AbstractValidator implements ValidatorInterface {

  const IS_NOT_EQUAL_LENGTH = 'IS_NOT_EQUAL_LENGTH';

  protected $_messageTemplates = array(
    self::IS_NOT_EQUAL_LENGTH => "This field must be equal to %equal%."
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');

    // get equal value
    $cond = array_key_exists('equal', $conf) && is_numeric($conf['equal']);
    $equal = $cond ? (int)$conf['equal'] : 0;

    // validate
    if (strlen($value) != $equal) {
      $this->setEqual($equal);
      $this->setIsValid(false);
      $this->addError(self::IS_NOT_EQUAL_LENGTH);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::IS_NOT_EQUAL_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
