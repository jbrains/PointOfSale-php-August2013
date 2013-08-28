<?php

class Price {
  private $cents;

  public function __construct($cents) {
    $this->cents = $cents;
  }

  public static function cents($cents) {
    return new Price($cents);
  }

  public function format() {
    return sprintf("EUR %.2f", ($this->cents / 100.0));
  }
}

class FormatPriceTest extends PHPUnit_Framework_TestCase {
  public function testZero() {
    $this->assertEquals("EUR 0.00", Price::cents(0)->format());
  }

  public function testNoTrailingZeroes() {
    $this->assertEquals("EUR 7.81", Price::cents(781)->format());
  }
}
