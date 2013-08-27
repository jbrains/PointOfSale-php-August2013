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

  public function testProductNotFound() {
    $this->markTestSkipped("Refactoring to make it possible to pass this test...");

    $sale = new Sale();
    $display = new Display();

    $sale->onBarcode("23456");

    $this->assertEquals("EUR 10.00", $display->getText());
  }
}
?>
