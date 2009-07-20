<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/Base.php';

class Pitlib_Test extends Test_Pitlib_Base {

    function testDriver () {

        $d =& Pitlib::Driver ();

        $this->assertType ('Pitlib_Driver', $d);

    }

}
