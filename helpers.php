<?php
/**
 * Created by baonguyen
 */

function recordStart() {
  $time_start = microtime(true);
  return $time_start;
}

function recordEnd($start) {
  return microtime(true) - $start;
}

/*
 * Convert string to arr
 */
function formatData($num) {
  $num = explode(",", str_replace(" ", "", trim($num)));
  $nums = [];
  foreach ($num as $n) {
    if (is_numeric($n)) {
      $nums[] = (int) $n;
    }
  }
  return $nums;
}

function binary_search(array $a, $first, $last, $target) {
  $last = $last - 1;

  while ($first <= $last) {
    $mid = (int) (($last - $first) / 2) + $first;
    $compare = ($a[$mid] < $target) ? -1 : (($a[$mid] > $target) ? 1 : 0);

    if ($compare < 0) {
      $first = $mid + 1;
    }
    elseif ($compare > 0) {
      $last = $mid - 1;
    }
    else {
      return $mid; // position ==> found
    }
  }
  return false;
}

function validateSlidingKey($k) {
  return (int) $k > 0 ? $k : false;
}