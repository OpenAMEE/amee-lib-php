<?php

/*
 * This file provides the Services_AMEE_DataItem_UnitTest class. Please see
 * the class documentation for full details.
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

require_once 'Services/AMEE/BaseObject.php';

/**
 * The Services_AMEE_DataItem_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_DataItem class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_DataItem_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure that the Services_AMEE_DataItem::_construct() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_BaseObject::_hasJSONDecode() method.
     */
    public function testConstructJSONDecodeError()
    {
        // Prepare testing Exception to return
        $oJSONException = new Exception('JSON Test Exception');

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_hasJSONDecode'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _hasJSONDecode()
        // method will be called exactly once and set the Exception that
        // will be thrown by the method call.
        $oMockDataItem->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->throwException($oJSONException));

        // Call the __construct() method
        try {
            $oMockDataItem->__construct('/metadata');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oJSONException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_DataItem::_construct() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::get() method.
     */
    public function testConstructAPIGetError()
    {
        // Prepare testing Exception to return
        $oAPIException = new Exception('API Test Exception');

        // Prepare a mocked version of the Services_AMEE_API class, with the
        // required call expectations and exception being thrown
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/data/metadata/drill',
                    array()
                )
                ->will($this->throwException($oAPIException));

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_getAPI'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _getAPI() method
        // will be called exactly once and set the mocked Services_AMEE_API
        // object to be returned
        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Call the __construct() method
        try {
            $oMockDataItem->__construct('/metadata');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oAPIException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_DataItem::_construct() method
     * correctly throws an error when the Drill Down request is invalid
     */
    public function testConstructBadCall()
    {
        // Prepare a mocked version of the Services_AMEE_API class, with the
        // required call expectations and return JSON
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/data/metadata/drill',
                    array()
                )
                ->will($this->returnValue('{"SOME":"JSON"}'));

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_getAPI'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _getAPI() method
        // will be called exactly once and set the mocked Services_AMEE_API
        // object to be returned
        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Call the __construct() method
        try {
            $oMockDataItem->__construct('/metadata');
        } catch (Exception $oException) {
            // Test the Exception type and message
            $this->assertTrue(is_a($oException, 'Services_AMEE_Exception'));
            $sExpectedMessage =
                'AMEE API Data Item Drill Down for path ' .
                '\'/data/metadata/drill\' with the specified options did not ' .
                'return a Data Item UID - check that the specified options ' .
                'fully define a complete Drill Down to a single Data Item';
            $this->assertEquals($sExpectedMessage, $oException->getMessage());
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the functionality of the Services_AMEE_DataItem::getPath() method.
     */
    public function testGetPath()
    {
        // Prepare a mocked version of the Services_AMEE_API class, with the
        // required call expectations and return JSON
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $sReturnJSON = '
            {
              "choices":
              {
                "name":"uid",
                "choices":
                [{
                  "name":"1234567890AB",
                  "value":"1234567890AB"
                }]
                
              }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/data/metadata/drill',
                    array()
                )
                ->will($this->returnValue($sReturnJSON));

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_getAPI'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _getAPI() method
        // will be called exactly once and set the mocked Services_AMEE_API
        // object to be returned
        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Call the __construct() method
        $oMockDataItem->__construct('/metadata');

        // Test the getPath() method
        $this->assertEquals('/metadata', $oMockDataItem->getPath());

        // Test the getUID() method for good measure
        $this->assertEquals('1234567890AB', $oMockDataItem->getUID());
    }

    /**
     * Test the functionality of the
     * Services_AMEE_DataItem::getDrillDownOptions() method when there are no
     * drill down options set.
     */
    public function testGetDrillDownOptionNoOptions()
    {
        // Prepare a mocked version of the Services_AMEE_API class, with the
        // required call expectations and return JSON
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $sReturnJSON = '
            {
              "choices":
              {
                "name":"uid",
                "choices":
                [{
                  "name":"1234567890AB",
                  "value":"1234567890AB"
                }]

              }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/data/metadata/drill',
                    array()
                )
                ->will($this->returnValue($sReturnJSON));

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_getAPI'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _getAPI() method
        // will be called exactly once and set the mocked Services_AMEE_API
        // object to be returned
        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Call the __construct() method
        $oMockDataItem->__construct('/metadata');

        // Test the getDrillDownbOptions() method
        $this->assertEquals(array(), $oMockDataItem->getDrillDownOptions());
    }


    /**
     * Test the functionality of the
     * Services_AMEE_DataItem::getDrillDownOptions() method when there are drill
     * down options set.
     */
    public function testGetDrillDownOptionWithOptions()
    {
        // Prepare a mocked version of the Services_AMEE_API class, with the
        // required call expectations and return JSON
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $sReturnJSON = '
            {
              "choices":
              {
                "name":"uid",
                "choices":
                [{
                  "name":"66056991EE23",
                  "value":"66056991EE23"
                }]

              }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/data/home/energy/quantity/drill',
                    array('type' => 'gas')
                )
                ->will($this->returnValue($sReturnJSON));

        // Prepare a mocked version of the Services_AMEE_DataItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_getAPI'
        );
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _getAPI() method
        // will be called exactly once and set the mocked Services_AMEE_API
        // object to be returned
        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Call the __construct() method
        $oMockDataItem->__construct(
            '/home/energy/quantity',
            array('type' => 'gas')
        );

        // Test the getDrillDownbOptions() method
        $this->assertEquals(
            array('type' => 'gas'),
            $oMockDataItem->getDrillDownOptions()
        );
    }

}

?>
