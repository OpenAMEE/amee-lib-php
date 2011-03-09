<?php

/*
 * This file provides the Services_AMEE_DataItem class. Please see the class
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

/**
 * The Services_AMEE_DataItem class is used to represent an AMEE Data Item
 * and provides all of the methods required to obtain the UID for a requested
 * Data Item "Drill Down" request.
 *
 * For more information about AMEE Data Items, please see:
 *      http://my.amee.com/developers/wiki/DataItem
 *
 * For more information about AMEE Data Item Drill DOwn requests, please see:
 *      http://my.amee.com/developers/wiki/DrillDown
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_DataItem extends Services_AMEE_BaseItemObject
{

    /**
     * @var <string> $sPath The AMEE Data Item path. 
     */
    protected $sPath;

    /**
     *
     * @var <array> $aOptions The optional array of AMEE Data Item name/value
     *      pairs that define the AMEE Data Item's Drill Down UID, in those
     *      cases where the path does not define the UID.
     */
    protected $aOptions;

    /**
     * The constructor for the Services_AMEE_DataItem class.
     *
     * @param <string> $sPath The path of the AMEE API Data Item.
     * @param <array> $aOptions An optional array of AMEE API Data Item
     *      name/value pairs that define the AMEE API Data Item's Drill Down
     *      UID, in those cases where the path does not define the UID.
     * @return <object> The created Services_AMEE_DataItem object; an Exception
     *      object otherwise.
     */
    function  __construct($sPath, $aOptions = array()) {
        try {
            parent::__construct();
            // Helpfully re-format the path, if required
            if (!preg_match('#^/#', $sPath)) {
                $sPath = '/' . $sPath;
            }
            if (preg_match('#(.*)/$#', $sPath, $aMatches)) {
                $sPath = $aMatches[1];
            }
            // Store the path and array
            $this->sPath    = $sPath;
            $this->aOptions = $aOptions;
            // Prepare the AMEE REST API path
            $sPath = '/data' . $this->sPath . '/drill';
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->get($sPath, $this->aOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Test that a valid Data Item UID has been located
            if (isset($this->aLastJSON['choices'])
                && isset($this->aLastJSON['choices']['name'])
                && $this->aLastJSON['choices']['name'] == 'uid'
                && isset($this->aLastJSON['choices']['choices'])
                && count($this->aLastJSON['choices']['choices']) == 1
                && isset($this->aLastJSON['choices']['choices'][0])
                && isset($this->aLastJSON['choices']['choices'][0]['value'])) {
                // Set this object's UID
                $this->sUID = $this->aLastJSON['choices']['choices'][0]['value'];
            } else {
                throw new Services_AMEE_Exception(
                    'AMEE API Data Item Drill Down for path \'' . $sPath .
                    '\' with the specified options did not return a Data ' .
                    'Item UID - check that the specified options fully ' .
                    'define a complete Drill Down to a single Data Item'
                );
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to retun the AMEE API Data Item's path
     *
     * @return <mixed> This AMEE API Data Item's path as a string; an Exception
     *      object if this object hasn't been initialized.
     */
    public function getPath()
    {
        if (!empty($this->sPath)) {
            return $this->sPath;
        }
        // Error, object is not itialized
        throw new Services_AMEE_Exception(
            'Cannot call Service_AMEE_DataItem::getPath() on an ' .
            'un-initialized object'
        );
    }

    /**
     * A method to return the AMEE API Data Item's drill down options.
     *
     * @return <mixed> This AMEE API Data Item's drill down options as an array;
     *      an Exception object if this object hasn't been initialized.
     */
    public function getDrillDownOptions()
    {
        if (is_array($this->aOptions)) {
            return $this->aOptions;
        }
        // Error, object is not itialized
        throw new Services_AMEE_Exception(
            'Cannot call Service_AMEE_DataItem::getDrillDownOptions() on an ' .
            'un-initialized object'
        );
    }

    /**
     * A static method that can be used to obtain the drill down name and
     * values that may exist for a given AMEE API Data Item path and optional
     * AMEE API Data Item's drill down name/value pairs.
     *
     * @param <string> $sPath The path of the AMEE API Data Item.
     * @param <array> $aOptions An optional array of AMEE API Data Item
     *      name/value pairs that define either a full or partial set of
     *      AMEE API Data Item's Drill Down options.
     * @return <mixed> An array of two items, with the following keys
     *      - "drillOption": The name of the drill down that the array of
     *                       options below is for; and
     *      - "options"      An array of drill down option name/value pairs
     *                       (empty when none exist);
     *      or an Exception object on error.
     */
    public static function browseDrillDownOptions($sPath, $aOptions = array())
    {
        try {
            // Prepare the AMEE REST API connection
            $oAPI = Services_AMEE_API::singleton();
            // Prepare the AMEE REST API path
            $sPath = '/data' . $sPath . '/drill';
            // Call the AMEE REST API
            $sLastJSON = $oAPI->get($sPath, $aOptions);
            // Process the result data
            $aLastJSON = json_decode($sLastJSON, true);
            // Test that a valid Data Item drill down option array can be
            // generated & returned
            $aReturn = array();
            if (isset($aLastJSON['choices'])
                && isset($aLastJSON['choices']['name'])
                && $aLastJSON['choices']['name'] != 'uid'
                && isset($aLastJSON['choices']['choices'])
                && is_array($aLastJSON['choices']['choices'])) {
                // Prepare the return array
                $aReturn['drillOption'] = $aLastJSON['choices']['name'];
                foreach ($aLastJSON['choices']['choices'] as $aChoice) {
                    $aReturn['options'][$aChoice['name']] = $aChoice['value'];
                }
                return $aReturn;
            } else if (isset($aLastJSON['choices'])
                && isset($aLastJSON['choices']['name'])
                && $aLastJSON['choices']['name'] == 'uid'
                && isset($aLastJSON['selections'])
                && is_array($aLastJSON['selections'])) {
                // Prepare the return array
                foreach ($aLastJSON['selections'] as $aSelection) {
                    if (!array_key_exists($aSelection['name'], $aOptions)) {
                        $aReturn['drillOption'] = $aSelection['name'];
                        $aReturn['options'][$aSelection['value']] = $aSelection['value'];
                    }
                }
                return $aReturn;
            } else {
                throw new Services_AMEE_Exception(
                    'AMEE API Data Item Drill Down for path \'' . $sPath .
                    '\' with the specified options did not return a Data ' .
                    'Item option set - check the specified options'
                );
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }

}

?>
