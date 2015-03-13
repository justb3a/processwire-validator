<?php

namespace Kfi\Validator;

class MatchFieldValidator extends AbstractValidator implements ValidatorInterface {

  const FIELD_DOES_NOT_MATCH = 'fieldDoesNotMatch';

  protected $_messageTemplates = array(
    self::FIELD_DOES_NOT_MATCH => "This field must match '%field%'."
  );

  public function validate($value, $conf = array()) {
    $cond = is_array($conf) && array_key_exists('field', $conf);
    $field = $cond ? $conf['field'] : '';
    $this->setField($field);

    if (!empty(wire('input')->post->$field)) {
      // validate
      if ($value != wire('input')->post->$field) {
        $this->setIsValid(false);
        $this->addError(self::FIELD_DOES_NOT_MATCH);
        $this->checkOwnMessage($conf);
      }
    }
  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::FIELD_DOES_NOT_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
