<?php

/*
 * This file provides the Services_AMEE_ProfileItem_UnitTest class. Please see
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

require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_ProfileItem_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_ProfileItem class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
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
     * @param <array> $aExtraMockMethods An optional array of additional methods
     *      that should be mocked in the returned mock version of the
     *      Services_AMEE_DataItem class.
     * @return <Services_AMEE_DataItem> The mocked version of the
     *      Services_AMEE_DataItem class.
     */
    private function _getDataItem($aExtraMockMethods = array())
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

        $aMockMethods = array(
            '_getAPI'
        );
        foreach ($aExtraMockMethods as $sMethod) {
            $aMockMethods[] = $sMethod;
        }
        $oMockDataItem = $this->getMock(
            'Services_AMEE_DataItem',
            $aMockMethods,
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
                "modified": "2010-04-13T10:19:18+00:00",
                "amount": {
                  "value": 0,
                  "unit": "kg/year"
                },
                "startDate": "2010-04-13T10:19:00+00:00",
                "uid": "A606D4394BAD",
                "endDate": "",
                "created": "2010-04-13T10:19:18+00:00",
                "itemValues": [
                  {
                    "path": "otherDetails",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "greenTariff",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "peopleInHousehold",
                    "value": "1",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "state",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "postcode",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "childrenInHousehold",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "country",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "profileStatus",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "adultsInHousehold",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "profileType",
                    "value": "Individual",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "mainHeatingSystem",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "buildingType",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  },
                  {
                    "path": "floorAreaM2",
                    "value": "",
                    "unit": "",
                    "perUnit": ""
                  }
                ]
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

    /***************************************************************************
     * NON-SPECIFIC CONSTRUCTOR TESTS
     **************************************************************************/

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
        // Prepare a mocked version of the Services_AMEE_Profile object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            array('getUID'),
            array('1234567890AB')
        );
        $oMockProfile->expects($this->exactly(3))
                ->method('getUID')
                ->will($this->returnValue('1234567890AB'));

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $aExtraMockMethods = array(
            'getUID',
            'getPath'
        );
        $oMockDataItem = $this->_getDataItem($aExtraMockMethods);
        $oMockDataItem->expects($this->exactly(3))
                ->method('getPath')
                ->will($this->returnValue('/home/energy/quantity'));
        $oMockDataItem->expects($this->exactly(2))
                ->method('getUID')
                ->will($this->returnValue('BA0987654321'));

        // Prepare a mocked version of the Services_AMEE_API object that can
        // be used in the construction of a Services_AMEE_ProfileItem object
        $oMockAPI = $this->getMock(
            'Services_AMEE_API'
        );
        $sPostJSON = '
            {
              "UID":"000000000000"
            }';
        $oMockAPI->expects($this->once())
                ->method('post')
                ->with(
                    '/profiles/1234567890AB/home/energy/quantity',
                    array(
                        'dataItemUid'     => 'BA0987654321',
                        'lastReading'     => 12345,
                        'currentReading'  => 12890,
                        'includesHeating' => true,
                        'name'            => 'someName'
                    )
                )
                ->will($this->returnValue($sPostJSON));
        $sSearchJSON = '
            {
              "profileItem":
                {
                  "modified": "2010-04-13T13:37:29+00:00",
                  "name": "someName",
                  "amount": {
                    "value": 50000,
                    "unit": "g/week"
                  },
                  "startDate": "2010-04-13T13:37:00+00:00",
                  "uid": "000000000000",
                  "endDate": "",
                  "created": "2010-04-13T13:37:19+00:00",
                  "itemValues": [
                    {
                      "path": "someValue",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    }
                  ]
                }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/profiles/1234567890AB/home/energy/quantity/000000000000',
                    array(
                        'returnUnit'    => 'g',
                        'returnPerUnit' => 'week'
                    )
                )
                ->will($this->returnValue($sSearchJSON));

        // Prepare a mocked version of the Service_AMEE_ProfileItem object that
        // has the _getAPI() method mocked and set to return the above mocked
        // version of the Services_AMEE_API
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            array('_getAPI'),
            array(),
            '',
            false
        );
        $oMockProfileItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Create the Services_AMEE_ProfileItem object
        $oMockProfileItem->__construct(
            array(
                $oMockProfile,
                $oMockDataItem,
                array(
                    'lastReading'     => 12345,
                    'currentReading'  => 12890,
                    'includesHeating' => true
                ),
                array(
                    'name' => 'someName'
                ),
                array(
                    'returnUnit'    => 'g',
                    'returnPerUnit' => 'week'
                )
            )
        );

        // Test that the object was created as expected
        $aExpectedInfo = array(
            'uid'         => '000000000000',
            'name'        => 'someName',
            'created'     => '2010-04-13T13:37:19+00:00',
            'modified'    => '2010-04-13T13:37:29+00:00',
            'profileUid'  => '1234567890AB',
            'path'        => '/home/energy/quantity',
            'dataItemUid' => 'BA0987654321',
            'amount'      => '50000',
            'unit'        => 'g',
            'perUnit'     => 'week',
            'startDate'   => '2010-04-13T13:37:00+00:00',
            'endDate'     => ''
        );
        $aInfo = $oMockProfileItem->getInfo();
        $this->assertEquals($aExpectedInfo, $aInfo);
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
     * Also test the Services_AMEE_ProfileItem::getInfo() method, "double" GHG
     * output values and all possible class variables that will be set from the
     * results returned by the API.
     */
    public function testConstructUID()
    {
        // Prepare a mocked version of the Services_AMEE_Profile object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            array('getUID'),
            array('555555555555')
        );
        $oMockProfile->expects($this->exactly(2))
                ->method('getUID')
                ->will($this->returnValue('555555555555'));

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $aExtraMockMethods = array(
            'getUID',
            'getPath'
        );
        $oMockDataItem = $this->_getDataItem($aExtraMockMethods);
        $oMockDataItem->expects($this->exactly(2))
                ->method('getPath')
                ->will($this->returnValue('/home/energy/quantity'));
        $oMockDataItem->expects($this->once())
                ->method('getUID')
                ->will($this->returnValue('777777777777'));

        // Prepare a mocked version of the Services_AMEE_API object that can
        // be used in the construction of a Services_AMEE_ProfileItem object
        $oMockAPI = $this->getMock(
            'Services_AMEE_API'
        );
        $sSearchJSON = '
            {
              "profileItem":
                {
                  "modified": "2010-04-13T13:37:29+00:00",
                  "name": "testName",
                  "amount": {
                    "value": 123123123123123.669973,
                    "unit": "kg/year"
                  },
                  "startDate": "2010-04-13T13:37:00+00:00",
                  "uid": "888888888888",
                  "endDate": "2010-04-13T13:39:00+00:00",
                  "created": "2010-04-13T13:37:19+00:00",
                  "itemValues": [
                    {
                      "path": "someValue",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    }
                  ]
                }
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/profiles/555555555555/home/energy/quantity/888888888888'
                )
                ->will($this->returnValue($sSearchJSON));

        // Prepare a mocked version of the Service_AMEE_ProfileItem object that
        // has the _getAPI() method mocked and set to return the above mocked
        // version of the Services_AMEE_API
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            array('_getAPI'),
            array(),
            '',
            false
        );
        $oMockProfileItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Create the Services_AMEE_ProfileItem object
        $oMockProfileItem->__construct(
            array(
                $oMockProfile,
                $oMockDataItem,
                '888888888888'
            )
        );

        // Test that the object was created as expected
        $aExpectedInfo = array(
            'uid'         => '888888888888',
            'name'        => 'testName',
            'created'     => '2010-04-13T13:37:19+00:00',
            'modified'    => '2010-04-13T13:37:29+00:00',
            'profileUid'  => '555555555555',
            'path'        => '/home/energy/quantity',
            'dataItemUid' => '777777777777',
            'amount'      => '123123123123123.669973',
            'unit'        => 'kg',
            'perUnit'     => 'year',
            'startDate'   => '2010-04-13T13:37:00+00:00',
            'endDate'     => '2010-04-13T13:39:00+00:00'
        );
        $aInfo = $oMockProfileItem->getInfo();
        $this->assertEquals($aExpectedInfo, $aInfo);
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
        // Prepare a mocked version of the Services_AMEE_Profile object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            array('getUID'),
            array('1234567890AB')
        );
        $oMockProfile->expects($this->exactly(2))
                ->method('getUID')
                ->will($this->returnValue('121212121212'));

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $aExtraMockMethods = array(
            'getUID',
            'getPath'
        );
        $oMockDataItem = $this->_getDataItem($aExtraMockMethods);
        $oMockDataItem->expects($this->exactly(2))
                ->method('getPath')
                ->will($this->returnValue('/home/energy/quantity'));
        $oMockDataItem->expects($this->exactly(2))
                ->method('getUID')
                ->will($this->returnValue('66056991EE23'));

        // Prepare a mocked version of the Services_AMEE_API object that can
        // be used in the construction of a Services_AMEE_ProfileItem object
        $oMockAPI = $this->getMock(
            'Services_AMEE_API'
        );
        $sSearchJSON = '
            {
              "profileItems":
                [{
                  "modified": "2010-04-13T13:37:19+00:00",
                  "name": null,
                  "amount": {
                    "value": 2127.669973,
                    "unit": "g/week"
                  },
                  "startDate": "2010-04-13T13:37:00+00:00",
                  "uid": "7E941AC2DE82",
                  "dataItem": {
                    "Label": "gas",
                    "uid": "66056991EE23"
                  },
                  "endDate": "",
                  "created": "2010-04-13T13:37:19+00:00",
                  "itemValues": [
                    {
                      "path": "someValue",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    }
                  ]
                },
                {
                  "modified": "2010-04-13T13:37:20+00:00",
                  "name": null,
                  "amount": {
                    "value": 5180.393848,
                    "unit": "g/week"
                  },
                  "startDate": "2010-04-13T13:37:00+00:00",
                  "uid": "F11AF4561700",
                  "dataItem": {
                    "Label": "electricity",
                    "uid": "CDC2A0BA8DF3"
                  },
                  "endDate": "",
                  "created": "2010-04-13T13:37:20+00:00",
                  "itemValues": [
                    {
                      "path": "someValue",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    }
                  ]
                }]
            }';
        $oMockAPI->expects($this->once())
                ->method('get')
                ->with(
                    '/profiles/121212121212/home/energy/quantity',
                    array(
                        'returnUnit'    => 'g',
                        'returnPerUnit' => 'week'
                    )
                )
                ->will($this->returnValue($sSearchJSON));

        // Prepare a mocked version of the Service_AMEE_ProfileItem object that
        // has the _getAPI() method mocked and set to return the above mocked
        // version of the Services_AMEE_API
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            array('_getAPI'),
            array(),
            '',
            false
        );
        $oMockProfileItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Create the Services_AMEE_ProfileItem object
        $oMockProfileItem->__construct(
            array(
                $oMockProfile,
                $oMockDataItem,
                array(
                    'returnUnit'    => 'g',
                    'returnPerUnit' => 'week'
                )
            )
        );

        // Test that the object was created as expected
        $aExpectedInfo = array(
            'uid'         => '7E941AC2DE82',
            'name'        => '',
            'created'     => '2010-04-13T13:37:19+00:00',
            'modified'    => '2010-04-13T13:37:19+00:00',
            'profileUid'  => '121212121212',
            'path'        => '/home/energy/quantity',
            'dataItemUid' => '66056991EE23',
            'amount'      => '2127.669973',
            'unit'        => 'g',
            'perUnit'     => 'week',
            'startDate'   => '2010-04-13T13:37:00+00:00',
            'endDate'     => ''
        );
        $aInfo = $oMockProfileItem->getInfo();
        $this->assertEquals($aExpectedInfo, $aInfo);
    }

    /***************************************************************************
     * NON-CONSTRUCTOR TESTS
     **************************************************************************/

    /**
     * A private method to set up a set of test framework objects for the 
     * non-constructor tests.
     *
     * @return <array> An array containing, by index:
     *      0 => A mocked version of the Services_AMEE_Profile class;
     *      1 => A mocked version of the Services_AMEE_DataItem class;
     *      2 => A mocked version of the Services_AMEE_API class; and
     *      3 => A mocked version of the Services_AMEE_ProfileItem class.
     *
     *      These items are set up so that:
     *          - The Services_AMEE_ProfileItem object has been created, using
     *            the other mocked objects;
     *          - Additional expectations can be set on the first three objects,
     *            so that testing of non-constructor methods can be easily
     *            performed.
     */
    private function _getNonConstructorSetup()
    {
        // Prepare a mocked version of the Services_AMEE_Profile object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $oMockProfile = $this->getMock(
            'Services_AMEE_Profile',
            array('getUID'),
            array('111111111111')
        );
        $oMockProfile->expects($this->any())
                ->method('getUID')
                ->will($this->returnValue('111111111111'));

        // Prepare a mocked version of the Services_AMEE_DataItem object that
        // can be used in the construction of a Services_AMEE_ProfileItem object
        $aExtraMockMethods = array(
            'getUID',
            'getPath'
        );
        $oMockDataItem = $this->_getDataItem($aExtraMockMethods);
        $oMockDataItem->expects($this->any())
                ->method('getPath')
                ->will($this->returnValue('/home/energy/quantity'));
        $oMockDataItem->expects($this->any())
                ->method('getUID')
                ->will($this->returnValue('222222222222'));

        // Prepare a mocked version of the Services_AMEE_API object that can
        // be used in the construction of a Services_AMEE_ProfileItem object
        $oMockAPI = $this->getMock(
            'Services_AMEE_API'
        );
        $sSearchJSON = '
            {
              "profileItem":
                {
                  "modified": "2010-04-13T13:37:29+00:00",
                  "name": "",
                  "amount": {
                    "value": 20.37,
                    "unit": "kg/year"
                  },
                  "startDate": "2010-04-13T13:37:00+00:00",
                  "uid": "333333333333",
                  "endDate": "2010-04-13T13:39:00+00:00",
                  "created": "2010-04-13T13:37:19+00:00",
                  "itemValues": [
                    {
                      "path": "energyConsumption",
                      "value": "100",
                      "unit": "kWh",
                      "perUnit": "year"
                    },
                    {
                      "path": "currentReading",
                      "value": "0",
                      "unit": "kWh",
                      "perUnit": "year"
                    },
                    {
                      "path": "includesHeating",
                      "value": "false",
                      "unit": "",
                      "perUnit": ""
                    },
                    {
                      "path": "greenTariff",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    },
                    {
                      "path": "season",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    },
                    {
                      "path": "paymentFrequency",
                      "value": "",
                      "unit": "",
                      "perUnit": ""
                    },
                    {
                      "path": "massPerTime",
                      "value": "0",
                      "unit": "kg",
                      "perUnit": "year"
                    },
                    {
                      "path": "lastReading",
                      "value": "0",
                      "unit": "kWh",
                      "perUnit": "year"
                    },
                    {
                      "path": "deliveries",
                      "value": "",
                      "unit": "",
                      "perUnit": "year"
                    },
                    {
                      "path": "volumePerTime",
                      "value": "0",
                      "unit": "L",
                      "perUnit": "year"
                    }
                  ]
                }
            }';
        $oMockAPI->expects($this->any())
                ->method('get')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333'
                )
                ->will($this->returnValue($sSearchJSON));

        // Prepare a mocked version of the Service_AMEE_ProfileItem object that
        // has the _getAPI() method mocked and set to return the above mocked
        // version of the Services_AMEE_API
        $oMockProfileItem = $this->getMock(
            'Services_AMEE_ProfileItem',
            array('_getAPI'),
            array(),
            '',
            false
        );
        $oMockProfileItem->expects($this->once())
                ->method('_getAPI')
                ->will($this->returnValue($oMockAPI));

        // Create the Services_AMEE_ProfileItem object
        $oMockProfileItem->__construct(
            array(
                $oMockProfile,
                $oMockDataItem,
                '333333333333'
            )
        );

        // Test that the object was created as expected
        $aExpectedInfo = array(
            'uid'         => '333333333333',
            'name'        => '',
            'created'     => '2010-04-13T13:37:19+00:00',
            'modified'    => '2010-04-13T13:37:29+00:00',
            'profileUid'  => '111111111111',
            'path'        => '/home/energy/quantity',
            'dataItemUid' => '222222222222',
            'amount'      => '20.37',
            'unit'        => 'kg',
            'perUnit'     => 'year',
            'startDate'   => '2010-04-13T13:37:00+00:00',
            'endDate'     => '2010-04-13T13:39:00+00:00'
        );
        $aInfo = $oMockProfileItem->getInfo();
        $this->assertEquals($aExpectedInfo, $aInfo);

        $aReturn = array(
            0 => $oMockProfile,
            1 => $oMockDataItem,
            2 => $oMockAPI,
            3 => $oMockProfileItem
        );
        return $aReturn;
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::getDataItem() method
     * returns the Services_AMEE_DataItem used in the construction of the
     * Services_AMEE_ProfileItem object.
     */
    public function testGetDataItem()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Call the getDataItem() method
        $oObtainedDataItem = $oMockProfileItem->getDataItem();

        // Check that the returned AMEE API Data Item object is the same as
        // the one used to create the AMEE API Profile Item object
        $this->assertSame($oObtainedDataItem, $oMockDataItem);
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::getItemValue() method
     * returns false when an AMEE API Profile Item Value is requested that does
     * not exist for the AMEE API Profile Item.
     */
    public function testGetDataItemNotExists()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Call the getItemValue() method for an AMEE API Profile Item Value
        // that does not exist
        $bResult = $oMockProfileItem->getItemValue('doesNotExist');

        // Check that the returned value is false
        $this->assertSame($bResult, false);
    }
    
    /**
     * Test to ensure that the Services_AMEE_ProfileItem::getItemValue() method
     * returns correct values when an AMEE API Profile Item Value that exists is
     * requested.
     */
    public function testGetDataItemExists()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Call the getItemValue() method for an AMEE API Profile Item Value
        // that exists
        $aResult = $oMockProfileItem->getItemValue('energyConsumption');

        // Check that the returned value is as expected
        $aExpected = array(
            'path'    => 'energyConsumption',
            'value'   => 100,
            'unit'    => 'kWh',
            'perUnit' => 'year'
        );
        $this->assertEquals($aResult, $aExpected);

        // Call the getItemValue() method for an AMEE API Profile Item Value
        // that exists
        $aResult = $oMockProfileItem->getItemValue('massPerTime');

        // Check that the returned value is as expected
        $aExpected = array(
            'path'    => 'massPerTime',
            'value'   => 0,
            'unit'    => 'kg',
            'perUnit' => 'year'
        );
        $this->assertEquals($aResult, $aExpected);

        // Call the getItemValue() method for an AMEE API Profile Item Value
        // that exists
        $aResult = $oMockProfileItem->getItemValue('paymentFrequency');

        // Check that the returned value is as expected
        $aExpected = array(
            'path'    => 'paymentFrequency',
            'value'   => '',
            'unit'    => '',
            'perUnit' => ''
        );
        $this->assertEquals($aResult, $aExpected);
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateValues() method
     * correctly throws an exception if passed a non-array parameter.
     */
    public function testUpdateValuesValidateNotArrayError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oValidateException = new Exception(
            'Services_AMEE_ProfileItem::updateValues() called with ' .
            'non-array parameter'
        );

        // Call the updateValues() method
        try {
            $oMockProfileItem->updateValues('foo');
        } catch (Exception $oException) {
            // Test the exception was thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oValidateException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateValues() method
     * correctly throws an exception if passed an empty array parameter.
     */
    public function testUpdateValuesValidateEmptyArrayError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oValidateException = new Exception(
            'Services_AMEE_ProfileItem::updateValues() called with ' .
            'empty array parameter'
        );

        // Call the updateValues() method
        try {
            $oMockProfileItem->updateValues(array());
        } catch (Exception $oException) {
            // Test the exception was thrown
            $this->assertEquals(
                $oException->getMessage(),
                $oValidateException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateValues() method
     * correctly bubbles up an exception thrown by the Services_AMEE_API::put()
     * method.
     *
     * Also tests that the Services_AMEE_Profile::updateValues() method calls
     * the API correctly to set the updated values.
     */
    public function testUpdateValuesAPIPutError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oGetException = new Exception('Test API Exception');

        // Set that the API will throw this error
        $oMockAPI->expects($this->any())
                ->method('put')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333',
                    array(
                        'some' => 'value'
                    )
                )
                ->will($this->throwException($oGetException));

        // Call the updateValues() method
        try {
            $oMockProfileItem->updateValues(array('some' => 'value'));
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oGetException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateValues() method
     * correctly bubbles up an exception thrown by the Services_AMEE_API::get()
     * method.
     */
    public function testUpdateValuesAPIGetError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oGetException = new Exception('Test API Exception');

        // Set that the API will throw this error
        $oMockAPI->expects($this->any())
                ->method('get')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333'
                )
                ->will($this->throwException($oGetException));

        // Call the updateValues() method
        try {
            $oMockProfileItem->updateValues(array('some' => 'value'));
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oGetException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateOptions() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::_validateProfileOptionParamArray() method.
     */
    public function testUpdateOptionsValidateError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oValidateException = new Exception(
            'Services_AMEE_ProfileItem method called with option ' .
            'parameter array not actually being an array'
        );

        // Call the updateOptions() method
        try {
            $oMockProfileItem->updateOptions('foo');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertEquals(
                $oException->getMessage(),
                $oValidateException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateOptions() method
     * correctly bubbles up an exception thrown by the Services_AMEE_API::put()
     * method.
     *
     * Also tests that the Services_AMEE_Profile::updateOptions() method calls
     * the API correctly to set the updated options.
     */
    public function testUpdateOptionsAPIPutError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oGetException = new Exception('Test API Exception');

        // Set that the API will throw this error
        $oMockAPI->expects($this->any())
                ->method('put')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333',
                    array(
                        'name' => 'testName'
                    )
                )
                ->will($this->throwException($oGetException));

        // Call the updateOptions() method
        try {
            $oMockProfileItem->updateOptions(array('name' => 'testName'));
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oGetException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateOptions() method
     * correctly bubbles up an exception thrown by the Services_AMEE_API::get()
     * method.
     */
    public function testUpdateOptionsAPIGetError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oGetException = new Exception('Test API Exception');

        // Set that the API will throw this error
        $oMockAPI->expects($this->any())
                ->method('get')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333'
                )
                ->will($this->throwException($oGetException));

        // Call the updateOptions() method
        try {
            $oMockProfileItem->updateOptions(array('name' => 'testName'));
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oGetException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateReturn() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::_validateReturnUnitParamArray() method.
     */
    public function testUpdateReturnValidateError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oValidateException = new Exception(
            'Services_AMEE_ProfileItem method called with return unit ' .
            'parameter array not actually being an array'
        );

        // Call the updateReturn() method
        try {
            $oMockProfileItem->updateReturn('foo');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertEquals(
                $oException->getMessage(),
                $oValidateException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::updateReturn() method
     * correctly bubbles up an exception thrown by the Services_AMEE_API::get()
     * method.
     */
    public function testUpdateReturnAPIGetError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oGetException = new Exception('Test API Exception');

        // Set that the API will throw this error
        $oMockAPI->expects($this->any())
                ->method('get')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333'
                )
                ->will($this->throwException($oGetException));

        // Call the updateReturn() method
        try {
            $oMockProfileItem->updateReturn(array());
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oGetException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_ProfileItem::delete() method
     * correctly bubbles up an exception thrown by the
     * Services_AMEE_API::delete() method.
     */
    public function testDeleteAPIError()
    {
        list($oMockProfile, $oMockDataItem, $oMockAPI, $oMockProfileItem) =
            $this->_getNonConstructorSetup();

        // Prepare testing Exception to return
        $oAPIException = new Exception('API Test Exception');

        // Set the fact that the above exception will be thrown by the API
        // on delete, and set the call expectation for the method
        $oMockAPI->expects($this->once())
                ->method('delete')
                ->with(
                    '/profiles/111111111111/home/energy/quantity/333333333333'
                )
                ->will($this->throwException($oAPIException));

        // Call the delete() method
        try {
            $oMockProfileItem->delete();
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
