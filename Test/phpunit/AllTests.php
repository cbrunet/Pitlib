<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/Pitlib/AllTests.php';

class AllTests
{
    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Project');
        $suite->addTest(Pitlib_AllTests::suite());

        return $suite;
    }
}
?>

