<?php
/**
 * Created by baonguyen
 */

include "permutation.php";
include "sliding_window.php";

// Q1. Sliding Window
// Start count
$start = recordStart();

echo strtoupper("<b>Sliding Window</b><br/>");
$num = [1, 3, -1, -3, 5, 3, 6, 7];
$k = 3;

// Func
slidingWindow($num, $k);

// Cal exe time
recordEnd($start);

// END

echo "<br/>-------<br/>";

// Q2. Permutation
// Start count
$start = recordStart();

echo strtoupper("<b>Permutation</b><br/>");
$digits = "23a";

// Call
permutation($digits);

// Cal exe time
recordEnd($start);


//=========HELPER============//

function recordStart() {
  $time_start = microtime(true);
  echo "Start: {$time_start}<br/>";
  return $time_start;
}

function recordEnd($start) {
  $end = microtime(true) - $start;
  echo "<br/>Total Execution Time: {$end}<br/>";
}
