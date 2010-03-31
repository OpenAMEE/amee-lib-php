<?php

/*
 * This file provides the Services_AMEE_AllIntegrationTests class. Please see
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
require_once 'tests/testConfig.php';
//require_once 'tests/integration/AMEETest.php';

/**
 * The Services_AMEE_AllIntegrationTests class provides a convenient way of
 * running all of the PHPUnit integration tests for the Services_AMEE package.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_AllIntegrationTests extends PHPUnit_Framework_TestSuite
{

    public static function suite()
    {
        $oIntegrationTestSuite = new Services_AMEE_AllIntegrationTests(
            'Services_AMEE Integration Tests'
        );

        // Add all of the individual integration test classes
        //$oIntegrationTestSuite->addTestSuite(
        //    'Services_AMEE_IntegrationTest'
        //);

        return $oIntegrationTestSuite;
    }

}

?>
