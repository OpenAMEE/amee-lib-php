<?php

/* 
 * This file provides the Services_AMEE_Profile class. Please see the class
 * documentation for full details.
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

require_once 'Services/AMEE/BaseObject.php';

/**
 * The Services_AMEE_Profile class is used to represent an AMEE API Profile,
 * and provides all of the methods required to create (and delete) AMEE API
 * Profiles.
 *
 * An AMEE API Profile contains a set AMEE API Profile Items, which collectively
 * represent the consumption (and other things!) and the associated resulting
 * Greenhouse Gas (GHG) emissions (and other things!).
 * 
 * You are free to choose what an AMEE API Profile actually represents in your
 * application -- and of course, you can have many AMEE API Profiles, if you so
 * desire.
 *
 * For example, you may have one AMEE API Profile per user (person or business)
 * in your application, or you might have one AMEE API Profile per business unit
 * in your application. What you choose to represent with an AMEE API Profile
 * will very much depend on how you want to aggregate your data in your
 * application.
 *
 * For more information about AMEE API Profiles, please see:
 *      http://my.amee.com/developers/wiki/Profile
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Profile extends Services_AMEE_BaseObject
{

    /**
     * The constructor for the Services_AMEE_Profile class.
     *
     * @param <string> $sProfileUID An optional string, defining the UID of an
     *      existing AMEE API Profile. If passed in, the Services_AMEE_Profile
     *      object will be created on the assumption that the UID passed in is
     *      a valid AMEE API Profile UID; if no value is passed in, then a new
     *      AMEE API Profile will be created.
     * @return <object> A Services_AMEE_Profile object (either for the specified
     *      existing AMEE API Profile, or for the newly created AMEE API
     *      Profile), or an Exception object on error.
     */
    public function __construct($sProfileUID = null)
    {
        try {
            parent::__construct();
            if (is_null($sProfileUID)) {
                // Create a new AMEE API Profile - prepare the AMEE REST API
                // call path & options
                $sPath = '/profiles';
                $aOptions = array(
                    'profile' => 'true'
                );
                // Call the AMEE REST API
                $this->sLastJSON = $this->oAPI->post($sPath, $aOptions);
                // Process the result data
                $this->aLastJSON = json_decode($this->sLastJSON, true);
                // Set this object's UID
                $this->sUID = $this->aLastJSON['profile']['uid'];
            } else {
                // Create the AMEE API Profile on the basis of the Profile UID
                $this->sUID = $sProfileUID;
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to delete the AMEE Profile.
     *
     * @return <mixed> True on success; an Exception object otherwise.
     */
    public function delete()
    {
        try {
            // Prepare the AMEE REST API call path
            $sPath = '/profiles/' . $this->sUID;
            // Call the AMEE REST API
            $this->oAPI->delete($sPath);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

}

?>
