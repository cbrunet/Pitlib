<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/Base.php';

class Type_Test extends Test_Pitlib_Base {

    function testFromMime () {

        $r1 = Pitlib_Type::from_mime ('image/jpeg');
        $r2 = Pitlib_Type::from_mime ('');

        $this->assertEquals ($r1, Pitlib_Type::JPEG);
        $this->assertFalse  ($r2);

    }

    function testToMime () {
        $r1 = Pitlib_Type::to_mime ( Pitlib_Type::JPEG );

        $this->assertEquals ($r1, 'image/jpeg');
    }

    function testFromFilename () {
        
        $r1 = Pitlib_Type::from_filename ('example.jpg');
        $r2 = Pitlib_Type::from_filename ('example.jpeg');
        $r3 = Pitlib_Type::from_filename ('Example.Jpg');
        $r4 = Pitlib_Type::from_filename ('Example.JPEG');
        $r5 = Pitlib_Type::from_filename ('Example.J');
        $r6 = Pitlib_Type::from_filename ('Example.');
        $r7 = Pitlib_Type::from_filename ('Example');
        $r8 = Pitlib_Type::from_filename ('');

        $this->assertEquals ($r1, Pitlib_Type::JPEG);
        $this->assertEquals ($r2, Pitlib_Type::JPEG);
        $this->assertEquals ($r3, Pitlib_Type::JPEG);
        $this->assertEquals ($r4, Pitlib_Type::JPEG);
        $this->assertFalse  ($r5);
        $this->assertFalse  ($r6);
        $this->assertFalse  ($r7);
        $this->assertFalse  ($r8);

    }

    function testToExtension () {
    
        $r1 = Pitlib_Type::get_extension (Pitlib_Type::JPEG);

        $this->assertEquals ($r1, 'jpg');

    }

    function testFromFile () {

        $r1 = Pitlib_Type::from_file ( SOURCE.'png' );
        $r2 = Pitlib_Type::from_file ( SOURCE.'jpg' );

        $this->assertEquals ($r1, Pitlib_Type::PNG );
        $this->assertEquals ($r2, Pitlib_Type::JPEG );
    }

}

?>
