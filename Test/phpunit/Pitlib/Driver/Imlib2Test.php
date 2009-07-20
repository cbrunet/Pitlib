<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/Base.php';

class Pitlib_Driver_Imlib2_Test extends Test_Pitlib_Driver_Base {

    function setUp () {
        Pitlib::driver ('imlib2');
    }	

    function testRotate () {
        try {
            parent::testRotate ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
        }
    }

    function testRotate90 () {
        try {
            parent::testRotate90 ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
        }
    }

    function testFlipFlop () {
        try {
            parent::testFlipFlop ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
        }
    }

}

?>
