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
 * The Services_AMEE_ProfileItem class is used to represent an AMEE API Profile
 * Item and provides all of the methods required to ...
 *
 * An AMEE API Profile Item is an "instance" of an AMEE API Data Item within an
 * AMEE API Profile. For example, if you had an AMEE API Profile that
 * represented a household's CO2 emissions, and you wanted to include the use of
 * a medium sized European petrol car in the AMEE API Profile, then you would
 * include an AMEE API Profile Item of the approciate AMEE API Data Item.
 *
 * For more information about AMEE API Profiles, please see:
 *      http://my.amee.com/developers/wiki/ProfileItem
 * 
 * For more information about AMEE API Data Items, please see the
 *      Services_AMEE_DataItem class.
 *
 * For more information about medium sized Eurpoean petrol cars, please see:
 *      http://explorer.amee.com/categories/Car_Defra_By_Size
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
     * @var <Services_AMEE_Profile> $oProfile The AMEE API Profile that the
     *      AMEE API Profile Item belongs to.
     */
    private $oProfile;

    /**
     * @var <Services_AMEE_DataItem> $oDataItem The AMEE API Data Item that is
     *      associated with the AMEE API Profile Item.
     */
    private $oDataItem;
    
    /**
     * @var <double> $dAmount The amount of CO2e produced by this AMEE API
     *      Profile Item.
     *
     * @TODO Test integers, doubles and scientific notation
     */
    private $dAmount;

    /**
     * @var <string> $sUnit The mass unit for this AMEE API Profile Item's
     *      amount value.
     */
    private $sUnit;

    /**
     * @var <string> $sPerUnit The time unit for this AMEE API Profile Item's
     *      amount value.
     */
    private $sPerUnit;

    /**
     * @var <string> $sStartDate Optional time that the AMEE API Profile Item is
     *      valid from.
     */
    private $sStartDate;

    /**
     * @var <string> $sEndDate Optional time that the AMEE API Profile Item is
     *      valid until.
     */
    private $sEndDate;

    /**
     * @var <array> $aValidProfileItemOptions An array defining the valid keys
     *      that can be passed in as AMEE API Profile Item options (i.e. as
     *      keys in the fourth parameter) when creating a new AMEE API Profile
     *      Item.
     */
    private $aValidProfileItemOptions = array(
        'name',
        'startDate',
        'endDate',
        'duration',
        'representation'
    );

    /**
     * The constructor for the Services_AMEE_ProfileItem class.
     *
     * There are three different ways to create a new Services_AMEE_ProfileItem
     * object.
     *
     ***************************************************************************
     *
     * 1. Create an object for a new AMEE API Profile Item
     *
     * @param <array> $aParams An array of parameters, being:
     *
     *      $aParams[0] => <Services_AMEE_Profile> The instance of the
     *          Services_AMEE_Profile class representing the AMEE API Profile in
     *          which the new AMEE API Profile Item should be created.
     *
     *      $aParams[1] => <Services_AMEE_DataItem> The instance of the
     *          Services_AMEE_DataItem class representing the AMEE API Data Item
     *          on which the AMEE API Profile Item should be based.
     *
     *      $aParams[2] => <array> An array of name/value pairs that represent
     *          the input data for one or more AMEE API Profile Item Values.
     *
     *          For example, assuming that the AMEE API Data Item that the AMEE
     *          API Profile Item is to be based on is
     *          http://explorer.amee.com/categories/Car_Defra_By_Size, then the
     *          array *must* contain the "distance" key (because this is defined
     *          as a required parameter in the AMEE API Data Item above), with
     *          value specifying the km/year travelled. That is, the absolute
     *          minimum array that this parameter could be for this AMEE API
     *          Data Item would be, for example:
     *
     *          array(
     *              'distance' => 100
     *          );
     *
     *          representing that the car usage is/was 100 km/year.
     *
     *          Optionally, the array in this example could additionally contain
     *          the keys "occupants", "ownFuelConsumption", "totalFuelConsumed"
     *          and "numberOfJourneys", to specify additional information about
     *          the car use, as described on the AMEE API Data Item page above.
     * 
     *          Optionally, the array in this example could addtionally contain
     *          keys specifying "unit" and "perUnit" options for the name/value
     *          pairs. That is, on the
     *          http://explorer.amee.com/categories/Car_Defra_By_Size page, the
     *          required parameter "distance" is, by default, specified in
     *          km/year. However, if you wanted to specify this in another
     *          format, such as miles/week, then you could do so, by setting
     *          the array to be, for example:
     *
     *          array(
     *              'distance'        => '5'
     *              'distanceUnit'    => 'mi'
     *              'distancePerUnit' => 'week'
     *          );
     *
     *          representing that the car usage is/was 5 miles/week.
     *
     *          Note that you can only specify "unit" and "perUnit" modifer
     *          options for those name/value pairs that support it -- that is,
     *          for example, it is not possible to specify different "unit" or
     *          "perUnit" options for the "occupants" key in this case.
     *
     *          You can find details of supported units at
     *              http://my.amee.com/developers/wiki/Units
     *
     *      $aParams[3] => <array> An optional array of name/value pairs that
     *          represent AMEE API Profile Items options. Valid key values are
     *          "name", "startDate", "endDate", "duration" and "representation",
     *          as defined at
     *          http://my.amee.com/developers/wiki/ProfileItem#CreateanewProfileItem
     *
     ***************************************************************************
     *
     * 2. Create an object for an existing AMEE API Profile Item by UID
     *
     * @param <array> $aParams An array of parameters, being:
     *
     *      $aParams[0] => <Services_AMEE_Profile> The instance of the
     *          Services_AMEE_Profile class representing the AMEE API Profile in
     *          which the AMEE API Profile Item exists.
     *
     *      $aParams[1] => <Services_AMEE_DataItem> The instance of the
     *          Services_AMEE_DataItem class representing the AMEE API Data Item
     *          on which the existing AMEE API Profile Item is based.
     *
     *      $aParams[2] => <string> The AMEE API Profile Item UID for the
     *          existing AMEE API Profile Item.
     *
     ***************************************************************************
     *
     * 3. Create an object for an existing AMEE API Profile Item by AMEE API
     *      Data Item
     *
     * @param <array> $aParams An array of parameters, being:
     *
     *      $aParams[0] => <Services_AMEE_Profile> The instance of the
     *          Services_AMEE_Profile class representing the AMEE API Profile in
     *          which the AMEE API Profile Item exists.
     * 
     *      $aParams[1] => <Services_AMEE_DataItem> The instance of the
     *          Services_AMEE_DataItem class representing the AMEE API Data Item
     *          on which the existing AMEE API Profile Item is based.
     *
     ***************************************************************************
     *
     * In all three cases:
     *
     * @return <object> A Services_AMEE_ProfileItem object (either for the
     *      specified existing AMEE API Profile Item, or for the newly created
     *      AMEE API Profile Item), or an Exception object on error.
     */
    function  __construct($aParams) {
        try {
            parent::__construct();
            // Validate the number of parameters passed into the constructor
            if (!is_array($aParams)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with a parameter that is not an array'
                );
            }
            if (count($aParams) == 1 || count($aParams) > 4) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array containing an invalid number ' .
                    'of items'
                );
            }
            // Validate parameters one and two, which are always the object
            // representing the owning AMEE API Profile, and the object
            // representing the associated AMEE API Data Item, respectively
            if (!is_a($aParams[0], 'Services_AMEE_Profile')) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s first parameter not being ' .
                    'the required Services_AMEE_Profile object'
                );
            }
            if (!is_a($aParams[1], 'Services_AMEE_DataItem')) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s second parameter not being ' .
                    'the required Services_AMEE_DataItem object'
                );
            }
            // Validate the optional third parameter and set the construction
            // method type based on the existence (or otherwise) of this
            // parameter and its type
            $sConstructType = $this->_validateThirdParam($aParam[2]);            
            // Validate the optional fourth parameter
            if ($sConstructType != 'new' && exists($aParam[3])) {
                // The fourth parameter is only valid with construction type
                // 'new', for when a new AMEE API Profile Item is being created
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s fourth parameter being set,' .
                    'but with other parameters such that a fourth parameter ' .
                    'is not expected to be set'
                );
            }
            if ($sConstructType == 'new') {
                $this->_validateFourthParam($aParam[3]);
            }
            // All validation has passed
            if ($sConstructType == 'new') {
                // Create a new AMEE API Profile Item in the AMEE REST API, and
                // obtain the details of the created AMEE API Profile Item
                /** @TODO */
            } else if ($sConstructType == 'uid') {
                // Obtain the details of the already existing AMEE API Profile
                // Item
                /** @TODO */
            } else if ($sConstructType == 'search') {
                // Obtain the details of the already existing AMEE API Profile
                // Item
                /** @TODO */
            } else {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method failed ' .
                    'with an internal error - found construction type of ' .
                    $sConstructType
                );
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A private method to validate the optional third parameter of the
     * contstructor method, and return the construction type (i.e. a new
     * AMEE API Profile Item ["new"], or an existing AMEE API Profile Item
     * based on the UID ["uid"] or based solely on the path and AMEE API Data
     * Item UID ["search"]).
     * 
     * @param <mixed> An optional "third parameter" from the constructor method
     *      array.
     * @return <mixed> One of the strings "new", "uid" or "search", or an
     *      Exception if there is an issue with validating the parameter.
     */
    private function _validateThirdParam($aParam = null)
    {
        if (exists($aParam)) {
            if (is_string($aParam)) {
                return 'uid';
            } else if (is_array($aParam)) {
                if (count($aParam) == 0) {
                    throw new Services_AMEE_Exception(
                        'Services_AMEE_ProfileItem constructor method ' .
                        'called with the parameter array\'s third ' .
                        'parameter being an empty array'
                    );
                }
                return 'new';
            } else {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s third parameter not ' .
                    'being either an array or a string'
                );
            }
        } else {
            return 'search';
        }
    }

    /**
     *A private method to validate the optional third parameter of the
     * contstructor method.
     * 
     * @param <array> $aParam An optional "third parameter" from the constructor
     *      method array.
     * @return <mixed> The boolean true if the parameter passes validation, or
     *      an Exception if there is an issue with validating the parameter.
     */
    private function _validateFourthParam($aParam)
    {
        if (exists($aParam)) {
            if (!is_array($aParam)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method ' .
                    'called with the parameter array\'s fourth ' .
                    'parameter not being an array'
                );
            }
            foreach ($aParam as $sKey => $sValue) {
                if (!in_array($sKey, $this->aValidProfileItemOptions)) {
                    throw new Services_AMEE_Exception(
                        'Services_AMEE_ProfileItem constructor method ' .
                        'called with the parameter array\'s fourth ' .
                        'parameter being an array containing invalid ' .
                        'key ' . $sKey
                    );
                }
            }
            if (isset($aParam['endDate'])
                && isset($aParam['duration'])) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method ' .
                    'called with the parameter array\'s fourth ' .
                    'parameter being an array containing both an ' .
                    '\'endDate\' and \'duration\' - only one of ' .
                    'these items may be set'
                );
            }
            if (isset($aParam['endDate'])
                || isset($aParam['duration'])) {
                if (!isset($aParam['startDate'])) {
                    throw new Services_AMEE_Exception(
                        'Services_AMEE_ProfileItem constructor method ' .
                        'called with the parameter array\'s fourth ' .
                        'parameter being an array containing either ' .
                        '\'endDate\' or \'duration\' set, but without ' .
                        'the \'startDate\' set'
                    );
                }
            }
        }
    }





















    



//    /**
//     * @var <string> $sName Optional name for the AMEE Profile Item.
//     */
//    protected $sName;
//
//    /**
//     * @var <string> $sDuration Optional duration that the AMEE Profile Item is
//     *      valid until (given a start date).
//     */
//    protected $sDuration;

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

//                // Create the AMEE Profile Item on the basis of the required
//                // information passed into the constructor
//                $this->sUID          = $aProfileItemData['uid'];
//                $this->sCreated      = $this->_formatDate($aProfileItemData['created']);
//                $this->sModified     = $this->_formatDate($aProfileItemData['modified']);
//                $this->sCategoryPath = $aProfileItemData['categoryPath'];
//                $this->sDataItemUid  = $aProfileItemData['dataItemUid'];
//                // Create the AMEE Profile Item on the basis of the optional
//                // information passed into the constructor
//                if (isset($aProfileItemData['name'])) {
//                    $this->sName = $aProfileItemData['name'];
//                }
//                if (isset($aProfileItemData['startDate'])) {
//                    $this->sStartDate = $this->_formatDate($aProfileItemData['startDate']);
//                }
//                if (isset($aProfileItemData['endDate'])) {
//                    $this->sEndDate = $this->_formatDate($aProfileItemData['endDate']);
//                }
//                if (isset($aProfileItemData['duration'])) {
//                    $this->sDuration = $aProfileItemData['duration'];
//                }
//                if (isset($aProfileItemData['representation'])) {
//                    $this->sDuration = $aProfileItemData['representation'];
//                }
//
//
//
//            }
//            // Create a new AMEE Profile Item - prepare the AMEE REST API path &
//            // options
//            $sPath = '/profiles/' . $oProfile->getUID() . $aProfileItemData['categoryPath'];
//            $aOptions = array(
//                'dataItemUid' => $aProfileItemData['dataItemUid']
//            );
//            if (isset($aProfileItemData['name'])) {
//                $aOptions['name'] = $aProfileItemData['name'];
//            }
//            if (isset($aProfileItemData['startDate'])) {
//                $aOptions['startDate'] = $this->_formatDate($aProfileItemData['startDate']);
//            }
//            if (isset($aProfileItemData['endDate'])) {
//                $aOptions['endDate'] = $this->_formatDate($aProfileItemData['endDate']);
//            }
//            if (isset($aProfileItemData['duration'])) {
//                $aOptions['duration'] = $aProfileItemData['duration'];
//            }
//            if (isset($aProfileItemData['representation'])) {
//                $aOptions['representation'] = $aProfileItemData['representation'];
//            }
//            foreach ($aProfileItemValues as $sProfileItemValueKey => $sProfileItemValue) {
//                $aOptions[$sProfileItemValueKey] = $sProfileItemValue;
//            }
//            // Call the AMEE REST API
//            $this->sLastJSON = $this->oAPI->post($sPath, $aOptions);
//            // Process the result data
//            $this->aLastJSON = json_decode($this->sLastJSON, true);
//
//
//            print_r($this->aLastJSON);
//
//
//            // Set this object's UID, created date and modified date
//            $this->sUID      = $this->aLastJSON['profile']['uid'];
//            $this->sCreated  = $this->_formatDate($this->aLastJSON['profile']['created']);
//            $this->sModified = $this->_forma


}

?>
