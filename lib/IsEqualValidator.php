<?php

namespace Kfi\Validator;

class IsEqualValidator extends AbstractValidator implements ValidatorInterface {

  const IS_NOT_EQUAL = 'IS_NOT_EQUAL';

  protected $_messageTemplates = array(
    self::IS_NOT_EQUAL => "This field must be equal to '%equal%'."
  );

  public function validate($value, $conf = array()) {
    // get equal value
    $cond = is_array($conf) && array_key_exists('equal', $conf);
    $equal = $cond ? $conf['equal'] : '';

    // validate
    if ($value != wire('input')->post->$equal) {
      $this->setEqual($equal);
      $this->setIsValid(false);
      $this->addError(self::IS_NOT_EQUAL);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::IS_NOT_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
