<?php
/**
 * Created by baonguyen
 */

/**
 * @param $num array
 * @param $k string
 * @return array
 */
function slidingWindow($num, $k) {
  return [
    "Raw method" => json_encode(raw_method($num, $k)),
    "Raw method2" => json_encode(raw_method2($num, $k)),
    "build-in" => json_encode(build_in_method($num, $k)),
  ];
}

/**
 *
 * @param $nums array
 * @param $k string
 * @return array
 */
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

/**
 * Compare left and right
 * Result: it's slower than compare from left to right, rather than merge left and right then compare
 * @param $nums array
 * @param $k string
 * @return array
 */
function raw_method2($nums, $k) {
  $start = recordStart();
  $result = [];

  $max_left[0] = $nums[0];
  $max_right[count($nums) - 1] = $nums[count($nums) - 1];

  // Separate max start from left and max start from right
  for ($i = 0; $i < count($nums); $i++) {
    $max_left[$i] = ($i % $k == 0) ? $nums[$i] : max($max_left[$i - 1], $nums[$i]);

    $j = count($nums) - $i - 1;
    $max_right[$j] = ($j % $k == 0) ? $nums[$j] : max(isset($max_right[$j + 1]) ? $max_right[$j + 1] : $max_right[$j], $nums[$j]);
  }

  // Merge and compare
  for ($i = 0, $j = 0; $i + $k <= count($nums); $i++) {
    $result[$j++] = max($max_right[$i], $max_left[$i + $k - 1]);
  }


  $end = recordEnd($start);

  return ['result raw_method2' => $result, 'input' => $nums, 'slide' => $k, 'total exe time (microsecond)' => $end];
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
