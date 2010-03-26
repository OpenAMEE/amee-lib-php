<?php

/*
 * This file provides the Services_AMEE_API class. Please see the class
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
 * The Services_AMEE_API class provides connection and communication management
 * for the AMEE REST API.
 *
 * There is no need to ever use this class yourself; it is intended to be a
 * support class that is used by other
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_API_Connection
{

    /**
     * @var <string> $sAuthToken The AMEE API authorisation token.
     */
    private $sAuthToken = '';

    /**
     * A wrapper method to simplify the process of sending POST requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An associative array of parameters to be passed
     *      to the AMEE REST API as part of the POST request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API response string on success; an
     *      Exception object otherwise.
     */
    public function post($sPath, array $aParams)
    {

    }

    /**
     * A wrapper method to simplify the process of sending PUT requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An associative array of parameters to be passed
     *      to the AMEE REST API as part of the PUT request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API response string on success; an
     *      Exception object otherwise.
     */
    public function put($sPath, array $aParams)
    {

    }

    /**
     * A wrapper method to simplify the process of sending GET requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An associative array of parameters to be passed
     *      to the AMEE REST API as part of the GET request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API response string on success; an
     *      Exception object otherwise.
     */
    public function get($sPath, array $aParams)
    {

    }

    /**
     * A wrapper method to simplify the process of sending DELETE requests to
     * the AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @return <mixed> The AMEE REST API response string on success; an
     *      Exception object otherwise.
     */
    public function delete($sPath)
    {
        
    }

    /**
     * A private method to determine if a connection to the AMEE REST API
     * already exists or not.
     *
     * @return <boolean> True if a connection to the AMEE REST API exists; false
     *      otherwise.
     */
    private function _connected()
    {

    }

    /**
     * A private method to create a new connection to the AMEE REST API.
     *
     * @return <mixed> True if a connection to the AMEE REST API was
     *      successfully created; an Exception object otherwise.
     */
    private function _connect()
    {
        
    }

    /**
     * A private method to close the current AMEE REST API connection (if one
     * exists) by dropping all current session authentication tokens.
     */
    private function _disconnect()
    {

    }

    /**
     * A private method to close the current AMEE REST API connection (if one
     * exists) and then to reconnect to the AMEE REST API.
     *
     * @return <mixed> True if a connection to the AMEE REST API was
     *      successfully created; an Exception object otherwise.
     */
    private function _reconnect()
    {

    }

    /**
     * 
     */
    private function _sendRequest()
    {

    }

}

?>
