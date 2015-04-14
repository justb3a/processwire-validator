<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\MinLengthValidator;

class MinLengthValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new MinLengthValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testMinLength() {
    $a = new MinLengthValidator('lengthIs9');
    $b = new MinLengthValidator('lengthIs9', array('min' => 5));

    $this->assertTrue($a->isValid(), "Value must be at minimum 0 characters.");
    $this->assertTrue($b->isValid(), "Value must be at minimum 5 characters.");
  }

  public function testMinLengthFail() {
    $a = new MinLengthValidator('lengthIs9', array('min' => 12));
    $b = new MinLengthValidator('lengthIs9', array('min' => 12, 'messages' => array('length' => 'This is another error message.')));

    $this->assertFalse($a->isValid(), "Value must be at minimum 12 characters.");
    $this->assertFalse($b->isValid(), "Value must be at minimum 12 characters.");

    $this->assertEquals(MinLengthValidator::MIN_LENGTH, $a->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(MinLengthValidator::MIN_LENGTH, $b->getErrors()[0], 'Error message is missing.');
  }

}
