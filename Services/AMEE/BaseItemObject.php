<?php

/*
 * This file provides the Services_AMEE_BaseItemObject class. Please see the
 * class documentation for full details.
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
 * The Services_AMEE_BaseItemObject class is an abstract class that defines all
 * of the common class variables and methods of the AMEE REST API objects that
 * represent single items (i.e. AMEE Profiles and AMEE Profile Items).
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
abstract class Services_AMEE_BaseItemObject extends Services_AMEE_BaseObject
{

    /**
     * @var <string> $sCreated The created date of the object.
     */
    protected $sCreated;

    /**
     * @var <string> $sModified The last modified date of the object.
     */
    protected $sModified;

    /**
     * A method to retun this object's created date
     *
     * @return <mixed> This object's created date as a string; an Exception
     *      object if this object hasn't been initialized.
     */
    public function getCreated()
    {
        if (!empty($this->sCreated)) {
            return $this->sCreated;
        }
        // Error, object is not itialized
        throw new Services_AMEE_Exception(
            'Cannot call Service_AMEE_BaseItemObject::getCreated() on an ' .
            'un-initialized object'
        );
    }

    /**
     * A method to retun this object's modified date
     *
     * @return <mixed> This object's modified date as a string; an Exception
     *      object if this object hasn't been initialized.
     */
    public function getModified()
    {
        if (!empty($this->sModified)) {
            return $this->sModified;
        }
        // Error, object is not itialized
        throw new Services_AMEE_Exception(
            'Cannot call Service_AMEE_BaseItemObject::getModified() on an ' .
            'un-initialized object'
        );
    }

    /**
     * A public method that correctly formats date strings into ISO 8601
     * format.
     *
     * @param <string> $sDate The date string to format.
     * @return <string> The same date as an ISO 8601 formatted string.
     */
    public function formatDate($sDate)
    {
        if (preg_match("/([+-]\d\d):\d\d$/", $sDate, $aMatches)) {
            // Store the current timezone
            $sTZ = date_default_timezone_get();
            date_default_timezone_set('Etc/GMT' . sprintf('%+d', $aMatches[1]));
            $sDate = date('c', strtotime($sDate));
            date_default_timezone_set($sTZ);
            return $sDate;
        }
        return date('c', strtotime($sDate));
    }

}

?>
