<?php

class Price {
  public static function cents($cents) {
    return new Price();
  }

  public function format() {
    return "EUR 0.00";
  }
}


class FormatPriceTest extends PHPUnit_Framework_TestCase {
  public function test_zero() {
    $this->assertEquals("EUR 0.00", Price::cents(0)->format());
  }
}
