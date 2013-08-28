<?php
class Sale {
  private $display;
  private $pricesByBarcode;

  public function __construct($display, $pricesByBarcode) {
    $this->display = $display;
    $this->pricesByBarcode = $pricesByBarcode;
    $this->products_scanned = array();
  }

  public function displayProductNotFoundMessage($barcode) {
    $this->display->setText(sprintf("Product not found: %s", $barcode));
  }

  public function findPrice($barcode) {
    return $this->pricesByBarcode[$barcode];
  }

  public function hasBarcode($barcode) {
    return array_key_exists($barcode, $this->pricesByBarcode);
  }

  public function onBarcode($barcode) {
    if ($barcode == "") {
      $this->display->displayEmptyBarcodeMessage();
      return;
    }

    if ($this->hasBarcode($barcode)) {
      $price = $this->findPrice($barcode);
      $this->display->displayPrice($price);
      array_push($this->products_scanned, $price);
    }
    else {
      $this->displayProductNotFoundMessage($barcode);
    }
  }

  public function onTotal() {
    if (count($this->products_scanned) == 0) {
      $this->display->setText("No sale in progress. Scan a product to start.");
    }
    else {
      $this->display->setText(sprintf("Total: %s", $this->products_scanned[0]));
    }
  }
}

class Display {
  private $text;

  public function getText() { return $this->text; }
  public function setText($text) { $this->text = $text; }

  public function displayEmptyBarcodeMessage() {
    $this->setText("Scanning error: empty barcode");
  }

  public function displayPrice($price) {
    $this->setText($price);
  }
}
?>
