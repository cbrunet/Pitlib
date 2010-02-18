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
  <title>Pitlib test page</title>
  <meta name="Author" content="Charles Brunet" />
  <meta name="Description" 
    content="Test page for Pitlib" />
</head>

<body>

<h1>Pitlib: PHP Image Transformation Library</h1>

<p>Version: <?php echo Pitlib::version(); ?></p>

<h2>Supported drivers on this system</h2>

<table>
<tr><th>Driver</th><th>Installed?</th><th>Test</th></tr>

<?php

$drivers = array(
	'gd',
	'imagick_ext',
	'magickwand',
	'imlib2',
	'imagick_shell',
	'gmagick_shell',
	'netpbm',
);

foreach ($drivers as $d) {
	echo '<tr><td>' . $d . '</td><td align="center">';

	try {
		Pitlib::driver($d);
		echo '<span style="color: green;">Yes</span></td>';
		echo '<td><a href="roundedCorner.php?driver='.$d.'">Rounded corners</a>';
	}
	catch (Pitlib_Exception $e) {
		echo '<span style="color: red;">No</span><br/>';
		echo $e->getMessage();
		echo '</td><td>';
	}
	echo '</td></tr>';
}

?>
</table>

</body>
</html>