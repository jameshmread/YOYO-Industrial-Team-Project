<?php

namespace App\Types;

class Date
{
    private $day;
    private $month;
    private $year;
    private $hour;
    private $minute;
    private $second;

    /**
     * @todo move logic into a new class (DateBuilder)
     * @todo check parameters
     */
    public function __construct(string $csvLine) {
        $dateAndTime = explode(' ', $csvLine);
        $date = $dateAndTime[0];
        $dayMonthYear = explode('/', $date);
        $time = $dateAndTime[1];
        $hourMinuteSecond = explode(':', $time);
        $this->day = $dayMonthYear[0];
        $this->month = $dayMonthYear[1];
        $this->year = $dayMonthYear[2];
        $this->hour = $hourMinuteSecond[0];
        $this->minute = $hourMinuteSecond[1];
        $this->second = $hourMinuteSecond[2];
    }
}