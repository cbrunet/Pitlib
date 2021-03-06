<?php
// vim: tabstop=4: expandtab: sts=4: ai: sw=4:

/**
 * @author Charles Brunet <cbrunet@php.net>
 * @author Kaloyan K. Tsvetkov <kaloyan@kaloyan.info>
 * @license http://opensource.org/licenses/lgpl-license.php
 *     GNU Lesser General public License Version 2.1
 * @package Pitlib
 * @subpackage Pitlib.Core
 * @version 0.3.0
 */

/////////////////////////////////////////////////////////////////////////////

/**
 * Pitlib Color
 *
 * This class stores common color-related routines
 *
 * @package Pitlib
 * @subpackage Pitlib.Core
 */
Class Pitlib_Color {

    /**
     * Red Channel
     * @var integer
     * @access private
     */
    private $_red = 0;

    /**
     * Green Channel
     * @var integer
     * @access private
     */
    private $_green = 0;

    /**
     * Blue Channel
     * @var integer
     * @access private
     */
    private $_blue = 0;

    /**
     * Alpha Channel
     * @var integer
     * @access private
     */
    private $_alpha = 0;

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    /**
     * Set a new color
     *
     * @param integer $red   the value has to be from 0 to 255
     * @param integer $green the value has to be from 0 to 255
     * @param integer $blue  the value has to be from 0 to 255
     * @param integer $alpha the value has to be from 0 to 255
     * @access public
     */
    public function set($red, $green, $blue, $alpha = 0) {
        $this->_red = $red % 256;
        $this->_green = $green % 256;
        $this->_blue = $blue % 256;
        $this->_alpha = $alpha % 256;
    }

    /**
     * Get the stored color
     *
     * @return array indexed array with three elements: one for each channel
     *    following the RGB order
     * @access public
     */
    public function get() {
        return array(
                $this->_red,
                $this->_green,
                $this->_blue,
                $this->_alpha
                );
    }
	
	/**
	 * Get the stored color, in ImageMagick "rgb(xxx, xxx, xxx)" format
	 *
	 * @return string Color identifier
	 * @access public
	 */
	public function imagick() {
		return sprintf('rgb(%d, %d, %d)', $this->_red, $this->_green, $this->_blue);
	}

    // -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- -- 

    //--end-of-class--  
}

/////////////////////////////////////////////////////////////////////////////

?>
