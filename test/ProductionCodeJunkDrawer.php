<?php
class Sale {
  private $display;
  private $pricesByBarcode;
  private $catalog;

  public function __construct($display, $catalog) {
    $this->display = $display;
    $this->pricesByBarcode = NULL;
    $this->products_scanned = array();
    $this->catalog = $catalog;
  }

  public function findPrice($barcode) {
    if ($this->catalog == NULL) {
      return $this->pricesByBarcode[$barcode];
    }
    else {
      return $this->catalog->findPrice($barcode);
    }
  }

  public function hasBarcode($barcode) {
    if ($this->catalog == NULL) {
      return array_key_exists($barcode, $this->pricesByBarcode);
    }
    else {
      return $this->catalog->hasBarcode($barcode);
    }
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
      $this->display->displayProductNotFoundMessage($barcode);
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

class Catalog {
  private $pricesByBarcode;

  public function __construct($pricesByBarcode) {
    $this->pricesByBarcode = $pricesByBarcode;
  }

  public function findPrice($barcode) {
    return $this->pricesByBarcode[$barcode];
  }

  public function hasBarcode($barcode) {
    return array_key_exists($barcode, $this->pricesByBarcode);
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

  public function displayProductNotFoundMessage($barcode) {
    $this->setText(sprintf("Product not found: %s", $barcode));
  }
}
?>
