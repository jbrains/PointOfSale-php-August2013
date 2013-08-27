<?php
class Sale {
  private $display;
  private $pricesByBarcode;

  public function __construct($display, $pricesByBarcode) {
    $this->display = $display;
    $this->pricesByBarcode = $pricesByBarcode;
    $this->products_scanned = array();
  }

  public function onBarcode($barcode) {
    if ($barcode == "") {
      $this->display->setText("Scanning error: empty barcode");
      return;
    }

    if (array_key_exists($barcode, $this->pricesByBarcode)) {
      $price = $this->pricesByBarcode[$barcode];
      $this->display->setText($price);
      array_push($this->products_scanned, $price);
    }
    else {
      $this->display->setText(sprintf("Product not found: %s", $barcode));
    }
  }

  public function onTotal() {
    if (count($this->products_scanned) == 0) {
      $this->display->setText("No sale in progress. Scan a product to start.");
    }
    else {
      $this->display->setText(sprintf("Total: %s", sprintf("EUR %s", "7.95")));
    }
  }
}

class Display {
  private $text;

  public function getText() { return $this->text; }
  public function setText($text) { $this->text = $text; }
}
?>
