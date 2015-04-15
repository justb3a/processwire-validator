<?php

namespace Kfi\Validator;
use WireException;

class MinLengthValidator extends AbstractValidator implements ValidatorInterface {

  const MIN_LENGTH = 'minLength';

  protected $_messageTemplates = array(
    self::MIN_LENGTH => "This field must be at least '%min%' characters."
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');

    // get min value
    $cond = is_array($conf) && array_key_exists('min', $conf) && is_numeric($conf['min']);
    $min = $cond ? (int)$conf['min'] : 0;
    $this->setMin($min);

    // validate
    if (strlen($value) < $min) {
      $this->setIsValid(false);
      $this->addError(self::MIN_LENGTH);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        if (defined('self::MIN_' . strtoupper($error)) && !empty($message)) {
          $error = constant('self::MIN_' . strtoupper($error));
          $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
        }
      }
    }
  }

}
