<?php

/*
 * This file provides the Services_AMEE_BaseObject class. Please see the class
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

require_once 'Services/AMEE/API.php';
require_once 'Services/AMEE/Exception.php';

/**
 * The Services_AMEE_BaseObject class is an abstract class that defines all of
 * the common class variables and methods of the AMEE REST API objects.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
abstract class Services_AMEE_BaseObject
{

    /**
     * @var <Services_AMEE_API> $oAPI The local instance of the API
     *      communications class.
     */
    protected $oAPI;

    /**
     * @var <string> $sLastJSON The last JSON data string obtained.
     */
    protected $sLastJSON;

    /**
     * @var <array> $aLastJSON The last JSON data string obtained in decoded
     *      format.
     */
    protected $aLastJSON;

    /**
     * @var <string> $sUID The UID of the object.
     */
    protected $sUID;

    /**
     * The constructor method for the Services_AMEE_BaseObject class, which
     * can be used by implementing class constructors to set up the API
     * communications class.
     */
    function __construct()
    {
        try {
            // Ensure JSON package exists
            $this->_hasJSONDecode();
            // Create the local instance of the API communications class
            $this->oAPI = $this->_getAPI();
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A protected method to wrap the Services_AMEE_API::singleton() method
     * for testing.
     *
     * @return <Services_AMEE_API> The singleton instance of the
     *      Services_AMEE_API. 
     */
    protected function _getAPI()
    {
        return Services_AMEE_API::singleton();
    }

    /**
     * A protected method that detects if the PHP environment has the required
     * PHP json_decode() function available.
     *
     * @return <mixed> Returns the boolean true if json_decode() is available,
     *      throws an Exception otherwise.
     */
    protected function _hasJSONDecode()
    {
        if (extension_loaded('json')) {
            return true;
        }
        throw new Services_AMEE_Exception(
            'The PHP function json_decode() does not exist - the JSON ' .
            'package is required'
        );
    }

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
            'Cannot call Service_AMEE_BaseObject::getUID() on an ' .
            'un-initialized object'
        );
    }

}

?>
