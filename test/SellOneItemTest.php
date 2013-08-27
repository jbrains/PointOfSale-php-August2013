<?php
require 'vendor/autoload.php';

class Sale {
  private $display;

  public function __construct($display) {
    $this->display = $display;
  }

  public function onBarcode($barcode) {
    if ($barcode == "12345") {
      $this->display->setText("EUR 7.95");
    }
    else {
      $this->display->setText("EUR 10.00");
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
}
?>
