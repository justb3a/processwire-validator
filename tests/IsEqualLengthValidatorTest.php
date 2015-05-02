<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\IsEqualLengthValidator;

class IsEqualLengthValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new IsEqualLengthValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testIsEqualLength() {
    $validator = new IsEqualLengthValidator('string', array('equal' => 6));
    $this->assertTrue($validator->isValid(), "Value should be equal to 6.");
  }

  public function testIsNotEqualLength() {
    $a = new IsEqualLengthValidator('string', array('equal' => 8));
    $b = new IsEqualLengthValidator('string');
    $c = new IsEqualLengthValidator('string', array('equal' => 'string'));
    $d = new IsEqualLengthValidator('string', array('equal' => 'string', 'messages' => array('length' => 'This is another error message.')));

    foreach (range('a', 'd') as $validator) {
      $this->assertFalse(${$validator}->isValid(), "Value should be equal to 8.");
      $message = ${$validator}->getMessages();
      $err = ${$validator}->getErrors();
      $this->assertNotEmpty($message[0]);
      $this->assertEquals(IsEqualLengthValidator::IS_NOT_EQUAL_LENGTH, $err[0], 'Error message is missing.');
    }

  }

}
