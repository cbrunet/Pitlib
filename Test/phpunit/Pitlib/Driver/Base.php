<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

require_once dirname(__FILE__).'/../Base.php';

define ('RESULT_DIR', dirname(__FILE__).'/../../results/');

abstract class Test_Pitlib_Driver_Base extends Test_Pitlib_Base {

    function setUp () {
        error_reporting (E_ALL | E_STRICT);
        Pitlib::$TEMPDIR = TMP;
    }

    function testConvert () {
        $this->emptyTmpDir ();
        $sources = Pitlib::get_supported_types (Pitlib::SUPPORT_READ);
        $targets = Pitlib::get_supported_types (Pitlib::SUPPORT_WRITE);

        foreach ($sources as $s) {
            $in = SOURCE . Pitlib_Type::get_extension ($s);
            foreach ($targets as $t) {
                $out = TARGET . Pitlib_Type::get_extension ($t);
                $this->doConvertTest ($in, $out);
                $this->doConvertTest ($in, TMP.'foobar', $t);
            }
        }
    }

    function testResize () {
        $this->emptyTmpDir ();
        $this->doResizeTest (50, 75, Pitlib::RESIZE_STRETCH, 50, 75);
        $this->doResizeTest (75, 50, Pitlib::RESIZE_STRETCH, 75, 50);
        $this->doResizeTest (150, 200, Pitlib::RESIZE_STRETCH, 150, 200);
        $this->doResizeTest (200, 150, Pitlib::RESIZE_STRETCH, 200, 150);
        $this->doResizeTest (50, 75, Pitlib::RESIZE_PROPORTIONAL, 50, 50);
        $this->doResizeTest (75, 50, Pitlib::RESIZE_PROPORTIONAL, 50, 50);
        $this->doResizeTest (150, 200, Pitlib::RESIZE_PROPORTIONAL, 150, 150);
        $this->doResizeTest (200, 150, Pitlib::RESIZE_PROPORTIONAL, 150, 150);
        $this->doResizeTest (50, 75, Pitlib::RESIZE_FIT, 50, 50);
        $this->doResizeTest (75, 50, Pitlib::RESIZE_FIT, 50, 50);
        $this->doResizeTest (150, 200, Pitlib::RESIZE_FIT, 100, 100);
        $this->doResizeTest (200, 150, Pitlib::RESIZE_FIT, 100, 100);
    }

    function testFrame () {
        
        $this->emptyTmpDir ();
        $color = Pitlib::color (110, 120, 130);

        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->frame (120, 120, $color)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.frame.png');

        $this->assertImageSize (TARGET.'png', 120, 120);
        $this->assertPngImageColor (TARGET.'png', 0, 0, 110, 120, 130);
        $this->assertPngImageColor (TARGET.'png', 110, 110, 110, 120, 130);
        $this->assertPngImageColor (TARGET.'png', 25, 25, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 75, 75, 255, 255, 255);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testWatermark () {
        error_reporting (E_ALL | E_STRICT);
        Pitlib::$TEMPDIR = TMP;
        $this->emptyTmpDir ();

        // Default BOTTOM_RIGHT AT 0.25
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->watermark (SOURCE.'png')
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.watermark1.png');
        $this->assertPngImageColor (TARGET.'png', 55, 55, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 76, 76, 0, 0, 0);
        unlink (TARGET.'png');

        // BOTTOM_RIGHT NO SCALE
        $image = Pitlib::image (SOURCE.'png', TARGET.'png')
        ->watermark (CIRCLE, Pitlib::WATERMARK_BOTTOM_RIGHT,
            Pitlib::WATERMARK_SCALABLE_DISABLED)
        ->save ();
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.watermark2.png');
        $this->assertPngImageColor (TARGET.'png', 55, 55, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 76, 76, 0, 255, 0);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testGrayscale () {
        $this->emptyTmpDir ();
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->grayscale ()
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.grayscale.png');

        $this->assertPngImageIsGray (TARGET.'png', 25, 75);
        $this->assertPngImageIsGray (TARGET.'png', 75, 25);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testRotate () {
        $this->emptyTmpDir ();

        $color = Pitlib::color (255, 0, 255);
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->rotate (45, $color)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.rotate45.png');

        $this->assertImageSize (TARGET.'png', 141, 141, '', 4);
        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 0, 255, '', 1);
        $this->assertPngImageColor (TARGET.'png', 70, 10, 0, 0, 0, '', 1);

        unlink (TARGET.'png');

        // Test at 30 degrees
        $color = Pitlib::color (255, 0, 255);
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->rotate (30, $color)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.rotate30.png');

        $this->assertImageSize (TARGET.'png', 137, 137, '', 4);
        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 0, 255, '', 1);
        $this->assertPngImageColor (TARGET.'png', 120, 50, 0, 0, 255, '', 1);
        $this->assertPngImageColor (TARGET.'png', 120, 87, 255, 0, 255, '', 1);

        unlink (TARGET.'png');

        $this->assertTmpDirEmpty ();
    }

    function testRotate90 () {
        $this->emptyTmpDir ();

        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->rotate (90)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.rotate90.png');

        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 255, 0, '', 1);
        $this->assertPngImageColor (TARGET.'png', 99, 0, 0, 0, 0, '', 1);
        $this->assertPngImageColor (TARGET.'png', 0, 99, 255, 255, 255, '', 1);
        $this->assertPngImageColor (TARGET.'png', 99, 99, 0, 0, 255, '', 1);
        unlink (TARGET.'png');

        Pitlib::image (SOURCE.'png', TARGET.'png')
        ->rotate (-90)
        ->save ();
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.rotate-90.png');

        $this->assertPngImageColor (TARGET.'png', 0, 0, 0, 0, 255);
        $this->assertPngImageColor (TARGET.'png', 99, 0, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 0, 99, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 99, 99, 255, 255, 0);
        unlink (TARGET.'png');

        Pitlib::image (SOURCE.'png', TARGET.'png')
        ->rotate (180)
        ->save ();
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.rotate180.png');
        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 99, 0, 255, 255, 0);
        $this->assertPngImageColor (TARGET.'png', 0, 99, 0, 0, 255);
        $this->assertPngImageColor (TARGET.'png', 99, 99, 0, 0, 0);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testCopy () {
        $this->emptyTmpDir ();

        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->copy (CIRCLE, 25, 25)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.copy.png');

        $this->assertPngImageColor (TARGET.'png', 26, 26, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 50, 50, 0, 255, 0);
        $this->assertPngImageColor (TARGET.'png', 74, 74, 255, 255, 255);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testCrop () {
        $this->emptyTmpDir ();
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->crop (0, 0, 50, 50)
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.crop1.png');

        $this->assertImageSize (TARGET.'png', 50, 50);
        $this->assertPngImageColor (TARGET.'png', 0, 0, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 49, 49, 0, 0, 0);

        unlink (TARGET.'png');
        
        Pitlib::image (SOURCE.'png', TARGET.'png')
        ->crop (50, 50, 50, 50)
        ->save ();
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.crop2.png');

        $this->assertImageSize (TARGET.'png', 50, 50);
        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 49, 49, 255, 255, 255);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    function testFlipFlop () {
        $this->emptyTmpDir ();
        
        try {
            Pitlib::image (SOURCE.'png', TARGET.'png')
            ->flip ()
            ->save ();
        }
        catch (Pitlib_Exception_OperationNotSupported $e) {
            $this->markTestSkipped ();
            return;
        }
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.flip.png');

        $this->assertPngImageColor (TARGET.'png', 0, 0, 255, 255, 0);
        $this->assertPngImageColor (TARGET.'png', 99, 0, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 0, 99, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 99, 99, 0, 0, 255);

        unlink (TARGET.'png');

        Pitlib::image (SOURCE.'png', TARGET.'png')
        ->flop ()
        ->save ();
        copy (TARGET.'png', RESULT_DIR. Pitlib::driver ()->name ().'.flop.png');

        $this->assertPngImageColor (TARGET.'png', 0, 0, 0, 0, 255);
        $this->assertPngImageColor (TARGET.'png', 99, 0, 0, 0, 0);
        $this->assertPngImageColor (TARGET.'png', 0, 99, 255, 255, 255);
        $this->assertPngImageColor (TARGET.'png', 99, 99, 255, 255, 0);

        unlink (TARGET.'png');
        $this->assertTmpDirEmpty ();
    }

    //--------------------------------------------------------------------------

    function doConvertTest ($src, $dst, $type=null) {
        
        $image = Pitlib::image ($src, $dst);
        
        if ($type) {
            $image->convert ($type);
        }

        $image->save ();

        // $dst file exists
        $this->assertFileExists ($dst);

        // $dst file is an image
        //if (!$type) {
        //    $type = Pitlib_Type::from_filename ($dst);
        //}
        //if ($type != Pitlib_Type::WBMP) {
        //    $this->assertEquals ($type, Pitlib_Type::from_file ($dst));
        //}

        // cleanup!
        unlink ($dst);
        
        $this->assertTmpDirEmpty ();
    }

    function doResizeTest ($w, $h, $t, $ew, $eh) {
        Pitlib::image (SOURCE.'png', TARGET.'png')
        ->resize ($w, $h, $t)
        ->save ();
        
        $this->assertImageSize (TARGET.'png', $ew, $eh);

        unlink (TARGET.'png');

        $this->assertTmpDirEmpty ();
    }

    //--------------------------------------------------------------------------

    function assertImageSize ($filename, $w, $h, $message='', $delta=0) {
        $size = getimagesize ($filename);
        $this->assertEquals ($w, $size[0], $message, $delta);
        $this->assertEquals ($h, $size[1], $message, $delta);
    }

    function assertPngImageColor ($filename, $x, $y, $r, $g, $b, $message='',
        $delta = 0) {
        
        $res = imagecreatefrompng ($filename);
        $col = imagecolorat ($res, $x, $y);
        $colors = imagecolorsforindex ($res, $col);

        $this->assertEquals ($r, $colors['red'], $message, $delta);
        $this->assertEquals ($g, $colors['green'], $message, $delta);
        $this->assertEquals ($b, $colors['blue'], $message, $delta);

        imagedestroy ($res);
    }

    function assertPngImageIsGray ($filename, $x, $y, $message='') {
        $res = imagecreatefrompng ($filename);
        $col = imagecolorat ($res, $x, $y);
        $colors = imagecolorsforindex ($res, $col);
        
        $this->assertEquals ($colors['red'], $colors['green'], $message);
        $this->assertEquals ($colors['red'], $colors['blue'], $message);
        $this->assertEquals ($colors['green'], $colors['blue'], $message);
        
        imagedestroy ($res);
    }

    function assertJpgImageIsGray ($filename, $x, $y, $message='') {
        $res = imagecreatefromjpeg ($filename);
        $col = imagecolorat ($res, $x, $y);
        $colors = imagecolorsforindex ($res, $col);
        
        $this->assertEquals ($colors['red'], $colors['green'], $message);
        $this->assertEquals ($colors['red'], $colors['blue'], $message);
        $this->assertEquals ($colors['green'], $colors['blue'], $message);
        
        imagedestroy ($res);
    }

    function assertTmpDirEmpty () {
        $d = dir (TMP);
        while (false !== $f = $d->read ()) {
            if ($f != '.' && $f != '..') {
                unlink (TMP.$f);
                $this->fail ('Tmp dir not empty: '.$f);
            }
        }
    }
}

?>
