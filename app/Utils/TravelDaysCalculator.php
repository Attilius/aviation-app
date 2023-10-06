<?php

namespace App\Utils;

class TravelDaysCalculator
{
    const SECONDS_AMOUNT_IN_A_DAY = 86400;

    /**
     * Calculating amount travel days.
     *
     * @param string $departure_date
     * @param string $return_date
     * @return int
     */
    public static function calculate(string $departure_date, string $return_date): int
    {
        return (strtotime($return_date) - strtotime($departure_date)) / self::SECONDS_AMOUNT_IN_A_DAY;
    }

}
