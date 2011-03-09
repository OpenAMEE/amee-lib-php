<?php

/*
 * This file provides the Services_AMEE_Example_IntegrationMARVTest class.
 * Please see the class documentation for full details.
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

require_once 'Services/AMEE/DataItem.php';
require_once 'Services/AMEE/Profile.php';
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_Example_IntegrationMARVTest class provides a PHPUnit
 * integration test case that shows an example application process using the
 * AMEE REST API.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Example_IntegrationMARVTest extends PHPUnit_Framework_TestCase
{

    /**
     * A private array for storing data during & between tests. Uses PHPUnit's
     * return & parameter passing mechanism to maintain state.
     */
    private $aDataStore = array();

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the sample application create a new AMEE API Profile for
     * a new user that has signed up to use the application.
     */
    function testExampleNewProfile()
    {
        try {

            // Step 0: Before using the AMEE REST API PEAR Library, you need
            //      to ensure that your AMEE REST API server, API key and
            //      API password are defined. This has already been done in
            //      this example by the tests/testConfig.php file - although
            //      you would need to update this file if you wanted to actually
            //      run this script!

            // Step 1: A new user (let's call them "User A") has created an
            //      account in the application, ready to start adding their
            //      data. All data needs to go into an AMEE API Profile, and in
            //      this case. we're assuming that an AMEE API Profile
            //      represents a user. So, we create a new AMEE API Profile for
            //      the "User A".

            $oProfile = new Services_AMEE_Profile();

            // Step 2: The user's new AMEE API Profile has been created - get
            //      the UID of their new AMEE API Profile, so that the UID can
            //      be stored in the application as part of the user's account
            //      details, for later use. We NEED to store the AMEE API
            //      Profile UID somewhere, if we intend to remember that this
            //      AMEE API Profile "belongs" to "User A"!

            $this->aDataStore['sUserAProfileUID'] = $oProfile->getUID();

            // Step 3: Now that "User A" has an AMEE API Profile, the AMEE API
            //      Profile's metadata should be added, to configure the AMEE
            //      API Profile ready for use. Details on metadata can be found
            //      at http://explorer.amee.com/categories/Metadata.
            //
            //      For this example, however, there are no metadata items that
            //      are relevant, so, they do not need to be set.

            /*******************************************************************
             * End example code in this method -- the code below are assertions
             * for this integration test.
             ******************************************************************/

            // Assert that the AMEE API Profile created has a vaild UID
            $bResult = preg_match('/^[0-9A-Z]{12}$/', $oProfile->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Return the data store array for use in the next test
            return $this->aDataStore;

        } catch (Exception $oException) {

            echo "\n" . $oException->__toString() . "\n";

            // A real world appliction would deal with errors gracefully here,
            // and show the user a helpful error message. However, as this is
            // a PHPUnit integration test, we fail the test if an exception is
            // thrown!
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );

        }
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the sample application adds some AMEE API Profile Items
     * to the user's AMEE API Profile.
     *
     * @depends testExampleNewProfile
     */
    function testExampleAddProfileItems($aDataStore)
    {

        // Set up the private data store array on the basis of the previous test
        $this->aDataStore = $aDataStore;

        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile(
                $this->aDataStore['sUserAProfileUID']
            );

            // Step 2: Now that we have the user's AMEE API Profile, we can add
            //      their GHG generation items. Imagine that this sample
            //      application supports the tracking of GHG generation by
            //      car travel, based on US Greenhouse Gas Protocol standards.
            //      Firstly, we need to create the AMEE API Data Items for this
            //      type of GHG generation item.
            //
            //      To do this, firstly, we manually use the AMEE Explorer
            //      (http://explorer.amee.com/) to locate the category that the
            //      GHG generation item fall into; in this case:
            //      http://explorer.amee.com/categories/US_road_transport_by_Greenhouse_Gas_Protocol
            //
            //      Then, we select the appropriate Drill Down name/value pairs
            //      to obtain the required Data Items; in this case,
            //      "type/passenger car", "fuel/diesel" and
            //      "emissionStandard/1983-present". (These choices could
            //      either be hard coded into the application, if it was asking
            //      the user a question about a hard-coded type of car, or the
            //      choices may depend on user inputs about the type of car they
            //      have. This is up to you, and your application design.)
            //
            //      Finally, we create the AMEE API Data Item object based on
            //      the path and Drill Down options.

            $sPath = '/transport/ghgp/vehicle/us';
            $aOptions = array(
                'type'             => 'passenger car',
                'fuel'             => 'diesel',
                'emissionStandard' => '1983-present'
            );
            $oDataItemCar = new Services_AMEE_DataItem($sPath, $aOptions);

            // Step 3: Now we are ready to add the user's details of their car
            //      usage, based on inputs from the user that the sample
            //      application has collected.
            //
            //      In the case below, assume the application has asked the user
            //      about their car use, and determined:
            //
            //      - That they have consumed 2 gallons of diesel for their
            //        journey; and
            //      - That the journey distance was 100 miles.
            //
            //      In this example, notice that we are not specifying any kind
            //      of start date, end date or duration information -- the
            //      sample application in this case is assumed to be a simple
            //      calculator that allows the user to input total use, and
            //      convert this into GHG emissions, as opposed to a more
            //      complex application which would include tracking of use by
            //      time, and allow reporting on GHG emissions based on
            //      different reporting periods.
            //
            //      (It is possible to write more complex applicaions that do
            //      time period based tracking and reporting with the AMEE REST
            //      API, but this is not currently supported by this library.
            //      See the README.txt file for more details.)
            //
            //      Note that because the fuel consumed and the distance
            //      travelled are in units that are different from the defaults,
            //      two extra parameters are used in the input array to specify
            //      these values.

            $aProfileItemCarValues = array(
                'distance'          => 100,
                'distanceUnits'     => 'miles',
                'fuelConsumed'      => 2,
                'fuelConsumedUnits' => 'gallons'
            );
            $oProfileItemCar = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemCar,
                    $aProfileItemCarValues
                )
            );

            /*******************************************************************
             * End example code in this method -- the code below are assertions
             * for this integration test.
             ******************************************************************/

            // Assert that the retrieved AMEE API Profile has the expected UID
            $this->assertEquals(
                $oProfile->getUID(), $this->aDataStore['sUserAProfileUID'])
            ;

            // Assert that the AMEE API Data Item created has a valid UID
            $bResult = preg_match('/^[0-9A-Z]{12}$/', $oDataItemCar->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Data Items created has path as expected
            $this->assertEquals(
                $oDataItemCar->getPath(), '/transport/ghgp/vehicle/us'
            );

            // Assert that the AMEE API Profile Item created has a valid UID
            $bResult = preg_match(
                '/^[0-9A-Z]{12}$/', $oProfileItemCar->getUID()
            );
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Store the UID of the created AMEE API Data Item use in the next
            // test
            $this->aDataStore['sDataItemCarUID'] = $oDataItemCar->getUID();

            // Store the UIDs of the created AMEE API Profile Item for use in
            // the next test
            $this->aDataStore['sProfileItemCarUID'] =
                $oProfileItemCar->getUID();

            // Return the data store array for use in the next test
            return $this->aDataStore;

        } catch (Exception $oException) {

            echo $oException->getMessage();

            // A real world appliction would deal with errors gracefully here,
            // and show the user a helpful error message. However, as this is
            // a PHPUnit integration test, we fail the test if an exception is
            // thrown!
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );

        }
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the sample application reports on the GHG output for the
     * user's AMEE API Profile Items.
     *
     * @depends testExampleAddProfileItems
     */
    function testExampleReport($aDataStore)
    {

        // Set up the private data store array on the basis of the previous test
        $this->aDataStore = $aDataStore;

        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile(
                $this->aDataStore['sUserAProfileUID']
            );

            // Step 2: Now that the user has input their car use, the
            //      application can report the GHG use to the user, both in
            //      terms of each specific GHG, as well as in terms of CO2e.
            //
            //      To do this, the application needs to obtain the GHG
            //      emissions for each AMEE API Profile Item that exists in the
            //      user's AMEE API Profile.
            //
            //      Let's assume that your application stored the AMEE API
            //      Profile Item UID when it was created.

            // Step 2.1: Retrieve the existing AMEE API Profile Item

            $sPath = '/transport/ghgp/vehicle/us';
            $aOptions = array(
                'type'             => 'passenger car',
                'fuel'             => 'diesel',
                'emissionStandard' => '1983-present'
            );
            $oDataItemCar = new Services_AMEE_DataItem($sPath, $aOptions);

            $oProfileItemCar = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemCar,
                    $this->aDataStore['sProfileItemCarUID']
                )
            );

            // Step 2.3: The AMEE REST API supports returning GHG in all manner
            //      of different units (eg. g, kg, etc.) and time periods (which
            //      we are ignoring in this sample application).
            //
            //      The return units can be set when creating AMEE API Profile
            //      Items, and sensible defaults are always used, but just so
            //      you can see an exmaple, here's how the application can
            //      convert the return units, should you want to do so - here,
            //      we ensure that both AMEE API Profile Items are set to return
            //      their GHG totals in kilograms.

            $aReturnUnits = array(
                'returnUnit' => "kg"
            );

            $oProfileItemCar->updateReturn($aReturnUnits);

            // Step 2.4: Extract the GHG emission amounts (both CO2e and
            //      specific values) from the AMEE API Profile Item

            $aResult = array();

            $aTemp = $oProfileItemCar->getInfo();

            $aResult['co2e']            = $aTemp['amount'];
            $aResult['co2e_units']      = $aTemp['unit'];

            $aResult['co2e_dupe']       = $aTemp['amounts']['CO2e']['value'];
            $aResult['co2e_dupe_units'] = $aTemp['amounts']['CO2e']['unit'];

            $aResult['ch4']             = $aTemp['amounts']['CH4']['value'];
            $aResult['ch4_units']       = $aTemp['amounts']['CH4']['unit'];

            $aResult['n2o']             = $aTemp['amounts']['N2O']['value'];
            $aResult['n2o_units']       = $aTemp['amounts']['N2O']['unit'];

            $aResult['notes']           = $aTemp['notes'];

            // Step 2.5: Now that we have the GHG emissions, in kg, that would
            //      result from the user's car use, the sample application would
            //      be able to display the $aResult array values to the user
            //      appropriately here...

            /*******************************************************************
             * End example code in this method -- the code below are assertions
             * for this integration test.
             ******************************************************************/

            // Assert that the retrieved AMEE API Profile has the expected UID
            $this->assertEquals(
                $oProfile->getUID(), $this->aDataStore['sUserAProfileUID']
            );

            // Assert that the AMEE API Data Item created has a valid UID
            $bResult = preg_match('/^[0-9A-Z]{12}$/', $oDataItemCar->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Data Items created has path as expected
            $this->assertEquals(
                $oDataItemCar->getPath(), '/transport/ghgp/vehicle/us'
            );

            // Assert that the AMEE API Data Item created has the same UID as
            // the same AMEE API Data Item created in the previous test
            $this->assertEquals(
                $oDataItemCar->getUID(), $this->aDataStore['sDataItemCarUID']
            );

            // Assert that the AMEE API Profile Item created has a valid UID
            $bResult = preg_match(
                '/^[0-9A-Z]{12}$/', $oProfileItemCar->getUID()
            );
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Profile Item created has the same UID as
            // the same AMEE API Profile Item created in the previous test
            $this->assertEquals(
                $oProfileItemCar->getUID(),
                $this->aDataStore['sProfileItemCarUID']
            );

            // Assert that there are real GHG emissions available in the results
            // array. Note that we don't actually assert the expected GHG
            // values, as one of the advantages of the AMEE REST API is that,
            // if emissions standards are ever updated/changed/improved, the
            // AMEE REST API will update the emissions to reflect the
            // update/changed/improved standards!
            $this->assertTrue($aResult['co2e'] > 0);
            $this->assertEquals($aResult['co2e_units'], 'kg');

            $this->assertTrue($aResult['co2e_dupe'] > 0);
            $this->assertEquals($aResult['co2e_dupe_units'], 'kg');

            $this->assertTrue($aResult['ch4'] > 0);
            $this->assertEquals($aResult['ch4_units'], 'kg');

            $this->assertTrue($aResult['n2o'] > 0);
            $this->assertEquals($aResult['n2o_units'], 'kg');

            // Assert that the CO2e value returned in the main result section is
            // the same as the CO2e value returned in the Multiple Algorithm
            // Return Values section
            $this->assertEquals($aResult['co2e'], $aResult['co2e_dupe']);

            // Assert that there are three "notes" about the Multiple Algorithm
            // Return Values, and that these notes are as expected for the
            // /transport/ghgp/vehicle/us category
            $this->assertEquals(count($aResult['notes']), 3);
            $this->assertEquals(
                $aResult['notes'][0],
                "There are no biogenic CO2 emissions associated with this item"
            );
            $this->assertEquals(
                $aResult['notes'][1],
                "CH4 emissions converted to CO2e using a global warming potential of 21"
            );
            $this->assertEquals(
                $aResult['notes'][2],
                "N2O emissions converted to CO2e using a global warming potential of 310"
            );

            // Return the data store array for use in the next test
            return $this->aDataStore;

        } catch (Exception $oException) {

            // A real world appliction would deal with errors gracefully here,
            // and show the user a helpful error message. However, as this is
            // a PHPUnit integration test, we fail the test if an exception is
            // thrown!
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );

        }
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the user has deleted their account from the sample
     * application, and rather than re-using the AMEE API Profile for another
     * user (which is encouraged), the sample application will delete the AMEE
     * API Profile instead.
     *
     * @depends testExampleReport
     * @backupGlobals enabled
     */
    function testExampleDeleteProfile($aDataStore)
    {

        // Set up the private data store array on the basis of the previous test
        $this->aDataStore = $aDataStore;

        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile(
                $this->aDataStore['sUserAProfileUID']
            );

            // Step 2: Delete the user's AMEE API Profile. Can't be undone!

            $oProfile->delete();

        } catch (Exception $oException) {

            // A real world appliction would deal with errors gracefully here,
            // and show the user a helpful error message. However, as this is
            // a PHPUnit integration test, we fail the test if an exception is
            // thrown!
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );

        }
    }

}

?>
