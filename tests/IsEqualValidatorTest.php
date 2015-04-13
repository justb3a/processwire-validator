<?php

namespace Kfi\Validator\Tests;

use Kfi\Validator\IsEqualValidator;

class IsEqualValidatorTest extends \PHPUnit_Framework_TestCase {

  /**
   * @expectedException WireException
   */
  public function testConfigIsArrayException() {
    try {
      new IsEqualValidator('some string', 'noarray');
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
      new IsEqualValidator('drowssap');
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: No field to match was transferred.');
  }

  /**
   * @expectedException WireException
   */
  public function testPostFieldException() {
    try {
      $validator = new IsEqualValidator('drowsap', array('equal' => 'string'));
    } catch (WireException $e) {
      $this->assertNotEmpty($e);
    }

    $this->fail('An expected exception has not been raised: Transferred field does not exist in POST request.');
  }

  public function testIsEqual() {
    wire('input')->post->pass_confirm = 'drowssap';
    $validator = new IsEqualValidator('drowssap', array('equal' => 'pass_confirm'));
    $this->assertTrue($validator->isValid(), "Value should be equal to pass_confirm.");
  }

  public function testIsNotEqual() {
    wire('input')->post->pass_confirm = 'drowssap';
    $validator = new IsEqualValidator('drowsap', array('equal' => 'pass_confirm'));
    $this->assertFalse($validator->isValid(), "Value should be equal to pass_confirm.");
    $this->assertNotEmpty($validator->getMessages()[0]);
  }

}
