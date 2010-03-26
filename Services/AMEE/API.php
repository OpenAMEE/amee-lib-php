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
 *
 * @TODO Restore cookie based auth!
 */

/**
 * The Services_AMEE_API class provides connection and communication management
 * for the AMEE REST API.
 *
 * There is no need to ever use this class yourself; it is intended to be an
 * API communications wrapper class that used by other classes in the
 * Services_AMEE package.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_API
{

    /**
     * @var <string> $sAuthToken The AMEE API authorization token.
     */
    private $sAuthToken;

    /**
     * @var <iteger> $iAuthExpires The time (in seconds since Unix Epoch) that
     *      the AMEE API authorization token will expire.
     */
    private $iAuthExpires;

    /**
     * @var <array> $aConfig The configuration data array for your AMEE REST API
     *      service library.
     */
    private $aConfig;

    /**
     * @var <array> $aPostPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API post operations (in Perl Regex format).
     */
    private $aPostPathOpenings = array(
        '/auth'
    );

    /**
     * @var <array> $aPutPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API put operations (in Perl Regex format).
     */
    private $aPutPathOpenings = array(

    );

    /**
     * @var <array> $aGetPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API get operations (in Perl Regex format).
     */
    private $aGetPathOpenings = array(

    );

    /**
     * @var <array> $aDeletePathOpenings An array of opening path strings that
     *      are valid for AMEE REST API delete operations (in Perl Regex
     *      format).
     */
    private $aDeletePathOpenings = array(

    );

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
        try {
            // Test to ensure that the path at least as a valid opening
            $this->_validPath($sPath, 'post');
            // Send the AMEE REST API post request
            return $this->_sendRequest("POST $sPath", http_build_query($aParams, NULL, '&'));
        } catch (Exception $oException) {
            throw $oException;
        }
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
        try {
            // Test to ensure that the path at least as a valid opening
            $this->_validPath($sPath, 'put');
            // Send the AMEE REST API put request
            return $this->_sendRequest("PUT $sPath", http_build_query($aParams, NULL, '&'));
        } catch (Exception $oException) {
            throw $oException;
        }
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
        try {
            // Test to ensure that the path at least as a valid opening
            $this->_validPath($sPath, 'delete');
            // Send the AMEE REST API delete request
            return $this->_sendRequest("DELETE $sPath", http_build_query($aParams));
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A private method to determine if a supplied AMEE REST API path at least
     * as an opening path that is valid, according to the type of method being
     * called.
     *
     * @param <string> $sPath The path being called.
     * @param <string> $sType The type of method call being made. One of "post",
     *      "put", "get" or "delete".
     * @return <mixed> True if the path is valid; an Exception object otherwise.
     */
    private function _validPath($sPath, $sType)
    {
        // Ensure the type has the correct formatting
        $sFomattedType = ucfirst(strtolower($sType));
        // Prepare the path opening array variable name
        $aPathOpenings = 'a' . $sFormattedType . 'PathOpenings';
        // Convert the path opening array into a preg_match suitable pattern
        $sPathPattern = '#^(' . implode($$aPathOpenings, "|") . ')#';
        // Test the path to see if it matches one of the valid path openings
        // for the method type
        if (!preg_match($sPathPattern, $sPath)) {
            throw new Services_AMEE_Exception(
                'Invalid AMEE REST API ' . strtoupper($sType) . ' path specified: ' . $sPath
            );
        }
        return true;
    }

    /**
     * A private method to take care of sending AMEE REST API method call
     * requests.
     *
     * @param <string> $sPath The full AMEE REST API method request path.
     *
     * @return
     *
     * @TODO missing parameters
     */
    private function _sendRequest($sPath, $sBody)
    {
        // Ensure that there is a connection to the AMEE REST API open, so long
        // as this is NOT a "POST /auth" request!
        if (!$this->_connected() && !preg_match('#^POST /auth#', $sPath)) {
            try {
                $this->_connect();
            } catch (Exception $oException) {
                throw $oException;
            }
        }
        // Ensure that the request is a valid type
        if (!preg_match('/^(GET|POST|PUT|DELETE)/', $sPath)) {
            throw new Services_AMEE_Exception(
                'Invalid AMEE REST API method specified: ' . $sPath
            );
        }
        // Prepare the HTTP request string
        $sRequest =
            $sPath .
            " HTTP/1.0\n" .
            "Accept: application/json\n" .

            // Probably broken; needs inspection re: cookies & authentication
            // tokens!
            "authToken: " . $this->sAuthToken . "\n" .

            "Host: " . AMEE_API_URL . "\n" .
            "Content-Type: application/x-www-form-urlencoded\n" .
            "Content-Length: " . strlen($sBody) . "\n" .
            "\n" .
            $sBody;
        // Connect to the AMEE REST API and send the request
        $rSocket = socket_create(AF_INET, SOCK_STREAM, 0);
        if (!socket_connect($rSocket, gethostbyname(AMEE_API_URL), AMEE_API_PORT)) {
            throw new Services_AMEE_Exception(
                'Unable to connect to the AMEE REST API: ' .
                    socket_strerror(socket_last_error($rSocket))
            );
        }
		if (socket_write($rSocket, $sRequest, strlen($sRequest)) === false) {
            throw new Services_AMEE_Exception(
                'Error sending the AMEE REST API request: ' .
                    socket_strerror(socket_last_error($rSocket))
            );
        }
        // Obtain the AMEE REST API response
        $aResponseLines = array();
        $aResponseLines[0] = '';
        $iCounter = 0;
        $sJSON = '';
        while (true) {
            // Read the next byte from the socket
            $sResponseByte = socket_read($rSocket, 1);
            if ($sResponseByte === false) {
                throw new Services_AMEE_Exception(
                    'Error receiving response from the AMEE REST API: ' .
                        socket_strerror(socket_last_error($rSocket))
                );
            }
            if ($sResponseByte != "\n" && strlen($sResponseByte) != 0) {
                // Have not yet completed reading in a line, so add the byte to
                // the current line of the response, and continue with the next
                // byte
                $aResponseLines[$iCounter] .= $sResponseByte;
                continue;
            }
            // Have finished reading in a line
            if (preg_match('/^Set-Cookie: /', $aResponseLines[$iCounter])) {
                // The line is a "Set-Cookie:" line - save the cookie info, so
                // that it can be set later

            } else if (preg_match('/^{/', $aResponseLines[$iCounter])) {
                // The line is a JSON response line, store it separately
                $sJSON = $aResponseLines[$iCounter];
            }
            if ($sResponseByte == 0) {
                // No more bytes to come from the socket
                break;
            }
            // There are more bytes to come from the socket, continue with the
            // next line of the response
            $iCounter++;
            $aResponseLines[$iCounter] = '';
        }
        socket_close($rSocket);

        // Stuff below needs completion!
        if(strpos($lines[0], '401 UNAUTH') !== false){
            // Auth failed, try again, try ONCE at getting new authtoken then trying again
			if($repeat){
				$this->debug('Authentication failure - get a new token and try again.');
				$this->reconnect();
				return $this->sendRequest($path, $body, $xml_only, false); //Try one more time!
			} else {
				$this->debug('Authentication failure on second attempt.');
			}
		}
		if($this->debugon) {
			$this->responses[] = array('request' => $header, 'response' => $lines);
			$this->debug($header);
			$this->debug(implode("\n", $lines));
		}
		if($xml_only) {
			$this->lastresponse = $xml_line;
			return $xml_line;
		} else {
			$this->lastresponse = '';
			return $lines;
		}


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
        // Are we already connected via this object?
		if (!empty($this->sAuthToken)
                && !empty($this->iAuthExpires)
                && $this->iAuthExpires > time()) {
			return true;
		}
        // Are we already connected via a previous connection?



        // No connection could be found
        return false;
    }

    /**
     * A private method to create a new connection to the AMEE REST API.
     *
     * @return <mixed> True if a connection to the AMEE REST API was
     *      successfully created; an Exception object otherwise.
     *
     * @TODO SSL support for protection of login info!
     */
    private function _connect()
    {
        // Ensure that the required definitions to make a connection are present
        if (!exists(AMEE_API_PROJECT_KEY)) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No project key defined.'
            );
        }
        if (!exists(AMEE_API_PASSWORD)) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No project password defined.'
            );
        }
        if (!exists(AMEE_API_URL)) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No API URL defined.'
            );
        }
        if (!exists(AMEE_API_PORT)) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No API port defined.'
            );
        }
        // Prepare the parameters for the AMEE REST API post method
        $sPath = '/auth';
        $aOptions = array(
            'username' => AMEE_API_PROJECT_KEY,
            'password' => AMEE_API_PROJECT_PASSWORD
        );
        // Call the AMEE REST API post method
        $result = $this->post($sPath, $aOptions);



        return true;
    }

    /**
     * A private method to close the current AMEE REST API connection (if one
     * exists) by dropping all current session authentication tokens.
     */
    private function _disconnect()
    {
        // Unset this object's connection
        unset($this->sAuthToken);
        unset($this->iAuthExpires);
        // Unset any previous connection



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
        try {
            $this->_disconnect();
            $this->_connect();
        } catch (Exception $oException) {
            throw $oException;
        }
    }

}

?>
