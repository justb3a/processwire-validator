<?php

namespace Kfi\Validator;
use WireException;

abstract class AbstractValidator {
  private $errors = [];
  private $isValid = true;
  private $value = '';
  private $min = 0;
  private $max = 10;
  private $equal = '';
  private $field = '';

  public function __construct($value, $conf = array()) {
    $this->validate($value, $conf);
  }

  protected function addError($error) {
    array_push($this->errors, $error);
  }

  protected function setValue($value) {
    $this->value = $value;
  }

  public function getValue() {
    return $this->value;
  }

  protected function setMin($min) {
    $this->min = $min;
  }

  public function getMin() {
    return $this->min;
  }

  protected function setMax($max) {
    $this->max = $max;
  }

  public function getMax() {
    return $this->max;
  }

  protected function setEqual($equal) {
    $this->equal = $equal;
  }

  protected function setIsValid($isValid) {
    $this->isValid = $isValid;
  }

  public function isValid() {
    return $this->isValid;
  }

  public function getErrors() {
    return $this->errors;
  }

  public function getMessages() {
    $messages = array();
    foreach ($this->errors as $error) {
      if (array_key_exists($error, $this->_messageTemplates)) {
        $message = $this->_messageTemplates[$error];

        // replace placeholders
        foreach (array('min', 'max', 'value', 'equal', 'field') as $replace) {
          if (preg_match('/%'. $replace . '%/', $message)) {
            $message = str_replace('%' . $replace . '%', $this->$replace, $message);
          }
        }
      }

      $messages[] = $message;
    }

    return $messages;
  }
}
