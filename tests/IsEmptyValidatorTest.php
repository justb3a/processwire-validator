<?php

namespace Kfi\Validator\Tests;

use Kfi\Validator\IsEmptyValidator;

class IsEmptyValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new IsEmptyValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testIsEmpty() {
    $validator = new IsEmptyValidator('');
    $this->assertFalse($validator->isValid(), "Value should be empty.");
  }

  public function testIsNotEmpty() {
    $validator = new IsEmptyValidator('some string');
    $this->assertTrue($validator->isValid(), "Value is not allowed to be empty.");
  }

}
