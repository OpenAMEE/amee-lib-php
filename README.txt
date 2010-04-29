AMEE REST API PEAR Library
--------------------------

A PHP PEAR wrapper library for the AMEE REST API.


About the AMEE REST API
-----------------------

AMEE makes it easy to develop applications to measure and track environmental
impacts, enabling companies, governments and consumers calculate their carbon
footprint and model energy consumption.

AMEE supports the data and algorithms provided for the greenhouse gas emissions
calculations required to support the Global Reporting Initiative (GRI), the
Carbon Reduction Commitment (CRC) and other initiatives.

AMEE finds, verifies, and makes accessible the best carbon-related data in the
world: that is, emissions factors and the algorithms for using them. The AMEE
REST API then allows you to access and embed best-practice carbon models into
carbon accounting systems, carbon calculators, and many other applications.


About the library
-----------------

Version:   1.1.0

Copyright: 2010 AMEE UK Limited

License:   MIT

 - Please see http://www.opensource.org/licenses/mit-license.html for the full
   details of the MIT license.

Supports:  AMEE REST API v2

Download:  http://github.com/AMEE/amee-lib-php/downloads

Source:    http://github.com/AMEE/amee-lib-php

Requirements:

 - PHP 5.2.0+
 - Core PHP packages:
  - Network
  - JSON

Authentication:

  This library suports the use of OpenSSL to encypher AMEE REST API username and
  password details, if the PHP OpenSSL package is installed and emabled. If the
  PHP OpenSSL package is not installed and enabled, then all username and
  password details will be sent "in the clear".

TODO:

  At present there is no caching support of GET request data. This will be added
  in the next version.

  At present there is no support for advanced time-period based reporting on
  AMEE API Profile Item data. This will be added in the next version.


Installing the library
----------------------

Please see the INSTALL.txt file.


Using the library
-----------------

To use the AMEE REST API PEAR library:

1. Install the library by following the install instructions above.

2. Include the three main required files in your code:

    require_once 'Services/AMEE/DataItem.php';
    require_once 'Services/AMEE/Profile.php';
    require_once 'Services/AMEE/ProfileItem.php';

3. Create three definitions, for the AMEE REST API host name, your AMEE API
    key, and your AMEE API password. For example:

    define('AMEE_API_URL',              'stage.amee.com');
    define('AMEE_API_PROJECT_KEY',      'your_api_key');
    define('AMEE_API_PROJECT_PASSWORD', 'your_api_password');

4. Create AMEE API Profiles and AMEE API Profile Items & use them as required.

Please see the examples/EXAMPLES.txt file for details of code examples that will
help you to understand and use the AMEE REST API PEAR library.