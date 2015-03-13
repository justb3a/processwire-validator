<?php

namespace Kfi\Validator;

class NoWhitespaceValidator extends AbstractValidator implements ValidatorInterface {

  const NO_WHITESPACE = 'noWhitespace';

  protected $_messageTemplates = array(
    self::NO_WHITESPACE => "This field may not have whitespace."
  );

  public function validate($value, $conf = array()) {
    if (preg_match('/\s/', $value)) {
      $this->setIsValid(false);
      $this->addError(self::NO_WHITESPACE);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::NO_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
