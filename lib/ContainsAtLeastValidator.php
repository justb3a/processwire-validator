<?php

namespace Kfi\Validator;
use WireException;

class ContainsAtLeastValidator extends AbstractValidator implements ValidatorInterface {

  const MUST_CONTAIN_DIGIT = 'mustContainDigit';
  const MUST_CONTAIN_LETTER = 'mustContainLetter';
  const MUST_CONTAIN_SPECIALSIGN = 'mustContainSpecialsign';
  const MUST_CONTAIN_UPPERCASE = 'mustContainUppercase';

  protected $_messageTemplates = array(
    self::MUST_CONTAIN_DIGIT => "'%value%' must contain at least one digit character",
    self::MUST_CONTAIN_LETTER => "'%value%' must contain at least one letter",
    self::MUST_CONTAIN_SPECIALSIGN => "'%value%' must contain at least one special sign",
    self::MUST_CONTAIN_UPPERCASE => "'%value%' must contain at least one uppercase letter"
  );

  public function validate($value, $conf = array()) {
    if (!is_array($conf)) throw new WireException('Config must be of type array but is of type ' . gettype($conf) . '.');

    if (!array_key_exists('contains', $conf) || empty($conf['contains'])) {
      $conf['contains'] = 'digit, letter, specialsign, uppercase';
    }

    $this->setValue($value);

    foreach (explode(',' , $conf['contains']) as $type) {
      switch(trim($type)) {
        case 'digit':
          if (!preg_match('/\d/', $value)) {
            $this->setIsValid(false);
            $this->addError(self::MUST_CONTAIN_DIGIT);
          }
          break;
        case 'letter':
          if (!preg_match('/[A-Za-z]/', $value)) {
            $this->setIsValid(false);
            $this->addError(self::MUST_CONTAIN_LETTER);
          }
          break;
        case 'specialsign':
          if (!preg_match('/[_\W]/', $value)) {
            $this->setIsValid(false);
            $this->addError(self::MUST_CONTAIN_SPECIALSIGN);
          }
          break;
        case 'uppercase':
          if (!preg_match('/[A-Z]/', $value)) {
            $this->setIsValid(false);
            $this->addError(self::MUST_CONTAIN_UPPERCASE);
          }
          break;
        default:
          throw new WireException('Unknown param: ' . $type . '.');
          break;
      }
    }

  $this->checkOwnMessage($conf);

  }

  private function checkOwnMessage($conf) {
    if (array_key_exists('messages', $conf) && is_array($conf['messages'])) {
      foreach ($conf['messages'] as $error => $message) {
        $error = constant('self::MUST_CONTAIN_' . strtoupper($error));
        $this->_messageTemplates[$error] = wire('sanitizer')->text($message);
      }
    }
  }

}
