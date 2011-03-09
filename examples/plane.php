<?php

/*
 * This file is a simple example file showing how to create an AMEE profile,
 * find a data item UID, and create a profile item for a plan journey.
 *
 * PHP Version 5
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    James Smith <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */

require_once 'exampleConfig.php'; 
require_once 'Services/AMEE/DataItem.php';
require_once 'Services/AMEE/Profile.php';
require_once 'Services/AMEE/ProfileItem.php';

// Create a new profile
$oProfile = new Services_AMEE_Profile();
printf("Profile UID: %s\n", $oProfile->getUID());

// Get data item for a one-way plane journey between specific points
$sPath = '/transport/plane/generic';
$aOptions = array(
  'type' => 'auto',
  'size' => 'one way'
);
$oDataItemPlane = new Services_AMEE_DataItem($sPath, $aOptions);
printf("Data Item UID: %s\n", $oDataItemPlane->getUID());

// Create a profile item for a journey from Gatwick to LA
$aProfileItemValues = array(
    'IATACode1'          => "LGW",
    'IATACode2'          => "LAX",
    'numberOfPassengers' => 1
);
$oProfileItemPlane = new Services_AMEE_ProfileItem(
    array(
        $oProfile,
        $oDataItemPlane,
        $aProfileItemValues
    )
);

// Print out the CO2 value
$aTemp = $oProfileItemPlane->getInfo();
printf("CO2: %f %s\n", $aTemp['amount'], $aTemp['unit']);

?>
