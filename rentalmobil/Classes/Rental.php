<?php
include_once 'Car.php';
include_once 'Customer.php';

class Rental {
    public $car;
    public $customer;
    public $days;

    public function __construct($car, $customer, $days) {
        $this->car = $car;
        $this->customer = $customer;
        $this->days = $days;
    }

    public function calculateTotal() {
        return $this->days * $this->car->pricePerDay;
    }
}
?>
