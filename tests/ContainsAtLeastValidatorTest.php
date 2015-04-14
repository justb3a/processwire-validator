<?php

namespace Kfi\Validator\Tests;
use Kfi\Validator\ContainsAtLeastValidator;

class ContainsAtLeastValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new ContainsAtLeastValidator('rkjtgidy', 'noarray');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Config must be of type array.');
  }

  /**
   * @expectedException WireException
   */
  public function testWrongParamException() {
    try {
      new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'lowercase'));
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Unknown param.');
  }

  public function testIsValid() {
    $contains = array(
      array('contains' => 'digit, letter, specialsign, uppercase'),
      array('contains' => ''),
      array()
    );

    foreach ($contains as $contain) {
      $validator = new ContainsAtLeastValidator('3k}T3idy', $contain);
      $this->assertTrue($validator->isValid(), 'Value should contain at least one digit, letter, specialsign and uppercase.');
    }
  }

  public function testIsInvalid() {
    $a = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'digit'));
    $b = new ContainsAtLeastValidator('12345678', array('contains' => 'letter'));
    $c = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'specialsign'));
    $d = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'uppercase'));

    $e = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'digit', 'messages' => array('digit' => 'This is another error message.')));
    $f = new ContainsAtLeastValidator('12345678', array('contains' => 'letter', 'messages' => array('letter' => 'This is another error message.')));
    $g = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'specialsign', 'messages' => array('specialsign' => 'This is another error message.')));
    $h = new ContainsAtLeastValidator('rkjtgidy', array('contains' => 'uppercase', 'messages' => array('uppercase' => 'This is another error message.')));

    $i = new ContainsAtLeastValidator(
      'rkjtgidy',
      array(
        'contains' => 'uppercase, digit, specialsign',
        'messages' => array(
          'uppercase' => 'This is another error message.',
          'digit' => 'This is another error message.',
          'specialsign' => 'This is another error message.'
        )
      )
    );

    foreach (range('a', 'i') as $validator) $this->assertFalse(${$validator}->isValid(), 'Value is not allowed to contain any uppercase, digit, letter and specialsign');

    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_DIGIT, $a->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_LETTER, $b->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_SPECIALSIGN, $c->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_UPPERCASE, $d->getErrors()[0], 'Error message is missing.');

    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_DIGIT, $e->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_LETTER, $f->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_SPECIALSIGN, $g->getErrors()[0], 'Error message is missing.');
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_UPPERCASE, $h->getErrors()[0], 'Error message is missing.');

    foreach ($i->getErrors() as $error) {
      switch($error) {
        case 'uppercase':
          $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_UPPERCASE, $i->getErrors()[0], 'Error message is missing.');
          break;
        case 'digit':
          $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_DIGIT, $i->getErrors()[0], 'Error message is missing.');
          break;
        case 'specialsign':
          $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_SPECIALSIGN, $i->getErrors()[0], 'Error message is missing.');
          break;
      }
    }
  }

}
