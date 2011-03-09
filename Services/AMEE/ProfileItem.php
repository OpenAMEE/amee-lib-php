<?php

/*
 * This file provides the Services_AMEE_ProfileItem class. Please see the class
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
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileItem extends Services_AMEE_BaseItemObject
{
    
    /**
     * @var <string> $sName Optional name for the AMEE API Profile Item.
     */
    private $sName;
    
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
     * @var <array> $aItemValues An array for storing information about the
     *      current AMEE API Profile Item Values in the AMEE API Profile Item.
     */
    private $aItemValues;

    /**
     * @var <array> $aReturnUnitOptions An array to store the return unit
     *      options set, if present.
     */
    private $aReturnUnitOptions = array();

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
        'duration'
    );

    /**
     * @var <array> $aValidReturnUnitOptions An array defining the valid keys
     *      that can be passed in as AMEE API Profile Item return unit options
     *      (i.e. as keys in the fourth or fifth parameter, depending on the
     *      type of construction).
     */
    private $aValidReturnUnitOptions = array(
        'returnUnit',
        'returnPerUnit'
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
     *          "name", "startDate", "endDate", and "duration" as defined at
     *          http://my.amee.com/developers/wiki/ProfileItem#CreateanewProfileItem.
     *
     *          Use null for this parameter if no AMEE API Profile Item options
     *          need to be set, but you do want to set the fifth option array
     *          below.
     *
     *      $aParams[4] => <array> An optional array of name/value pairs that
     *          represent the desired "unit" and "per unit" values that should
     *          be used for the AMEE API Profile Item. Must be specified using
     *          the key values "returnUnit" and "returnPerUnit" as defined at
     *          http://my.amee.com/developers/wiki/ProfileCategory#GetCategory.
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
     *      $aParams[3] => <array> An optional array of name/value pairs that
     *          represent the desired "unit" and "per unit" values that should
     *          be used for the AMEE API Profile Item. Must be specified using
     *          the key values "returnUnit" and "returnPerUnit" as defined at
     *          http://my.amee.com/developers/wiki/ProfileCategory#GetCategory.
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
     *      $aParams[2] => <array> An optional array of name/value pairs that
     *          represent the desired "unit" and "per unit" values that should
     *          be used for the AMEE API Profile Item. Must be specified using
     *          the key values "returnUnit" and "returnPerUnit" as defined at
     *          http://my.amee.com/developers/wiki/ProfileCategory#GetCategory.
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
            if (count($aParams) < 2 || count($aParams) > 5) {
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
            $this->oProfile = $aParams[0];
            if (!is_a($aParams[1], 'Services_AMEE_DataItem')) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s second parameter not being ' .
                    'the required Services_AMEE_DataItem object'
                );
            }
            $this->oDataItem = $aParams[1];
            // Validate the optional third parameter and set the construction
            // method type based on the existence (or otherwise) of this
            // parameter and its type
            if (array_key_exists(2, $aParams)) {
                $sConstructType = $this->_validateThirdParam($aParams[2]);
            } else {
                $sConstructType = $this->_validateThirdParam();
            }
            // Validate the optional fourth parameter
            if ($sConstructType == 'search' && array_key_exists(3, $aParams)) {
                // The fourth parameter is only valid with construction types
                // 'new' and 'uid'
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s fourth parameter being set, ' .
                    'but with other parameters such that a fourth parameter ' .
                    'is not expected to be set'
                );
            }
            if (array_key_exists(3, $aParams)) {
                $this->_validateFourthParam($sConstructType, $aParams[3]);
            }
            // Validate the optional fifth parameter
            if ($sConstructType != 'new' && array_key_exists(4, $aParams)) {
                // The fifth parameter is only valid with construction type
                // 'new'
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method called ' .
                    'with the parameter array\'s fifth parameter being set, ' .
                    'but with other parameters such that a fifth parameter ' .
                    'is not expected to be set'
                );
            }
            if (array_key_exists(4, $aParams)) {
                $this->_validateReturnUnitParamArray($aParams[4]);
            }
            // All validation has passed
            if ($sConstructType == 'new') {
                // Create a new AMEE API Profile Item in the AMEE REST API, and
                // obtain the details of the created AMEE API Profile Item
                $this->_constructNew($aParams);
            } else if ($sConstructType == 'uid') {
                // Obtain the details of the already existing AMEE API Profile
                // Item
                $this->_constructExistingByUID($aParams[2]);
            } else if ($sConstructType == 'search') {
                // Obtain the details of the already existing AMEE API Profile
                // Item
                $this->_constructExistingBySearch();
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
        if (!isset($aParam)) {
            // No third parameter, this must be a "search" type construction;
            // return type "search" without any validation required
            return 'search';
        }
        if (is_string($aParam)) {
            // The third parameter is a string, this must be a "uid" type
            // construction; return type "uid" without any validation required
            return 'uid';
        }
        if (!is_array($aParam)) {
            // If the parameter exists and it is not a string, then it can
            // only be an array; as it is not, throw an Exception
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem constructor method called ' .
                'with the parameter array\'s third parameter not ' .
                'being either an array or a string'
            );
        }
        // The array parameter can be either the optional return unit option
        // array for a "search" type construction, or the required option array
        // for a "new" type construction; which is it?
        if (array_key_exists('returnUnit', $aParam)
            || array_key_exists('returnPerUnit', $aParam)) {
            // Assume a "search" type construction, as there are return unit
            // keys in the array; validate the return unit option array, and
            // return type "search"
            $this->_validateReturnUnitParamArray($aParam);
            return 'search';
        }
        // Assume a "new" type construction; return type "new"
        //
        // It is permitted to create a new Profile Item without any parameters,
        // for example, see
        // http://explorer.amee.com/categories/Reductions/data/fix%20dripping%20tap
        return 'new';
    }

    /**
     *A private method to validate the optional third parameter of the
     * contstructor method.
     *
     * @param <string> $sConstructType A string representing the construction
     *      type, either "new" or "uid".
     * @param <array> $aParam The optional "fourth parameter" from the
     *      constructor method array.
     */
    private function _validateFourthParam($sConstructType, $aParam)
    {
        if (is_null($aParam)) {
            // No problems, no options set
            return;
        }
        if (!is_array($aParam)) {
            // This is a problem; if set, the fourth parameter must be an array
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem constructor method ' .
                'called with the parameter array\'s fourth ' .
                'parameter not being an array'
            );
        }
        if ($sConstructType == 'uid') {
            // The fourth parameter is an optional array of return unit options
            $this->_validateReturnUnitParamArray($aParam);
        }
        if ($sConstructType == 'new') {
            // The fourth parameter is an optional array of AMEE API Profile
            // Item options
            $this->_validateProfileOptionParamArray($aParam);
        }
    }

    /**
     * A private method that throws an Exception if the array parameter
     * containing the AMEE API Profile Item options for a AMEE API Profile Item
     * is invalid.
     *
     * @param <array> $aParam The array containing the AMEE API Profile Item
     *      options.
     */
    private function _validateProfileOptionParamArray($aParam)
    {
        if (!is_array($aParam)) {
            // This is a problem; if set, the parameter must be an array
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem method called with option ' .
                'parameter array not actually being an array'
            );
        }
        foreach ($aParam as $sKey => $sValue) {
            if (!in_array($sKey, $this->aValidProfileItemOptions)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem method called with option ' .
                    'parameter array containing invalid key \'' . $sKey . '\''
                );
            }
        }
        if (array_key_exists('endDate', $aParam)
            && array_key_exists('duration', $aParam)) {
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem method called with the option ' .
                'parameter array containing both an \'endDate\' and ' .
                '\'duration\' - only one of these items may be set'
            );
        }
        if (array_key_exists('endDate', $aParam)
            || array_key_exists('duration', $aParam)) {
            if (!array_key_exists('startDate', $aParam)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem method called with the option ' .
                    'parameter array containing one of \'endDate\' or ' .
                    '\'duration\' set, but without the \'startDate\' set'
                );
            }
        }
    }

    /**
     * A private method that throws an Exception if the array parameter
     * containing the return unit options for a AMEE API Profile Item is
     * invalid.
     *
     * @param <array> $aParam The array containing the AMEE API Profile Item
     *      return unit options.
     */
    private function _validateReturnUnitParamArray($aParam)
    {
        if (is_null($aParam)) {
            // No problems, no options set
            return;
        }
        if (!is_array($aParam)) {
            // This is a problem; if set, the parameter must be an array
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem method called with return unit ' .
                'parameter array not actually being an array'
            );
        }
        foreach ($aParam as $sKey => $sValue) {
            if (!in_array($sKey, $this->aValidReturnUnitOptions)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem method called with the return ' .
                    'unit parameter array containing invalid key \'' . $sKey .
                    '\''
                );
            }
        }
        // Valid, store
        foreach ($this->aValidReturnUnitOptions as $sOption) {
            if (array_key_exists($sOption, $aParam)) {
                $this->aReturnUnitOptions[$sOption] = $aParam[$sOption];
            }
        }
    }

    /**
     * A private method to perform the actual AMEE REST API call required to
     * generate a new AMEE API Profile Item, based on the parameters passed
     * into the constructor method, and set the local object variables based
     * on the result.
     *
     * @param <array> $aParams The validated parameters from the object's
     *      __construct() method.
     * @return <mixed> An Exception object on error, void otherwise.
     */
    private function _constructNew($aParams)
    {
        try {
            // Prepare the AMEE REST API call path & options
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath();
            $aOptions = array(
                'dataItemUid' => $this->oDataItem->getUID()
            );
            foreach ($aParams[2] as $sKey => $sValue) {
                $aOptions[$sKey] = $sValue;
            }
            if (isset($aParams[3])) {
                foreach ($aParams[3] as $sKey => $sValue) {
                    $aOptions[$sKey] = $sValue;
                }
            }
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->post($sPath, $aOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Now that the AMEE API Profile Item is created, construct this
            // object via the __constuctExistingByUID method
            $this->_constructExistingByUID($this->aLastJSON['UID']);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A private method to perform the actual AMEE REST API call required to
     * obtain the details of an existing AMEE API Profile Item by UID, and set
     * the local object variables based on the result.
     *
     * @param <string> $sUID The desired AMEE API Profile Item's UID.
     * @return <mixed> An Exception object on error, void otherwise.
     */
    private function _constructExistingByUID($sUID)
    {
        try {
            // Prepare the AMEE REST API call path & options
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath() . '/' . $sUID;
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->get($sPath, $this->aReturnUnitOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Set the objcet variables
            if (!isset($this->aLastJSON['profileItem'])) {
                // Bad UID given
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem constructor method requested ' .
                    'an existing AMEE API Profile Item by AMEE API Profile ' .
                    'Item UID ' . $sUID . ', but no such AMEE API Profile ' .
                    'Item could be located'
                );
            }
            $this->_constructExistingByDataArray($this->aLastJSON['profileItem']);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A private method to perform the actual AMEE REST API call required to
     * obtain the details of an existing AMEE API Profile Item by searching the
     * appropriate category path & filtering on the AMEE API Data Item UID, and
     * set the local object variables based on the result.
     *
     * @return <mixed> An Exception object on error, void otherwise.
     */
    private function _constructExistingBySearch()
    {
        try {
            // Prepare the AMEE REST API call path & options
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath();
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->get($sPath, $this->aReturnUnitOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Locate the AMEE API Profile Item UID by the AMEE API Data Item
            // UID
            foreach ($this->aLastJSON['profileItems'] as $aProfileItem) {
                if ($aProfileItem['dataItem']['uid'] == $this->oDataItem->getUID()) {
                    // Found it!
                    $this->_constructExistingByDataArray($aProfileItem);
                    return;
                }
            }
            // Could not find the AMEE API Profile Item requested
            throw new Services_AMEE_Exception(
                'Services_AMEE_ProfileItem constructor method requested an ' .
                'existing AMEE API Profile Item by AMEE API Data Item UID ' .
                $this->oDataItem->getUID() . ', but no such AMEE API Profile ' .
                'Item could be located'
            );
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A private method to set the AMEE API Profile Item object variables based
     * on an array of AMEE API Profile Item data obtained from the AMEE REST
     * API.
     *
     * @param <array> $aData The array of AMEE API Profile Item object data from
     *      the AMEE REST API.
     */
    private function _constructExistingByDataArray($aData)
    {
        // Set the AMEE API Profile Item's properties
        $this->sUID       = $aData['uid'];
        $this->sCreated   = $this->formatDate($aData['created']);
        $this->sModified  = $this->formatDate($aData['modified']);
        $this->sName      = $aData['name'];
        $this->dAmount    = $aData['amount']['value'];
        $this->aAmounts   = array();
        $this->aNotes     = array();
        $this->sUnit      = '';
        $this->sPerUnit   = '';
        if (!empty($aData['amount']['unit'])) {
            if (preg_match('#(.+)/(.+)#', $aData['amount']['unit'], $aMatches)) {
                $this->sUnit    = $aMatches[1];
                $this->sPerUnit = $aMatches[2];
            } else {
                $this->sUnit = $aData['amount']['unit'];
            }
        }
        if (!empty($aData['startDate'])) {
            $this->sStartDate = $this->formatDate($aData['startDate']);
        }
        if (!empty($aData['endDate'])) {
            $this->sEndDate   = $this->formatDate($aData['endDate']);
        }
        if (!empty($aData['itemValues'])) {
            foreach ($aData['itemValues'] as $aItemValue) {
                $this->aItemValues[$aItemValue['path']] = array(
                    'path'    => $aItemValue['path'],
                    'value'   => $aItemValue['value'],
                    'unit'    => $aItemValue['unit'],
                    'perUnit' => $aItemValue['perUnit']
                );
            }
        }
        if (!empty($aData['amounts'])) {
            if (!empty($aData['amounts']['amount'])) {
                foreach ($aData['amounts']['amount'] as $aMARV) {
                    $this->aAmounts[$aMARV['type']] = $aMARV;
                }
            }
            if (!empty($aData['amounts']['note'])) {
                foreach ($aData['amounts']['note'] as $aMARVNote) {
                    $this->aNotes[] = $aMARVNote['value'];
                }
            }
        }
    }

    /**
     * A method to return the information & results for an AMEE API Profile
     * Item. The information returned is:
     *
     *      - 'uid'         => The UID;
     *      - 'name'        => The name, if set;
     *      - 'created'     => The created date/time;
     *      - 'modified'    => The most recently modified date/time;
     *      - 'profileUid'  => The UID of the parent AMEE API Profile;
     *      - 'path'        => The path of the AMEE API Data Item the AMEE API
     *                          Profile Item was created with;
     *      - 'dataItemUid' => The UID of the AMEE API Data Item the AMEE API
     *                          Profile Item was created with;
     *      - 'amount'      => The GHG emission result amount;
     *      - 'amounts'     => An array of additional GHG emission results, when
     *                          this is supported by the category in use;
     *      - 'notes'       => An array of notes about the additional GHG
     *                          emission results, when this is supported by the
     *                          category in use;
     *      - 'unit'        => The GHG emission result unit;
     *      - 'perUnit'     => The GHG emission result per time unit;
     *      - 'startDate'   => The vaid from start date/time; and
     *      - 'endDate'     => The vaid to end date/time, is set.
     *
     * @return <array> An array containing the AMEE API Profile Item's
     *      information, including the result of any GHG emission calculations.
     */
    public function getInfo()
    {
        $aReturn = array(
            'uid'         => $this->sUID,
            'name'        => $this->sName,
            'created'     => $this->sCreated,
            'modified'    => $this->sModified,
            'profileUid'  => $this->oProfile->getUID(),
            'path'        => $this->oDataItem->getPath(),
            'dataItemUid' => $this->oDataItem->getUID(),
            'amount'      => $this->dAmount,
            'unit'        => $this->sUnit,
            'perUnit'     => $this->sPerUnit,
            'startDate'   => $this->sStartDate,
            'endDate'     => $this->sEndDate
        );
        if (!empty($this->aAmounts)) {
            $aReturn['amounts'] = $this->aAmounts;
        }
        if (!empty($this->aNotes)) {
            $aReturn['notes'] = $this->aNotes;
        }
        return $aReturn;
    }

    /**
     * A method to return the AMEE API Data Item that the AMEE API Profile
     * Item was created with.
     *
     * @return <Services_AMEE_DataItem> The AMEE API Data Item that the AMEE
     *      API Profile Item was created with.
     */
    public function getDataItem()
    {
        return $this->oDataItem;
    }

    /**
     * A method to return the AMEE API Profile Item Value set in the AMEE API
     * Profile Item, if it exists.
     *
     * @param <string> $sItemName The AMEE API Profile Item Value name.
     * @return <mixed> The AMEE API Profile Item's value for the given AMEE API
     *      Profile Item Value name, if it exists; false otherwise.
     */
    public function getItemValue($sItemName)
    {
        if (isset($this->aItemValues[$sItemName])) {
            return $this->aItemValues[$sItemName];
        }
        return false;
    }

    /**
     * A method to allow an AMEE API Profile Item object's AMEE API Profile
     * Item Value(s) to be updated.
     *
     * @param <array> $aValues An array of name/value pairs, containing
     *
     *      These options can of course be set on AMEE API Profile Item object
     *      creation -- this method exists to allw an object that has already
     *      been created be updated, both locally an in the AMEE REST API,
     *      should you need to change one or more of the associated AMEE API
     *      Profile Item Values in the AMEE API Profile Item after creation.
     */
    public function updateValues($aValues)
    {
        try {
            // Validate the array
            if (!is_array($aValues)) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem::updateValues() called with ' .
                    'non-array parameter'
                );
            }
            if (count($aValues) == 0) {
                throw new Services_AMEE_Exception(
                    'Services_AMEE_ProfileItem::updateValues() called with ' .
                    'empty array parameter'
                );
            }
            // Prepare the AMEE REST API call path & options
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath() . '/' . $this->sUID;
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->put($sPath, $aValues);
            // Re-load this object from the API
            $this->_constructExistingByUID($this->sUID);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to allow an AMEE API Profile Item object's options to be
     * updated.
     *
     * @param <array> $aOptions An array of name/value pairs, containing one or
     *      more valid keys from the values "name", "startDate", "endDate", and
     *      "duration" as defined at
     *      http://my.amee.com/developers/wiki/ProfileItem#CreateanewProfileItem.
     *
     *      These options can of course be set on AMEE API Profile Item object
     *      creation -- this method exists to allw an object that has already
     *      been created be updated, both locally an in the AMEE REST API,
     *      should you need to change the options after creation.
     */
    public function updateOptions($aOptions)
    {
        try {
            // Validate the return options
            $this->_validateProfileOptionParamArray($aOptions);
            // Prepare the AMEE REST API call path & options
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath() . '/' . $this->sUID;
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->put($sPath, $aOptions);
            // Re-load this object from the API
            $this->_constructExistingByUID($this->sUID);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to allow an AMEE API Profile Item object's returnUnit and/or
     * returnPerUnit options to be updated.
     *
     * @param <array> $aReturnOptions An array of name/value pairs, containing
     *      either one of, or both, the indexes "returnUnit" and
     *      "returnPerUnit", as defined at
     *      http://my.amee.com/developers/wiki/ProfileCategory#GetCategory.
     *
     *      The returnUnit and returnPerUnit options can of course be set on
     *      AMEE API Profile Item object creation -- this method exists to allow
     *      an object that has already been created to be updated, both locally 
     *      and in the AMEE REST API, should you need to change the return
     *      options after creation.
     *
     * @return <mixed> An Exception object on error; void otherwise.
     */
    public function updateReturn($aReturnOptions)
    {
        try {
            // Validate the return options
            $this->_validateReturnUnitParamArray($aReturnOptions);
            // Re-load this object from the API, now that the new
            // return options have been set by the above
            $this->_constructExistingByUID($this->sUID);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to delete the AMEE Profile Item.
     *
     * @return <mixed> An Exception object on error; void otherwise.
     */
    public function delete()
    {
        try {
            // Prepare the AMEE REST API call path
            $sPath = '/profiles/' . $this->oProfile->getUID() .
                $this->oDataItem->getPath() . '/' . $this->sUID;
            // Call the AMEE REST API
            $this->oAPI->delete($sPath);
        } catch (Exception $oException) {
            throw $oException;
        }
    }

}

?>
