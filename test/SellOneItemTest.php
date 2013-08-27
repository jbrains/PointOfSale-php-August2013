<?php
require 'vendor/autoload.php';

class Sale {
  public function onBarcode($barcode) {}
}

class Display {
  public function getText() { return "EUR 7.95"; }
}

class SellOneItemTest extends PHPUnit_Framework_TestCase {
  public function testProductFound() {
    $sale = new Sale();
    $display = new Display();

    $sale->onBarcode("12345");

    $this->assertEquals("EUR 7.95", $display->getText());
  }
}
?>
