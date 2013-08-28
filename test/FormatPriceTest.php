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
  public function specialCases() {
    return array(
      array("EUR 0.00", 0),
      array("EUR 7.81", 781),
      array("EUR 7.80", 780),
      array("EUR 7.00", 700),
      array("EUR 1237.67", 123767),
    );
  }

  /** @dataProvider specialCases */
  public function testFormatPrice($expectedText, $centsAsInteger) {
    $this->assertEquals($expectedText, Price::cents($centsAsInteger)->format());
  }
}
