<?php

namespace Kfi\Validator;

interface ValidatorInterface {
  public function validate($value, $conf = array());
  public function isValid();
  public function getErrors();
  public function getMessages();
}
