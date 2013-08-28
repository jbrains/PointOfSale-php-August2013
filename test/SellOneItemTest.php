<?php
error_reporting(E_ALL);
include_once 'ProductionCodeJunkDrawer.php';

class SellOneItemTest extends PHPUnit_Framework_TestCase {
  public function testProductFound() {
    $display = new Display();
    $sale = new Sale($display, new Catalog(array("12345" => "EUR 7.95")));

    $sale->onBarcode("12345");

    $this->assertEquals("EUR 7.95", $display->getText());
  }

  public function testProductFoundAmongMany() {
    $display = new Display();
    $sale = new Sale($display, new Catalog(array("12345" => "EUR 7.95", "23456" => "EUR 10.00", "34567" => "EUR 12.50")));

    $sale->onBarcode("23456");

    $this->assertEquals("EUR 10.00", $display->getText());
  }

  public function testProductNotFound() {
    $display = new Display();
    $sale = new Sale($display, new Catalog(array("anything but 99999", "irrelevant price")));

    $sale->onBarcode("99999");

    $this->assertEquals("Product not found: 99999", $display->getText());
  }

  public function testEmptyBarcode() {
    $display = new Display();
    $sale = new Sale($display, null);

    $sale->onBarcode("");

    $this->assertEquals("Scanning error: empty barcode", $display->getText());
  }
}
?>
