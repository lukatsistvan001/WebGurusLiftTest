<?php

namespace App\Libraries;

class Lift
{
    private $currentFloor;
    private $name;

    public function __construct($initialFloor, $name)
    {
        $this->currentFloor = $initialFloor;
        $this->name = $name;
    }

    public function getCurrentFloor()
    {
        return $this->currentFloor;
    }

    public function getName()
    {
        return $this->name;
    }

    public function moveToFloor($floor)
    {
        $this->currentFloor = $floor;
    }
}
