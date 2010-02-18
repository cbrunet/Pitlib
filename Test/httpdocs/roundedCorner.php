<?php

require_once '../../lib/Pitlib.php';

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 

<html xmlns="http://www.w3.org/1999/xhtml" 
  xml:lang="en" lang="en">

<head>
  <title>Pitlib rounded corners test page</title>
  <meta name="Author" content="Charles Brunet" />
  <meta name="Description" 
    content="Test page for Pitlib (rounded corners)" />
</head>

<body bgcolor="#7f7f7f">

<h1>Pitlib: PHP Image Transformation Library</h1>

<p>Version: <?php echo Pitlib::version(); ?></p>

<h2>Rounded corners tests</h2>

<?php

// Setting driver
$driver = null;
if (isset($_GET['driver'])) {
	try {
		Pitlib::driver($_GET['driver']);
		$driver = $_GET['driver'];
	}
	catch (Pitlib_Exception $e) {
		echo '<p>' . $e->getMessage() . '</p>';
	}
}
else {
	$d = Pitlib::driver();
	$driver = $d->name();
}

echo '<p>Driver: ' . $driver . '</p>';

echo '<table>';

$sources = array('pitlib.jpg', 'pitlib.png');
$dests   = array('pitlib.jpg', 'pitlib.png', 'pitlib.gif');



// Calculating and showing results
echo '<tr><th>Dest \ Source</th>';
foreach ($sources as $s) {
	echo '<th>' . $s . '</th>';
}
echo '</tr>';
foreach ($dests as $d) {
	echo '<tr><th>' . $d . '</th>';
	foreach ($sources as $s) {
		echo '<td>';
		try {
			$i = Pitlib::image('images/' . $s);
			$i->roundedCorner(15, Pitlib::color(255, 0, 255, 255));
			$i->save('results/' . $driver . '.' . $s . '.' . $d, Pitlib::OVERWRITE_ENABLED);
			echo '<img src="results/' . $driver . '.' . $s . '.' . $d . '" alt="" />';
		}
		catch (Pitlib_Exception $e) {
			echo $e->getMessage();
		}
		echo '</td>';
	}
	echo '</tr>';
}
echo '</table>';

?>

<p><a href="index.php">&lt; Back to main page</a></p>


</body>
</html>