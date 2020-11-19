<?php

use CodeIgniter\I18n\Time;

function formatDefaultDateTime($date){

    $time = Time::parse($date);

    return $time->day.'/'.$time->month.'/'.$time->year.' '.$time->hour.':'.$time->minute;

}