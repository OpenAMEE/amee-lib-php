<?php

/*
 * This file provides the Services_AMEE_DataItem_IntegrationTest class.
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

/**
 * The Services_AMEE_DataItem_IntegrationTest class provides a PHPUnit
 * integration test case that tests the static method
 * Services_AMEE_DataItem::browseDrillDownOptions().
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_DataItem_IntegrationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the functionality of the
     * Services_AMEE_DataItem::browseDrillDownOptions() method.
     */
    public function testBrowseDrillDownOptions()
    {

        // Test 1: Test that the /metadata path has no drill down options.
        try {
            $aOptions = Services_AMEE_DataItem::browseDrillDownOptions(
                '/metadata'
            );
        } catch (Exception $oException) {
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );
        }
        $this->assertEquals(array(), $aOptions);

        // Test 2: Test that the /transport/car/generic path, with no
        //         selected drill down options, returns the expected drill
        //         down options for the "fuel" drill down.
        try {
            $aOptions = Services_AMEE_DataItem::browseDrillDownOptions(
                '/transport/car/generic',
                array()
            );
        } catch (Exception $oException) {
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );
        }
        $aExpected = array(
            'drillOption' => 'fuel',
            'options'     => array(
                'average'       => 'average',
                'cng'           => 'cng',
                'diesel'        => 'diesel',
                'lpg'           => 'lpg',
                'petrol'        => 'petrol',
                'petrol hybrid' => 'petrol hybrid'
            )
        );
        $this->assertEquals($aExpected, $aOptions);

        // Test 3: Test that the /transport/car/generic path, with the
        //         value "diesel" used for the "fuel" drill down option
        //         returns the expected drill down options for the "size"
        //         drill down.
        try {
            $aOptions = Services_AMEE_DataItem::browseDrillDownOptions(
                '/transport/car/generic',
                array('fuel' => 'diesel')
            );
        } catch (Exception $oException) {
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );
        }
        $aExpected = array(
            'drillOption' => 'size',
            'options'     => array(
                'small'  => 'small',
                'medium' => 'medium',
                'large'  => 'large'
            )
        );
        $this->assertEquals($aExpected, $aOptions);

        // Test 4: Test that the /transport/car/generic path, with the
        //         value "average" used for the "fuel" drill down option
        //         returns the expected drill down options for the "size"
        //         drill down.
        //
        //         Note that Test 4 differs from Test 3 because with "fuel"
        //         being "average", there is only one possible choice for
        //         the "size" drill down, and the API returns the data in
        //         a different format as a result.
        try {
            $aOptions = Services_AMEE_DataItem::browseDrillDownOptions(
                '/transport/car/generic',
                array('fuel' => 'average')
            );
        } catch (Exception $oException) {
            $this->fail(
                'Test failed, as no Exception should have been thrown!'
            );
        }
        $aExpected = array(
            'drillOption' => 'size',
            'options'     => array(
                'average'  => 'average'
            )
        );
        $this->assertEquals($aExpected, $aOptions);
        
    }
    
}

?>
