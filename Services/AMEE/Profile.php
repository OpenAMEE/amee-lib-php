<?php

/* 
 * This file provides the Services_AMEE_Profile class. Please see the class
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

/**
 * The Services_AMEE_Profile class is used to represent an AMEE Profile,
 * and provides all of the methods required to ...
 *
 * An AMEE Profile is a set of data that collectively represent the CO2
 * emissions of a person, group, organisation, etc. You are free to choose what
 * a profile actually represents in your application -- and of course, you can
 * have many profiles, if you so desire.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Profile
{

    /**
     * @var string $uid The UID of the AMEE Profile.
     */
    protected $uid;

    /**
     * A method to get an AMEE Profile Category description and contents for
     * the specificed AMEE Profile Category path.
     * 
     * @param string $sCategoryPath An optional string of the path of the
     *      desired AMEE Profile Category. For example, "/home" or
     *      "/home/energy/quantity". If not supplied, the
     * @param array $aOptions ...
     * @return
     */
    public function getCategory($sCategoryPath = null, $aOptions = null)
    {
        return null;
    }

    /**
     * A method to delete this AMEE Profile.
     *
     * @return
     */
    public function delete()
    {
        return null;
    }

    /**
     * A method to create a new AMEE Profile Item (in this AMEE Profile) ...
     *
     * @param Service_AMEE_DataItem $oDataItem The AMEE Data Item that
     *      corresponds to the AMEE Profile Item that should be created.
     * @param array $aOptions ...
     * @return object A Service_AMEE_ProfileItem object represeting the AMEE
     *      Profile Item created, or an exception if an error occurred.
     */
    public function createItem($oDataItem, $aOptions = null)
    {
        return null;
    }

    /**
     * A method to retrieve an AMEE Profile Item (from this AMEE Profile) ...
     *
     * @param string $sProfileItemUID The AMEE Profile Item UID.
     * @return object The requested AMEE Profile Item as a
     *      Service_AMEE_ProfileItem object, or an exception if an error
     *      occurred.
     */
    public function getItem($sProfileItemUID)
    {
        return null;
    }

}

?>
