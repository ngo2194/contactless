<!DOCTYPE html>
<html lang="en">
<head>
  <title>MEMORYBOX QR Generator</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="MemoryBox - Photo Booth QR Code Generator">
  <meta name="author" content="Sean Ngo">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
  <div class="container">

<?php
// read POST parameters
$email = $_POST["email"];
$cc = $_POST["cc"];
$session = $_POST["session"];
$guestname = $_POST["guestname"]; // Added to get guest name
$script = $_SERVER["SCRIPT_NAME"];

if (strlen($email) > 3 && strlen($guestname) > 0) {
  // display QR code
  $info = 'Email address: ' . $email;
  $email = '&autoemail=' . urlencode($email);
  $info = 'Guest Name: ' . $guestname . '<br>';  
  $guestname = '&guestname=' . urlencode($guestname);
$info .= '<br>Session type: ' . $session;
  if ($session == "photo") {
    $cmd = 'c1=' . urlencode('Select photobooth+start') . '&c2=' . urlencode('switchToStillsAndStart');
  } else {
    $cmd = 'c1=' . urlencode('Select video booth+start') . '&c2=' .urlencode('switchToGifAndStart');
  }
  $url = urlencode("https://contactlessbooth.com$script?$cmd$email$guestname");


  echo <<<QR
<div>
  <img class="img-responsive" src="https://chart.googleapis.com/chart?chs=350x350&cht=qr&chl=$url&choe=UTF-8" title="Photo Booth QR Code">
</div>
<p>$info</p>
<div>
  <a href="$script" class="btn btn-info" role="button">Enter new email address</a>
</div>
QR;
} else {
  // display form asking for email address and session type
  echo <<<FORM
<h3>Photo Booth QR Code Generator</h3>
<form action="$script" method="post">
 <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" placeholder="Enter email" id="email" name="email" required pattern="^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$">
  </div> 
 <div class="form-group">
    <label for="guestname">Guest name:</label>
    <input type="text" class="form-control" placeholder="Enter guest name" id="guestname" name="guestname">
  </div>
 
  <div class="form-check">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" name="session" value="photo" checked>Photos
    </label>
  </div>
  <div class="form-check">
    <label class="form-check-label">
      <input type="radio" class="form-check-input" name="session" value="gif">Boomerang GIF
    </label>
  </div>
  <button type="submit" class="btn btn-primary">Generate QR code</button>
</form>
FORM;
}
?>
  <hr class="featurette-divider">
  <footer>
    <p>&copy; 2023 MemoryBox</p>
  </footer>
  </div>
</body>
</html>