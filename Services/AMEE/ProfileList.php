<?php

/*
 * This file provides the Services_AMEE_ProfileList class. Please see the class
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

require_once 'Services/AMEE/BaseObject.php';
require_once 'Services/AMEE/Observer.php';
require_once 'Services/AMEE/API.php';
require_once 'Services/AMEE/Profile.php';

/**
 * The Services_AMEE_ProfileList class provides the means for obtaining the
 * AMEE Profiles that exist within an AMEE REST API account.
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
class Services_AMEE_ProfileList extends Services_AMEE_BaseObject
    implements Services_AMEE_Observer
{

    /**
     * @var <array> $aProfiles An array of the Services_AMEE_Profile objects,
     *      indexed by AMEE Profile UID.
     */
    private $aProfiles = array();

    /**
     * @var <boolean> $bCompleteList Is the list of AMME Profiles stored in
     *      this object complete, or are there more AMEE Profiles not yet
     *      loaded?
     */
    private $bCompleteList = false;

    /**
     * The constructor for the Services_AMEE_ProfileList class.
     *
     * @param <boolean> $bSetAllProfiles An optional parameter, when true,
     *      causes all AMEE Profiles to be obtained and set; by default, only
     *      up to the first 10 AMEE Profiles will be set, for faster object
     *      creation time.
     */
    function __construct($bSetAllProfiles = false)
    {
        parent::__construct();
        try {
            // Get up to the first 10 AMEE Profiles
            $this->setProfiles();
            // Do more AMEE Profiles need to be set?
            if (!$this->allProfilesSet() && $bSetAllProfiles) {
                // Get them ALL
                $this->setProfiles(1, $this->aLastJSON['pager']['items']);
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }
    
    /**
     * An interface-required method to allow the this class to be notified
     * when a new AMEE Profile object has been created.
     *
     * @param <string> $sUID The UID of the AMEE Profile object that has been
     *      created.
     * @param <object> $oChild The AMEE Profile object that has been created.
     */
    public function newChild($sUID, $oChild)
    {
        if (!isset($this->aProfiles[$sUID])) {
            $this->aProfiles[$sUID] = $oChild;
        }
    }

    /**
     * An interface-required method to allow this class to be notified
     * when an AMEE Profile object is deleted.
     *
     * @param <string> $sUID The UID of the AMEE Profile that has been deleted.
     */
    public function deletedChild($sUID)
    {
        if (isset($this->aProfiles[$sUID])) {
            unset($this->aProfiles[$sUID]);
        }

    }

    /**
     * A method to get the required AMEE Profile data that exists in the defined
     * AMEE REST API account and create and the associated Service_AMEE_Profile
     * objects in this object.
     *
     * @param <integer> $iPage Optional page number of the AMEE Profile items
     *      to return. Default is the first page.
     * @param <integer> $iItemsPerPage Optional number of AMEE Profile items
     *      to return per page. Default is 10.
     */
    public function setProfiles($iPage = 1, $iItemsPerPage = 10)
    {
        // Prepare the AMEE REST API call path & options
        $sPath = '/profiles';
        $aOptions = array(
            'page'         => $iPage,
            'itemsPerPage' => $iItemsPerPage
        );
        // Call the AMEE REST API
        try {
            $this->sLastJSON = $this->oAPI->get($sPath, $aOptions);

        } catch (Exception $oException) {
            throw $oException;
        }
        // Process the result data
        $this->aLastJSON = json_decode($this->sLastJSON, true);
        // Create and set the AMEE Profiles found
        foreach ($this->aLastJSON['profiles'] as $aProfile) {            
            // Don't create and set for already existing AMEE Profiles
            if (isset($this->aProfiles[$aProfile['uid']])) {
                continue;
            }
            $aProfileData = array(
                'uid'      => $aProfile['uid'],
                'created'  => $this->_formatDate($aProfile['created']),
                'modified' => $this->_formatDate($aProfile['modified'])
            );
            $oProfile = new Services_AMEE_Profile($this, $aProfileData);
        }
        // Are all AMEE Profiles (now) set?
        if (count($this->aProfiles) == $this->aLastJSON['pager']['items']) {
            $this->bCompleteList = true;
        } else {
            $this->bCompleteList = false;
        }
    }

    /**
     * A method to determine if all AMEE Profiles in the defined AMEE REST API
     * account have been set in the current Services_AMEE_ProfileList object or
     * not.
     *
     * @return <boolean> True if all AMEE Profiles are set in the object, false
     *      otherwise.
     */
    public function allProfilesSet()
    {
        return $this->bCompleteList;
    }

    /**
     * A method to return the details of all known AMEE Profiles in the defined
     * AMEE REST API account. Will only return the details of AMEE Profiles set.
     * Use the allProfilesSet() method to determing if all AMEE Profiles are set
     * or not.
     *
     * @return <array> An array of AMEE Profile information, indexed by AMEE
     *      Profile UID valies, in the array format defined by the
     *      Services_AMEE_Profile::getInfo() method.
     */
    public function getProfileInfo()
    {
        $aReturn = array();
        foreach ($this->aProfiles as $oProfile) {
            $aReturn[$oProfile->getUID()] = $oProfile->getInfo();
        }
        return $aReturn;
    }

    /**
     * A method to return an AMEE Profile from the list of currently set AMEE
     * Profiles.
     *
     * @param <string> $sUID The UID of the AMEE Profile to return.
     * @return <mixed> Returns the Services_AMEE_Profle object for the specified
     *      AMEE Profie UID, or an Exception if the AMEE Profile is not present.
     */
    public function getProfile($sUID)
    {
        if (isset($this->aProfiles[$sUID])) {
            return $this->aProfiles[$sUID];
        }
        throw new Services_AMEE_Exception(
            'Requested AMEE Profile with UID ' . $sUID . ' is not currently ' .
            'set or does not exist'
        );
    }

}

?>
