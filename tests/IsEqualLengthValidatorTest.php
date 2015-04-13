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
    $this->assertFalse($a->isValid(), "Value should be equal to 8.");
    $this->assertNotEmpty($a->getMessages()[0]);

    $b = new IsEqualLengthValidator('string');
    $this->assertFalse($b->isValid(), "Value should be equal to 8.");

    $c = new IsEqualLengthValidator('string', array('equal' => 'string'));
    $this->assertFalse($c->isValid(), "Value should be equal to 8.");
  }

}

