<?php

namespace App\Common;

use DateTime;
use DateTimeZone;

class Helpers
{
  public static function getMonthInUnixSeconds(string $slotSeconds)
  {
    $date = new DateTime(strtotime($slotSeconds), new DateTimeZone('Asia/Manila'));
    $year = $date->format("Y");
    $month = $date->format("m");

    // TODO: Validate if year and month is numeric.
    $monthInUnixSeconds = DateTime::createFromFormat(
      "Y-m-d h:i",
      "{$year}-{$month}-1 00:00",
      new DateTimeZone('Asia/Manila')
    )->getTimestamp();

    return $monthInUnixSeconds;
  }
}
