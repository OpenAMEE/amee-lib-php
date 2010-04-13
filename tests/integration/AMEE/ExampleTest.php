<?php

/*
 * This file provides the Services_AMEE_Example_IntegrationTest class.
 * Please see the class documentation for full details.
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
require_once 'Services/AMEE/DataItem.php';
require_once 'Services/AMEE/Profile.php';
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_Example_IntegrationTest class provides a PHPUnit
 * integration test case that shows an example application process using the
 * AMEE REST API.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Example_IntegrationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @var <string> $sUserProfileUID Somewhere to store the AMEE API Profile
     *      UID for "User A" in the example.
     */
    private $sUserAProfileUID;

    /**
     * Two private variables which have nothing to do with the example code.
     * They are simply for PHPUnit integration testing.
     */
    private $sTestDataItemGasUID;
    private $sTestDataItemElectricityUID;

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

            $this->sUserAProfileUID = $oProfile->getUID();

            // Step 2.1: As this is a PHPUnit integration test, we'll just check
            //      that a valid AMEE API Profile UID has now been obtained from
            //      the AMEE REST API...

            $bResult = preg_match('/^[0-9A-F]{12}$/', $this->sUserAProfileUID);
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Step 3: Now that "User A" has an AMEE API Profile, the AMEE API
            //      Profile's metadata should be added, to configure the AMEE
            //      API Profile ready for use. Details on metadata can be found
            //      at http://explorer.amee.com/categories/Metadata.

            // Setp 3.1: To set up an AMEE API Profile with metadata, firstly
            //      create the AMEE API Data Item for the metadata path.

            $sPath = '/metadata';
            $oDataItemMetadata = new Services_AMEE_DataItem($sPath);

            // Step 3.2: As this is a PHPUnit integration test, we'll just check
            //      that a valid AMEE API Data Item has now been obtained from
            //      the AMEE REST API...

            $bResult = preg_match('/^[0-9A-F]{12}$/', $oDataItemMetadata->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Step 3.3: Now create an AMEE API Profile Item with the required
            //      metadata AMEE API Profile Item Values in "User A's" AMEE API
            //      Profile.
            //      
            //      Assuming your application allows users to store household
            //      Greenhouse Gas (GHG) emissions, we will set both the country
            //      and the number of people per household in the metadata, as
            //      described in the above link on metadata.

            $aProfileItemValues = array(
                'country'           => 'GB',
                'peopleInHousehold' => 3
            );
            $oProfileItemMetadata = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemMetadata,
                    $aProfileItemValues
                )
            );

            // Step 3.4: As this is a PHPUnit integration test, we'll just check
            //      that a valid AMEE API Profile Item has now been obtained
            //      from the AMEE REST API...

            $bResult = preg_match('/^[0-9A-F]{12}$/', $oProfileItemMetadata->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer


        } catch (Exception $oException) {

            // A real world appliction would deal with errors more gracefully
            // than just displaying them to the user, of course!
            echo $oException->getMessage();

        }
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the sample application adds some AMEE API Profile Items
     * to the user's AMEE API Profile.
     */
    function testExampleAddProfileItems()
    {
        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile($this->sUserAProfileUID);

            // Step 2: Now that we have the user's AMEE API Profile, we can add
            //      their GHG generation items. Imagine that this sample
            //      application supports the tracking of GHG generation by
            //      household utility use, such as gas and electricity. Firstly,
            //      we need to create the AMEE API Data Items for these types
            //      of GHG generation items.
            //
            //      To do this, firstly, we manually use the AMEE Explorer
            //      (http://explorer.amee.com/) to locate the category that the
            //      GHG generation items fall into; in this case:
            //      http://explorer.amee.com/categories/Energy_by_Quantity.
            //
            //      Then, we select the appropriate Drill Down name/value pairs
            //      to obtain the required Data Items; in this case, "type/gas"
            //      and "type/electricity".
            //
            //      Finally, we create the AMEE API Data Item objects based on
            //      the path and Drill Down options.

            $sPath = '/home/energy/quantity';
            $aOptions = array(
                'type' => 'gas'
            );
            $oDataItemGas = new Services_AMEE_DataItem($sPath, $aOptions);

            $sPath = '/home/energy/quantity';
            $aOptions = array(
                'type' => 'electricity'
            );
            $oDataItemElectricity = new Services_AMEE_DataItem($sPath, $aOptions);

            // Step 2.1: As this is a PHPUnit integration test, we'll just check
            //      that two valid AMEE API Data Items have now been obtained
            //      from the AMEE REST API, and store them for later testing

            $this->sTestDataItemGasUID = $oDataItemGas->getUID();
            $bResult = preg_match('/^[0-9A-F]{12}$/', $this->sTestDataItemGasUID);
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            $this->sTestDataItemElectricityUID = $oDataItemElectricity->getUID();
            $bResult = preg_match('/^[0-9A-F]{12}$/', $this->sTestDataItemElectricityUID);
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Step 3: Now we are ready to add the user's details of their gas
            //      and electricity usage, based on inputs from the user that
            //      the sample application has collected.
            //
            //      In the case below, assume the application has asked the user
            //      about their home gas and electricity use, and determined:
            //
            //      - That they have a start and end gas meter readings of
            //          "12345" and "12890 respectively;
            //      - That their home heating is provided by gas;
            //      - That they have used 500 kWh of electricty; and
            //      - They are using a green tarrif for their electricity.
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

            $aProfileItemGasValues = array(
                'lastReading'     => 12345,
                'currentReading'  => 12890,
                'includesHeating' => true
            );
            $oProfileItemGasUse = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemGas,
                    $aProfileItemGasValues
                )
            );

            $aProfileItemElectricityValues = array(
                'energyConsumption' => 5000,
                'greenTarrif'       => true
            );
            $oProfileItemElectricityUse = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemElectricity,
                    $aProfileItemElectricityValues
                )
            );

            // Step 3.1: As this is a PHPUnit integration test, we'll just check
            //      that two valid AMEE API Profile Items have now been obtained
            //      from the AMEE REST API...

            $bResult = preg_match('/^[0-9A-F]{12}$/', $oProfileItemGasUse->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            $bResult = preg_match('/^[0-9A-F]{12}$/', $oProfileItemElectricityUse->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

        } catch (Exception $oException) {

            // A real world appliction would deal with errors more gracefully
            // than just displaying them to the user, of course!
            echo $oException->getMessage();

        }
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the sample application reports on the GHG output for the
     * user's AMEE API Profile Items.
     */
    function testExampleReport()
    {
        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile($this->sUserAProfileUID);

            // Step 2: Now that the user has input their gas and electrictiy
            //      use, the application can report the GHG use to the user,
            //      by each item and in total.
            //
            //      To do this, the application needs to obtain the GHG
            //      emissions for each AMEE API Profile Item that exists in the
            //      user's AMEE API Profile.
            //
            //      There are two ways of doing this.
            //
            //      Firstly, your application could keep track of the AMEE API
            //      Profile Item UIDs for every AMEE API Profile Item created,
            //      if you want, and access the AMEE API Profile Items by UID.
            //
            //      However, in this case, the sample application did not keep
            //      track of the AMEE API Profile Item UIDs in the previous test
            //      when they were created, so the application needs to search
            //      for the items.
            //      
            //      The applicaiton knows that it only deals with AMEE API Data
            //      Items that are in the "/home/energy/quantity" path and with
            //      types "gas" and "electrictiy"; so, the application knows to
            //      look in these areas for existing AMEE API Profile Items.

            // Step 2.1: Create the AMEE API Data Items, as in the previous
            //      test.

            $sPath = '/home/energy/quantity';
            $aOptions = array(
                'type' => 'gas'
            );
            $oDataItemGas = new Services_AMEE_DataItem($sPath, $aOptions);

            $sPath = '/home/energy/quantity';
            $aOptions = array(
                'type' => 'electricity'
            );
            $oDataItemElectricity = new Services_AMEE_DataItem($sPath, $aOptions);

            // Step 2.2: As this is a PHPUnit integration test, we'll just check
            //      that two valid AMEE API Data Items have now been obtained
            //      from the AMEE REST API, and test them against the stored
            //      AMEE API Data Item UIDs from the previous test

            /**
             * @TODO Fix the assertions below, and assert the remainder of the
             *      test.
             */

//            $bResult = preg_match('/^[0-9A-F]{12}$/', $oDataItemGas->getUID());
//            $this->assertEquals($bResult, 1); // preg_matches returns an integer
//            $this->assertEquals($this->sTestDataItemGasUID, $oDataItemGas->getUID());
//
//            $bResult = preg_match('/^[0-9A-F]{12}$/', $oDataItemElectricity->getUID());
//            $this->assertEquals($bResult, 1); // preg_matches returns an integer
//            $this->assertEquals($this->sTestDataItemElectricityUID, $oDataItemElectricity->getUID());

            
            $this->markTestIncomplete();
            return;

            // Step 2.3: Search for existing AMEE API Profile Items by AMEE
            //      API Data Item.

            $oProfileItemGas = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemGas
                )
            );

            $oProfileItemElectricity = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemElectricity
                )
            );

            // Step 2.4: The AMEE REST API supports returning GHG in all manner
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

            $oProfileItemGas->updateReturn($aReturnUnits);

            $oProfileItemElectricity->updateReturn($aReturnUnits);

            // Step 2.5: Extract the GHG emission amounts from each AMEE API
            //      Profile Item, and calculate the total.
            
            $aResult = array();

            $aTemp = $oProfileItemGas->getInfo();
            $aResult['gas']       = $aTemp['amount'];
            $aResult['gas_units'] = $aTemp['unit'];

            $aTemp = $oProfileItemElectricity->getInfo();
            $aResult['electricity']       = $aTemp['amount'];
            $aResult['electricity_units'] = $aTemp['unit'];

            $aResult['total'] = $aResult['gas'] + $aResult['electricity'];
            $aResult['total_units'] = $aResult['gas_units'];

            // Step 2.6: Normally, this is where you would show the output of
            //      the totals to the user; instead, we're going to execute
            //      a PHPUnit assertion to check that the GHG totals returned
            //      are correct.

            $this->assertEquals($aResult['gas'],                0);
            $this->assertEquals($aResult['gas_units'],          'kg');
            $this->assertEquals($aResult['electricity'],        0);
            $this->assertEquals($aResult['electricity_units'], 'kg');
            $this->assertEquals($aResult['total'],              0);
            $this->assertEquals($aResult['total_units'],        'kg');

        } catch (Exception $oException) {

            // A real world appliction would deal with errors more gracefully
            // than just displaying them to the user, of course!
            echo $oException->getMessage();

        }
    }

    function testExampleUpdateProfile()
    {
        $this->markTestIncomplete();
    }

    /**
     * A PHPUnit integration test that simluates a sample "real world"
     * application's use of the AMEE REST API.
     *
     * In this test, the user has deleted their account from the sample
     * application, and rather than re-using the AMEE API Profile for another
     * user (which is encouraged), the sample application will delete the AMEE
     * API Profile instead.
     */
    function testExampleDeleteProfile()
    {
        try {

            // Step 1: Before we can add the user's AMEE API Profile Items, we
            //      need to retrieve their AMEE API Profile, of course. Luckily,
            //      we saved their AMEE API Profile UID.

            $oProfile = new Services_AMEE_Profile($this->sUserAProfileUID);

            // Step 2: Delete the user's AMEE API Profile. Can't be undone!

            $oProfile->delete();

        } catch (Exception $oException) {

            // A real world appliction would deal with errors more gracefully
            // than just displaying them to the user, of course!
            echo $oException->getMessage();

        }
    }

}

?>
