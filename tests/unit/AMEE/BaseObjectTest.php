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
        $this->assertClassHasAttribute('oAPI',      'Services_AMEE_BaseObject');
        $this->assertClassHasAttribute('sLastJSON', 'Services_AMEE_BaseObject');
        $this->assertClassHasAttribute('aLastJSON', 'Services_AMEE_BaseObject');
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_BaseObject');
    }

    /**
     * Test the functionality of the Services_AMEE_BaseObject::getUID() method
     * in the context of an un-initialised Services_AMEE_BaseObject class.
     */
    public function testGetUIDInvalid()
    {
        // Create a mocked object with NO methods replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseObject',
            array()
        );

        // Call the method that throws an Exception
        try {
            $oMock->getUID();
        } catch (Exception $oException) {
            // Test the Exception type and message
            $this->assertTrue(is_a($oException, 'Services_AMEE_Exception'));
            $sExpectedMessage = 'Cannot call Service_AMEE_BaseObject::getUID() on an un-initialized object';
            $this->assertEquals($sExpectedMessage, $oException->getMessage());
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the functionality of the Services_AMEE_BaseObject::_hasJSONDecode()
     * method when the JSON extension is not present.
     *
     * @expectedException Services_AMEE_Exception
     */
    public function test_hasJSONDecodeNotLoaded()
    {
        $this->markTestIncomplete();
        return;

        // Create a mocked object with only the _extensionLoaded() method
        // replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseObject',
            array('_extensionLoaded'),
            '',
            false
        );

        // Set the expectation on the mocked object that the _extentionLoaded()
        // method will be called once with parameter string "json", and set the
        // return value to be false
        $oMock->expects($this->once())
                ->method('_extensionLoaded')
                ->with($this->equalTo('json'))
                ->will($this->returnValue(false));

        // Call the class constructor method
        $oMock->__construct();
    }

    /**
     * Test the functionality of the Services_AMEE_BaseObject::_hasJSONDecode()
     * method when the JSON extension is present.
     */
    public function test_hasJSONDecodeLoaded()
    {
        $this->markTestIncomplete();
        return;

        // Create a mocked object with only the _extensionLoaded() method
        // replaced
        $oMock = $this->getMockForAbstractClass(
            'Services_AMEE_BaseObject',
            array('_extensionLoaded'),
            '',
            false
        );

        // Set the expectation on the mocked object that the _extentionLoaded()
        // method will be called once with parameter string "json", and set the
        // return value to be true
        $oMock->expects($this->once())
                ->method('_extensionLoaded')
                ->with($this->equalTo('json'))
                ->will($this->returnValue(true));

        // Call the class constructor method
        $oMock->__construct();

    }

}

?>
