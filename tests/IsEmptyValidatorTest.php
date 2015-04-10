<?php

namespace Kfi\Validator\Tests;

use Kfi\Validator\IsEmptyValidator;

class IsEmptyValidatorTest extends \PHPUnit_Framework_TestCase {

  public function testIsEmpty() {
    $validator = new IsEmptyValidator('');
    $this->assertFalse($validator->isValid(), "Value should be empty.");
  }

  public function testIsNotEmpty() {
    $validator = new IsEmptyValidator('some string');
    $this->assertTrue($validator->isValid(), "Value is not allowed to be empty.");
  }

}
