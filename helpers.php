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
