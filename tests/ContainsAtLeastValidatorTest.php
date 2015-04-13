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

    $this->assertFalse($a->isValid());
    $this->assertFalse($b->isValid());
    $this->assertFalse($c->isValid());
    $this->assertFalse($d->isValid());

    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_DIGIT, $a->getErrors()[0]);
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_LETTER, $b->getErrors()[0]);
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_SPECIALSIGN, $c->getErrors()[0]);
    $this->assertEquals(ContainsAtLeastValidator::MUST_CONTAIN_UPPERCASE, $d->getErrors()[0]);
  }

}
