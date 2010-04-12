<?php

/*
 * This file provides the Services_AMEE_AllUnitTests class. Please see the class
 * documentation for full details.
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
require_once 'tests/testConfig.php';
require_once 'tests/unit/AMEE/ExceptionTest.php';
require_once 'tests/unit/AMEE/BaseObjectTest.php';
require_once 'tests/unit/AMEE/BaseItemObjectTest.php';
require_once 'tests/unit/AMEE/APITest.php';
//require_once 'tests/unit/AMEE/ProfileTest.php';
//require_once 'tests/unit/AMEE/ProfileItemTest.php';

/**
 * The Services_AMEE_AllUnitTests class provides a convenient way of running all
 * of the PHPUnit unit tests for the Services_AMEE package.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_AllUnitTests extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        // Create the test suite
        $oUnitTestSuite = new Services_AMEE_AllUnitTests();

        // Add all of the individual unit test classes
        $oUnitTestSuite->addTestSuite('Services_AMEE_Exception_UnitTest');
        $oUnitTestSuite->addTestSuite('Services_AMEE_BaseObject_UnitTest');
        $oUnitTestSuite->addTestSuite('Services_AMEE_BaseItemObject_UnitTest');
        $oUnitTestSuite->addTestSuite('Services_AMEE_API_UnitTest');
//        $oUnitTestSuite->addTestSuite('Services_AMEE_Profile_UnitTest');
//        $oUnitTestSuite->addTestSuite('Services_AMEE_ProfileItem_UnitTest');

        // Return the test suite
        return $oUnitTestSuite;
    }

}

?>
