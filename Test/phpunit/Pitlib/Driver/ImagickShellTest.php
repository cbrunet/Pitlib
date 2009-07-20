<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/Base.php';

class Pitlib_Driver_Imagick_Shell_Test extends Test_Pitlib_Driver_Base {

    function setUp () {
        Pitlib::driver ('imagick_shell');
    }	

    function testRotate () {
        try {
            parent::testRotate ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
        }
    }
}

?>
