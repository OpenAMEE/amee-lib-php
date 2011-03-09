<?php

/*
 * This file provides the Services_AMEE_Profile_UnitTest class. Please see the
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

require_once 'Services/AMEE/Profile.php';

/**
 * The Services_AMEE_Profile_UnitTest class provides the PHPUnit unit test cases
 * for the Services_AMEE_Profile class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Profile_UnitTest extends PHPUnit_Framework_TestCase
{
    
    // Test to ensure that the Services_AMEE_Profile class extends the
    // Services_AMEE_BaseObject class
    public function testClassDefinition()
    {
        $oProfile = new Services_AMEE_Profile('1234567890AB');
        $this->assertTrue(is_a($oProfile, 'Services_AMEE_Profile'));
        $this->assertTrue(is_a($oProfile, 'Services_AMEE_BaseObject'));
    }

    /**
     * Test to ensure the Services_AMEE_Profile has the required class
     * attributes that are inherited from Services_AMEE_BaseObject.
     */
    public function testInheritedVariables()
    {
        $this->assertClassHasAttribute('oAPI',      'Services_AMEE_Profile');
        $this->assertClassHasAttribute('sLastJSON', 'Services_AMEE_Profile');
        $this->assertClassHasAttribute('aLastJSON', 'Services_AMEE_Profile');
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_Profile');
    }

    /**
     * Test to ensure that the Services_AMEE_Profile::_construct() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_BaseObject::_hasJSONDecode() method.
     */
    public function testConstructJSONDecodeError()
    {
        // Prepare testing Exception to return
        $oJSONException = new Exception('JSON Test Exception');

        // Create a mocked version of the Services_AMEE_Profile class, with
        // the _hasJSONDecode() method mocked
        $aMockMethods = array(
            '_hasJSONDecode'
        );
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _hasJSONDecode()
        // method will be called exactly once and set the Exception that
        // will be thrown by the method call.
        $oMockProfile->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->throwException($oJSONException));

        // Call the __construct() method
        try {
            $oMockProfile->__construct('1234567890AB');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oJSONException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_Profile::_construct() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::post() method.
     */
    public function testConstructAPIError()
    {
        // Prepare testing Exception to return
        $oAPIException = new Exception('API Test Exception');

        // Create a mocked version of the Services_AMEE_API class
        $oMockAPI = $this->getMock('Services_AMEE_API');

        // Create a mocked version of the Services_AMEE_Profile class, with
        // the _hasJSONDecode() method mocked
        $aMockMethods = array(
            '_hasJSONDecode',
            '_getAPI'
        );
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked profile object that the
        // _hasJSONDecode()/ method will be called exactly once and return true
        $oMockProfile->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->returnValue(true));

        // Set the expectation on the mocked profile object that the _getAPI()
        // method will be called exactly once and return the mocked API class
        $oMockProfile->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Set the expectation on the mocked API object that the post() method
        // will be called exactly once, with parameters as expected for creation
        // of a new profile, and set the exception that will be thrown
        $oMockAPI->expects($this->once())
                ->method('post')
                ->with(
                    $this->equalTo('/profiles'),
                    $this->equalTo(array('profile' => 'true'))
                )
                ->will($this->throwException($oAPIException));

        // Call the __construct() method
        try {
            $oMockProfile->__construct();
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oAPIException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_Profile::_construct() method
     * sets the UID correctly from returned JSON data.
     */
    public function testConstruct()
    {
        // Create a mocked version of the Services_AMEE_API class
        $oMockAPI = $this->getMock('Services_AMEE_API');

        // Create a mocked version of the Services_AMEE_Profile class, with
        // the _hasJSONDecode() method mocked
        $aMockMethods = array(
            '_hasJSONDecode',
            '_getAPI'
        );
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked profile object that the
        // _hasJSONDecode()/ method will be called exactly once and return true
        $oMockProfile->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->returnValue(true));

        // Set the expectation on the mocked profile object that the _getAPI()
        // method will be called exactly once and return the mocked API class
        $oMockProfile->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Set the expectation on the mocked API object that the post() method
        // will be called exactly once, with parameters as expected for creation
        // of a new profile, and set the exception that will be thrown
        $sReturn = '
            {
              "apiVersion":"2.0",
              "profile":{
                "uid":"180D73DA5229",
                "environment":{
                  "uid":"5F5887BCF726"
                },
                "created":"Wed Mar 18 10:23:59 GMT 2009",
                "name":"180D73DA5229",
                "path":"180D73DA5229",
                "permission":{
                  "uid":"2F093CD55011",
                  "created":"Wed Mar 18 10:23:59 GMT 2009",
                  "group":{
                    "uid":"AC65FFA5F9D9",
                    "name":"amee"
                  },
                  "environmentUid":"5F5887BCF726",
                  "auth":{
                    "uid":"BA6EB0039D69",
                    "username":"v2user"
                  },
                  "modified":"Wed Mar 18 10:23:59 GMT 2009"
                },
                "modified":"Wed Mar 18 10:23:59 GMT 2009"
              }
            }';
        $oMockAPI->expects($this->once())
                ->method('post')
                ->with(
                    $this->equalTo('/profiles'),
                    $this->equalTo(array('profile' => 'true'))
                )
                ->will($this->returnValue($sReturn));

        // Call the __construct() method
        $oMockProfile->__construct();

        // Test that the UID was set correctly
        $this->assertEquals($oMockProfile->getUID(), '180D73DA5229');
    }

    /**
     * Test to ensure that the Services_AMEE_Profile::delete() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::delete() method.
     */
    public function testDeleteAPIError()
    {
        // Prepare testing Exception to return
        $oAPIException = new Exception('API Test Exception');

        // Create a mocked version of the Services_AMEE_API class
        $oMockAPI = $this->getMock('Services_AMEE_API');

        // Create a mocked version of the Services_AMEE_Profile class, with
        // the _hasJSONDecode() method mocked
        $aMockMethods = array(
            '_hasJSONDecode',
            '_getAPI'
        );
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked profile object that the
        // _hasJSONDecode()/ method will be called exactly once and return true
        $oMockProfile->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->returnValue(true));

        // Set the expectation on the mocked profile object that the _getAPI()
        // method will be called exactly once and return the mocked API class
        $oMockProfile->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Set the expectation on the mocked API object that the post() method
        // will be called exactly once, with parameters as expected for creation
        // of a new profile, and set the exception that will be thrown
        $oMockAPI->expects($this->once())
                ->method('delete')
                ->with(
                    $this->equalTo('/profiles/1234567890AB')
                )
                ->will($this->throwException($oAPIException));
        
        // Call the __construct() method
        $oMockProfile->__construct('1234567890AB');

        // Call the delete() method
        try {
            $oMockProfile->delete();
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oAPIException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

}

?>
