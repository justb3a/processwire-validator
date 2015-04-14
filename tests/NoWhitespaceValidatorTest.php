<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\NoWhitespaceValidator;

class NoWhitespaceValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new NoWhitespaceValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testNoWhitespace() {
    $validator = new NoWhitespaceValidator('stringwithoutwhitespace');
    $this->assertTrue($validator->isValid(), "Value is not allowed to contain whitespace.");
  }

  public function testContainsWhitespace() {
    $a = new NoWhitespaceValidator('string with whitespace');
    $b = new NoWhitespaceValidator('string with whitespace', array('messages' => array('whitespace' => 'This is another error message.')));

    foreach (range('a', 'b') as $validator) {
      $this->assertFalse(${$validator}->isValid(), "Value contains whitespace.");
      $this->assertEquals(NoWhitespaceValidator::NO_WHITESPACE, ${$validator}->getErrors()[0], 'Error message is missing.');
    }
  }

}
