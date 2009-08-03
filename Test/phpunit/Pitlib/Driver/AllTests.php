<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/GdTest.php';
require_once dirname(__FILE__).'/ImagickShellTest.php';
require_once dirname(__FILE__).'/GmagickShellTest.php';
require_once dirname(__FILE__).'/ImagickExtTest.php';
require_once dirname(__FILE__).'/Imlib2Test.php';
require_once dirname(__FILE__).'/NetpbmTest.php';
require_once dirname(__FILE__).'/MagickwandTest.php';

class Pitlib_Driver_AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Driver');
        $suite->addTestSuite('Pitlib_Driver_Gd_Test');
        $suite->addTestSuite('Pitlib_Driver_Imagick_Shell_Test');
        $suite->addTestSuite('Pitlib_Driver_Gmagick_Shell_Test');
        $suite->addTestSuite('Pitlib_Driver_Imagick_Ext_Test');
        $suite->addTestSuite('Pitlib_Driver_Imlib2_Test');
        $suite->addTestSuite('Pitlib_Driver_Netpbm_Test');
        $suite->addTestSuite('Pitlib_Driver_Magickwand_Test');

        return $suite;
    }
}
?>

