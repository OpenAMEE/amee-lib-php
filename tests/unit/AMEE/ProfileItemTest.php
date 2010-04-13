<?php

/*
 * This file provides the Services_AMEE_ProfileItem_UnitTest class. Please see
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
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_ProfileItem_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_ProfileItem class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileItem_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * A private method that prepares and returns a mocked version of the
     * Services_AMEE_DataItem class, set up with just the _getAPI() method
     * mocked so that it returns a mock Services_AMEE_API object, which in
     * turns has all methods mocked, and an expectation/return value set up
     * to allow the mocked Services_AMEE_DataItem to be constructed for the
     * "/metadata" path.
     *
     * @return <Services_AMEE_DataItem>
     */
    private function _getDataItem()
    {


        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        //
        // Requires the creation of a mocked version of the Services_AMEE_API
        // class that will return the required JSON data when called for the
        // drill down on the Data Item "/metadata" path
        $oMockAPI = $this->getMock('Services_AMEE_API');

        $sMetadataDrillJSON = '
            {
              "choices":
              {
                "choices":
                [{
                  "name":"86D02FBD95AE",
                  "value":"86D02FBD95AE"
                }],
                "name":"uid"
              }
            }';

        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    $this->equalTo('/data/metadata/drill'),
                    $this->equalTo(array())
                )
                ->will($this->returnValue($sMetadataDrillJSON));

        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            array('_getAPI'),
            array(),
            '',
            false
        );

        $oMockDataItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));
        $oMockDataItem->__construct('/metadata');

        return $oMockDataItem;
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem class extends the
     * Services_AMEE_BaseItemObject class
     */
    public function testClassDefinition()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare a mocked version of the Services_AMEE_API object that will
        // return the required JSON data when called for the get existing AMEE
        // API Profile Item object by UID
        $oMockAPI = $this->getMock('Services_AMEE_API');
        $sGetProfileJSON = '
            {
              "profileItem": {
                "name": null,
                "modified": "2010-04-13T10:19:18+01:00",
                "amount": {
                  "value": 0,
                  "unit": "kg/year"
                },
                "startDate": "2010-04-13T10:19:00+01:00",
                "uid": "A606D4394BAD",
                "endDate": "",
                "created": "2010-04-13T10:19:18+01:00"
              }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    $this->equalTo('/profiles/1234567890AB/metadata/BA0987654321'),
                    $this->equalTo(array())
                )
                ->will($this->returnValue($sGetProfileJSON));

        // Prepare a mocked version of the Services_AMEE_ProfileItem class,
        // with the _getAPI() method mocked, without calling the constructor
        // method
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            array('_getAPI'),
            array(),
            '',
            false
        );

        // Set the return value of the _getAPI() method in the created mocked
        // object to be the pre-prepared Services_AMEE_API mock
        $oMockProfileItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));
        
        // Call the __construct() method
        $oMockProfileItem->__construct(
            array(
                $oProfile,
                $oMockDataItem,
                'BA0987654321'
            )
        );
        
        $this->assertTrue(is_a($oMockProfileItem, 'Services_AMEE_ProfileItem'));
        $this->assertTrue(is_a($oMockProfileItem, 'Services_AMEE_BaseItemObject'));
    }
    
    /**
     * Test to ensure the Services_AMEE_ProfileItem has the required class
     * attributes that are inherited from Services_AMEE_BaseObject.
     */
    public function testInheritedVariables()
    {
        $this->assertClassHasAttribute('oAPI',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sLastJSON', 'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('aLastJSON', 'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sCreated',  'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sModified', 'Services_AMEE_ProfileItem');
    }

    /**
     * Test to ensure the Services_AMEE_ProfileItem class has the required class
     * attributes.
     */
    public function testVariables()
    {
        $this->assertClassHasAttribute('sName',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('dAmount',    'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sUnit',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sPerUnit',   'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sStartDate', 'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sEndDate',   'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('oProfile',   'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('oDataItem',  'Services_AMEE_ProfileItem');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::_construct() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_BaseObject::_hasJSONDecode() method.
     */
    public function testConstructJSONDecodeError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare testing Exception to return
        $oJSONException = new Exception('JSON Test Exception');

        // Prepare a mocked version of the Services_AMEE_ProfileItem class,
        // with the _hasJSONDecode() method mocked, without calling the
        // constructor method
        $aMockMethods = array(
            '_hasJSONDecode'
        );
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            $aMockMethods,
            array(),
            '',
            false
        );

        // Set the expectation on the mocked object that the _hasJSONDecode()
        // method will be called exactly once and set the Exception that
        // will be thrown by the method call.
        $oMockProfileItem->expects($this->once())
                ->method('_hasJSONDecode')
                ->will($this->throwException($oJSONException));

        // Call the __construct() method
        try {
            $oMockProfileItem->__construct(
                array(
                    $oProfile,
                    $oMockDataItem,
                    'BA0987654321'
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oJSONException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called without an array parameter.
     */
    public function testConstructParamNotArrayError()
    {
        // Prepare the expected exception
        $oNotArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with a parameter that is not an array'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem('foo');
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oNotArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter with an invalid
     * number of items.
     */
    public function testConstructEmptyArrayParamError()
    {
        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array containing an invalid number ' .
            'of items'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(array());
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter with an invalid
     * number of items.
     */
    public function testConstructSmallArrayParamError()
    {
        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array containing an invalid number ' .
            'of items'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(array('one'));
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter with an invalid
     * number of items.
     */
    public function testConstructLargeArrayParamError()
    {
        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array containing an invalid number ' .
            'of items'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array('one', 'two', 'three', 'four', 'five', 'six')
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter that does not
     * have a Services_AMEE_Profile object as the first parameter.
     */
    public function testConstructParamOneError()
    {
        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array\'s first parameter not being ' .
            'the required Services_AMEE_Profile object'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array('one', 'two', 'three')
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter that does not
     * have a Services_AMEE_DataItem object as the second parameter.
     */
    public function testConstructParamTwoError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');
        
        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array\'s second parameter not being ' .
            'the required Services_AMEE_DataItem object'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array($oProfile, 'two', 'three')
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }
    
    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameter that has the third
     * parameter being neither a string nor an array.
     */
    public function testConstructParamThreeTypeError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array\'s third parameter not ' .
            'being either an array or a string'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array($oProfile, $oMockDataItem, $oMockDataItem)
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /***************************************************************************
     * TESTS FOR THE "NEW" STYLE OF CREATION
     **************************************************************************/

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "uid" style construction (i.e. third param is an array of items) but
     * where that third parameter is an empty array.
     */
    public function testConstructNewParamThreeEmptyArrayError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called with' .
            'the parameter array\'s third parameter being an empty AMEE ' .
            'API Profile Item Value array'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array($oProfile, $oMockDataItem, array())
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * with a fourth parameter that is not an array.
     */
    public function testConstructNewParamFourError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method ' .
            'called with the parameter array\'s fourth ' .
            'parameter not being an array'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    'four'
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * with a fourth parameter array containins an invalid key.
     */
    public function testConstructNewParamFourInvalidOptionError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with option ' .
            'parameter array containing invalid key \'foo\''
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    array(
                        'foo' => 'bar'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * with a fourth parameter array containing an both the "endDate" and
     * "duration" options.
     */
    public function testConstructNewParamFourEndDateAndDurationError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with the option ' .
            'parameter array containing both an \'endDate\' and ' .
            '\'duration\' - only one of these items may be set'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    array(
                        'endDate'  => 'foo',
                        'duration' => 'bar'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * with a fourth parameter array containing an the "endDate" option, but
     * no "startDate" option.
     */
    public function testConstructNewParamFourEndDateNoStartDateError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with the option ' .
            'parameter array containing one of \'endDate\' or ' .
            '\'duration\' set, but without the \'startDate\' set'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    array(
                        'endDate' => 'foo'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * with a fourth parameter array containing an the "endDate" option, but
     * no "startDate" option.
     */
    public function testConstructNewParamFourDurationNoStartDateError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with the option ' .
            'parameter array containing one of \'endDate\' or ' .
            '\'duration\' set, but without the \'startDate\' set'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    array(
                        'duration' => 'foo'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "new" style construction (i.e. third param is an array of items) but
     * where the fith parameter is not an array.
     */
    public function testConstructNewParamFiveError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with return unit ' .
            'parameter array not actually being an array'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'item' => 'value'
                    ),
                    array(
                        'startDate' => 'foo'
                    ),
                    'five'
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that all of the expected calls to mocked versions of the
     * Services_AMEE_Profile, Services_AMEE_DataItem and Services_AMEE_API
     * classes are made and that a valid Services_AMEE_ProfileItem class is
     * created when the class is constructed via the "new" technique.
     *
     * Also test the Services_AMEE_ProfileItem::getInfo() method.
     */
    public function testConstructNew()
    {
        $this->markTestIncomplete();
        return;
    }

    /***************************************************************************
     * TESTS FOR THE "UID" STYLE OF CREATION
     **************************************************************************/

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "uid" style construction (i.e. third param is a string) but with a
     * fourth parameter that is not an array.
     */
    public function testConstructUIDParamFourError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method ' .
            'called with the parameter array\'s fourth ' .
            'parameter not being an array'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    '1234567890AB',
                    'four'
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }
    
    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "uid" style construction (i.e. third param is a string) but where the
     * third parameter contains an invalid key.
     */
    public function testConstructUIDParamFourArrayOfReturnAndOtherError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with the return ' .
            'unit parameter array containing invalid key \'foo\''
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    '1234567890AB',
                    array(
                        'returnUnit' => 'g',
                        'foo'        => 'bar'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }
    
    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "uid" style construction (i.e. third param is a string) and where a
     * fifth parameter has also been passed in.
     */
    public function testConstructUIDParamFiveError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array\'s fifth parameter being set, ' .
            'but with other parameters such that a fifth parameter ' .
            'is not expected to be set'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    '1234567890AB',
                    array(),
                    'five'
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that all of the expected calls to mocked versions of the
     * Services_AMEE_Profile, Services_AMEE_DataItem and Services_AMEE_API
     * classes are made and that a valid Services_AMEE_ProfileItem class is
     * created when the class is constructed via the "uid" technique.
     *
     * Also test the Services_AMEE_ProfileItem::getInfo() method.
     */
    public function testConstructUID()
    {
        $this->markTestIncomplete();
        return;
    }

    /***************************************************************************
     * TESTS FOR THE "SEARCH" STYLE OF CREATION
     **************************************************************************/

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "search" style construction (i.e. third param is an array of return
     * options) but where thjat third parameter also has an invalid key.
     */
    public function testConstructSearchParamThreeArrayOfReturnAndOtherError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem method called with the return ' .
            'unit parameter array containing invalid key \'foo\''
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oMockDataItem,
                    array(
                        'returnUnit' => 'g',
                        'foo'        => 'bar'
                    )
                )
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }
    
    /**
     * Test to ensure that the Services_AMEE_ProfileItem::__construct() method
     * throws an exception if called with an array parameters set that is for
     * a "search" style construction (i.e. third param is null) but with a
     * fourth parameter also set.
     */
    public function testConstructSearchParamFourError()
    {
        // Prepare a Services_AMEE_Profile object that be used in the
        // construction of a Services_AMEE_ProfileItem object
        $oProfile = new Services_AMEE_Profile('1234567890AB');

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockDataItem = $this->_getDataItem();

        // Prepare the expected exception
        $oArrayException = new Services_AMEE_Exception(
            'Services_AMEE_ProfileItem constructor method called ' .
            'with the parameter array\'s fourth parameter being set, ' .
            'but with other parameters such that a fourth parameter ' .
            'is not expected to be set'
        );

        try {
            $oProfileItem = new Services_AMEE_ProfileItem(
                array($oProfile, $oMockDataItem, null, 'four')
            );
        } catch (Exception $oException) {
            // Test the Exception was correctly thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oArrayException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that all of the expected calls to mocked versions of the
     * Services_AMEE_Profile, Services_AMEE_DataItem and Services_AMEE_API
     * classes are made and that a valid Services_AMEE_ProfileItem class is
     * created when the class is constructed via the "search" technique.
     *
     * Also test the Services_AMEE_ProfileItem::getInfo() method.
     */
    public function testConstructSearch()
    {
        $this->markTestIncomplete();
        return;
    }

}

?>
