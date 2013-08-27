<?php
require 'vendor/autoload.php';
error_reporting(E_ALL);

class Sale {
  private $display;
  private $pricesByBarcode;

  public function __construct($display) {
    $this->display = $display;
    $this->pricesByBarcode = array("12345" => "EUR 7.95", "23456" => "EUR 10.00");
  }

  public function onBarcode($barcode) {
    if ($barcode == "") {
      $this->display->setText("Scanning error: empty barcode");
      return;
    }

    if (array_key_exists($barcode, $this->pricesByBarcode)) {
      $this->display->setText($this->pricesByBarcode[$barcode]);
    }
    else {
      $this->display->setText(sprintf("Product not found: %s", $barcode));
    }
  }
}

class Display {
  private $text;

  public function getText() { return $this->text; }
  public function setText($text) { $this->text = $text; }
}

class SellOneItemTest extends PHPUnit_Framework_TestCase {
  public function testProductFound() {
    $display = new Display();
    $sale = new Sale($display);

    $sale->onBarcode("12345");

    $this->assertEquals("EUR 7.95", $display->getText());
  }

  public function testAnotherProductFound() {
    $display = new Display();
    $sale = new Sale($display);

    $sale->onBarcode("23456");

    $this->assertEquals("EUR 10.00", $display->getText());
  }

  public function testProductNotFound() {
    $display = new Display();
    $sale = new Sale($display);

    $sale->onBarcode("99999");

    $this->assertEquals("Product not found: 99999", $display->getText());
  }

  public function testEmptyBarcode() {
    $display = new Display();
    $sale = new Sale($display);

    $sale->onBarcode("");

    $this->assertEquals("Scanning error: empty barcode", $display->getText());
  }
}
?>
