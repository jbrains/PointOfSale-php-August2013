<?php

class Price {
  private $cents;

  private function __constructor($cents) {
    $this->cents = cents;
  }

  public static function cents($cents) {
    return new Price($cents);
  }

  public function format() {
    return sprintf("EUR %.2f", ($this->cents / 100.0));
  }
}


class FormatPriceTest extends PHPUnit_Framework_TestCase {
  public function test_zero() {
    $this->assertEquals("EUR 0.00", Price::cents(0)->format());
  }

  public function xtest_no_trailing_zeroes() {
    $this->assertEquals("EUR 7.81", Price::cents(781)->format());
  }
}
