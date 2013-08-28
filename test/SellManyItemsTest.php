<?php
error_reporting(E_ALL);
include_once 'ProductionCodeJunkDrawer.php';

class SellManyItemsTest extends PHPUnit_Framework_TestCase {
  public function testZeroItems() {
    $display = new Display();
    $sale = new Sale($display, null);

    $sale->onTotal();

    $this->assertEquals("No sale in progress. Scan a product to start.", $display->getText());
  }

  public function testOneItem() {
    $display = new Display();
    $sale = new Sale($display, new Catalog(array("12345" => "EUR 7.95")));

    $sale->onBarcode("12345");
    $sale->onTotal();

    $this->assertEquals("Total: EUR 7.95", $display->getText());
  }

  public function testManyItems() {
    $this->markTestSkipped("When I know that I can compute the total of items in the shopping cart, then I can make this test pass.");

    $display = new Display();
    $sale = new Sale($display, new Catalog(array(
      "12345" => "EUR 7.00",
      "23456" => "EUR 8.00",
      "34567" => "EUR 9.00",
    )));

    $sale->onBarcode("12345");
    $sale->onBarcode("23456");
    $sale->onBarcode("34567");
    $sale->onTotal();

    $this->assertEquals("Total: EUR 24.00", $display->getText());
  }
}

?>
