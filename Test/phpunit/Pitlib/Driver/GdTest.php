<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/Base.php';

class Pitlib_Driver_Gd_Test extends Test_Pitlib_Driver_Base {

    function setUp () {
        Pitlib::driver ('gd');
    }	

}

?>
