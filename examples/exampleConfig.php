<?php

/*
 * This file the AMEE configuration file for the scripts in the /examples directory.
 *
 * PHP Version 5
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    James Smith <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */

/**
 * Define the AMEE REST API project key you want to use.
 *
 * You can see your project keys (or sign up for the AMEE REST API) at:
 *      http://my.amee.com/
 */
if (!defined('AMEE_API_PROJECT_KEY')) {
    define('AMEE_API_PROJECT_KEY', 'your_api_key');
}

/**
 * Define the AMEE REST API project password.
 *
 * Please note that this is NOT the same as your MyAMEE password. You can reset
 * your project password by clicking on the project key link at:
 *      http://my.amee.com/
 */
if (!defined('AMEE_API_PROJECT_PASSWORD')) {
    define('AMEE_API_PROJECT_PASSWORD', 'your_api_password');
}

/**
 * Define the AMEE REST API URL.
 */
if (!defined('AMEE_API_URL')) {
    define('AMEE_API_URL', 'stage.amee.com');
}

/**
 * Define the AMEE REST API ports. Optional, ports 80 and 443 will be assumed
 * if these values are not defined.
 */
if (!defined('AMEE_API_PORT')) {
    define('AMEE_API_PORT', '80');
}
if (!defined('AMEE_API_PORT_SSL')) {
    define('AMEE_API_PORT_SSL', '443');
}

/**
 * Define if the library should produce debugging information about the AMEE API
 * calls that are made.
 *
 * If this is set to true, debugging information will be logged via the PHP
 * syslog() function with logging level LOG_NOTICE; the location of the
 * syslog() file is defined by the error_log option in the php.ini file.
 */
if (!defined('AMEE_API_ENABLE_DEBUGGING')) {
    define('AMEE_API_ENABLE_DEBUGGING', false);
}

?>
