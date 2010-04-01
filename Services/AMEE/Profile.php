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
{

    /**
     * @var <array> $aObservingProfileLists An array of observing
     * Services_AMEE_Profile objects. Normally, only expect there to be one of
     * these, but you can have more if you really want.
     */
    private $aObservingProfileLists;

    /**
     * The constructor for the Services_AMEE_Profile class.
     *
     * @param <Services_AMEE_ProfileList> $oProfileList The instance of the
     *      Services_AMEE_Profile class in use in the script.
     * @param <array> $aProfileData An optional array of AMEE Profile
     *      information, the intention is to create a Services_AMEE_Profile
     *      object for an AMEE Profile that already exists. Must contiain keys
     *      'uid', 'created' and 'modified' to supply the already existing AMEE
     *      Profile UID, created date and modified date. If no array is
     *      supplied, or the array does not contain the complete required
     *      information, a new AMEE Profile will be attempted to be created.
     * @return <object> The created Services_AMEE_Profile object (either for the
     *      specified AMEE Profile that already existed, or for the newly
     *      created AMEE Profile); an Exception object otherwise.
     */
    public function __construct($oProfileList, $aProfileData = array())
    {
        try {
            parent::__construct();
            $this->register($oProfileList);
            if (isset($aProfileData['uid'])
                    && isset($aProfileData['created'])
                    && isset($aProfileData['modified'])) {
                // Create the AMEE Profile on the basis of the information passed
                // into the constructor
                $this->sUID      = $aProfileData['uid'];
                $this->sCreated  = $this->_formatDate($aProfileData['created']);
                $this->sModified = $this->_formatDate($aProfileData['modified']);
                // Notify any observing classes of this AMEE Profile object's
                // creation
                $this->_notifyObserversNewChild();
                return;
            }
            // Prepare the AMEE REST API call path & options
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
        foreach ($this->aObservingProfileLists as $oObservers) {
            $oObservers->newChild($this->sUID, $this);
        }
    }

    /**
     * A private method to perform the task of notifying any observing objects
     * of the fact that this is a new AMEE Profile object that has been deleted.
     */
    private function _notifyObserversDeletedChild()
    {
        foreach ($this->aObservingProfileLists as $oObservers) {
            $oObservers->deletedChild($this->sUID);
        }
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

//    /**
//     * A method to get an AMEE Profile Category description and the contents
//     * of that AMEE Profile Category, for the specificed AMEE Profile Category
//     * path.
//     *
//     * The contents includes ...
//     *
//     * @param <string> $sCategoryPath An optional string of the path of the
//     *      desired AMEE Profile Category. For example, "/home" or
//     *      "/home/energy/quantity". If no AMEE Profile Category path is
//     *      supplied, then the entire AMEE Profile Category tree will be
//     *      returned.
//     * @param <array> $aOptions An optional associative array of parameters that
//     *      can be used to restrict ...
//     *          - startDate
//     *          - endDate
//     *          - duration
//     *          - selectby
//     *          - mode
//     *          - returnUnit
//     *          - returnPerUnit
//     * @return ... ???
//     */
//    public function getCategory($sCategoryPath = null, array $aOptions = null)
//    {
//
//    }
//
//    /**
//     * A method to create a new AMEE Profile Item in this AMEE Profile.
//     *
//     * @param <Service_AMEE_DataItem> $oDataItem The AMEE Data Item that
//     *      corresponds to the AMEE Profile Item that should be created.
//     * @param <array> $aOptions
//     * @return <object> A Service_AMEE_ProfileItem object represeting the AMEE
//     *      Profile Item created; an Exception object otherwise.
//     */
//    public function createItem(Service_AMEE_DataItem $oDataItem, array $aOptions = null)
//    {
//
//    }
//
//    /**
//     * A method to retrieve an AMEE Profile Item from this AMEE Profile.
//     *
//     * @param <string> $sProfileItemUID The AMEE Profile Item UID.
//     * @return <object> The requested AMEE Profile Item as a
//     *      Service_AMEE_ProfileItem object; an Exception object otherwise.
//     */
//    public function getItem($sProfileItemUID)
//    {
//
//    }

}

?>
