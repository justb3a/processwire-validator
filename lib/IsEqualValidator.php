<?php

namespace Kfi\Validator;
use WireException;

class IsEqualValidator extends AbstractValidator implements ValidatorInterface {

  const IS_NOT_EQUAL = 'IS_NOT_EQUAL';

  protected $_messageTemplates = array(
    self::IS_NOT_EQUAL => "This field must be equal to '%equal%'."
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');
    if (!array_key_exists('equal', $conf)) throw new WireException('No field to match was transferred.');
    if (is_null(wire('input')->post->$conf['equal'])) throw new WireException('Transferred field does not exist in POST request.');

    // validate
    if ($value != wire('input')->post->$conf['equal']) {
      $this->setEqual($conf['equal']);
      $this->setIsValid(false);
      $this->addError(self::IS_NOT_EQUAL);
      $this->checkOwnMessage($conf);
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        if (defined('self::IS_NOT_' . strtoupper($error)) && !empty($message)) {
          $error = constant('self::IS_NOT_' . strtoupper($error));
          $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
        }
      }
    }
  }

}
