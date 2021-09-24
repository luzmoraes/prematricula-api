<?php
use Carbon\Carbon;

if (!function_exists('enrollmentsYear')) {
  function enrollmentsYear()
  {
    $year = Carbon::now()->addYears(1);
    return $year->year;
  }
}