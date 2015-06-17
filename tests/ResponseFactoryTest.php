<?php

namespace NetRivet\WordPress\Http;


class ResponseFactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var ResponseFactory
     */
    protected $factory;


    public function setUp()
    {
        $this->factory = new ResponseFactory();
    }


    public function testUnexpectedInputCreates500Response()
    {
        $response = $this->factory->create(111);

        $this->assertSame(500, $response->getStatusCode());
    }


    public function testArrayMissingResponseCodeCreates500Response()
    {
        $response = $this->factory->create(['foo' => 'bar']);

        $this->assertSame(500, $response->getStatusCode());
    }


    public function testNormalWordpressArrayConvertedCorrectly()
    {
        $response = $this->factory->create(['body' => 'the body', 'response' => ['code' => '200']]);

        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('the body', $response->getBody());
    }


    public function testReturns500ResponseWithErrorsWhenInputIsWordpressErrorObject()
    {
        $wpError = $this->prophesize('WP_Error');
        $wpError->get_error_messages()->willReturn(['ack!', 'bleh...', 'LOL wut?']);

        $response = $this->factory->create($wpError->reveal());

        $this->assertSame(500, $response->getStatusCode());
        $this->assertSame("ack!\nbleh...\nLOL wut?", $response->getBody());
    }
}
