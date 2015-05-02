<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\RangeValidator;

class RangeValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new RangeValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testRange() {
    $validators = array(
      new RangeValidator('lengthis9'),
      new RangeValidator('lengthis9', array('min' => 5)),
      new RangeValidator('lengthiseq12', array('max' => 20)),
      new RangeValidator('lengthiseq12', array('min' => 5, 'max' => 20))
    );

    foreach ($validators as $validator) {
      $this->assertTrue(
        $validator->isValid(),
        'Value is not allowed to be out of range.
        Min: ' . $validator->getMin() . ';
        Max: ' . $validator->getMax() . ';
        Is: ' . strlen($validator->getValue())
      );
    }
  }

  public function testOutOfRange() {
    $validators = array(
      new RangeValidator('lengthis9', array('min' => 15)),
      new RangeValidator('lengthiseq12', array('max' => 10)),
      new RangeValidator('lengthiseq12', array('min' => 15, 'max' => 20)),
      new RangeValidator('lengthiseq12', array('min' => 15, 'max' => 20, 'messages' => array('range' => 'This is another error message.')))
    );

    foreach ($validators as $validator) {
      $this->assertFalse(
        $validator->isValid(),
        'Value should be out of range.
        Min: ' . $validator->getMin() . ';
        Max: ' . $validator->getMax() . ';
        Is: ' . strlen($validator->getValue())
      );

      $err = $validator->getErrors();

      $this->assertEquals(
        RangeValidator::OUT_OF_RANGE,
        $err[0],
        'Error message is missing.'
      );
    }
  }

}
