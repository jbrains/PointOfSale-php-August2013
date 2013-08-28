<?php
class Price {
  private $cents;

  public function __construct($cents) {
    $this->cents = $cents;
  }

  public static function cents($cents) {
    return new Price($cents);
  }

  public function format() {
    return sprintf("EUR %.2f", ($this->cents / 100.0));
  }
}

class Sale {
  private $display;
  private $catalog;

  public function __construct($display, $catalog) {
    $this->display = $display;
    $this->products_scanned = array();
    $this->catalog = $catalog;
  }

  public function onBarcode($barcode) {
    if ($barcode == "") {
      $this->display->displayEmptyBarcodeMessage();
      return;
    }

    if ($this->catalog->hasBarcode($barcode)) {
      $price = $this->catalog->findPrice($barcode);
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
  private $formattedPricesByBarcode;
  private $pricesByBarcode;

  public function __construct($formattedPricesByBarcode, $pricesByBarcode) {
    $this->pricesByBarcode = $pricesByBarcode;
    $this->formattedPricesByBarcode = NULL;
  }

  public function findPrice($barcode) {
    if ($this->pricesByBarcode == NULL) {
      return $this->formattedPricesByBarcode[$barcode];
    }
    else {
      return $this->pricesByBarcode[$barcode]->format();
    }
  }

  public function hasBarcode($barcode) {
    if ($this->pricesByBarcode == NULL) {
      return array_key_exists($barcode, $this->formattedPricesByBarcode);
    }
    else {
      return array_key_exists($barcode, $this->pricesByBarcode);
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

  public function displayProductNotFoundMessage($barcode) {
    $this->setText(sprintf("Product not found: %s", $barcode));
  }
}
?>
