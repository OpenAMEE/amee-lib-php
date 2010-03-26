<?php

/*
 * This file provides the Services_AMEE_BaseObject class. Please see the class
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

/**
 * The Services_AMEE_BaseObject class is an abstract class that defines all of
 * the common class variables and methods of the AMEE REST API objects.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
abstract class Services_AMEE_BaseObject
{

    /**
     * @var <string> $sUID The UID of the object.
     */
    private $sUID = '';

    /**
     * @var <string> $sCreated The created date of the object.
     */
    private $sCreated;

    /**
     * @var <string> $sModified The last modified date of the object.
     */
    private $sModified;

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
        return new Services_AMEE_Exception(
            'Cannot call Service_AMEE_BaseObject::getUID() on an un-initialized object.',
             0
        );
    }

}

?>
