<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\IsEmailValidator;

class IsEmailValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new IsEmailValidator('test@foo.com', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  public function testIsValid() {
    $validator = new IsEmailValidator('test@foo.com');
    $this->assertTrue($validator->isValid(), 'Email address should be valid.');
  }

  public function testIsInvalid() {
    $validator = new IsEmailValidator('testfoo.com');
    $this->assertFalse($validator->isValid(), 'Email address should be invalid.');

    $a = new IsEmailValidator('');
    $b = new IsEmailValidator('testfoocom');
    $c = new IsEmailValidator('test@foocom');
    $d = new IsEmailValidator('testfoo.com');
    $e = new IsEmailValidator('testfoo.com', array('messages' => array('invalid' => 'This is another error message.')));

    foreach (range('a', 'e') as $validator) $this->assertFalse(${$validator}->isValid(), 'Email address should be invalid.');

    $this->assertNotEmpty($a->getMessages()[0], 'Error message is missing.');

    foreach (array('a', 'e') as $validator) {
      $this->assertEquals(IsEmailValidator::EMAIL_IS_INVALID, ${$validator}->getErrors()[0], 'Error message is missing.');
    }
  }

}
