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

require dirname(__FILE__).'/../lib/Pitlib.php';


$msg = "\n";
foreach ($drivers as $d) {

	echo str_pad($d, 14) . ': ';

	try {
		Pitlib::driver($d);
		echo "OK";
	}
	catch (Pitlib_Exception $e) {
		echo "\033[31mno\033[37m";
		$msg .= $e->getMessage() . "\n";
	}
	echo "\n";
}

echo $msg;

?>
