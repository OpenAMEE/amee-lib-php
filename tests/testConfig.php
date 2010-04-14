<?php

/*
 * This file is both the actual configuration for the the PHPUnit unit and
 * integration tests for the Services_AMEE package, and an example of the
 * definitions that must be created in your application before using the
 * Services_AMEE package to use the AMEE REST API.
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

?>
