<?php

/*
 * This file provides the Services_AMEE_ProfileItem_UnitTest class. Please see
 * the class documentation for full details.
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

require_once 'PHPUnit/Framework.php';
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_ProfileItem_UnitTest class provides the PHPUnit unit test
 * cases for the Services_AMEE_ProfileItem class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileItem_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure the Services_AMEE_ProfileItem has the required class
     * attributes that are inherited from Services_AMEE_BaseObject.
     */
    public function testInheritedVariables()
    {
        $this->assertClassHasAttribute('sUID',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sCreated',  'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sModified', 'Services_AMEE_ProfileItem');
    }

    /**
     * Test to ensure the Services_AMEE_ProfileItem class has the required class
     * attributes.
     */
    public function testVariables()
    {
        $this->assertClassHasAttribute('iAmount',    'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sUnit',      'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sPerUnit',   'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sStartDate', 'Services_AMEE_ProfileItem');
        $this->assertClassHasAttribute('sEndDate',   'Services_AMEE_ProfileItem');
    }

}

?>
