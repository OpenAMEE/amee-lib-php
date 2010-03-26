<?php

/*
 * This file provides the Services_AMEE_BaseObject_UnitTest class. Please see
 * the class documentation for full details.
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
require_once 'Services/AMEE/BaseObject.php';

/**
 * The Services_AMEE_BaseObject_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_BaseObject class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_BaseObject_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure the Services_AMEE_BaseObject class has the required class
     * attributes.
     */
    public function testVariables()
    {
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_BaseObject');
        $this->assertClassHasAttribute('sCreated',  'Services_AMEE_BaseObject');
        $this->assertClassHasAttribute('sModified', 'Services_AMEE_BaseObject');
    }

    /**
     * Test the functionality of the getUID in the context of the
     * Services_AMEE_BaseObject class.
     *
     * @expectedException Services_AMEE_Exception
     */
    public function testGetUID()
    {
        $oMock = $this->getMockForAbstractClass('Services_AMEE_BaseObject');
        $oMock->getUID();
    }

}

?>
