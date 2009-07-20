<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/../../../lib/Pitlib.php';

define ('SOURCE', dirname(__FILE__).'/../img/example.');
define ('CIRCLE', dirname(__FILE__).'/../img/circle.png');
define ('TMP', dirname(__FILE__).'/../tmp/');
define ('TARGET', TMP.'example.');

abstract class Test_Pitlib_Base extends PHPUnit_Framework_TestCase {

    function setUp () {
        error_reporting (E_ALL | E_STRICT);
        Pitlib::$TEMPDIR = TMP;
    }
    
    function emptyTmpDir () {
        @exec ('rm -f '.TMP.'*');
    }

    function tearDown () {
        $this->emptyTmpDir ();
    }

}

?>
