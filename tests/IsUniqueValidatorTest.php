<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\IsUniqueValidator;

class IsUniqueValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new IsUniqueValidator('some string', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  /**
   * @expectedException WireException
   */
  public function testFieldToMatchException() {
    try {
      new IsUniqueValidator('string');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: No field to match was transferred.');
  }

  public function testIsUnique() {
    $a = new IsUniqueValidator('unique@email.com', array('ident' => 'email', 'sanitize' => 'email'));
    $b = new IsUniqueValidator('uniqueusername', array('ident' => 'name', 'sanitize' => 'username'));
    $c = new IsUniqueValidator('uniquestring', array('ident' => 'name', 'sanitize' => 'text'));
    $d = new IsUniqueValidator('uniquestring', array('ident' => 'name'));

    $this->assertTrue($a->isValid(), 'This email should be unique.');
    $this->assertTrue($b->isValid(), 'This username should be unique.');
    $this->assertTrue($c->isValid(), 'This string should be unique.');
    $this->assertTrue($d->isValid(), 'This string should be unique.');
  }

  public function testIsNotUnique() {
    $user = wire('users')->get('template=user');

    $a = new IsUniqueValidator($user->email, array('ident' => 'email', 'sanitize' => 'email'));
    $b = new IsUniqueValidator($user->name, array('ident' => 'name', 'sanitize' => 'username'));
    $c = new IsUniqueValidator($user->name, array('ident' => 'name', 'sanitize' => 'text'));
    $d = new IsUniqueValidator($user->name, array('ident' => 'name', 'sanitize' => 'text', 'messages' => array('text' => 'This is another error message.')));
    $e = new IsUniqueValidator($user->name, array('ident' => 'name', 'sanitize' => 'text', 'messages' => array('notexisting' => 'This is another error message.')));

    $this->assertFalse($a->isValid(), 'This email ' . $user->email . ' should not be unique.');
    $this->assertFalse($b->isValid(), 'This username should not be unique.');
    $this->assertFalse($c->isValid(), 'This string should not be unique.');
    $this->assertFalse($d->isValid(), 'This string should not be unique.');
    $this->assertFalse($e->isValid(), 'This string should not be unique.');

    $errs = array();
    foreach (range('a', 'e') as $letter) {
      $err = ${$letter}->getErrors();
      $errs[$letter] = $err[0];
    }

    $this->assertEquals(IsUniqueValidator::IS_NOT_UNIQUE_EMAIL, $errs['a'], 'Error message is missing.');
    $this->assertEquals(IsUniqueValidator::IS_NOT_UNIQUE_USERNAME, $errs['b'], 'Error message is missing.');
    $this->assertEquals(IsUniqueValidator::IS_NOT_UNIQUE_TEXT, $errs['c'], 'Error message is missing.');
    $this->assertEquals(IsUniqueValidator::IS_NOT_UNIQUE_TEXT, $errs['d'], 'Error message is missing.');
    $this->assertEquals(IsUniqueValidator::IS_NOT_UNIQUE_TEXT, $errs['e'], 'Error message is missing.');
  }

}
