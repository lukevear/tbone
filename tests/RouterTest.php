<?php

use GuzzleHttp\Client;
use TBone\TBone;
use TBone\TBoneEvent;

class RouterTest extends PHPUnit_Framework_TestCase
{
    private function getClient()
    {
        /** @noinspection PhpUndefinedConstantInspection */
        return new Client([
            'base_uri' => 'http://' . WEB_SERVER_HOST . ':' . WEB_SERVER_PORT . '/',
            'exceptions' => false,
        ]);
    }

    public function testServer()
    {
        $response = $this->getClient()->request('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testGet()
    {
        $response = $this->getClient()->request('GET', '/');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['route' => '/']), $response->getBody()->__toString()
        );

        $response = $this->getClient()->request('GET', '/get');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['route' => '/get']), $response->getBody()->__toString()
        );
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testInvalidArgumentsForGet() {
        $router = new TBone;
        $router->get('/', null);
    }

    public function testPost()
    {
        $response = $this->getClient()->request('POST', '/post');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['route' => '/post']), $response->getBody()->__toString()
        );
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testInvalidArgumentsForPost() {
        $router = new TBone;
        $router->post('/', null);
    }

    public function testPut()
    {
        $response = $this->getClient()->request('PUT', '/put');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['route' => '/put']), $response->getBody()->__toString()
        );
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testInvalidArgumentsForPut() {
        $router = new TBone;
        $router->put('/', null);
    }

    public function testDelete()
    {
        $response = $this->getClient()->request('DELETE', '/delete');
        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['route' => '/delete']), $response->getBody()->__toString()
        );
    }

    /**
     * @expectedException TBone\TBoneException
     * @expectedExceptionMessage The callback that was provided is not callable.
     */
    public function testInvalidArgumentsForDelete() {
        $router = new TBone;
        $router->delete('/', null);
    }

    public function testNotFound()
    {
        $response = $this->getClient()->request('GET', '/doesnotexist');
        $this->assertEquals(404, $response->getStatusCode());

        $this->assertJsonStringEqualsJsonString(
            json_encode(['error' => TBoneEvent::ROUTE_NOT_FOUND]), $response->getBody()->__toString()
        );
    }

}