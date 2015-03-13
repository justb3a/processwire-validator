<?php

namespace Kfi\Validator;

class MaxLengthValidator extends AbstractValidator implements ValidatorInterface {

  const MAX_LENGTH = 'maxLength';

  protected $_messageTemplates = array(
    self::MAX_LENGTH => "This field must be at maximum '%max%' characters."
  );

  public function validate($value, $conf = array()) {
    // get max value
    $cond = is_array($conf) && array_key_exists('max', $conf) && is_numeric($conf['max']);
    $max = $cond ? (int)$conf['max'] : 10;
    $this->setMax($max);

    // validate
    if (strlen($value) > $max) {
      $this->setIsValid(false);
      $this->addError(self::MAX_LENGTH);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::MAX_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
