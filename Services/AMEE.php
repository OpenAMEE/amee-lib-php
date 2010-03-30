<?php

/*
 * This file provides the Services_AMEE class. Please see the class
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

require_once 'Services/AMEE/API.php';

/**
 * The Services_AMEE class provides the single, top-level AMEE REST API account
 * method which allows you to obtain all of the AMEE Profiles that exist within
 * your account.
 *
 * Please see the Services_AMEE_Profile class for more details about AMEE
 * Profiles.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE
{

    private $oAPI;

    function __construct()
    {
        $this->oAPI = new Services_AMEE_API();
    }

    /**
     * A method to get all of the AMEE Profiles that exist in the current
     * account.
     *
     * @return <mixed> An array of all of the AMEE Profiles that exist, as
     *      Services_AMEE_Profile objects on success; an Exception object
     *      otherwise.
     */
    public function getProfiles()
    {
        // Prepare the AMEE REST API call & options
        $sPath = '/profiles';
        // Call the AMEE REST API
        try {
            $aResult = $this->oAPI->get($sPath);
        } catch (Exception $oException) {
            throw $oException;
        }
        // Process the result array


        return $aResult;
    }

}

?>
