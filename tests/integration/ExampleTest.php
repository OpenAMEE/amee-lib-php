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
require_once 'Services/AMEE/ProfileList.php';

/**
 * The Services_AMEE_Example_IntegrationTest class provides a PHPUnit
 * integration test case that shows an example application process using the
 * API.
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
     * A PHPUnit test that emulates a "real world" example use of the AMEE API
     * where working with a new AMEE Profile.
     *
     * Your application lets users create a new account, add details of their
     * CO2 generation items, and view their CO2 output. This example shows the
     * details of doing this.
     */
    function testExampleNewProfile()
    {
        try {

            // Step 1: Initialise the Services_AMEE_ProfileList class, which is
            //      used to manage AMEE API Profiles.
            $oProfileList = new Services_AMEE_ProfileList();

            // Step 2: The user has created a new account - we therefore need to
            //      create a new AMEE API Profile to store their CO2 generation
            //      items.
            $oProfile = new Services_AMEE_Profile($oProfileList);

            // Step 3: The user's new AMEE API Profile has been created - get
            //      the UID of this new Profile, so that it can be stored in
            //      your application next to the user's account details, for
            //      later use.
            $this->sUserAProfileUID = $oProfile->getUID();

            // Step 4: Now that the user has an AMEE API Profile, the Profile's
            //      metadata should be added, to configure the Profile ready
            //      for use. Details on metadata can be found at
            //      http://explorer.amee.com/categories/Metadata.
            //
            // Setp 4.1: To set up an AMEE API Profile with metadata, firstly
            //      create the AMEE API Data Item for the metadata path.
            $sPath = '/metadata';
            $oDataItemMetadata = new Services_AMEE_DataItem($sPath);

            // Step 4.2: Now create an AMEE API Profile Item with the required
            //      metadata items for the AMEE API Profile. Assuming your
            //      application allows users to store household CO2 emissions,
            //      we will set both the country and the number of people per
            //      household in the metadata.
            $aProfileItemValues = array(
                'country'           => '',
                'peopleInHousehold' => 3
            );
            $oProfileItemMetadata = new Services_AMEE_ProfileItem(
                $oProfile,
                $oDataItemMetadata,
                $aProfileItemValues
            );


//
//            // Step 4: Now that the user has an AMEE API Profile, they can add
//            //      their CO2 generation items via your application. Imagine
//            //      that your application supports the tracking of CO2
//            //      generation by household utility use, such as gas and
//            //      electricity. Firstly, you need to create the AMEE API Data
//            //      Items for these types of CO2 generation items.
//            //
//            // To do this, firstly, use the AMEE Explorer
//            //      (http://explorer.amee.com/) to locate the category that the
//            //      CO2 generation items fall into; in this case:
//            //      http://explorer.amee.com/categories/Energy_by_Quantity.
//            //
//            // Then, select the appropriate Drill Down name/value pairs to
//            //      obtain the required Data Items; in this case, "type/gas" and
//            //      "type/electricity".
//            //
//            // Finally, create the AMEE API Data Item objects based on the path
//            // and Drill Down options.
//            $sPath = '/home/energy/quantity';
//            $aOptions = array(
//                'type' => 'gas'
//            );
//            $oDataItemGas = new Services_AMEE_DataItem($sPath, $aOptions);
//
//            $sPath = '/home/energy/quantity';
//            $aOptions = array(
//                'type' => 'electricity'
//            );
//            $oDataItemElectricity = new Services_AMEE_DataItem($sPath, $aOptions);
//
//            // Step 5: Add the user's details of their gas and electricity
//            //      usage, based on inputs from the user that your application
//            //      will have collected...
//            $sGas;

        } catch (Exception $oException) {

            // Deal with errors gracefully here!
            echo $oException->getMessage();
            
        }
    }

    function testExampleUpdateProfile()
    {

    }

    /**
     * A PHPUnit test that emulates a "real world" example use of the AMEE API
     * where working with an existing AMEE Profile.
     *
     * Your user has deleted their account, and you want to remove their AMEE
     * API Profile.
     */
    function testExampleDeleteProfile()
    {
        try {

            // Step 1: Initialise the Services_AMEE_ProfileList class, which is
            //      used to manage AMEE Profiles
            $oProfileList = new Services_AMEE_ProfileList();

            // Step 2: Check to ensure

        } catch (Exception $oException) {

            // Deal with errors gracefully here!
            echo $oException->getMessage();

        }
    }

}

?>
