<?php

/*
 * This file provides the Services_AMEE_BaseItemObject class. Please see the
 * class documentation for full details.
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
require_once 'Services/AMEE/Exception.php';

/**
 * The Services_AMEE_BaseItemObject class is an abstract class that defines all
 * of the common class variables and methods of the AMEE REST API objects that
 * represent single items (i.e. AMEE Profiles and AMEE Profile Items).
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
abstract class Services_AMEE_BaseItemObject extends Services_AMEE_BaseObject
{

    /**
     * @var <string> $sUID The UID of the object.
     */
    protected $sUID;

    /**
     * @var <string> $sCreated The created date of the object.
     */
    protected $sCreated;

    /**
     * @var <string> $sModified The last modified date of the object.
     */
    protected $sModified;

    /**
     * A method to retun this object's UID
     *
     * @return <mixed> This object's UID as a string; an Exception object
     *      if this object hasn't been initialized.
     */
    public function getUID()
    {
        if (!empty($this->sUID)) {
            return $this->sUID;
        }
        // Error, object is not itialized
        throw new Services_AMEE_Exception(
            'Cannot call Service_AMEE_BaseObject::getUID() on an un-initialized object'
        );
    }

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
            'Cannot call Service_AMEE_BaseObject::getCreated() on an un-initialized object'
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
            'Cannot call Service_AMEE_BaseObject::getModified() on an un-initialized object'
        );
    }


    /**
     * A method to retun this object's UID, created date and modified date in
     * an array, indexed by 'uid', 'created' and 'modified'.
     *
     * @return <mixed> This object's information array; an Exception object if
     *      this object hasn't been initialized.
     */
    public function getInfo()
    {
        try {
            $aReturn = array(
                'uid'      => $this->getUID(),
                'created'  => $this->getCreated(),
                'modified' => $this->getModified()
            );
        } catch (Exception $oException) {
            throw $oException;
        }
        return $aReturn;
    }

}

?>
