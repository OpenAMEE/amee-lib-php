<?php

/*
 * This file provides the Services_AMEE_DataItem class. Please see the class
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
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
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
     * @param <array> $aOptions An optional array of AMEE Data Item name/value
     *      pairs that define the AMEE Data Item's Drill Down UID, in those
     *      cases where the path does not define the UID.
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
            $this->sPath = $sPath;
            $this->aOptions = $aOptions;
            // Prepare the AMEE REST API path
            $sPath = '/data' . $this->sPath . '/drill';
            // Call the AMEE REST API
            $this->sLastJSON = $this->oAPI->get($sPath, $aOptions);
            // Process the result data
            $this->aLastJSON = json_decode($this->sLastJSON, true);
            // Test that a valid Data Item UID has been located
            if ($this->aLastJSON['choices']['name'] == 'uid'
                && count($this->aLastJSON['choices']['choices']) == 1
                && isset($this->aLastJSON['choices']['choices'][0])
                && isset($this->aLastJSON['choices']['choices'][0]['value'])) {
                // Set this object's UID
                $this->sUID = $this->aLastJSON['choices']['choices'][0]['value'];
            } else {
                throw new Services_AMEE_Exception(
                    'AMEE API Data Item Drill Down for path ' . $sPath . ' with the' .
                    'specified options did not return a Data Item UID - check that ' .
                    'the specified options fully define a complete Drill Down to a ' .
                    'single Data Item'
                );
            }
        } catch (Exception $oException) {
            throw $oException;
        }
    }

}

?>
