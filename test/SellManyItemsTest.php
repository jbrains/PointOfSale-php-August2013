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
}

?>
