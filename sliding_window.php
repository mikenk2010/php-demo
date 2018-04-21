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

function raw_method($num, $k) {
  $nums = formatData($num);

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

function build_in_method($num, $k) {
  $nums = formatData($num);

  $start = recordStart();

  $result = [];
  for ($i = 0; $i <= count($nums) - $k; $i++) {
    $result[] = max(array_slice($nums, $i, $k));

  }

  $end = recordEnd($start);

  return ['result build_in_method' => $result, 'input' => $nums, 'slide' => $k, 'total exe time (microsecond)' => $end];
}

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
