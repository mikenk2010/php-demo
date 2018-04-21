<?php
/**
 * Created by baonguyen
 */

/**
 * @param $num array
 * @param $k integer
 */
function slidingWindow($num, $k) {
  $start = recordStart();
  $num = explode(",", str_replace(" ", "", trim($num)));
  $nums = [];
  foreach ($num as $n) {
    if (is_numeric($n)) {
      $nums[] = (int) $n;
    }
  }
  
  $result = [];
  for ($i = 0; $i <= count($nums) - $k; $i++) {
    $max = $nums[$i];
    for ($j = 0; $j < $k; $j++) {
      if ($nums[$i + $j] > $max) {
        $max = $nums[$i + $j];
      }
    }
    $result[] = $max;
  }

  $end = recordEnd($start);

  return ['result' => $result, 'input' => $nums, 'slide' => $k, 'total exe time (microsecond)' => $end];
}
