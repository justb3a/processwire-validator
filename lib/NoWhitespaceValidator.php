<?php

namespace Kfi\Validator;
use WireException;

class NoWhitespaceValidator extends AbstractValidator implements ValidatorInterface {

  const NO_WHITESPACE = 'noWhitespace';

  protected $_messageTemplates = array(
    self::NO_WHITESPACE => "This field may not have whitespace."
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');

    if (preg_match('/\s/', $value)) {
      $this->setIsValid(false);
      $this->addError(self::NO_WHITESPACE);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        if (defined('self::NO_' . strtoupper($error)) && !empty($message)) {
          $error = constant('self::NO_' . strtoupper($error));
          $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
        }
      }
    }
  }

}
