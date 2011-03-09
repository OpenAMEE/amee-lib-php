<?php

/*
 * This file provides the Services_AMEE_API_UnitTest class. Please see the class
 * documentation for full details.
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

require_once 'Services/AMEE/API.php';

/**
 * The Services_AMEE_API_UnitTest class provides the PHPUnit unit test cases for
 * the Services_AMEE_API class.
 *
 * @category  Web Services
 * @package   Services_AMEE
 * @version   $Id$
 * @author    Andrew Hill <help@amee.com>
 * @copyright 2010-2011 AMEE UK Limited
 * @license   http://www.opensource.org/licenses/mit-license.html MIT License
 * @link      http://pear.php.net/package/Services_AMEE
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
        $this->assertClassHasStaticAttribute('oAPI', 'Services_AMEE_API');
    }

    /**
     * Test to ensure the Services_AMEE_API::signleton() method does only ever
     * create a single instance of the class.
     */
    public function testSingleton()
    {
        // Create a new instance of the class via the singleton
        $oAPI_Instance1 = Services_AMEE_API::singleton();

        // Create a second instance of the class via the singleton
        $oAPI_Instance2 = Services_AMEE_API::singleton();

        // Create a third instance of the class via the constructor
        $oAPI_Instance3 = new Services_AMEE_API();

        // Test that the instances generated via the singleton method are the
        // same object
        $this->assertSame($oAPI_Instance1, $oAPI_Instance2);

        // Test that the instances generated via the singletone method and the
        // class constructor are different objects
        $this->assertNotSame($oAPI_Instance1, $oAPI_Instance3);
        $this->assertNotSame($oAPI_Instance2, $oAPI_Instance3);
    }

    /**
     * Test to ensure that the Services_AMEE_API::post() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::validPath()
     * method.
     */
    public function testPostValidPathError()
    {
        // Prepare testing Exception to return
        $oPathException = new Exception('Valid Path Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() method mocked
        $aMockMethods = array(
            'validPath'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath()
        // method will be called exactly once with the path paramter
        // "/invalidpath" and type parameter "post", and set the Exception that
        // will be thrown by the method call.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('post')
                )
                ->will($this->throwException($oPathException));

        // Call the post() method
        try {
            $oMockAPI->post('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
            return;
        }
        
        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::put() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::validPath()
     * method.
     */
    public function testPutValidPathError()
    {
        // Prepare testing Exception to return
        $oPathException = new Exception('Valid Path Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() method mocked
        $aMockMethods = array(
            'validPath'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath()
        // method will be called exactly once with the path paramter
        // "/invalidpath" and type parameter "put", and set the Exception that
        // will be thrown by the method call.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('put')
                )
                ->will($this->throwException($oPathException));

        // Call the put() method
        try {
            $oMockAPI->put('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::get() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::validPath()
     * method.
     */
    public function testGetValidPathError()
    {
        // Prepare testing Exception to return
        $oPathException = new Exception('Valid Path Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() method mocked
        $aMockMethods = array(
            'validPath'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath()
        // method will be called exactly once with the path paramter
        // "/invalidpath" and type parameter "get", and set the Exception that
        // will be thrown by the method call.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('get')
                )
                ->will($this->throwException($oPathException));

        // Call the get() method
        try {
            $oMockAPI->get('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::delete() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::validPath()
     * method.
     */
    public function testDeleteValidPathError()
    {
        // Prepare testing Exception to return
        $oPathException = new Exception('Valid Path Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() method mocked
        $aMockMethods = array(
            'validPath'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath()
        // method will be called exactly once with the path paramter
        // "/invalidpath" and type parameter "delete", and set the Exception
        // that will be thrown by the method call.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/invalidpath'),
                    $this->equalTo('delete')
                )
                ->will($this->throwException($oPathException));

        // Call the delete() method
        try {
            $oMockAPI->delete('/invalidpath');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oPathException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::post() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::sendRequest()
     * method.
     */
    public function testPostSendRequestError()
    {
        // Prepare testing Exception to return
        $oRequestException = new Exception('Send Request Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath() method
        // will be called exactly once with the path paramter "/auth" and type
        // parameter "post", and set the return value of true.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/auth'),
                    $this->equalTo('post')
                )
                ->will($this->returnValue(true));

        // Set the expectation on the mocked object that sendRequest() method
        // will be called exactly once, with the paramters as suggested by the
        // expectation above. Set the Exception that will be thrown by the
        // method call.
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo('')
                )
                ->will($this->throwException($oRequestException));

        // Call the post() method
        try {
            $oMockAPI->post('/auth');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::put() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::sendRequest()
     * method.
     */
    public function testPutSendRequestError()
    {
        // Prepare testing Exception to return
        $oRequestException = new Exception('Send Request Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath() method
        // will be called exactly once with the path paramter
        // "/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08"
        // and type parameter "put", and set the return value of true.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('put')
                )
                ->will($this->returnValue(true));

        // Set the expectation on the mocked object that sendRequest() method
        // will be called exactly once, with the paramters as suggested by the
        // expectation above. Set the Exception that will be thrown by the
        // method call.
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('PUT /profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08'),
                    $this->equalTo('')
                )
                ->will($this->throwException($oRequestException));

        // Call the put() method
        try {
            $oMockAPI->put('/profiles/4A546C3F1B2E/transport/motorcycle/generic/9B32A9FC3B08');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::get() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::sendRequest()
     * method.
     */
    public function testGetSendRequestError()
    {
        // Prepare testing Exception to return
        $oRequestException = new Exception('Send Request Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath() method
        // will be called exactly once with the path paramter "/profiles" and type
        // parameter "get", and set the return value of true.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles'),
                    $this->equalTo('get')
                )
                ->will($this->returnValue(true));

        // Set the expectation on the mocked object that sendRequest() method
        // will be called exactly once, with the paramters as suggested by the
        // expectation above. Set the Exception that will be thrown by the
        // method call.
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('GET /profiles')
                )
                ->will($this->throwException($oRequestException));

        // Call the get() method
        try {
            $oMockAPI->get('/profiles');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::delete() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::sendRequest()
     * method.
     */
    public function testDeleteSendRequestError()
    {
        // Prepare testing Exception to return
        $oRequestException = new Exception('Send Request Test Exception');

        // Create the mocked version of the Services_AMEE_API class, with the
        // validPath() and sendRequest() methods mocked
        $aMockMethods = array(
            'validPath',
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation on the mocked object that the validPath() method
        // will be called exactly once with the path paramter
        // "/profiles/228A21573085/home/energy/quantity/B56410A978B6" and type
        // parameter "delete", and set the return value of true.
        $oMockAPI->expects($this->once())
                ->method('validPath')
                ->with(
                    $this->equalTo('/profiles/228A21573085/home/energy/quantity/B56410A978B6'),
                    $this->equalTo('delete')
                )
                ->will($this->returnValue(true));

        // Set the expectation on the mocked object that sendRequest() method
        // will be called exactly once, with the paramters as suggested by the
        // expectation above. Set the Exception that will be thrown by the
        // method call.
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('DELETE /profiles/228A21573085/home/energy/quantity/B56410A978B6')
                )
                ->will($this->throwException($oRequestException));

        // Call the delete() method
        try {
            $oMockAPI->delete('/profiles/228A21573085/home/energy/quantity/B56410A978B6');
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oRequestException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::post(),
     * Services_AMEE_API::put(), Services_AMEE_API::get() and
     * Services_AMEE_API::delete() methods correctly extract and return the
     * required JSON data returned from the Services_AMEE_API::sendRequest()
     * method return array.
     */
    public function testPostPutGetDelete()
    {
        // Create the mocked versions of the Services_AMEE_API class, with the
        // validPath() and sendRequest() methods mocked
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
     * Test the Services_AMEE_API::validPath() method with all possible valid
     * POST paths, and some obvious invalid variations.
     */
    public function testValidPathPost()
    {
        $oAPI = new Services_AMEE_API();

        // Test valid POST path: /auth
        unset($bResult);
        $bResult = $oAPI->validPath('/auth', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/business
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/business', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/embodied
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/embodied', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/home
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/home', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/metadata
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/metadata', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/planet
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/planet', 'post');
        $this->assertTrue($bResult);

        // Test valid POST path: /profiles/1234567890AB/transport
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/transport', 'post');
        $this->assertTrue($bResult);
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath1()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /aut
        try {
            $bResult = $oAPI->validPath('/aut', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /aut'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath2()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /authh
        try {
            $bResult = $oAPI->validPath('/authh', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /authh'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath3()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profile
        try {
            $bResult = $oAPI->validPath('/profile', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profile'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath4()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiless
        try {
            $bResult = $oAPI->validPath('/profiless', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiless'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath5()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiles/1234567890AB
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890AB', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiles/1234567890AB'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath6()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiles/1234567890AB/foo
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890AB/foo', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiles/1234567890AB/foo'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath7()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiles/1234567890A/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A/transport', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiles/1234567890A/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath8()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890ABB/transport', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiles/1234567890ABB/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid POST path.
     */
    public function testValidPathPostBadPostPath9()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud POST path: /profiles/1234567890AB@/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A@/transport', 'post');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API POST path specified: /profiles/1234567890A@/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with all possible valid
     * PUT paths, and some obvious invalid variations.
     */
    public function testValidPathPut()
    {
        $oAPI = new Services_AMEE_API();

        // Test valid PUT path: /profiles/1234567890AB
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/business
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/business', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/embodied
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/embodied', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/home
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/home', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/metadata
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/metadata', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/planet
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/planet', 'put');
        $this->assertTrue($bResult);

        // Test valid PUT path: /profiles/1234567890AB/transport
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/transport', 'put');
        $this->assertTrue($bResult);
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath1()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /auth
        try {
            $bResult = $oAPI->validPath('/auth', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /auth'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath2()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiles
        try {
            $bResult = $oAPI->validPath('/profiles', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath3()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profile
        try {
            $bResult = $oAPI->validPath('/profile', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profile'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath4()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiless
        try {
            $bResult = $oAPI->validPath('/profiless', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiless'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath5()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiles/1234567890AB/foo
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890AB/foo', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/1234567890AB/foo'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath6()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiles/1234567890A/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A/transport', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/1234567890A/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath7()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890ABB/transport', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/1234567890ABB/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid PUT path.
     */
    public function testValidPathPostBadPutPath8()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud PUT path: /profiles/1234567890AB@/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A@/transport', 'put');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API PUT path specified: /profiles/1234567890A@/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with all possible valid
     * GET paths, and some obvious invalid variations.
     */
    public function testValidPathGet()
    {
        $oAPI = new Services_AMEE_API();

        // Test valid GET path: /profiles
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/business
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/business', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/embodied
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/embodied', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/home
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/home', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/metadata
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/metadata', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/planet
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/planet', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /profiles/1234567890AB/transport
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/transport', 'get');
        $this->assertTrue($bResult);

        // Test valid GET path: /data
        unset($bResult);
        $bResult = $oAPI->validPath('/data', 'get');
        $this->assertTrue($bResult);
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath1()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /auth
        try {
            $bResult = $oAPI->validPath('/auth', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /auth'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath2()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profile
        try {
            $bResult = $oAPI->validPath('/profile', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profile'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath3()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiless
        try {
            $bResult = $oAPI->validPath('/profiless', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profiless'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath4()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiles/1234567890AB/foo
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890AB/foo', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profiles/1234567890AB/foo'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath5()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiles/1234567890A/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A/transport', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profiles/1234567890A/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath6()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890ABB/transport', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profiles/1234567890ABB/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath7()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiles/1234567890AB@/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A@/transport', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /profiles/1234567890A@/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid GET path.
     */
    public function testValidPathPostBadGetPath8()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud GET path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/dat', 'get');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API GET path specified: /dat'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with all possible valid
     * DELETE paths, and some obvious invalid variations.
     */
    public function testValidPathDelete()
    {
        $oAPI = new Services_AMEE_API();

        // Test valid DELETE path: /profiles/1234567890AB
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/business
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/business', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/embodied
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/embodied', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/home
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/home', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/metadata
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/metadata', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/planet
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/planet', 'delete');
        $this->assertTrue($bResult);

        // Test valid DELETE path: /profiles/1234567890AB/transport
        unset($bResult);
        $bResult = $oAPI->validPath('/profiles/1234567890AB/transport', 'delete');
        $this->assertTrue($bResult);
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath1()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles
        try {
            $bResult = $oAPI->validPath('/profiles', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /profiles'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }
    
    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath2()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles/1234567890AB/foo
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890AB/foo', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /profiles/1234567890AB/foo'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath3()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles/1234567890A/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A/transport', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /profiles/1234567890A/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath4()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890ABB/transport', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /profiles/1234567890ABB/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath5()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles/1234567890AB@/transport
        try {
            $bResult = $oAPI->validPath('/profiles/1234567890A@/transport', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /profiles/1234567890A@/transport'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the Services_AMEE_API::validPath() method with an invalid DELETE
     * path.
     */
    public function testValidPathPostBadDeletePath6()
    {
        $oAPI = new Services_AMEE_API();

        // Test invalud DELETE path: /profiles/1234567890ABB/transport
        try {
            $bResult = $oAPI->validPath('/dat', 'delete');
        } catch (Exception $oException) {
            $this->assertEquals(
                $oException->getMessage(),
                'Invalid AMEE REST API DELETE path specified: /dat'
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::sendRequest() method throws
     * an exception when called with a bad method (i.e. not PUT, PUSH, GET or
     * DELETE).
     */
    public function testSendRequestBadMethod()
    {
        // Prepare the expected exception
        $oBadMethodException = new Services_AMEE_Exception(
            'Invalid AMEE REST API method specified: FOO /auth'
        );

        // Create a guaranteed new insteance of the class
        $oAPI = new Services_AMEE_API();

        // Test the sendRequest() method with a bad method
        try {
            $oAPI->sendRequest('FOO /auth');
        } catch (Exception $oException) {
            // Test that an Exception was correctly raised; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the sendRequest() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oBadMethodException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oBadMethodException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure the Services_AMEE_API::sendRequest() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::connect()
     * method.
     */
    public function testSendRequestConnectionException()
    {
        // Prepare the expected exception
        $oConnectException = new Exception('Connection Exception');

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() and connect() methods mocked
        $aMockMethods = array(
            'connected',
            'connect'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation onthe mocked object that the connected()
        // method will be called exactly once and will return false. Set the
        // epxectation for the mocked object that the connect() method will be
        // called exactly once and will throw an Exception.
        $oMockAPI->expects($this->once())
                ->method('connected')
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->once())
                ->method('connect')
                ->will($this->throwException($oConnectException));

        try {
            $oMockAPI->sendRequest('GET /profiles');
        } catch (Exception $oException) {
            // Test the exception was correctly bubbled up
            $this->assertEquals($oException, $oConnectException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::sendRequest() method throws
     * an exception if the built in PHP fsockopen() function returns false.
     */
    public function testSendRequestSocketOpenError()
    {
        // Prepare the expected exception
        $oSendRequestException = new Services_AMEE_Exception(
            'Unable to connect to the AMEE REST API: '
        );

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() and connect() methods and the protected _socketOpen()
        // method mocked
        $aMockMethods = array(
            'connected',
            'connect',
            '_socketOpen'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the connected() and
        // connect() methods will never be called, and that the _socketOpen()
        // method will be called exactly once, with appropriate parameters,
        // and will return false.
        $oMockAPI->expects($this->never())
                ->method('connected');
        $oMockAPI->expects($this->never())
                ->method('connect');
        if (extension_loaded('openssl')) {
            $sHost = 'ssl://' . AMEE_API_URL;
            $sPort = AMEE_API_PORT_SSL;
        } else {
            $sHost = AMEE_API_URL;
            $sPort = AMEE_API_PORT;
        }
        $oMockAPI->expects($this->once())
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue(false));

        try {
            $oMockAPI->sendRequest('POST /auth');
        } catch (Exception $oException) {
            // Test that an Exception was correctly raised; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the sendRequest() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oSendRequestException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oSendRequestException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::sendRequest() method throws
     * an exception if the built in PHP fwrite() function returns false.
     */
    public function testSendRequestSocketWriteErrorFalse()
    {
        // Prepare the expected exception
        $oSendRequestException = new Services_AMEE_Exception(
            'Error sending the AMEE REST API request'
        );

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() and connect() methods and the protected _socketOpen()
        // and _socketWrite() methods mocked
        $aMockMethods = array(
            'connected',
            'connect',
            '_socketOpen',
            '_socketWrite'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the connected() and
        // connect() methods will never be called, that the _socketOpen() method
        // will be called exactly once, with appropriate parameters,
        // and will return a socket resource (in this case, faked with the
        // boolean true), and that the _socketWrite method will be called
        // exactly once, with appropriate parameters, and will return the
        // boolean false
        $oMockAPI->expects($this->never())
                ->method('connected');
        $oMockAPI->expects($this->never())
                ->method('connect');
        if (extension_loaded('openssl')) {
            $sHost = 'ssl://' . AMEE_API_URL;
            $sPort = AMEE_API_PORT_SSL;
        } else {
            $sHost = AMEE_API_URL;
            $sPort = AMEE_API_PORT;
        }
        $oMockAPI->expects($this->once())
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue(true));
        $sWrite = "POST /auth HTTP/1.1\n" .
                "Connection: close\n" .
                "Accept: application/json\n" .
                "Host: " . AMEE_API_URL . "\n" .
                "\n";
        $oMockAPI->expects($this->once())
                ->method('_socketWrite')
                ->with(
                    $this->equalTo(true),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(false));

        try {
            $oMockAPI->sendRequest('POST /auth');
        } catch (Exception $oException) {
            // Test that an Exception was correctly raised; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the sendRequest() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oSendRequestException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oSendRequestException->getMessage()
            );
            return;
        }
        
        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::sendRequest() method throws
     * an exception if the built in PHP fwrite() function returns a character
     * write count different to the original write string length.
     */
    public function testSendRequestSocketWriteErrorBadWrite()
    {
        // Prepare the expected exception
        $oSendRequestException = new Services_AMEE_Exception(
            'Error sending the AMEE REST API request'
        );

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() and connect() methods and the protected _socketOpen()
        // and _socketWrite() methods mocked
        $aMockMethods = array(
            'connected',
            'connect',
            '_socketOpen',
            '_socketWrite'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the connected() and
        // connect() methods will never be called, that the _socketOpen() method
        // will be called exactly once, with appropriate parameters,
        // and will return a socket resource (in this case, faked with the
        // boolean true), and that the _socketWrite method will be called
        // exactly once, with appropriate parameters, and will return an integer
        // value that is NOT the same as the number of characters written
        $oMockAPI->expects($this->never())
                ->method('connected');
        $oMockAPI->expects($this->never())
                ->method('connect');
        if (extension_loaded('openssl')) {
            $sHost = 'ssl://' . AMEE_API_URL;
            $sPort = AMEE_API_PORT_SSL;
        } else {
            $sHost = AMEE_API_URL;
            $sPort = AMEE_API_PORT;
        }
        $oMockAPI->expects($this->once())
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue(true));
        $sWrite = "POST /auth HTTP/1.1\n" .
                "Connection: close\n" .
                "Accept: application/json\n" .
                "Host: " . AMEE_API_URL . "\n" .
                "\n";
        $oMockAPI->expects($this->once())
                ->method('_socketWrite')
                ->with(
                    $this->equalTo(true),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(1));

        try {
            $oMockAPI->sendRequest('POST /auth');
        } catch (Exception $oException) {
            // Test that an Exception was correctly raised; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the sendRequest() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oSendRequestException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oSendRequestException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::sendRequest() method throws
     * an exception if an authorisation method call is made but a 401 UNAUTH
     * response is returned; also check that the method call is repeated only
     * once.
     */
    public function testSendRequestSocketUnath()
    {
        // Prepare the expected exception
        $oSendRequestException = new Services_AMEE_Exception(
            'The AMEE REST API returned an authorisation failure result'
        );

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected(), connect() and reconnect() methods and the protected
        // _socketOpen(), _socketWrite(), _socketEOF(), _socketGetLine() and
        // _socketClose() methods mocked
        $aMockMethods = array(
            'connected',
            'connect',
            'reconnect',
            '_socketOpen',
            '_socketWrite',
            '_socketEOF',
            '_socketGetLine',
            '_socketClose'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the connected() and
        // connect() methods will never be called, and then that:
        //
        // - The _socketOpen() method will be called with appropriate parameters
        //      and will return a socket resource (in this case, faked with the
        //      string "socket_01");
        // - The _socketWrite() method will be called with approriate parameters
        //      and will return an integer being the length of the write string
        //      parameter;
        // - The _socketEOF() method will be called with appropriate parameters
        //      and will return false;
        // - The _socketGetLine() method will be called with appropriate
        //      parameters, and will return the string "HTTP/1.1 401 UNAUTH";
        // - The _socketEOF() method will be called with appropriate parameters
        //      and will return true;
        // - The _socketClose() method will be called with appropriate
        //      parameters and will return true;
        // - The reconnect() method will be called;
        //
        // The process above will then repeat, this time with a fake socket
        // resource string "socket_02", but without the call to re-connect,
        // resulting in an Exception being raised.
        $oMockAPI->expects($this->never())
                ->method('connected');
        $oMockAPI->expects($this->never())
                ->method('connect');
        if (extension_loaded('openssl')) {
            $sHost = 'ssl://' . AMEE_API_URL;
            $sPort = AMEE_API_PORT_SSL;
        } else {
            $sHost = AMEE_API_URL;
            $sPort = AMEE_API_PORT;
        }
        $oMockAPI->expects($this->at(0))
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue('socket_01'));
        $sWrite = "POST /auth HTTP/1.1\n" .
                "Connection: close\n" .
                "Accept: application/json\n" .
                "Host: " . AMEE_API_URL . "\n" .
                "\n";
        $oMockAPI->expects($this->at(1))
                ->method('_socketWrite')
                ->with(
                    $this->equalTo('socket_01'),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(strlen($sWrite)));
        $oMockAPI->expects($this->at(2))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket_01')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(3))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket_01')
                )
                ->will($this->returnValue('HTTP/1.1 401 UNAUTH'));
        $oMockAPI->expects($this->at(4))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket_01')
                )
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->at(5))
                ->method('_socketClose')
                ->with(
                    $this->equalTo('socket_01')
                )
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->once())
                ->method('reconnect');
        $oMockAPI->expects($this->at(7))
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue('socket_02'));
        $oMockAPI->expects($this->at(8))
                ->method('_socketWrite')
                ->with(
                    $this->equalTo('socket_02'),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(strlen($sWrite)));
        $oMockAPI->expects($this->at(9))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket_02')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(10))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket_02')
                )
                ->will($this->returnValue('HTTP/1.1 401 UNAUTH'));
        $oMockAPI->expects($this->at(11))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket_02')
                )
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->at(12))
                ->method('_socketClose')
                ->with(
                    $this->equalTo('socket_02')
                )
                ->will($this->returnValue(true));

        try {
            $oMockAPI->sendRequest('POST /auth');
        } catch (Exception $oException) {
            // Test that an Exception was correctly raised; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the sendRequest() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oSendRequestException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oSendRequestException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test the return data for a valid Services_AMEE_API::sendRequest() method
     * call where the headers as well as the JSON data is requested to be
     * returned; also tests the HTTP message sent, where no body exists.
     */
    public function testSendRequestHeaders()
    {
        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() method and the protected _socketOpen(), _socketWrite(),
        // _socketEOF(), _socketGetLine() and _socketClose() methods mocked
        $aMockMethods = array(
            'connected',
            '_socketOpen',
            '_socketWrite',
            '_socketEOF',
            '_socketGetLine',
            '_socketClose'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that|:
        //
        // - The connected() method will be called and will return true;
        // - The _socketOpen() method will be called with appropriate parameters
        //      and will return a socket resource (in this case, faked with the
        //      string "socket");
        // - The _socketWrite() method will be called with approriate parameters
        //      and will return an integer being the length of the write string
        //      parameter;
        //
        // LOOP
        //   - The _socketEOF() method will be called with appropriate parameters
        //      and will return false;
        //   - The _socketGetLine() method will be called with appropriate
        //      parameters, and will return a valid response string;
        // END LOOP
        //
        // - The _socketEOF() method will be called with appropriate parameters
        //      and will return true;
        // - The _socketClose() method will be called with appropriate
        //      parameters and will return true.
        $oMockAPI->expects($this->once())
                ->method('connected')
                ->will($this->returnValue(true));
        $sHost = AMEE_API_URL;
        $sPort = AMEE_API_PORT;
        $oMockAPI->expects($this->once())
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue('socket'));
        $sWrite = "GET /profiles HTTP/1.1\n" .
                "Connection: close\n" .
                "Accept: application/json\n" .
                "Cookie: authToken=\n" .
                "Host: " . AMEE_API_URL . "\n" .
                "\n";
        $oMockAPI->expects($this->once())
                ->method('_socketWrite')
                ->with(
                    $this->equalTo('socket'),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(strlen($sWrite)));
        $oMockAPI->expects($this->at(3))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(4))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('HTTP/1.1 200 OK'));
        $oMockAPI->expects($this->at(5))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(6))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('Content-Type: application/json; charset=UTF-8'));
        $oMockAPI->expects($this->at(7))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(8))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('{JSON DATA}'));
        $oMockAPI->expects($this->at(9))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->once())
                ->method('_socketClose')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(true));

        // Test the sendRequest() method
        $aResult = $oMockAPI->sendRequest('GET /profiles', null, true);
        $aExpectedResult = array(
            'HTTP/1.1 200 OK',
            'Content-Type: application/json; charset=UTF-8',
            '{JSON DATA}'
        );
        $this->assertEquals($aResult, $aExpectedResult);
    }

    /**
     * Test the return data for a valid Services_AMEE_API::sendRequest() method
     * call where just the JSON data is requested to be returned; also tests
     * the HTTP message sent, where a body does exist.
     */
    public function testSendRequestJSON()
    {

        // Create a mocked version of the Services_AMEE_API class, with the
        // connected() method and the protected _socketOpen(), _socketWrite(),
        // _socketEOF(), _socketGetLine() and _socketClose() methods mocked
        $aMockMethods = array(
            'connected',
            '_socketOpen',
            '_socketWrite',
            '_socketEOF',
            '_socketGetLine',
            '_socketClose'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that|:
        //
        // - The connected() method will be called and will return true;
        // - The _socketOpen() method will be called with appropriate parameters
        //      and will return a socket resource (in this case, faked with the
        //      string "socket");
        // - The _socketWrite() method will be called with approriate parameters
        //      and will return an integer being the length of the write string
        //      parameter;
        //
        // LOOP
        //   - The _socketEOF() method will be called with appropriate parameters
        //      and will return false;
        //   - The _socketGetLine() method will be called with appropriate
        //      parameters, and will return a valid response string;
        // END LOOP
        //
        // - The _socketEOF() method will be called with appropriate parameters
        //      and will return true;
        // - The _socketClose() method will be called with appropriate
        //      parameters and will return true.
        $oMockAPI->expects($this->once())
                ->method('connected')
                ->will($this->returnValue(true));
        $sHost = AMEE_API_URL;
        $sPort = AMEE_API_PORT;
        $oMockAPI->expects($this->once())
                ->method('_socketOpen')
                ->with(
                    $this->equalTo($sHost),
                    $this->equalTo($sPort),
                    $this->equalTo(''),
                    $this->equalTo('')
                )
                ->will($this->returnValue('socket'));
        $sWrite = "GET /profiles HTTP/1.1\n" .
                "Connection: close\n" .
                "Accept: application/json\n" .
                "Cookie: authToken=\n" .
                "Host: " . AMEE_API_URL . "\n" .
                "Content-Type: application/x-www-form-urlencoded\n" .
                "Content-Length: 9\n" .
                "\n" .
                "fake_body";
        $oMockAPI->expects($this->once())
                ->method('_socketWrite')
                ->with(
                    $this->equalTo('socket'),
                    $this->equalTo($sWrite)
                )
                ->will($this->returnValue(strlen($sWrite)));
        $oMockAPI->expects($this->at(3))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(4))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('HTTP/1.1 200 OK'));
        $oMockAPI->expects($this->at(5))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(6))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('Content-Type: application/json; charset=UTF-8'));
        $oMockAPI->expects($this->at(7))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(false));
        $oMockAPI->expects($this->at(8))
                ->method('_socketGetLine')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue('{JSON DATA}'));
        $oMockAPI->expects($this->at(9))
                ->method('_socketEOF')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->once())
                ->method('_socketClose')
                ->with(
                    $this->equalTo('socket')
                )
                ->will($this->returnValue(true));

        // Test the sendRequest() method
        $aResult = $oMockAPI->sendRequest('GET /profiles', 'fake_body');
        $aExpectedResult = array(
            '{JSON DATA}'
        );
        $this->assertEquals($aResult, $aExpectedResult);
    }

    /**
     * Test to ensure that the Services_AMEE_API::connect() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::sendRequest()
     * method.
     */
    public function testConnectSendRequestError()
    {
        // Prepare the expected exception
        $oSendRequestException = new Exception('Send Request Exception');

        // Create a mocked version of the Services_AMEE_API class, with the
        // sendRequest() method mocked
        $aMockMethods = array(
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the sendRequest()
        // method will be called exactly once, with appropriate parameters.
        // Set the mocked method to raise an exception.
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo(
                        'username=' . AMEE_API_PROJECT_KEY .
                        '&password=' . AMEE_API_PROJECT_PASSWORD
                    )
                )
                ->will($this->throwException($oSendRequestException));

        // Call the connect() method
        try {
            $oMockAPI->connect();
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oSendRequestException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::connect() method throws
     * an exception if the Services_AMEE_API::sendRequest() method does not
     * return an authorsation token.
     */
    public function testConnectSendRequestNoAuthToken()
    {
        // Prepare the expected exception
        $oConnectionException = new Services_AMEE_Exception(
            'Authentication error: No authToken returned by the AMEE REST API'
        );

        // Create a mocked version of the Services_AMEE_API class, with the
        // sendRequest() method mocked
        $aMockMethods = array(
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the sendRequest()
        // method will be called exactly once, with appropriate parameters.
        // Set the mocked method to return an invalid (i.e. no connection)
        // array.
        $aReturn = array(
            'HTTP/1.1 200 OK',
            'Content-Type: application/json; charset=UTF-8'
        );
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo(
                        'username=' . AMEE_API_PROJECT_KEY .
                        '&password=' . AMEE_API_PROJECT_PASSWORD
                    )
                )
                ->will($this->returnValue($aReturn));

        // Call the connect() method
        try {
            $oMockAPI->connect();
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up; done a little bit
            // differently from object comparison, as we're testing an Exception
            // object created in the connect() method itself, rather than a
            // mocked method exception
            $this->assertEquals(
                get_class($oException),
                get_class($oConnectionException)
            );
            $this->assertEquals(
                $oException->getMessage(),
                $oConnectionException->getMessage()
            );
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::connect() method returns true
     * if the connection was created correctly.
     */
    public function testConnect()
    {
        // Create a mocked version of the Services_AMEE_API class, with the
        // sendRequest() method mocked
        $aMockMethods = array(
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the sendRequest()
        // method will be called exactly once, with appropriate parameters.
        // Set the mocked method to return a valid (i.e. connection) array.
        $aReturn = array(
            'HTTP/1.1 200 OK',
            'Set-Cookie: authToken=1KVARbypAjxLGViZ0Cg+UskZEHmqVkhx/PmEvzkPGpnUlH17KQbJ58xfapXiewVVPvG2CtrQNTuawY+KWU4Dxx08570dM2Z0sZAoeijdlucuCOvAyHhi9A==;',
            'authToken: 1KVARbypAjxLGViZ0Cg+UskZEHmqVkhx/PmEvzkPGpnUlH17KQbJ58xfapXiewVVPvG2CtrQNTuawY+KWU4Dxx08570dM2Z0sZAoeijdlucuCOvAyHhi9A==',
            'Content-Type: application/json; charset=UTF-8'
        );
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo(
                        'username=' . AMEE_API_PROJECT_KEY .
                        '&password=' . AMEE_API_PROJECT_PASSWORD
                    )
                )
                ->will($this->returnValue($aReturn));

        // Call the connect() method
        $bResult = $oMockAPI->connect();
        $this->assertTrue($bResult);
    }
    
    /**
     * Test to ensure that the Services_AMEE_API::connected() method and the
     * Services_AMEE_API::disconnect() method behave as expected when there is
     * and is not a connection.
     */
    public function testConnectedDisconnect()
    {
        // Create a mocked version of the Services_AMEE_API class, with the
        // sendRequest() method mocked
        $aMockMethods = array(
            'sendRequest'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Test that there is no connection
        $bResult = $oMockAPI->connected();
        $this->assertFalse($bResult);

        // Set the expectation for the mocked object that the sendRequest()
        // method will be called exactly once, with appropriate parameters.
        // Set the mocked method to return a valid (i.e. connection) array.
        $aReturn = array(
            'HTTP/1.1 200 OK',
            'Set-Cookie: authToken=1KVARbypAjxLGViZ0Cg+UskZEHmqVkhx/PmEvzkPGpnUlH17KQbJ58xfapXiewVVPvG2CtrQNTuawY+KWU4Dxx08570dM2Z0sZAoeijdlucuCOvAyHhi9A==;',
            'authToken: 1KVARbypAjxLGViZ0Cg+UskZEHmqVkhx/PmEvzkPGpnUlH17KQbJ58xfapXiewVVPvG2CtrQNTuawY+KWU4Dxx08570dM2Z0sZAoeijdlucuCOvAyHhi9A==',
            'Content-Type: application/json; charset=UTF-8'
        );
        $oMockAPI->expects($this->once())
                ->method('sendRequest')
                ->with(
                    $this->equalTo('POST /auth'),
                    $this->equalTo(
                        'username=' . AMEE_API_PROJECT_KEY .
                        '&password=' . AMEE_API_PROJECT_PASSWORD
                    )
                )
                ->will($this->returnValue($aReturn));

        // Call the connect() method
        $bResult = $oMockAPI->connect();

        // Test that there is a connection
        $bResult = $oMockAPI->connected();
        $this->assertTrue($bResult);

        // Call the disconnect() method
        $bResult = $oMockAPI->disconnect();
        $this->assertTrue($bResult);

        // Test that there is not a connection
        $bResult = $oMockAPI->connected();
        $this->assertFalse($bResult);
    }

    /**
     * Test to ensure that the Services_AMEE_API::reconnect() method correctly
     * bubbles up an Exception thrown by the Services_AMEE_API::connect()
     * method.
     */
    public function testReconnectConnectError()
    {
        // Prepare the expected exception
        $oConnectException = new Exception('Connect Exception');

        // Create a mocked version of the Services_AMEE_API class, with the
        // disconnect() and connect() methods mocked
        $aMockMethods = array(
            'disconnect',
            'connect'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the disconnect()
        // method will be called exactly once, and return true. Set
        // the expectation that the connect() method will called exactly once
        // and will raise an Exception.
        $oMockAPI->expects($this->once())
                ->method('disconnect')
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->once())
                ->method('connect')
                ->will($this->throwException($oConnectException));

        // Call the reconnect() method
        try {
            $oMockAPI->reconnect();
        } catch (Exception $oException) {
            // Test the Exception was correctly bubbled up
            $this->assertSame($oException, $oConnectException);
            return;
        }

        // If we get here, the test has failed
        $this->fail('Test failed because expected Exception was not thrown');
    }

    /**
     * Test to ensure that the Services_AMEE_API::reconnect() method returns
     * true if the connection can be re-made.
     */
    public function testReconnect()
    {
        // Create a mocked version of the Services_AMEE_API class, with the
        // disconnect() and connect() methods mocked
        $aMockMethods = array(
            'disconnect',
            'connect'
        );
        $oMockAPI = $this->getMock('Services_AMEE_API', $aMockMethods);

        // Set the expectation for the mocked object that the disconnect()
        // and connect() methods will be called exactly once.
        $oMockAPI->expects($this->once())
                ->method('disconnect')
                ->will($this->returnValue(true));
        $oMockAPI->expects($this->once())
                ->method('connect')
                ->will($this->returnValue(true));

        // Call the reconnect() method
        $bResult = $oMockAPI->reconnect();
        // Test the result is valid
        $this->assertTrue($bResult);
    }

}

?>
