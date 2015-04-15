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

  public function testIsNotEmpty() {
    $validator = new IsEmptyValidator('some string');
    $this->assertTrue($validator->isValid(), "Value is not allowed to be empty.");
  }

  public function testIsEmpty() {
    $a = new IsEmptyValidator('');
    $b = new IsEmptyValidator('', array('messages' => array('empty' => 'This is another error message.')));

    foreach (range('a', 'b') as $validator) {
      $this->assertFalse(${$validator}->isValid(), "Value should be empty.");
      $this->assertEquals(IsEmptyValidator::IS_EMPTY, ${$validator}->getErrors()[0], 'Error message is missing.');
    }
  }

}
