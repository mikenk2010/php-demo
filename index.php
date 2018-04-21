<?php
/**
 * Created by baonguyen
 */

include "helpers.php";
include "permutation.php";
include "sliding_window.php";

// Sliding window
$result_sliding = '';
if (!empty($_POST['sliding_array']) || !empty($_POST['sliding_key'])) {
  if (!empty($_POST['sliding_array']) && !empty($_POST['sliding_key'])) {
    if ((int) $_POST['sliding_key'] <= 0) {
      $result_sliding = "Value `Slide` must > 1";
    }
    else {
      $result_sliding = json_encode(slidingWindow($_POST['sliding_array'], $_POST['sliding_key']));
    }
  }
  else {
    $result_sliding = "Missing value `Array` or `Slide`";
  }
}

// Permutation
$result_permutation = '';
if (!empty($_POST['permutation'])) {
  $result_permutation = json_encode(permutation($_POST['permutation']));
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>PHP DEMO</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>PHP DEMO</h2>
  <form action="index.php" method="POST">
    <div class="form-group">
      <h3>Sliding Window</h3>
      <label for="">Array</label>
      <input type="text" class="form-control" id="sliding_array" placeholder="Enter Valid PHP Array" name="sliding_array" value="<?php echo isset($_POST['sliding_array']) ? $_POST['sliding_array'] : '' ?>">
      <small id="" class="form-text text-muted">E.g: 1, 3, -1, -3, 5,3, 6, 7</small>
    </div>
    <div class="form-group">
      <label for="">Slide</label>
      <input type="text" class="form-control" id="sliding_key" placeholder="Enter Slide key" name="sliding_key" value="<?php echo isset($_POST['sliding_key']) ? $_POST['sliding_key'] : '' ?>">
      <small id="" class="form-text text-muted">E.g: 3</small>
    </div>
    <?php if (!empty($result_sliding)) { ?>
      <div class="form-group">
        <label for="">Result</label>
      <textarea disabled cols="5" rows="5" class="form-control" id="sliding_result" name="sliding_result"><?php echo nl2br($result_sliding) ?>
      </textarea>
      </div>
    <?php } ?>


    <div class="form-group">
      <h3>Permutation</h3>
      <label for="permutation">Keypad</label>
      <input type="text" class="form-control" id="permutation" placeholder="Enter numpad" name="permutation" value="<?php echo isset($_POST['permutation']) ? $_POST['permutation'] : '' ?>">
      <small id="" class="form-text text-muted">E.g: 23</small>
    </div>
    <?php if (!empty($result_permutation)) { ?>
      <div class="form-group">
        <label for="">Result</label>
      <textarea disabled cols="5" rows="5" class="form-control" id="permutation_result" name="permutation_result"><?php echo nl2br($result_permutation) ?>
      </textarea>
      </div>
    <?php } ?>
    <button type="submit" class="btn btn-default">Submit</button>
  </form>
</div>

</body>
</html>
