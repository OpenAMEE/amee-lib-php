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

Version:   1.0

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

Please see the tests/integration/AMEE/ExampleTest.php file, which acts as both
a PHPUnit integration test for the library as well as a well documented example
of how the AMEE REST API PHP PEAR library can be used.