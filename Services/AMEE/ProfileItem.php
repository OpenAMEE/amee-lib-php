<?php

/*
 * This file provides the Services_AMEE_ProfileItem class. Please see the class
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
require_once 'Services/AMEE/DataItem.php';

/**
 * The Services_AMEE_ProfileItem class is used to represent an AMEE Profile
 * Item and provides all of the methods required to ...
 *
 * An AMEE Profile Item is an "instance" of an AMEE Data Item within an AMEE
 * Profile. For example, if you had an AMEE Profile that represented a
 * household's CO2 emissions, and you wanted to include the use of an average
 * sized European petrol car in the AMEE Profile, then you would include an
 * AMEE Profile Item of the approciate AMEE Data Item.
 *
 * (The details of the level of use of the car are then included as an AMEE
 * Profile Item Value.)
 *
 * For more information about AMEE Profiles, please see:
 *      http://my.amee.com/developers/wiki/ProfileItem
 *
 * Please see the Services_AMEE_ProfileItemValue class for more details about
 * AMEE Profile Item Values.
 * 
 * Please see the Services_AMEE_DataItem class for more details about AMEE Data
 * Items.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileItem extends Services_AMEE_BaseItemObject
{


























    

    /**
     * @var <string> $sCategoryPath The category path of the AMEE Profile Item.
     */
    protected $sCategoryPath;

    /**
     * @var <string> $sCategoryPath The associated AMEE Data Item UID for the
     *      AMEE Profile Item.
     */
    protected $sDataItemUid;

    /**
     * @var <string> $sName Optional name for the AMEE Profile Item.
     */
    protected $sName;

    /**
     * @var <string> $sStartDate Optional time that the AMEE Profile Item is
     *      valid from.
     */
    protected $sStartDate;

    /**
     * @var <string> $sEndDate Optional time that the AMEE Profile Item is valid
     *      until.
     */
    protected $sEndDate;

    /**
     * @var <string> $sDuration Optional duration that the AMEE Profile Item is
     *      valid until (given a start date).
     */
    protected $sDuration;

    /**
     * @var <array> $aObservingProfiles An array of observing
     * Services_AMEE_Profile objects. Normally, only expect there to be one of
     * these, but you can have more if you really want.
     */
    private $aObservingProfiles;

    /**
     * The constructor for the Services_AMEE_ProfileItem class.
     *
     * @param <Services_AMEE_Profile> $oProfile The instance of the
     *      Services_AMEE_Profile class that is the observer of the new
     *      Services_AMEE_ProfileItem object to be created.
     *
     *
     *
     *
     * 
     * @param <boolean> $bCreateNew When true, will attempt to create a new
     *      AMEE Profile Item (and will therefore ignore any parameters passed
     *      in for $aProfileItemData and $aProfileItemValues). When false, will
     *      not create a new AMEE Profile Item, but will use the values in the
     *      $aProfileItemData and $aProfileItemValues parameter arrays to create
     *      an object for an AMEE Profile Item that already exists in AMEE.
     * @param <array> $aProfileItemData An optional array of existing AMEE
     *      Profile Item information. If passed in, will create a
     *      Services_AMEE_ProfileItem object for an AMEE Profile Item that
     *      already exists in AMEE. Must contiain keys 'uid', 'created',
     *      'modified', 'categoryPath' and 'dataItemUid' to supply the already
     *      existing AMEE Profile Item UID, created date, modified date,
     *      category path and associated AMEE Data Item UID. Can also contain
     *      optional keys 'name', 'startDate', 'endDate', 'duration' and
     *      'representation'. (Note that if 'endDate' or 'duration' is
     *      specified, then 'startDate' must be specified.)
     * 
     * @return <object> The created Services_AMEE_Profile object (either for the
     *      specified AMEE Profile that already existed, or for the newly
     *      created AMEE Profile); an Exception object otherwise.
     */
    function  __construct($oProfile, $oDataItem, $aProfileItemValues = array(), $aProfileItemData = array()) {
        try {
            parent::__construct();
            $this->register($oProfile);
            // Test the optional parameters
            if (isset($aProfileItemData['endDate'])
                && isset($aProfileItemData['duration'])) {
                throw new Services_AMME_Exception(
                    'Both the optional Data Profile Item end date and ' .
                    'duration were set - only one of these items may be used'
                );
            }
            if (isset($aProfileItemData['endDate'])
                || isset($aProfileItemData['duration'])) {
                if (!isset($aProfileItemData['startDate'])) {
                    throw new Services_AMME_Exception(
                        'One of the option Data Profile Item end date or ' .
                        'duration was set, but the start date was not set'
                    );
                }
            }
            if ($bCreateNew === false) {
                // Ensure that all required information to create an existing
                // AMEE Profile object is present
                if (!isset($aProfileItemData['uid'])) {
                    throw new Services_AMME_Exception(
                        'Missing UID parameter, which is required to create ' .
                        'an AMEE Profile Item object for an existing AMEE ' .
                        'Profile Item'
                    );
                }
                if (!isset($aProfileItemData['created'])) {
                    throw new Services_AMME_Exception(
                        'Missing created date parameter, which is required ' .
                        'to create an AMEE Profile Item object for an ' .
                        'existing AMEE Profile Item'
                    );
                }
                if (!isset($aProfileItemData['modified'])) {
                    throw new Services_AMME_Exception(
                        'Missing modified date parameter, which is required ' .
                        'to create an AMEE Profile Item object for an ' .
                        'existing AMEE Profile Item'
                    );
                }
                // Create the AMEE Profile Item on the basis of the required
                // information passed into the constructor
                $this->sUID          = $aProfileItemData['uid'];
                $this->sCreated      = $this->_formatDate($aProfileItemData['created']);
                $this->sModified     = $this->_formatDate($aProfileItemData['modified']);
                $this->sCategoryPath = $aProfileItemData['categoryPath'];
                $this->sDataItemUid  = $aProfileItemData['dataItemUid'];
                // Create the AMEE Profile Item on the basis of the optional
                // information passed into the constructor
                if (isset($aProfileItemData['name'])) {
                    $this->sName = $aProfileItemData['name'];
                }
                if (isset($aProfileItemData['startDate'])) {
                    $this->sStartDate = $this->_formatDate($aProfileItemData['startDate']);
                }
                if (isset($aProfileItemData['endDate'])) {
                    $this->sEndDate = $this->_formatDate($aProfileItemData['endDate']);
                }
                if (isset($aProfileItemData['duration'])) {
                    $this->sDuration = $aProfileItemData['duration'];
                }
                if (isset($aProfileItemData['representation'])) {
                    $this->sDuration = $aProfileItemData['representation'];
                }
                // Create the AMEE Profile Item Values for this AMEE Profile
                // Item


                
                // Notify any observing classes of this AMEE Profile Item
                // object's creation
                $this->_notifyObserversNewChild();
                return;
            }
            // Create a new AMEE Profile Item - prepare the AMEE REST API path &
            // options
            $sPath = '/profiles/' . $oProfile->getUID() . $aProfileItemData['categoryPath'];
            $aOptions = array(
                'dataItemUid' => $aProfileItemData['dataItemUid']
            );
            if (isset($aProfileItemData['name'])) {
                $aOptions['name'] = $aProfileItemData['name'];
            }
            if (isset($aProfileItemData['startDate'])) {
                $aOptions['startDate'] = $this->_formatDate($aProfileItemData['startDate']);
            }
            if (isset($aProfileItemData['endDate'])) {
                $aOptions['endDate'] = $this->_formatDate($aProfileItemData['endDate']);
            }
            if (isset($aProfileItemData['duration'])) {
                $aOptions['duration'] = $aProfileItemData['duration'];
            }
            if (isset($aProfileItemData['representation'])) {
                $aOptions['representation'] = $aProfileItemData['representation'];
            }
            foreach ($aProfileItemValues as $sProfileItemValueKey => $sProfileItemValue) {
                $aOptions[$sProfileItemValueKey] = $sProfileItemValue;
            }
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->post($sPath, $aOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);


            print_r($this->aLastJSON);


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
     * A method to allow a Services_AMEE_Profile object to register with
     * this object as an observer, so that it can be updated if this AMEE
     * Profile Item is created or deleted.
     *
     * @param <Services_AMEE_Profile> $oProfile
     */
    public function register($oProfile)
    {
        $this->aObservingProfiles[] = $oProfile;
    }

    /**
     * A private method to perform the task of notifying any observing objects
     * of the fact that this is a new AMEE Profile Item object that has been
     * created.
     */
    private function _notifyObserversNewChild()
    {
        foreach ($this->aObservingProfiles as $oObserver) {
            $oObserver->newChild($this->sUID, $this);
        }
    }

    /**
     * A private method to perform the task of notifying any observing objects
     * of the fact that this is a new AMEE Profile Item object that has been
     * deleted.
     */
    private function _notifyObserversDeletedChild()
    {
        foreach ($this->aObservingProfiles as $oObserver) {
            $oObserver->deletedChild($this->sUID);
        }
    }


















    /**
     * @var <integer> $iAmount The amount of CO2 produced by this AMEE Profile
     *      Item.
     *
     * @TODO Test integers, doubles and scientific notation
     */
    private $iAmount;

    /**
     * @var <string> $sUnit The mass unit for this AMEE Profile Item's amount
     *      value.
     */
    private $sUnit;

    /**
     * @var <string> $sPerUnit The time unit for this AMEE Profile Item's amount
     *      value.
     */
    private $sPerUnit;

//    /**
//     * A method to update the AMEE Profile Item.
//     *
//     *
//     */
//    public function update()
//    {
//
//    }
//
//    /**
//     * A method to delete the AMEE Profile Item.
//     *
//     * @return <mixed> True on success; an Exception object otherwise.
//     */
//    public function delete()
//    {
//
//    }

}

?>
