<?php
class Car {
    public $id;
    public $model;
    public $pricePerDay;
    public $available;
    public $image;

    public function __construct($id, $model, $pricePerDay, $available, $image) {
        $this->id = $id;
        $this->model = $model;
        $this->pricePerDay = $pricePerDay;
        $this->available = $available;
        $this->image = $image;
    }

    public function rent() {
        $this->available = false;
    }

    public function returnCar() {
        $this->available = true;
    }
    // Getter untuk properti $image
    public function getImage(){
        return $this->image;
    }
}
?>
