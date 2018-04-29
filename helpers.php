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

function binary_search($a, $k) {

  //find the middle
  $middle = round(count($a) / 2, 0) - 1;

  //if the middle is the key we search...
  if ($k == $a[$middle]) {
    echo $a[$middle] . " found";
    return true;
  }
  //if the array lasts just one key while the middle isn't the key we search
  elseif (count($a) == 1) {
    echo $k . " not found";
    return false;
  }
  //if the key we search is lower than the middle
  elseif ($k < $a[$middle]) {
    //make an array of the left half and search in this array
    return binary_search(array_slice($a, 0, $middle), $k);
  }
  //if the key we search is higher than the middle
  elseif ($k > $a[$middle - 1]) {
    //make an array of the right half and search in this array
    return binary_search(array_slice($a, $middle + 1), $k);
  }
}

function validateSlidingKey($k) {
  return (int) $k > 0 ? $k : false;
}

function showGit() {
  $commitHash = trim(exec('git log --pretty="%h" -n1 HEAD'));

  $commitDate = new \DateTime(trim(exec('git log -n1 --pretty=%ci HEAD')));
  $commitDate->setTimezone(new \DateTimeZone('UTC'));

  return sprintf('v%s.%s.%s-dev.%s (%s)', 0, 0, 1, $commitHash, $commitDate->format('Y-m-d H:m:s'));
}

function connectionDb() {
  $servername = "jobkred.c22jbs7ehg2m.us-east-1.rds.amazonaws.com";
  $username = "root";
  $password = "JobKred02018!o";
  $dbname = "jobkred";

// Create connection
  $conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
  if ($conn->connect_error) {
    return false;
  }
  return $conn;
}
