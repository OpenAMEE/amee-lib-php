<?php

/*
 * This file provides the Services_AMEE_Regression_IntegrationTest class.
 * Please see the class documentation for full details.
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

require_once 'Services/AMEE/DataItem.php';
require_once 'Services/AMEE/Profile.php';
require_once 'Services/AMEE/ProfileItem.php';

/**
 * The Services_AMEE_Regression_IntegrationTest class provides PHPUnit
 * integration test cases for regression testing of any bugs found and fixed
 * in the library.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_Regression_IntegrationTest extends PHPUnit_Framework_TestCase
{

    /**
     * A PHPUnit regression integration test for COM-137, a bug where it was
     * impossible to create new Profile Item objects where NO parameters are
     * required by the category, for example, for
     * http://explorer.amee.com/categories/Reductions/data/fix%20dripping%20tap.
     */
    function test_COM_137()
    {
        try {

            // Create a new AMEE API Profile
            $oProfile = new Services_AMEE_Profile();

            // Create the Data Item object for the category above
            $sPath = '/home/water/reductions';
            $aOptions = array(
                'type' => 'fix dripping tap'
            );
            $oDataItemFixDrippingTap =
                new Services_AMEE_DataItem($sPath, $aOptions);

            // Create a Profile Item based on this category
            $oProfileItemFixDrippingTap = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItemFixDrippingTap,
                    array()
                )
            );

            // Assert that the AMEE API Profile created has a vaild UID
            $bResult = preg_match('/^[0-9A-Z]{12}$/', $oProfile->getUID());
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Data Item created has a valid UID
            $bResult = preg_match(
                '/^[0-9A-Z]{12}$/', $oDataItemFixDrippingTap->getUID()
            );
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Data Item path is as expected
            $this->assertEquals(
                $oDataItemFixDrippingTap->getPath(), '/home/water/reductions'
            );

            // Assert that the AMEE API Profile Item created has a valid UID
            $bResult = preg_match(
                '/^[0-9A-Z]{12}$/', $oProfileItemFixDrippingTap->getUID()
            );
            $this->assertEquals($bResult, 1); // preg_matches returns an integer

            // Assert that the AMEE API Profile Item created has expected info
            $aInfo = $oProfileItemFixDrippingTap->getInfo();
            $this->assertEquals(
                $aInfo['uid'], $oProfileItemFixDrippingTap->getUID()
            );
            $this->assertEquals($aInfo['name'], '');
            $this->assertTrue(
                strtotime(date('c')) >= strtotime($aInfo['created'])
            );
            $this->assertTrue(
                strtotime(date('c')) >= strtotime($aInfo['modified'])
            );
            $this->assertEquals($aInfo['created'], $aInfo['modified']);
            $this->assertEquals($aInfo['profileUid'], $oProfile->getUID());
            $this->assertEquals($aInfo['path'], '/home/water/reductions');
            $this->assertEquals(
                $aInfo['dataItemUid'], $oDataItemFixDrippingTap->getUID()
            );
            $this->assertTrue($aInfo['amount'] > 0);
            $this->assertEquals($aInfo['unit'], 'kg');
            $this->assertEquals($aInfo['perUnit'], 'year');
            $this->assertTrue(
                strtotime(date('c')) >= strtotime($aInfo['startDate'])
            );
            $this->assertEquals($aInfo['endDate'], '');

        } catch (Exception $oException) {
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );
        }
    }

    /**
     * A PHPUnit regression integration test for COM-166, a bug where a poor
     * error message was returned in the event of an unvalid unit parameter
     * being supplied.
     */
    function test_COM_166()
    {
        try {

            // Create a new AMEE API Profile
            $oProfile = new Services_AMEE_Profile();

            // Create a Data Item object for /home/energy/quantity
            $sPath = '/home/energy/quantity';
            $aOptions = array(
                'type' => 'gas'
            );
            $oDataItem = new Services_AMEE_DataItem($sPath, $aOptions);

            // Create a Profile Item
            $oProfileItem = new Services_AMEE_ProfileItem(
                array(
                    $oProfile,
                    $oDataItem,
                    array(
                      'energyConsumption'        => '42',
                      'energyConsumptionPerUnit' => 'hour'
                    )
                )
            );

            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );

        } catch (Exception $oException) {

            $this->assertEquals(
                $oException->getMessage(),
                'The AMEE REST API was called called with invalid parameters'
            );

        }

    }

}

?>
