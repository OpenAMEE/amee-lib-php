<?php

/*
 * This file provides the Services_AMEE_AllTests class. Please see the class
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
require_once 'tests/unit/AllUnitTests.php';
require_once 'tests/integration/AllIntegrationTests.php';

/**
 * The Services_AMEE_AllTests class provides a convenient way of running all of
 * the PHPUnit unit & integration tests for the Services_AMEE package.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_AllTests extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $oTestSuite = new Services_AMEE_AllTests('Services_AMEE');

        // Add all of the unit tests
        $oTestSuite->addTestSuite(
            Services_AMEE_AllUnitTests::suite()
        );

        // Add all of the integration tests
        $oTestSuite->addTestSuite(
            Services_AMEE_AllIntegrationTests::suite()
        );

        return $oTestSuite;
    }

}

?>
