<?php
/**
 * Created by baonguyen
 */

/**
 * @param $num array
 * @param $k integer
 */
function slidingWindow($num, $k) {
  return [
    "Raw method" => json_encode(raw_method($num, $k)),
    "build-in" => json_encode(build_in_method($num, $k)),
  ];
}

function raw_method($nums, $k) {
  $start = recordStart();

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

  return ['result raw_method' => $result, 'input' => $nums, 'slide' => $k, 'total exe time (microsecond)' => $end];
}

function build_in_method($nums, $k) {

  $start = recordStart();

  $result = [];
  for ($i = 0; $i <= count($nums) - $k; $i++) {
    $result[] = max(array_slice($nums, $i, $k));

  }

  $end = recordEnd($start);

  return ['result build_in_method' => $result, 'input' => $nums, 'slide' => $k, 'total exe time (microsecond)' => $end];
}
