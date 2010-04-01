AMEE API PEAR Library

Requires PHP 5.2.0+

Core PHP packages that are required for the library:
  - Network
  - JSON

Can use openssl for POST /auth connections, if the package is installed, to
protect username/password info; if not present, will send username/password
information to the API "in the clear".