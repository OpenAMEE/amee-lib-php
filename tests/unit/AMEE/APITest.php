<?php

/*
 * This file provides the Services_AMEE_API_UnitTest class. Please see the class
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

require_once 'PHPUnit/Framework.php';
require_once 'Services/AMEE/API.php';

/**
 * The Services_AMEE_API_UnitTest class provides the PHPUnit unit test cases for
 * the Services_AMEE_API class.
 *
 * @category Web Services
 * @package Services_AMEE
 * @author Andrew Hill <andrew.hill@amee.com>
 * @copyright 2010 AMEE UK Limited
 * @license http://www.opensource.org/licenses/mit-license.html MIT License
 * @link http://pear.php.net/package/Services_AMEE
 */
class Services_AMEE_API_UnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test to ensure the Services_AMEE_API class has the required class
     * attributes.
     */
    public function testVariables()
    {
        $this->assertClassHasAttribute('sAuthToken',          'Services_AMEE_API');
        $this->assertClassHasAttribute('iAuthExpires',        'Services_AMEE_API');
        $this->assertClassHasAttribute('aPostPathOpenings',   'Services_AMEE_API');
        $this->assertClassHasAttribute('aPutPathOpenings',    'Services_AMEE_API');
        $this->assertClassHasAttribute('aGetPathOpenings',    'Services_AMEE_API');
        $this->assertClassHasAttribute('aDeletePathOpenings', 'Services_AMEE_API');
    }

    /**
     * Test the public post(), put(), get() and delete() methods, using a mocked
     * version of the validPath() method which returns an Exception.
     */
    public function testPostPutGetDeleteInvalidPath()
    {
        // Prepare testing Exception to return
        $oPathException = new Exception('Valid Path Test Exception');

        // Create the mocked versions of the Services_AMEE_API class, with the
        // protected validPath() method mocked
        $aMockMethods = array(
            'validPath'
        );
        $oMockAPIPost   = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIPut    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIGet    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIDelete = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked objects that the validPath()
        // method will be called exactly once, with the path paramter
        // "/invalidpath" and type parameters "post", "put", "get" and "delete"
        // respectively for the mocked objects. Set the Exception that will be
        // thrown by the method call in all four cases.
        $oMockAPIPost->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('post')
                )
                ->will($this->throwException($oPathException));
        $oMockAPIPut->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('put')
                )
                ->will($this->throwException($oPathException));
        $oMockAPIGet->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('get')
                )
                ->will($this->throwException($oPathException));
        $oMockAPIDelete->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('delete')
                )
                ->will($this->throwException($oPathException));

        // Call the post() method
        try {
            $oMockAPIPost->post('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
        }

        // Call the put() method
        try {
            $oMockAPIPut->put('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
        }

        // Call the get() method
        try {
            $oMockAPIGet->get('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
        }

        // Call the delete() method
        try {
            $oMockAPIDelete->delete('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
        }
    }

    /**
     * Test the public post(), put(), get() and delete() methods, using a mocked
     * version of the validPath() method which returns true, and a mocked
     * version of the sendRequest() method which returns an Exception.
     */
    public function testPostPutGetDeleteAPIError()
    {
        // Prepare testing Exception to return
        $oRequestException = new Exception('Send Request Test Exception');

        // Create the mocked versions of the Services_AMEE_API class, with the
        // protected validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPIPost   = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIPut    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIGet    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIDelete = $this->getMock('Services_AMEE_API', $aMockMethods);
        
        // Set the expectation for the mocked objects that the validPath()
        // method will be called exactly once, with the path paramters
        // "/auth",
        // "/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08",
        // "/profiles" and
        // "/profiles/228A21573085/home/energy/quantity/B56410A978B6"
        // respectively and type parameters "post", "put", "get" and "delete"
        // respectively for the mocked objects. Set the return respose of
        // "true".
        $oMockAPIPost->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/auth'),
                    $this->equalTo('post')
                )
                ->will($this->returnValue(true));
        $oMockAPIPut->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('put')
                )
                ->will($this->returnValue(true));
        $oMockAPIGet->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles'),
                    $this->equalTo('get')
                )
                ->will($this->returnValue(true));
        $oMockAPIDelete->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/228A21573085/home/energy/quantity/B56410A978B6'),
                    $this->equalTo('delete')
                )
                ->will($this->returnValue(true));
        
        // Set the expectation that the sendRequest() method will be called
        // once, with the paramters as suggested by the expectations above. Set
        // the Exception that will be thrown by the method call. Note the
        // null body parameter expections for GET and DELETE.
        $oMockAPIPost->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo('')
                )
                ->will($this->throwException($oRequestException));
        $oMockAPIPut->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('PUT /profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('')
                )
                ->will($this->throwException($oRequestException));
        $oMockAPIGet->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('GET /profiles')
                )
                ->will($this->throwException($oRequestException));
        $oMockAPIDelete->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('DELETE /profiles/228A21573085/home/energy/quantity/B56410A978B6')
                )
                ->will($this->throwException($oRequestException));

        // Call the post() method
        try {
            $oMockAPIPost->post('/auth');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
        }

        // Call the put() method
        try {
            $oMockAPIPut->put('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
        }

        // Call the get() method
        try {
            $oMockAPIGet->get('/profiles');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
        }

        // Call the delete() method
        try {
            $oMockAPIDelete->delete('/profiles/228A21573085/home/energy/quantity/B56410A978B6');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
        }
    }

    /**
     * Test the public post(), put(), get() and delete() methods, using a mocked
     * version of the validPath() method which returns true, and a mocked
     * version of the sendRequest() method which returns a fake JSON response
     * in an array.
     */
    public function testPostPutGetDelete()
    {
        // Create the mocked versions of the Services_AMEE_API class, with the
        // protected validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPIPost   = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIPut    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIGet    = $this->getMock('Services_AMEE_API', $aMockMethods);
        $oMockAPIDelete = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked objects that the validPath()
        // method will be called exactly once, with the path paramters
        // "/auth",
        // "/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08",
        // "/data/transport/car/generic/drill" and
        // "/profiles/228A21573085/home/energy/quantity/B56410A978B6"
        // respectively and type parameters "post", "put", "get" and "delete"
        // respectively for the mocked objects. Set the return respose of
        // "true".
        $oMockAPIPost->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/auth'),
                    $this->equalTo('post')
                )
                ->will($this->returnValue(true));
        $oMockAPIPut->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('put')
                )
                ->will($this->returnValue(true));
        $oMockAPIGet->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/data/transport/car/generic/drill'),
                    $this->equalTo('get')
                )
                ->will($this->returnValue(true));
        $oMockAPIDelete->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/228A21573085/home/energy/quantity/B56410A978B6'),
                    $this->equalTo('delete')
                )
                ->will($this->returnValue(true));

        // Set the expectation that the sendRequest() method will be called
        // once, with the paramters as suggested by the expectations above and
        // with optional parameter values, when supported. Set the fake JSON
        // data return arrays. Note the null body parameter expections for GET
        // and DELETE.
        $aReturnPost = array(
            0 => '{POST JSON DATA}'
        );
        $aReturnPut = array(
            0 => '{PUT JSON DATA}'
        );
        $aReturnGet = array(
            0 => '{GET JSON DATA}'
        );
        $aReturnDelete = array(
            0 => '{DELETE JSON DATA}'
        );
        $oMockAPIPost->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo('username=user&password=pass')
                )
                ->will($this->returnValue($aReturnPost));
        $oMockAPIPut->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('PUT /profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('distance=200&representation=full')
                )
                ->will($this->returnValue($aReturnPut));
        $oMockAPIGet->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('GET /data/transport/car/generic/drill?fuel=diesel&size=large')
                )
                ->will($this->returnValue($aReturnGet));
        $oMockAPIDelete->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('DELETE /profiles/228A21573085/home/energy/quantity/B56410A978B6')
                )
                ->will($this->returnValue($aReturnDelete));

        // Call the post() method
        $aOptions = array(
            'username' => 'user',
            'password' => 'pass'
        );
        $sResult = $oMockAPIPost->post('/auth', $aOptions);
        // Test the result is valid
        $this->assertEquals($sResult, '{POST JSON DATA}');

        // Call the put() method
        $aOptions = array(
            'distance'       => '200',
            'representation' => 'full'
        );
        $sResult = $oMockAPIPut->put('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08', $aOptions);
        // Test the result is valid
        $this->assertEquals($sResult, '{PUT JSON DATA}');

        // Call the get() method
        $aOptions = array(
            'fuel' => 'diesel',
            'size' => 'large'
        );
        $sResult = $oMockAPIGet->get('/data/transport/car/generic/drill', $aOptions);
        // Test the result is valid
        $this->assertEquals($sResult, '{GET JSON DATA}');

        // Call the delete() method
        $sResult = $oMockAPIDelete->delete('/profiles/228A21573085/home/energy/quantity/B56410A978B6');
        // Test the result is valid
        $this->assertEquals($sResult, '{DELETE JSON DATA}');
    }

    /**
     * Test all possible valid methods & paths, and some obvious invalid
     * variations.
     */
    public function testValidPath()
    {
        $oAPI = new Services_AMEE_API();

        // Test POST /auth methods
        unset($bResult);
        $bResult = $oAPI->validPath('/auth', 'post');
        $this->assertTrue($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/aut', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /aut'
            );
        }
        $this->assertNull($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/authh', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /authh'
            );
        }
        $this->assertNull($bResult);

        // Test POST /profiles methods
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles', 'post');
        $this->assertTrue($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/profile', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profile'
            );
        }
        $this->assertNull($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/profiless', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiless'
            );
        }
        $this->assertNull($bResult);

        // Test PUT /profiles methods
        try {
            $bResult = $oAPI->validPath('/profile', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profile'
            );
        }
        $this->assertNull($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/profiles', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles'
            );
        }
        $this->assertNull($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/profiles/ACDF76287', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/ACDF76287'
            );
        }
        $this->assertNull($bResult);
        $this->assertNull($bResult);
        unset($bResult);
        try {
            $bResult = $oAPI->validPath('/profiles/ACDF7628DF577', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/ACDF7628DF577'
            );
        }
        $this->assertNull($bResult);
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/ACDF7628D527', 'put');
        $this->assertTrue($bResult);
    }

    public function testSendRequest()
    {

    }

    public function testConnected()
    {

    }

    public function testConnect()
    {

    }

    public function testDisconnect()
    {

    }

    public function testReconnect()
    {

    }

}

?>
