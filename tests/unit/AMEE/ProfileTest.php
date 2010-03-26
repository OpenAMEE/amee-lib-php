<?php

/*
 * This file provides the Services_AMEE_Profile_UnitTest class. Please see the
 * class documentation for full details.
 *
 * PHP Version 5
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */

require_once 'PHPUnit/Framework.php';
require_once 'Services/AMEE/Profile.php';

/**
 * The Services_AMEE_Profile_UnitTest class provides the PHPUnit unit test cases
 * for the Services_AMEE_Profile class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Profile_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure the Services_AMEE_Profile has the required class
     * attributes that are inherited from Services_AMEE_BaseObject.
     */
    public function testInheritedVariables()
    {
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_Profile');
        $this->assertClassHasAttribute('sCreated',  'Services_AMEE_Profile');
        $this->assertClassHasAttribute('sModified', 'Services_AMEE_Profile');
    }

}

?>
