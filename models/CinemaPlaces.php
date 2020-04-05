<?php

namespace app\models;

class CinemaPlaces
{
    const PLACE_NOT_SOLD = 0;
    const PLACE_SOLD = 1;
    const COUNT_ROWS = 5;
    const COUNT_PLACES = 10;

    public $places_array = [];

    /**
     * @return array
     */
    public function getPlaces(){

        $count_pl = self::COUNT_ROWS * self::COUNT_PLACES;
        for ($i=0;$i<$count_pl;$i++) {
            array_push($this->places_array,self::PLACE_NOT_SOLD);
        }
        return $this->places_array;
    }
}