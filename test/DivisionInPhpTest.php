<?php
class DivisionInPhpTest extends PHPUnit_Framework_TestCase {
  public function testUnexpectedBehavior() {
    $this->assertEquals(7.81, 781 / 100.0);
  }
}

