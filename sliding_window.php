<?php
/**
 * Created by baonguyen
 */

/**
 * @param $num array
 * @param $k integer
 */
function slidingWindow($num, $k) {
  echo "Input: " . json_encode($num) . "<br/>";
  echo "Slide: " . $k . "<br/>";


  $result = [];
  for ($i = 0; $i <= count($num) - $k; $i++) {
    $max = $num[$i];
    for ($j = 0; $j < $k; $j++) {
      if ($num[$i + $j] > $max) {
        $max = $num[$i + $j];
      }
    }
    $result[] = $max;
  }

  return $result;
}
