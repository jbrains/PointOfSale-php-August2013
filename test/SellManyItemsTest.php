<?php
error_reporting(E_ALL);
include_once 'ProductionCodeJunkDrawer.php';

class SellManyItemsTest extends PHPUnit_Framework_TestCase {
  public function testZeroItems() {
    $display = new Display();
    $sale = new Sale($display, null, null);

    $sale->onTotal();

    $this->assertEquals("No sale in progress. Scan a product to start.", $display->getText());
  }

  public function testOneItem() {
    $display = new Display();
    $sale = new Sale($display, new Catalog(
      array("12345" => "EUR 7.95"),
      array("12345" => Price::cents(795))
    ));

    $sale->onBarcode("12345");
    $sale->onTotal();

    $this->assertEquals("Total: EUR 7.95", $display->getText());
  }
}

?>
