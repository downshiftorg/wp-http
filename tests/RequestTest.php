<?php

namespace NetRivet\WordPress\Http;

class RequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var ResponseFactory
     */
    protected $factory;

    /**
     * @var WP_Http
     */
    protected $wpHttp;

    /**
     * @var Request
     */
    protected $request;

    public function setUp()
    {
        $this->wpHttp  = $this->prophesize('WP_Http');
        $this->factory = $this->prophesize('NetRivet\WordPress\Http\ResponseFactory');
        $this->request = new Request($this->factory->reveal(), $this->wpHttp->reveal());
    }

    public function testGetPassesArgsOnToWordpressClass()
    {
        $this->wpHttp->get('http://foo.com', ['bar'])->shouldBeCalled();

        $this->request->get('http://foo.com', ['bar']);
    }

    public function testPostPassesArgsOnToWordpressClass()
    {
        $this->wpHttp->post('http://foo.com', ['bar'])->shouldBeCalled();

        $this->request->post('http://foo.com', ['bar']);
    }

    public function testPostJsonSetsHeadersAndJsonEncodesDataParam()
    {
        $this->wpHttp->post('uri', [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode(['foo' => 'bar']),
        ])->shouldBeCalled();

        $this->request->postJson('uri', ['foo' => 'bar']);
    }

    public function testReturnsResultOfPassingWpDataToFactoryCreate()
    {
        $wpData = ['response' => ['code' => 201]];
        $this->wpHttp->get('uri', [])->willReturn($wpData);
        $this->factory->create($wpData)->shouldBeCalled();

        $this->request->get('uri');
    }
}
