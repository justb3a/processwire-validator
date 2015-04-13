<?php

namespace Kfi\Validator;
use WireException;

class IsEmptyValidator extends AbstractValidator implements ValidatorInterface {

  const IS_EMPTY = 'isEmpty';

  protected $_messageTemplates = array(
    self::IS_EMPTY => "This field is required."
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');

    if (empty($value)) {
      $this->setIsValid(false);
      $this->addError(self::IS_EMPTY);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::IS_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
