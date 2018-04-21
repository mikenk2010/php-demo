<?php
/**
 * Created by baonguyen
 */

/**
 * @param $digits string
 * @return string
 */
function permutation($digits) {
  $start = recordStart();

  $keypads = [
    "0",
    "1",
    "abc",
    "def",
    "ghi",
    "jkl",
    "mno",
    "pqrs",
    "tuv",
    "wxyz"
  ];
  if (empty($digits)) {
    return "Errrrr empty ^^!";
  }

  // Avoid Blackberry phone ^^!, remove all char, keep number only
  $digits = preg_replace("/[^0-9]/", "", $digits);
  if (empty($digits)) {
    return "Incorrect digit";
  }

  // Init to pass while loop
  $result = [""];
  foreach (str_split($digits) as $index => $x) {
    while (strlen($result[0]) == $index) {
      // Extract first string
      $first_string = $result[0];

      // Remove after extract
      unset($result[0]);

      // Reindex String
      $result = array_values($result);

      // Concat string
      foreach (str_split($keypads[$x]) as $split_string) {
        $result[] = $first_string . $split_string;
      }

    }
  }

  $end = recordEnd($start);

  return ['result' => $result, 'total match' => count($result), 'input' => $digits, 'total exe time (microsecond)' => $end];
}
