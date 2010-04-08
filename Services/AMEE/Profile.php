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

require_once 'Services/AMEE/BaseItemObject.php';
require_once 'Services/AMEE/Observer.php';
require_once 'Services/AMEE/API.php';
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_Profile class is used to represent an AMEE Profile,
 * and provides all of the methods required to create and delete AMEE Profiles,
 * obtain the details of AMEE Profile Categories within the AMEE Profile, and
 * also to create new and obtain existing AMEE Profle Items within the AMEE
 * Profile.
 *
 * An AMEE Profile is a set of data that collectively represent the CO2
 * emissions of a person, group, organisation, etc. You are free to choose what
 * a profile actually represents in your application -- and of course, you can
 * have many profiles, if you so desire.
 *
 * For more information about AMEE Profiles, please see:
 *      http://my.amee.com/developers/wiki/Profile
 *
 * For more information about AMEE Profile Categories, please see:
 *      http://my.amee.com/developers/wiki/ProfileCategory
 *
 * Please see the Services_AMEE_Profile_Item class for more details about AMEE
 * Profile Items.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Profile extends Services_AMEE_BaseItemObject
    implements Services_AMEE_Observer
{

    /**
     * @var <array> $aProfileItems An array of the Services_AMEE_ProfileItem
     *      objects, indexed by AMEE Profile Item UID.
     */
    private $aProfileItems = array();

    /**
     * @var <boolean> $bCompleteList Is the list of AMME Profile Items stored in
     *      this object complete, or are there more AMEE Profile Items not yet
     *      loaded?
     */
    private $bCompleteList = false;

    /**
     * @var <array> $aObservingProfileLists An array of observing
     * Services_AMEE_ProfileList objects. Normally, only expect there to be one
     * of these, but you can have more if you really want.
     */
    private $aObservingProfileLists;

    /**
     * The constructor for the Services_AMEE_Profile class.
     *
     * @param <Services_AMEE_ProfileList> $oProfileList The instance of the
     *      Services_AMEE_ProfileList class that is the observer of the new
     *      Services_AMEE_Profile object to be created.
     * @param <array> $aProfileData An optional array of existing AMEE Profile
     *      information. If passed in, will create a Services_AMEE_Profile
     *      object for an AMEE Profile that already exists in AMEE. Must
     *      contiain keys 'uid', 'created' and 'modified' to supply the already
     *      existing AMEE Profile UID, created date and modified date.
     * @param <boolean> $bSetAllProfileItems An optional parameter, when true,
     *      causes all AMEE Profile Items to be obtained and set; by default, only
     *      up to the first 10 AMEE Profiles will be set, for faster object
     *      creation time.
     * @return <object> The created Services_AMEE_Profile object (either for the
     *      specified AMEE Profile that already existed, or for the newly
     *      created AMEE Profile); an Exception object otherwise.
     */
    public function __construct($oProfileList, $aProfileData = null, $bSetAllProfileItems = false)
    {
        try {
            parent::__construct();
            $this->register($oProfileList);
            if (is_array($aProfileData)) {
                // Ensure that all required information to create an existing
                // AMEE Profile object is present
                if (!isset($aProfileData['uid'])) {
                    throw new Services_AMME_Exception(
                        'Missing UID parameter, which is required to create ' .
                        'an AMEE Profile object for an existing AMEE Profile'
                    );
                }
                if (!isset($aProfileData['created'])) {
                    throw new Services_AMME_Exception(
                        'Missing created date parameter, which is required ' .
                        'to create an AMEE Profile object for an existing ' .
                        'AMEE Profile'
                    );
                }
                if (!isset($aProfileData['modified'])) {
                    throw new Services_AMME_Exception(
                        'Missing modified date parameter, which is required ' .
                        'to create an AMEE Profile object for an existing ' .
                        'AMEE Profile'
                    );
                }
                // Create the AMEE Profile on the basis of the information passed
                // into the constructor
                $this->sUID      = $aProfileData['uid'];
                $this->sCreated  = $this->_formatDate($aProfileData['created']);
                $this->sModified = $this->_formatDate($aProfileData['modified']);
                // As this is NOT a new AMEE API Profile, there may be existing
                // AMEE API Profile Items present - fet up to the first 10 AMEE
                // Profiles Items now
                $this->setProfileItemss();
                // Do more AMEE Profile Items need to be set?
                if (!$this->allProfileItemsSet() && $bSetAllProfileItems) {
                    // Get them ALL
                    $this->setProfileItems(1, $this->aLastJSON['pager']['items']);
                }
                // Notify any observing classes of this AMEE Profile object's
                // creation
                $this->_notifyObserversNewChild();
                return;
            }
            // Create a new AMEE Profile - prepare the AMEE REST API call path &
            // options
            $sPath = '/profiles';
            $aOptions = array(
                'profile' => 'true'
            );
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->post($sPath, $aOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Set this object's UID, created date and modified date
            $this->sUID      = $this->aLastJSON['profile']['uid'];
            $this->sCreated  = $this->_formatDate($this->aLastJSON['profile']['created']);
            $this->sModified = $this->_formatDate($this->aLastJSON['profile']['modified']);
            // Notify any observing classes of this AMEE Profile object's
            // creation
            $this->_notifyObserversNewChild();
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to allow a Services_AMEE_ProfileList object to register with
     * this object as an observer, so that it can be updated if this AMEE
     * Profile is created or deleted.
     *
     * @param <Services_AMEE_ProfileList> $oProfileList
     */
    public function register($oProfileList)
    {
        $this->aObservingProfileLists[] = $oProfileList;
    }

    /**
     * A private method to perform the task of notifying any observing objects
     * of the fact that this is a new AMEE Profile object that has been created.
     */
    private function _notifyObserversNewChild()
    {
        foreach ($this->aObservingProfileLists as $oObserver) {
            $oObserver->newChild($this->sUID, $this);
        }
    }

    /**
     * A private method to perform the task of notifying any observing objects
     * of the fact that this is a new AMEE Profile object that has been deleted.
     */
    private function _notifyObserversDeletedChild()
    {
        foreach ($this->aObservingProfileLists as $oObserver) {
            $oObserver->deletedChild($this->sUID);
        }
    }

    /**
     * An interface-required method to allow the this class to be notified
     * when a new AMEE Profile Item object has been created.
     *
     * @param <string> $sUID The UID of the AMEE Profile Item object that has
     *      been created.
     * @param <object> $oChild The AMEE Profile Item object that has been
     *      created.
     */
    public function newChild($sUID, $oChild)
    {
        if (!isset($this->aProfileItems[$sUID])) {
            $this->aProfileItems[$sUID] = $oChild;
        }
    }

    /**
     * An interface-required method to allow this class to be notified
     * when an AMEE Profile Item object is deleted.
     *
     * @param <string> $sUID The UID of the AMEE Profile Item that has been
     *      deleted.
     */
    public function deletedChild($sUID)
    {
        if (isset($this->aProfileItems[$sUID])) {
            unset($this->aProfileItems[$sUID]);
        }

    }

    /**
     * A method to get the required AMEE Profile Item data that exists in the
     * defined AMEE REST API Profile and create and the associated
     * Service_AMEE_ProfileItem objects in this object.
     *
     * @param <integer> $iPage Optional page number of the AMEE Profile Item
     *      items to return. Default is the first page.
     * @param <integer> $iItemsPerPage Optional number of AMEE Profile Item
     *      items to return per page. Default is 10.
     */
    public function setProfileItems($iPage = 1, $iItemsPerPage = 10)
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
            $this->aProfiles[$aProfile['uid']] = $oProfile;
        }
        // Are all AMEE Profiles (now) set?
        if (count($this->aProfiles) == $this->aLastJSON['pager']['items']) {
            $this->bCompleteList = true;
        } else {
            $this->bCompleteList = false;
        }
    }

    /**
     * A method to determine if all AMEE Profile Items in the defined AMEE REST
     * API Profile have been set in the current Services_AMEE_Profile object or
     * not.
     *
     * @return <boolean> True if all AMEE Profile Items are set in the object,
     *      false otherwise.
     */
    public function allProfileItemsSet()
    {
        return $this->bCompleteList;
    }

    /**
     * A method to delete the AMEE Profile.
     *
     * @return <mixed> True on success; an Exception object otherwise.
     */
    public function delete()
    {
       // Prepare the AMEE REST API call path
        $sPath = '/profiles/' . $this->sUID;
        // Call the AMEE REST API
        try {
            echo $this->oAPI->delete($sPath);
        } catch (Exception $oException) {
            throw $oException;
        }
        // Notify any observing classes of this AMEE Profile object's deletion
        $this->_notifyObserversDeletedChild();
    }

}

?>
