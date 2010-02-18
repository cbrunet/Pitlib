<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

/**
 * PHP Image Transformation Library
 *
 * Pitlib is a PHP (PHP5) image processing solution, derived from Asido.
 *
 * @author Charles Brunet <cbrunet@php.net>
 * @author Kaloyan K. Tsvetkov <kaloyan@kaloyan.info>
 * @license http://opensource.org/licenses/lgpl-license.php
 *     GNU Lesser General public License Version 2.1
 *
 * @package Pitlib
 * @subpackage Pitlib.Core
 * @version 0.3.0
 */

/////////////////////////////////////////////////////////////////////////////

/**
 * backward compatibility for OS_WINDOWS constant
 */
if (!defined('OS_WINDOWS')) {
    define('OS_WINDOWS', strToUpper(subStr(PHP_OS, 0, 3)) === 'WIN');
}

/**
 * backward compatibility for OS_UNIX constant
 */
if (!defined('OS_UNIX')) {
    define('OS_UNIX', !OS_WINDOWS);
}

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * backward compatibility: the DIR_SEP constant isn't used anymore
 */
if(!defined('DIR_SEP')) {
    define('DIR_SEP', DIRECTORY_SEPARATOR);
}

/**
 * backward compatibility: PATH_SEPARATOR constant is availble since 4.3.0RC2
 */
if (!defined('PATH_SEPARATOR')) {
    define('PATH_SEPARATOR', OS_WINDOWS ? ';' : ':');
}

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Set the PITLIB_DIR constant up with the absolute path to Pitlib files.
 * If it is not defined, include_path will be used. Set PITLIB_DIR only if any
 * other module or application has not already set it up.
 */
if (!defined('PITLIB_DIR')) {
    define('PITLIB_DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'Pitlib' .
            DIRECTORY_SEPARATOR );
}

/////////////////////////////////////////////////////////////////////////////

/**
 * @see Pitlib_Exception
 */
require_once PITLIB_DIR . 'Exception.php';

/**
 * @see Pitlib_Color
 */
require_once PITLIB_DIR . 'Color.php';

/**
 * @see Pitlib_Types
 */
require_once PITLIB_DIR . 'Types.php';

/**
 * @see Pitlib_Tmp
 */
require_once PITLIB_DIR . 'Tmp.php';

/**
 * @see Pitlib_Image
 */
require_once PITLIB_DIR . 'Image.php';

/**
 * @see Pitlib_Driver
 */
require_once PITLIB_DIR . 'Driver.php';

/////////////////////////////////////////////////////////////////////////////

/**
 * Pitlib API
 *
 * This class stores the Pitlib API for some basic image-processing
 * operations like resizing, watermarking and converting.
 *
 * @package Pitlib
 * @subpackage Pitlib.Core
 */
class Pitlib {

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring a proportional resize
 * @see Pitlib::resize()
 */
const RESIZE_PROPORTIONAL = 1001;

/**
 * Constant for declaring a strech resize
 * @see Pitlib::resize()
 */
const RESIZE_STRETCH = 1002;

/**
 * Constant for declaring a fitting resize
 * @see Pitlib::resize()
 */
const RESIZE_FIT = 1003;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring overwriting the target file if it exists
 * @see Pitlib_Image::save()
 */
const OVERWRITE_ENABLED = 2001;

/**
 * Constant for declaring NOT overwriting the target file if it exists
 * @see Pitlib_Image::save()
 */
const OVERWRITE_DISABLED = 2002;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_TOP_LEFT = 3001;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_TOP_CENTER = 3002;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_TOP_RIGHT = 3003;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_MIDDLE_LEFT = 3004;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_MIDDLE_CENTER = 3005;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_MIDDLE_RIGHT = 3006;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_BOTTOM_LEFT = 3007;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_BOTTOM_CENTER = 3008;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_BOTTOM_RIGHT = 3009;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_TILE = 3010;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_NORTH_WEST = Pitlib::WATERMARK_TOP_LEFT;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_NORTH = Pitlib::WATERMARK_TOP_CENTER;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_NORTH_EAST = Pitlib::WATERMARK_TOP_RIGHT;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_WEST = Pitlib::WATERMARK_MIDDLE_LEFT;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_CENTER = Pitlib::WATERMARK_MIDDLE_CENTER;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_MIDDLE = Pitlib::WATERMARK_MIDDLE_CENTER;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_EAST = Pitlib::WATERMARK_MIDDLE_RIGHT;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_SOUTH_WEST = Pitlib::WATERMARK_BOTTOM_LEFT;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_SOUTH = Pitlib::WATERMARK_BOTTOM_CENTER;

/**
 * Constant for declaring watermark position
 * @see Pitlib::watermark()
 */
const WATERMARK_SOUTH_EAST = Pitlib::WATERMARK_BOTTOM_RIGHT;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring watermark scalable
 * @see Pitlib::watermark()
 */
const WATERMARK_SCALABLE_ENABLED = 4001;

/**
 * Constant for declaring watermark scalable factor
 * @see Pitlib::watermark()
 */
const WATERMARK_SCALABLE_FACTOR = 0.25;

/**
 * Constant for declaring watermark not scalable
 * @see Pitlib::watermark()
 */
const WATERMARK_SCALABLE_DISABLED = 4002;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

/**
 * Constant for declaring what type of support the current driver offers
 * @see Pitlib::is_format_supported()
 */
const SUPPORT_READ = 5001;

/**
 * Constant for declaring what type of support the current driver offers
 * @see Pitlib::is_format_supported()
 */
const SUPPORT_WRITE = 5002;

/**
 * Constant for declaring what type of support the current driver offers
 * @see Pitlib::is_format_supported()
 */
const SUPPORT_READ_WRITE = 5003;

// -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

public static $TEMPDIR = -1;


    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Get version of Pitlib release
     *
     * @return string
     * @access public
     * @static
     */
    public static function version() {
        return '0.3.0';
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Set a driver
     *
     * Set a driver as active by providing its name as argument to this static
     * method. If empty, will return current driver, or try to set one from
     * a predefined list. Pass an array of driver_name to try each of them
     * until you find one that works.
     *
     * @param mixed $drivers null, or name, or array of names of the driver
     * @return Pitlib_Driver
     *
     * @access public
     * @static
     */
    public static function &driver($drivers = null) {

        if ( is_null ($drivers)) {
            $d =& Pitlib::_driver ();
            if ($d instanceof Pitlib_Driver) {
                return $d;
            }
            else {
                $drivers = array(
                    'imagick_ext',
                    'magickwand',
                                        'gmagick_shell',
                                        'imagick_shell',
                                        'gd',
                    'imlib2',
                    'netbpm',
                );
            }
        }
        else if (is_string ($drivers)) {
            $drivers = array ($drivers);
        }

                $excep = null;
        foreach ($drivers as $driver_name) {
            try {
                $d =& Pitlib::_driver ($driver_name);
                return $d;
            }
            catch (Pitlib_Exception $e) {
                                $excep = $e;
                // echo $e->getMessage ();
                // Error loading driver...
                // trigger notice...
            }
        }
                
                if ($excep) {
                        throw $excep;
                }
        
        throw new Pitlib_Exception ('No suitable driver found.');
    }

    /**
     * Compose the filename for a driver
     *
     * If you want to use a different mechanism for composing driver's 
     * filename, then override this method in a subclass of {@link Pitlib}
     *
     * @param string $driver_name
     * @return string
     *
     * @access protected
     * @static
     */
    protected static function __driver_filename ($driver_name) {
        $driver_name = ucfirst ($driver_name);
        return PITLIB_DIR . 'Driver' . DIRECTORY_SEPARATOR . 
            $driver_name . '.php';

    }

    /**
     * Compose the classname for a driver
     *
     * If you want to use a different mechanism for composing driver's 
     * classname, then override this method in a subclass of {@link Pitlib}
     *
     * @param string $driver_name
     * @return string
     *
     * @access protected
     * @static
     */
    protected static function __driver_classname ($driver_name) {
        $driver_name = ucfirst ($driver_name);
        return 'Pitlib_Driver_' . $driver_name;
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Get the supported image-types by the loaded driver
     *
     * @param integer $mode
     * @return array
     * @access public
     * @static
     */
    public static function get_supported_types (
            $mode=Pitlib::SUPPORT_READ_WRITE) {

        $d =& Pitlib::_driver ();

        // no driver ?
        //
        if (!$d instanceOf Pitlib_Driver) {
            throw new Pitlib_Exception('No Pitlib driver loaded');
            return false;
        }

        return $d->get_supported_types($mode);
    }

    /**
     * Checks whether an image-type is supported
     *
     * @param mixed $image_type image type or mime type
     * @param integer $mode
     * @return array
     * @access public
     * @static
     */
    public static function is_format_supported($image_type,
            $mode=Pitlib::SUPPORT_READ_WRITE) {

        $d =& Pitlib::_driver ();

        // no driver ?
        //
        if (!$d instanceof Pitlib_Driver) {
            throw new Pitlib_Exception ('No Pitlib driver loaded');
            return false;
        }

        if (is_integer ($image_type)) {
            return $d->supported ($image_type, $mode);
        }
        else {
            return $d->supported_mime (strToLower ($image_type), $mode);
        }
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Get/Set the instance of Pitlib driver
     *
     * @param string $driver_name
     * @return Pitlib_Driver
     *
     * @internal using static array in order to store a reference in a static
     *     variable
     *
     * @access private
     * @static
     */
    private static function &_driver($driver_name=null) {

        static $_d = array (null);

        if (! $driver_name) {
            return $_d[0];      
        }

        // class exists ?
        if (class_exists($c = Pitlib::__driver_classname($driver_name))) {
            $driver = new $c;
        }
        else {
            // file exists ?
            if (!$fp = @fopen(
                        $f = Pitlib::__driver_filename($driver_name), 'r', 1)
               ) {
                throw new Pitlib_Exception (
                        sprintf(
                            'Pitlib driver file "%s" (for driver "%s") '
                            . ' not found for including',
                            $f,
                            $driver_name
                            ));
                return false;
            }
            fclose($fp);

            // include it
            //
            include_once ($f);

            // file loaded, check again ...
            //
            if (class_exists($c)) {
                $driver = new $c;
            }
            else {
                throw new PitlibException (
                        sprintf( 'Pitlib driver class "%s" (for driver "%s")
                            not found',
                            $c,
                            $driver_name
                            ));
                return false;
            }
        }

        // is it a driver ?
        if (!$driver instanceof Pitlib_Driver) {
                throw new Pitlib_Exception (
                        sprintf(
                            'The class you are attempting to '
                            . ' load "%s" is not an '
                            . ' Pitlib driver',
                            get_class($driver)
                            )
                        );
                return false;
        }

        // is it compatible ?
        if (!$driver->is_compatible()) {
            throw new Pitlib_Exception (
                        sprintf(
                            'The class you are attempting to load '
                            . ' "%s" as Pitlib driver is '
                            . ' not compatible',
                            get_class($driver)
                            )
                        );
                return false;
        }

        $_d[0] =& $driver;
        return $_d[0];      
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Get a new image object
     *
     * @param string $source source image for the image operations
     * @return Pitlib_Image
     *
     * @access public
     * @static
     */
    public static function image($source=null) {
        return new Pitlib_Image($source);
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Return an color object ({@link Pitlib_Color}) with the provided RGB
     *    channels
     *
     * @param integer $red   the value has to be from 0 to 255
     * @param integer $green the value has to be from 0 to 255
     * @param integer $blue  the value has to be from 0 to 255
     * @return Pitlib_Color
     * @access public
     * @static
     */
    public static function color($red, $green, $blue, $alpha = 0) {
        $color = new Pitlib_Color;
        $color->set($red, $green, $blue, $alpha);
        return $color;
    }

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    //--end-of-class--  
}

/////////////////////////////////////////////////////////////////////////////

?>
