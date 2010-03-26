<?php

/*
 * This file provides the Services_AMEE_ProfileItem class. Please see the class
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
 */

require_once 'Services/AMEE/BaseObject.php';

/**
 * The Services_AMEE_ProfileItem class is used to represent an AMEE Profile
 * Item and provides all of the methods required to ...
 *
 * An AMEE Profile Item is an "instance" of an AMEE Data Item within an AMEE
 * Profile. For example, if you had an AMEE Profile that represented a
 * household's CO2 emissions, and you wanted to include the use of an average
 * sized European petrol car in the AMEE Profile, then you would include an
 * AMEE Profile Item of the approciate AMEE Data Item.
 *
 * (The details of the level of use of the car are then included as an AMEE
 * Profile Item Value.)
 *
 * For more information about AMEE Profiles, please see:
 *      http://my.amee.com/developers/wiki/ProfileItem
 *
 * Please see the Services_AMEE_ProfileItemValue class for more details about
 * AMEE Profile Item Values.
 * 
 * Please see the Services_AMEE_DataItem class for more details about AMEE Data
 * Items.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_ProfileItem extends Services_AMEE_BaseObject
{

    /**
     * @var <integer> $iAmount The amount of CO2 produced by this AMEE Profile
     *      Item.
     */
    private $iAmount;

    /**
     * @var <string> $sUnit The mass unit for this AMEE Profile Item's amount
     *      value.
     */
    private $sUnit;

    /**
     * @var <string> $sPerUnit The time unit for this AMEE Profile Item's amount
     *      value.
     */
    private $sPerUnit;

    /**
     * @var <string> $sStartDate The time that this AMEE Profile Item is valid
     *      from.
     */
    private $sStartDate;

    /**
     * @var <string> $sEndDate The time that this AMEE Profile Item is valid
     *      until.
     */
    private $sEndDate;

    /**
     * A method to update the AMEE Profile Item.
     *
     * 
     */
    public function update()
    {

    }

    /**
     * A method to delete the AMEE Profile Item.
     *
     * @return <mixed> True on success; an Exception object otherwise.
     */
    public function delete()
    {

    }

}

?>
