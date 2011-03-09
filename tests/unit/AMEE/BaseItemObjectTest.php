<?php

/*
 * This file provides the Services_AMEE_BaseItemObject_UnitTest class. Please
 * see the class documentation for full details.
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

require_once 'Services/AMEE/BaseItemObject.php';

/**
 * The Services_AMEE_BaseItemObject_UnitTest class provides the PHPUnit unit
 * test cases for the Services_AMEE_BaseItemObject class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_BaseItemObject_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure the Services_AMEE_BaseItemObject class has the required
     * inherited class attributes.
     */
    public function testInheritedVariables()
    {
        $this->assertClassHasAttribute('oAPI',      'Services_AMEE_BaseItemObject');
        $this->assertClassHasAttribute('sLastJSON', 'Services_AMEE_BaseItemObject');
        $this->assertClassHasAttribute('aLastJSON', 'Services_AMEE_BaseItemObject');
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_BaseItemObject');
    }

    /**
     * Test to ensure the Services_AMEE_BaseItemObject class has the required
     * class attributes.
     */
    public function testVariables()
    {
        $this->assertClassHasAttribute('sCreated',  'Services_AMEE_BaseItemObject');
        $this->assertClassHasAttribute('sModified', 'Services_AMEE_BaseItemObject');
    }

    /**
     * Test the functionality of the Services_AMEE_BaseItemObject::getCreated()
     * method in the context of an un-initialised Services_AMEE_BaseItemObject
     * class.
     */
    public function testGetCreatedInvalid()
    {
        // Create a mocked object with NO methods replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseItemObject',
            array()
        );

        // Call the method that throws an Exception
        try {
            $oMock->getCreated();
        } catch (Exception $oException) {
            // Test the Exception type and message
            $this->assertTrue(is_a($oException, 'Services_AMEE_Exception'));
            $sExpectedMessage = 'Cannot call Service_AMEE_BaseItemObject::getCreated() on an un-initialized object';
            $this->assertEquals($sExpectedMessage, $oException->getMessage());
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the functionality of the Services_AMEE_BaseItemObject::getModified()
     * method in the context of an un-initialised Services_AMEE_BaseItemObject
     * class.
     */
    public function testGetModifiedInvalid()
    {
        // Create a mocked object with NO methods replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseItemObject',
            array()
        );

        // Call the method that throws an Exception
        try {
            $oMock->getModified();
        } catch (Exception $oException) {
            // Test the Exception type and message
            $this->assertTrue(is_a($oException, 'Services_AMEE_Exception'));
            $sExpectedMessage = 'Cannot call Service_AMEE_BaseItemObject::getModified() on an un-initialized object';
            $this->assertEquals($sExpectedMessage, $oException->getMessage());
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the functionality of the Services_AMEE_BaseItemObject::formatDate()
     * method.
     */
    public function testFormatDate()
    {
        // Create a mocked object with NO methods replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseItemObject',
            array()
        );

        // Call the method with a valid input string, and ensure it returns
        // the same as directly calling the the built in PHP function date()
        // with formatting option "c" for ISO 8601 formatting
        $sDate = '2010-04-12 10:35:45';
        $sTime = strtotime($sDate);
        $sDate1 = $oMock->formatDate($sDate);
        $sDate2 = date('c', $sTime);
        $this->assertEquals($sDate2, $sDate1);
    }

}

?>
