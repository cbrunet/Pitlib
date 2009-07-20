<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/PitlibTest.php';
require_once dirname(__FILE__).'/TypeTest.php';
require_once dirname(__FILE__).'/Driver/AllTests.php';

class Pitlib_AllTests
{
    public static function setUp () {
        exec ('rm '.dirname(__FILE__).'/../results/*');
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('PitlibTest');
        $suite->addTestSuite('Pitlib_Test');
        $suite->addTestSuite('Type_Test');
        $suite->addTest(Pitlib_Driver_AllTests::suite());

        return $suite;
    }
}
?>

