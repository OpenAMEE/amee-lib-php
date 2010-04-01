<?php

/*
 * This file provides the Services_AMEE_ProfileList_IntegrationTest class.
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
 * The Services_AMEE_ProfileList_IntegrationTest class provides the PHPUnit
 * integration test cases for the Services_AMEE_ProfileList class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileList_IntegrationTest extends PHPUnit_Framework_TestCase
{

    /**
     * @TODO Make a real test
     */
    function testGetProfiles()
    {
        $oProfileList = new Services_AMEE_ProfileList();
        echo "\nLIST OF ALL PROFILES\n";
        print_r($oProfileList->getProfileInfo());
    }

}

?>
