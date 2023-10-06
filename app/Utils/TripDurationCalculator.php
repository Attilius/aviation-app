<?php

namespace App\Utils;

class TripDurationCalculator
{
    private Int $travelSpeed;
    private Int $distance;

    public function __construct(Int $travelSpeed, Int $distance)
    {
        $this->travelSpeed = $travelSpeed;
        $this->distance = $distance;
    }

    /**
     * @return String
     */
    public function calculate(): String
    {
        $hours = 0;
        $minutes = 0;
        $seconds = 0;

        // Set hours
        $houreVolume = $this->distance / $this->travelSpeed;
        $hourParts = explode('.', (string)$houreVolume);
        $hours += intval($hourParts[0]);

        // Set minutes
        $minutesVolume = floatval(0 . '.' . $hourParts[1]) * 60;
        $minutesParts = explode('.', (string)$minutesVolume);
        $minutes += intval($minutesParts[0]);

        // Set seconds
        $secondsVolume = floatval(0 . '.' . $minutesParts[1]) * 60;
        $secondsParts = explode('.', (string)$secondsVolume);
        $seconds += intval($secondsParts[0]);

        $minutes == 60 ? $hours += 1 : $hours += 0;
        $seconds > 0 ? $minutes += 1 : $minutes += 0;

        if($minutes < 10) {
            return $hours . 'h' . '0' . $minutes;
        } else if($minutes > 59){
            $hours += 1;
            return $hours . 'h' . '00';
        } else {
            return $hours . 'h' . $minutes;
        }
    }
}
