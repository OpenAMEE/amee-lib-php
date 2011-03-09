<?php

/*
 * This file provides the Services_AMEE_Exception_UnitTest class. Please see the
 * class documentation for full details.
 *
 * PHP Version 5
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */

require_once 'Services/AMEE/Exception.php';

/**
 * The Services_AMEE_Exception_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_Exception class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Exception_UnitTest extends PHPUnit_Framework_TestCase
{

    // Test to ensure that the Services_AMEE_Exception class extends the PHP
    // Exception class
    public function testClassDefinition()
    {
        $oException = new Services_AMEE_Exception();
        $this->assertTrue(is_a($oException, 'Services_AMEE_Exception'));
        $this->assertTrue(is_a($oException, 'Exception'));
    }
    
}

?>
