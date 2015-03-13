<?php

namespace Kfi\Validator;

class IsEmailValidator extends AbstractValidator implements ValidatorInterface {

  const EMAIL_IS_INVALID = 'emailIsInvalid';

  protected $_messageTemplates = array(
    self::EMAIL_IS_INVALID => "Please enter a valid email address."
  );

  public function validate($value, $conf = array()) {
    if (empty(wire('sanitizer')->email($value))) {
      $this->setValue($value);
      $this->setIsValid(false);
      $this->addError(self::EMAIL_IS_INVALID);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::EMAIL_IS_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
