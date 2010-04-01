<?php

/*
 * This file provides the Services_AMEE_Observer interface. Please see the
 * interface documentation for full details.
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

require_once 'Services/AMEE/Exception.php';

/**
 * The Services_AMEE_Observer interface defines the method that must be
 * implemented in all classes that indent to act as an observer of "child"
 * AMEE REST API items.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
interface Services_AMEE_Observer
{

    /**
     * A method that must be implemented to allow the observer to be notified
     * of the fact that a new child class has been created.
     *
     * @param <string> $sUID The UID of the child class that has been created.
     * @param <object> $oChild The child class object instance that has been
     *      created.
     */
    public function newChild($sUID, $oChild);

    /**
     * A method that must be implemented to allow the observer to be notified
     * of the fact that a child chass has been deleted.
     * 
     * @param <string> $sUID The UID of the child class that was deleted.
     */
    public function deletedChild($UID);

}

?>
