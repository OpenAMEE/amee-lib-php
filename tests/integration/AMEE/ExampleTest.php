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
require_once 'Services/AMEE/Profile.php';
require_once 'Services/AMEE/ProfileItem.php';

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

            // Step 1: A new user (let's call them "User A" has created an
            //      account in your application, ready to start inputting their
            //      data. Their data needs to go into an AMEE API Profile, so in
            //      this case, we're assuming that an AMEE API Profile
            //      represents a user. So, we create a new AMEE API Profile for
            //      the "User A".
            $oProfile = new Services_AMEE_Profile();
        
            // Step 2: The user's new AMEE API Profile has been created - get
            //      the UID of their new AMEE API Profile, so that the UID can
            //      be stored in your application as part of the user's account
            //      details, for later use. You NEED to store the AMEE API
            //      Profile UID somewhere, if you intend to remember that this
            //      AMEE API Profile "belongs" to "User A"!
            $this->sUserAProfileUID = $oProfile->getUID();

            // Step 3: Now that "User A" has an AMEE API Profile, the AMEE API
            //      Profile's metadata should be added, to configure the AMEE
            //      API Profile ready for use. Details on metadata can be found
            //      at http://explorer.amee.com/categories/Metadata.

            // Setp 3.1: To set up an AMEE API Profile with metadata, firstly
            //      create the AMEE API Data Item for the metadata path.
            $sPath = '/metadata';
            $oDataItemMetadata = new Services_AMEE_DataItem($sPath);

            // Step 3.2: Now create an AMEE API Profile Item with the required
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


            print_r($oProfileItemMetadata->getInfo());


            echo "\nSearching for metadata profile item:";
            echo "\n";
            $oProfileItemMetadata2 = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemMetadata,
                    array('returnUnit' => 'g')
                )
            );

            print_r($oProfileItemMetadata2->getInfo());

            $oProfileItemMetadata2->updateReturn(
                array('returnPerUnit' => 'month')
            );

            print_r($oProfileItemMetadata2->getInfo());

            echo "\nDELETING!\n";

            $oProfileItemMetadata2->delete();

            $oProfile->delete();


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

        } catch (Exception $oException) {

            // Deal with errors gracefully here!
            echo $oException->getMessage();

        }
    }

}

?>
