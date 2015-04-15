<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\MaxLengthValidator;

class MaxLengthValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new MaxLengthValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testMaxLength() {
    $a = new MaxLengthValidator('lengthIs9');
    $b = new MaxLengthValidator('lengthIs9', array('max' => 9));

    $this->assertTrue($a->isValid(), "Value must be at maximum 10 characters.");
    $this->assertTrue($b->isValid(), "Value must be at maximum 9 characters.");
  }

  public function testMaxLengthFail() {
    $a = new MaxLengthValidator('lengthIs999');
    $b = new MaxLengthValidator('lengthIs999', array('max' => 5));
    $c = new MaxLengthValidator('lengthIs999', array('max' => 5, 'messages' => array('length' => 'This is another error message.')));

    foreach (range('a', 'c') as $validator) {
      $this->assertFalse(${$validator}->isValid(), 'Value must be at maximum ' . ${$validator}->getMax(). ' characters.');
      $this->assertEquals(MaxLengthValidator::MAX_LENGTH, ${$validator}->getErrors()[0], 'Error message is missing.');
    }
  }

}
