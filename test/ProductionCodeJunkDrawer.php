<?php
class Sale {
  private $display;
  private $pricesByBarcode;

  public function __construct($display, $pricesByBarcode) {
    $this->display = $display;
    $this->pricesByBarcode = $pricesByBarcode;
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

  public function onTotal() {
    $this->display->setText("No sale in progress. Scan a product to start.");
  }
}

class Display {
  private $text;

  public function getText() { return $this->text; }
  public function setText($text) { $this->text = $text; }
}
?>
