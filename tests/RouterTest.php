<?php

use TBone\TBone;
use TBone\TBoneEvent;

class RouterTest extends PHPUnit_Framework_TestCase
{
    protected $router;

    protected function setUp()
    {
        $this->router = new TBone();
    }

    protected function tearDown()
    {
        $_SERVER['REQUEST_METHOD'] = null;
        $_SERVER['REQUEST_URI'] = null;
    }

    public function testAddingOptions()
    {
        $this->assertTrue($this->router->options('/', function () {
            return true;
        }), 'Failed to add the route: OPTIONS /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidOptions()
    {
        $this->router->options('/bad-options', null);
    }

    public function testAddingHead()
    {
        $this->assertTrue($this->router->head('/', function () {
            return true;
        }), 'Failed to add the route: HEAD /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidHead()
    {
        $this->router->head('/bad-head', null);
    }

    public function testAddingGet()
    {
        $this->assertTrue($this->router->get('/', function () {
            return true;
        }), 'Failed to add the route: GET /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidGet()
    {
        $this->router->get('/bad-get', null);
    }

    public function testAddingPost()
    {
        $this->assertTrue($this->router->post('/', function () {
            return true;
        }), 'Failed to add the route: POST /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidPost()
    {
        $this->router->post('/bad-post', null);
    }

    public function testAddingPut()
    {
        $this->assertTrue($this->router->put('/', function () {
            return true;
        }), 'Failed to add the route: PUT /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidPut()
    {
        $this->router->put('/bad-put', null);
    }

    public function testAddingPatch()
    {
        $this->assertTrue($this->router->patch('/', function () {
            return true;
        }), 'Failed to add the route: PATCH /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidPatch()
    {
        $this->router->patch('/bad-patch', null);
    }

    public function testAddingDelete()
    {
        $this->assertTrue($this->router->delete('/', function () {
            return true;
        }), 'Failed to add the route: DELETE /');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testAddingInvalidDelete()
    {
        $this->router->delete('/bad-delete', null);
    }

    public function testAddingErrorHandler()
    {
        $this->assertTrue($this->router->addHandler(TBoneEvent::ROUTE_NOT_FOUND, function () {
            return false;
        }), 'Failed to add an error handler.');
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The handler provided is not callable.
     */
    public function testAddingInvalidHandler()
    {
        $this->router->addHandler(TBoneEvent::ROUTE_NOT_FOUND, null);
    }

    public function testCallingOptions()
    {
        $called = false;
        $this->router->options('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'OPTIONS';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingHead()
    {
        $called = false;
        $this->router->head('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'HEAD';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingGet()
    {
        $called = false;
        $this->router->get('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingPost()
    {
        $called = false;
        $this->router->post('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingPut()
    {
        $called = false;
        $this->router->put('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingPatch()
    {
        $called = false;
        $this->router->patch('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'PATCH';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testCallingDelete()
    {
        $called = false;
        $this->router->delete('/', function () use (&$called) {
            $called = true;

            return $called;
        });

        $_SERVER['REQUEST_METHOD'] = 'DELETE';
        $_SERVER['REQUEST_URI'] = '/';
        $this->router->route();
        $this->assertTrue($called);
    }

    public function testRouteMatching()
    {
        $firstCalled = false;
        $this->router->get('/', function () use (&$firstCalled) {
            $firstCalled = true;

            return $firstCalled;
        });

        $secondCalled = false;
        $this->router->get('/call-me', function () use (&$secondCalled) {
            $secondCalled = true;

            return $secondCalled;
        });

        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/call-me';
        $this->router->route();
        $this->assertFalse($firstCalled);
        $this->assertTrue($secondCalled);
    }

    public function testComplexRouteMatching()
    {
        $firstCalled = false;
        $this->router->get('/', function () use (&$firstCalled) {
            $firstCalled = true;

            return $firstCalled;
        });

        $secondCalled = false;
        $this->router->post('/call-me-post', function () use (&$secondCalled) {
            $secondCalled = true;

            return $secondCalled;
        });

        $thirdCalled = false;
        $this->router->get('/do-not-call-me-get', function () use (&$thirdCalled) {
            $thirdCalled = true;

            return $thirdCalled;
        });

        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/call-me-post';
        $this->router->route();
        $this->assertFalse($firstCalled);
        $this->assertTrue($secondCalled);
        $this->assertFalse($thirdCalled);
    }

    public function testComplexRouteMatchingWith404Page()
    {
        $firstCalled = false;
        $this->router->get('/', function () use (&$firstCalled) {
            $firstCalled = true;

            return $firstCalled;
        });

        $secondCalled = false;
        $this->router->post('/call-me-post', function () use (&$secondCalled) {
            $secondCalled = true;

            return $secondCalled;
        });

        $thirdCalled = false;
        $this->router->get('/do-not-call-me-get', function () use (&$thirdCalled) {
            $thirdCalled = true;

            return $thirdCalled;
        });

        $fourthCalled = false;
        $this->router->addHandler(TBoneEvent::ROUTE_NOT_FOUND, function () use (&$fourthCalled) {
            $fourthCalled = true;

            return $fourthCalled;
        });

        $_SERVER['REQUEST_METHOD'] = 'PUT';
        $_SERVER['REQUEST_URI'] = '/does-not-exist';
        $this->router->route();
        $this->assertFalse($firstCalled);
        $this->assertFalse($secondCalled);
        $this->assertFalse($thirdCalled);
        $this->assertTrue($fourthCalled);
    }
}
