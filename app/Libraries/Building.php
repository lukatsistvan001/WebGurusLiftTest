<?php

namespace App\Libraries;

use App\Libraries\Lift;

class Building
{
    private $liftA;
    private $liftB;

    public function __construct($liftACurrentFloor = 0, $liftBCurrentFloor = 6)
    {
        $this->liftA = new Lift($liftACurrentFloor, "A");
        $this->liftB = new Lift($liftBCurrentFloor, "B");
    }

    public function callNearestLift($floor)
    {
        $distanceA = abs($this->liftA->getCurrentFloor() - $floor);
        $distanceB = abs($this->liftB->getCurrentFloor() - $floor);

        if ($distanceA <= $distanceB) {
            return $this->liftA;
        } else {
            return $this->liftB;
        }
    }
}
