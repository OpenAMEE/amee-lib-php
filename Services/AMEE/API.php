<?php

/*
 * This file provides the Services_AMEE_API class. Please see the class
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

require_once 'Services/AMEE/Exception.php';

/**
 * A constant that defines the timeout value for the AMEE REST API authorisation
 * timeout. Currently 30 minutes (i.e. 30 * 60 = 1800 seconds).
 */
define('AMEE_API_AUTH_TIMEOUT', '1800');

/**
 * The Services_AMEE_API class provides connection and communication management
 * for the AMEE REST API.
 *
 * There is no need to ever use this class yourself; it is intended to be an
 * API communications wrapper class that used by other classes in the
 * Services_AMEE package.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_API
{

    /**
     *
     * @var <boolean> $debug Is debugging enabled for the connection?
     */
    private $debug;

    /**
     * @var <string> $sAuthToken The AMEE API authorisation token.
     */
    private $sAuthToken;

    /**
     * @var <iteger> $iAuthExpires The time (in seconds since Unix Epoch) that
     *      the AMEE API authorisation token will expire.
     */
    private $iAuthExpires;

    /**
     * @var <array> $aPostPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API post operations (in Perl Regex format,
     *      excluding the opening ^ limiter).
     */
    private $aPostPathOpenings = array(
        '/auth$',
        '/profiles$',
        '/profiles/[0-9A-Z]{12}/business',
        '/profiles/[0-9A-Z]{12}/embodied',
        '/profiles/[0-9A-Z]{12}/home',
        '/profiles/[0-9A-Z]{12}/lca',
        '/profiles/[0-9A-Z]{12}/metadata',
        '/profiles/[0-9A-Z]{12}/planet',
        '/profiles/[0-9A-Z]{12}/transport'
    );

    /**
     * @var <array> $aPutPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API put operations (in Perl Regex format,
     *      excluding the opening ^ limiter).
     */
    private $aPutPathOpenings = array(
        '/profiles/[0-9A-Z]{12}$',
        '/profiles/[0-9A-Z]{12}/business',
        '/profiles/[0-9A-Z]{12}/embodied',
        '/profiles/[0-9A-Z]{12}/home',
        '/profiles/[0-9A-Z]{12}/lca',
        '/profiles/[0-9A-Z]{12}/metadata',
        '/profiles/[0-9A-Z]{12}/planet',
        '/profiles/[0-9A-Z]{12}/transport'
    );

    /**
     * @var <array> $aGetPathOpenings An array of opening path strings that
     *      are valid for AMEE REST API get operations (in Perl Regex format,
     *      excluding the opening ^ limiter).
     */
    private $aGetPathOpenings = array(
        '/profiles$',
        '/profiles/[0-9A-Z]{12}$',
        '/profiles/[0-9A-Z]{12}/business',
        '/profiles/[0-9A-Z]{12}/embodied',
        '/profiles/[0-9A-Z]{12}/home',
        '/profiles/[0-9A-Z]{12}/lca',
        '/profiles/[0-9A-Z]{12}/metadata',
        '/profiles/[0-9A-Z]{12}/planet',
        '/profiles/[0-9A-Z]{12}/transport',
        '/data'
    );

    /**
     * @var <array> $aDeletePathOpenings An array of opening path strings that
     *      are valid for AMEE REST API delete operations (in Perl Regex format,
     *      excluding the opening ^ limiter).
     */
    private $aDeletePathOpenings = array(
        '/profiles/[0-9A-Z]{12}$',
        '/profiles/[0-9A-Z]{12}/business',
        '/profiles/[0-9A-Z]{12}/embodied',
        '/profiles/[0-9A-Z]{12}/home',
        '/profiles/[0-9A-Z]{12}/lca',
        '/profiles/[0-9A-Z]{12}/metadata',
        '/profiles/[0-9A-Z]{12}/planet',
        '/profiles/[0-9A-Z]{12}/transport'
    );

    private static $oAPI;

    /**
     * A static singleton method to obtain an instance of this class, while
     * ensuring that only ONE instance of the class ever exists for a single
     * PHP script execution.
     */
    static function singleton()
    {
        if (!isset(self::$oAPI)) {
            self::$oAPI = new Services_AMEE_API();
        }
        return self::$oAPI;
    }

    /**
     * A wrapper method to simplify the process of sending POST requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An optional associative array of parameters to be
     *      passed to the AMEE REST API as part of the POST request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API JSON response string on success; an
     *      Exception object otherwise.
     */
    public function post($sPath, array $aParams = array())
    {
        try {
            // Test to ensure that the path at least as a valid opening
            $this->validPath($sPath, 'post');
            // Send the AMEE REST API post request
            $aResult =  $this->sendRequest(
                "POST $sPath",
                http_build_query($aParams, NULL, '&')
            );
            // Return the JSON data string
            return $aResult[0];
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A wrapper method to simplify the process of sending PUT requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An optional associative array of parameters to be
     *      passed to the AMEE REST API as part of the PUT request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API JSON response string on success; an
     *      Exception object otherwise.
     */
    public function put($sPath, array $aParams = array())
    {
        try {
            // Test to ensure that the path at least as a valid opening
            $this->validPath($sPath, 'put');
            // Send the AMEE REST API put request
            $aResult = $this->sendRequest(
                "PUT $sPath",
                http_build_query($aParams, NULL, '&')
            );
            // Return the JSON data string
            return $aResult[0];
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A wrapper method to simplify the process of sending GET requests to the
     * AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @param <array> $aParams An optional associative array of parameters to be
     *      passed to the AMEE REST API as part of the GET request. The exact
     *      parameters will depend on the type of request being made, as defined
     *      by the query path.
     * @return <mixed> The AMEE REST API JSON response string on success; an
     *      Exception object otherwise.
     */
    public function get($sPath, array $aParams = array())
    {
        try {
            // Test to ensure that the path at least as a valid opening
            $this->validPath($sPath, 'get');
            // Send the AMEE REST API get request
            if (count($aParams) > 0) {
                $aResult = $this->sendRequest(
                    "GET $sPath?" . http_build_query($aParams, NULL, '&')
                );
            } else {
                $aResult = $this->sendRequest("GET $sPath");
            }
            // Return the JSON data string
            return $aResult[0];
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A wrapper method to simplify the process of sending DELETE requests to
     * the AMEE REST API.
     *
     * @param <string> $sPath The AMEE REST API query path.
     * @return <mixed> The boolean true on success; an Exception object
     *      otherwise.
     */
    public function delete($sPath)
    {
        try {
            // Test to ensure that the path at least as a valid opening
            $this->validPath($sPath, 'delete');
            // Send the AMEE REST API delete request
            $this->sendRequest("DELETE $sPath");
            // Return success
            return true;
        } catch (Exception $oException) {
            throw $oException;
        }
    }

    /**
     * A method to determine if a supplied AMEE REST API path at least has an
     * opening path that is valid, according to the type of method being called.
     *
     * @param <string> $sPath The path being called.
     * @param <string> $sType The type of method call being made. One of "post",
     *      "put", "get" or "delete".
     * @return <mixed> True if the path is valid; an Exception object otherwise.
     */
    public function validPath($sPath, $sType)
    {
        // Ensure the type has the correct formatting
        $sFormattedType = ucfirst(strtolower($sType));
        // Prepare the path opening array variable name
        $aPathOpenings = 'a' . $sFormattedType . 'PathOpenings';
        // Convert the path opening array into a preg_match suitable pattern
        $sPathPattern = '#^(' . implode($this->{$aPathOpenings}, "|") . ')#';
        // Test the path to see if it matches one of the valid path openings
        // for the method type
        if (!preg_match($sPathPattern, $sPath)) {
            throw new Services_AMEE_Exception(
                'Invalid AMEE REST API ' . strtoupper($sType) . ' ' .
                'path specified: ' . $sPath
            );
        }
        return true;
    }

    /**
     * A method to take care of sending AMEE REST API method call requests.
     *
     * @param <string> $sPath The full AMEE REST API method request path.
     * @param <string> $sBody The option body of the AMEE REST API method call
     *      (used for POST and PUT method calls).
     * @param <boolean> $bReturnHeaders Return the headers as well as the JSON
     *      resonse data? Optional; false by default.
     * @param <boolean> $bRepeat If, after ensuring a connection exists, the
     *      AMEE REST API returns a "401 UNAUTH" message, should the methood
     *      try to re-authorise and send the API call again? Optional; true by
     *      default.
     * @return <mixed> An array containing the (successful) result of the AMEE
     *      REST API call, where the array contains a single row being the JSON
     *      data (if $bReturnHeaders was false), or where the array contains
     *      multiple rows, with each row containing a single line of the
     *      response headers and the final row containing the JSON data
     *      (if $bReturnHeaders was true); an Exception object otherwise.
     */
    public function sendRequest($sPath, $sBody = null, $bReturnHeaders = false, $bRepeat = true)
    {

        if (!isset($this->debug)) {
            // By default, debugging is not enabled
            $this->debug = false;
            // Should debugging be enabled?
            if (defined('AMEE_API_ENABLE_DEBUGGING') && AMEE_API_ENABLE_DEBUGGING == true) {
                $this->debug = true;
            }
        }

        // Ensure that the request is a valid type
        if (!preg_match('/^(GET|POST|PUT|DELETE)/', $sPath)) {
            throw new Services_AMEE_Exception(
                'Invalid AMEE REST API method specified: ' . $sPath
            );
        }
        // Is this an authorisation request?
        $bAuthRequest = false;
        if (preg_match('#^POST /auth#', $sPath)) {
            $bAuthRequest = true;
        }
        // Ensure that there is a connection to the AMEE REST API open, so long
        // as this is NOT a "POST /auth" request!
        if (!$bAuthRequest && !$this->connected()) {
            try {
                $this->connect();
            } catch (Exception $oException) {
                throw $oException;
            }
        }
        // Prepare the HTTP request string
        $sRequest =
            $sPath . " HTTP/1.1\n" .
            "Connection: close\n" .
            "Accept: application/json\n";
            // Add existing authorisation items to the HTTP request string, if
            // this is not a new authorisation request
            if (!$bAuthRequest) {
                $sRequest .=
                "Cookie: authToken=" . $this->sAuthToken . "\n";
            }
            // Complete the HTTP request string
            $sRequest .=
            "Host: " . AMEE_API_URL . "\n";
            // Add the body, if required
            if (strlen($sBody) > 0) {
                $sRequest .= 
                "Content-Type: application/x-www-form-urlencoded\n" .
                "Content-Length: " . strlen($sBody) . "\n" .
                "\n" .
                $sBody;
            } else {
                $sRequest .=
                "\n";
            }
        // Connect to the AMEE REST API and send the request
        $iError = '';
        $sError = '';
        // DEBUG: OPENING SOCKET
        if ($this->debug) {
            $aStart = explode(' ', microtime());
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Opening socket';
            syslog(LOG_NOTICE, $message);
        }
        if ($bAuthRequest && extension_loaded('openssl')) {
            // Connect over SSL to protect the AMEE REST API username/password
            $rSocket = $this->_socketOpen(
                'ssl://' . AMEE_API_URL, AMEE_API_PORT_SSL,
                $iError,
                $sError
            );
        } else {
            $rSocket = $this->_socketOpen(
                AMEE_API_URL,
                AMEE_API_PORT,
                $iError,
                $sError
            );
        }
        if ($rSocket === false) {
            throw new Services_AMEE_Exception(
                'Unable to connect to the AMEE REST API: ' . $sError
            );
        }
        // DEBUG: SOCKET OPENED
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Socket opened';
            syslog(LOG_NOTICE, $message);
        }
        // DEBUG: SENDING REQUEST TO AMEE API
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Sending request to AMEE API';
            syslog(LOG_NOTICE, $message);
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ':   => URL:    ' . $sPath;
            syslog(LOG_NOTICE, $message);
            if (strlen($sBody) > 0) {
                $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
                $message .= ':   => Params: ' . $sBody;
                syslog(LOG_NOTICE, $message);
            }
        }
        $iResult = $this->_socketWrite($rSocket, $sRequest);
		if ($iResult === false || $iResult != strlen($sRequest)) {
            throw new Services_AMEE_Exception(
                'Error sending the AMEE REST API request'
            );
        }
        // DEBUG: REQUEST HAS BEEN SENT TO AMEE API
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Request sent';
            syslog(LOG_NOTICE, $message);
        }
        // Obtain the AMEE REST API response
        $aResponseLines  = array();
        $aLocationHeader = array();
        $aJSON           = array();
        // DEBUG: GETTING RESPONSE FROM AMEE API
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Getting response from AMEE API';
            syslog(LOG_NOTICE, $message);
        }
        while (!$this->_socketEOF($rSocket)) {
            $sLine = $this->_socketGetLine($rSocket);
            $aResponseLines[] = $sLine;
            if (preg_match('/^Location: /', $sLine)) {
                // The line is a Location: header response line, store it
                // separately
                $aLocationHeader[] = $sLine;
            }
            if (preg_match('/^{/', $sLine)) {
                // The line is a JSON response line, store it separately
                $aJSON[] = $sLine;
            }
        }
        // DEBUG: RESPONSE RECEIVED
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Response received';
            syslog(LOG_NOTICE, $message);
        }
        // DEBUG: CLOSING SOCKET
        if ($this->debug) {
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Closing socket';
            syslog(LOG_NOTICE, $message);
        }
        $this->_socketClose($rSocket);
        // DEBUG: SOCKET CLOSED & TOTAL TIME
        if ($this->debug) {
            $aEnd = explode(' ', microtime());
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': Socket closed';
            syslog(LOG_NOTICE, $message);
            $time = ((float) $aEnd[0] + (float) $aEnd[1]) - ((float) $aStart[0] + (float) $aStart[1]);
            $aMicrotime = explode(' ', microtime());
            $message = date('Y-m-d H:i:s.' . sprintf('%06d', $aMicrotime[0] * 1000000), $aMicrotime[1]);
            $message .= ': TOTAL REQUEST TIME: ' . sprintf("%.6f seconds", $time);;
            syslog(LOG_NOTICE, $message);
        }
        // Check that the request was authorised
        if (strpos($aResponseLines[0], '401 UNAUTH') !== false){
            // Authorisation failed
			if ($bRepeat) {
                // Try once more
                $this->reconnect();
                try {
                    return $this->sendRequest(
                        $sPath,
                        $sBody,
                        $bReturnHeaders,
                        false
                    );
                } catch (Exception $oException) {
                    throw $oException;
                }
			} else {
                // Not going to try once more, raise an Exception
                throw new Services_AMEE_Exception(
                    'The AMEE REST API returned an authorisation failure result'
                );
            }
		}
        // Check for a 400 return error where the JSON response advises that
        // invalid parameters were used to make the API call
        if (strpos($aResponseLines[0], '400') !== false && !empty($aJSON)) {
            $aJSONError = json_decode($aJSON[0], true);
            if (strpos($aJSONError['status']['description'], 'invalid parameters') !== false) {
                throw new Services_AMEE_Exception(
                    'The AMEE REST API was called called with invalid parameters'
                );
            }
        }
        // Update the authorisation time (now + authorisation timeout)
        $this->iAuthExpires = time() + AMEE_API_AUTH_TIMEOUT;
        // Return the AMEE REST API's results
		if ($bReturnHeaders) {
			return $aResponseLines;
		} else {
            // Return the JSON data response only, if it exists
            if (!empty($aJSON)) {
                return $aJSON;
            }
            // There was no JSON data in the response! Return the Location:
            // header information re-formatted as JSON data, if it exists
            if (!empty($aLocationHeader)) {
                // Extract the entity UID
                if (preg_match('#/([0-9A-Z]{12})$#', $aLocationHeader[0], $aMatches)) {
                    $aJSON[] = "{\"UID\":\"" . $aMatches[1] . "\"}";
                    return $aJSON;
                }
                // Location: header wasn't formatted as expected
                throw new Services_AMEE_Exception(
                    'The AMEE REST API returned an unexpected Location: ' .
                    'header response'
                );
            }
            // Oh dear, nothing to return - okay for DELETE methods and PUT
            // methods where an already existing AMEE API Profile Item is being
            // updated; not for anything else...
            $bOkay = false;
            if (preg_match('#^DELETE#', $sPath)) {
                $bOkay = true;
            }
            if (preg_match('#^PUT /profiles/[0-9A-Z]{12}/.+/[0-9A-Z]{12}$#', $sPath)) {
                $bOkay = true;
            }
            if (!$bOkay) {
                throw new Services_AMEE_Exception(
                    'The AMEE REST API failed to return an expected result'
                );
            }
		}
    }

    /**
     * A protected method that simply wraps the PHP function fsockopen, to help
     * with unit testing of the sendRequest() method.
     *
     * @param <string> $sHost The fsockopen() function host name.
     * @param <string> $sPort The fsockopen() function port.
     * @param <integer> $iError The fsockopen() function error code param.
     * @param <string> $sError The fsockopen() function error string param.
     * @return <mixed> As for the PHP fsockopen() function.
     *
     * See http://php.net/manual/en/function.fsockopen.php.
     */
    protected function _socketOpen($sHost, $sPort, &$iError, &$sError)
    {
        return fsockopen($sHost, $sPort, $iError, $sError);
    }

    /**
     * A protechted method that simply wraps the PHP function fwrite, to help
     * with unit testing of the sendRequest() method.
     *
     * @param <resource> $rSocket The fwrite() function socket resource.
     * @param <string> $sWrite The fwrite() function write string.
     * @return <mixed> As for the PHP fwrite() function.
     *
     * See http://php.net/manual/en/function.fwrite.php.
     */
    protected function _socketWrite($rSocket, $sWrite)
    {
        return fwrite($rSocket, $sWrite, strlen($sWrite));
    }

    /**
     * A protected method that simply wraps the PHP function feof, to help with
     * unit testing of the sendRequest() method.
     *
     * @param <resource> $rSocket The feof() function socket resource.
     * @return <boolean> As for the PHP fwrite() function.
     *
     * See http://php.net/manual/en/function.feof.php.
     */
    protected function _socketEOF($rSocket)
    {
        return feof($rSocket);
    }

    /**
     * A protected method that simply wraps the PHP function fgets, to help with
     * unit testing of the sendRequest() method.
     *
     * @param <type> $rSocket The fgets() function socket resource.
     * @return <mixed> As for the PHP fgets() function.
     *
     * See http://php.net/manual/en/function.fgets.php
     */
    protected function _socketGetLine($rSocket)
    {
        return trim(fgets($rSocket));
    }

    /**
     * A protected method that simply wraps the PHP function fclose, to help
     * with unit testing of the sendRequest() method.
     *
     * @param <type> $rSocket The fclose() function socket resource.
     * @return <boolean> As for the PHP close() function.
     *
     * See http://php.net/manual/en/function.fclose.php
     */
    protected function _socketClose($rSocket)
    {
        return fclose($rSocket);
    }

    /**
     * A method to determine if a connection to the AMEE REST API already
     * existsor not.
     *
     * @return <boolean> True if a connection to the AMEE REST API exists; false
     *      otherwise.
     */
    public function connected()
    {
        // Are we already connected via this object?
		if (!empty($this->sAuthToken)
                && !empty($this->iAuthExpires)
                && $this->iAuthExpires > time()) {
			return true;
		}
        // No connection could be found
        return false;
    }

    /**
     * A method to create a new connection to the AMEE REST API.
     *
     * @return <mixed> True if a connection to the AMEE REST API was
     *      successfully created; an Exception object otherwise.
     */
    public function connect()
    {
        // Ensure that the required definitions to make a connection are present
        if (!defined('AMEE_API_PROJECT_KEY')) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No project key defined'
            );
        }
        if (!defined('AMEE_API_PROJECT_PASSWORD')) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No project password ' .
                'defined'
            );
        }
        if (!defined('AMEE_API_URL')) {
            throw new Services_AMEE_Exception(
                'Cannot connect to the AMEE REST API: No API URL defined'
            );
        }
        if (!defined('AMEE_API_PORT')) {
            // Assume port 80
            define('AMEE_API_PORT', '80');
        }
        if (!defined('AMEE_API_PORT_SSL')) {
            // Assume port 443
            define('AMEE_API_PORT_SSL', '443');
        }        
        // Prepare the parameters for the AMEE REST API post method
        $sPath = '/auth';
        $aOptions = array(
            'username' => AMEE_API_PROJECT_KEY,
            'password' => AMEE_API_PROJECT_PASSWORD
        );
        // Call the AMEE REST API post method
        try {
            $aResult =  $this->sendRequest(
                "POST $sPath",
                http_build_query($aOptions, NULL, '&'),
                true,
                false
            );
        } catch (Exception $oException) {
            throw $oException;
        }
        // Connection was made!
        $bFoundAuth = false;
        foreach ($aResult as $sLine) {
            if (preg_match('/^authToken: (.+)/', $sLine, $aMatches)) {
                $this->sAuthToken = $aMatches[1];
                $this->iAuthExpires = time() + AMEE_API_AUTH_TIMEOUT;
                $bFoundAuth = true;
                break;
            }
        }
        if (!$bFoundAuth) {
            // Oh dear, no authorisation token found, connection wasn't
            // really made!
            throw new Services_AMEE_Exception(
                'Authentication error: No authToken returned by the ' .
                'AMEE REST API'
            );
        }
        return true;
    }

    /**
     * A method to close the current AMEE REST API connection (if one exists)
     * by dropping all current session authentication tokens.
     *
     * @return <boolean> Returns true.
     */
    public function disconnect()
    {
        // Unset this object's connection
        unset($this->sAuthToken);
        unset($this->iAuthExpires);
        return true;
    }

    /**
     * A method to close the current AMEE REST API connection (if one exists)
     * and then to reconnect to the AMEE REST API.
     *
     * @return <mixed> True if a connection to the AMEE REST API was
     *      successfully created; an Exception object otherwise.
     */
    public function reconnect()
    {
        $this->disconnect();
        try {
            $this->connect();
        } catch (Exception $oException) {
            throw $oException;
        }
        return true;
    }

}

?>
