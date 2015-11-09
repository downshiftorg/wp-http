<?php

namespace NetRivet\WordPress\Http;


class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWhenConstructedWithNonIntegerStatusCode()
    {
        new Response('', 'foobar');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsExceptionWhenConstructedWithInvalidStatusCode()
    {
        new Response('', 999);
    }


    public function testReturnsStatusCode()
    {
        $response = new Response('', 201);

        $this->assertSame(201, $response->getStatusCode());
    }


    public function testGetBodyReturnsBody()
    {
        $response = new Response('foo');

        $this->assertSame('foo', $response->getBody());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testJsonThrowsIfBodyNotJsonDecodable()
    {
        $response = new Response('foo');
        $response->json();
    }


    public function testJsonReturnsJsonDecodedBody()
    {
        $response = new Response(json_encode(['foo' => 'bar']));
        $json = $response->json();

        $this->assertSame(['foo' => 'bar'], $json);
    }


    public function testJsonReturnsEmptyArrayForEmptyBody()
    {
        $response = new Response();
        $this->assertSame([], $response->json());
    }


    public function testJsonStringIsJson()
    {
        $response = new Response('["foo"]');
        $this->assertTrue($response->isJson());
    }


    public function testNonJsonStringIsNotJson()
    {
        $response = new Response('meat on bone');
        $this->assertFalse($response->isJson());
    }

    public function testJsonRemovesBomBeforeDecoding()
    {
        $BOM = pack('H*','EFBBBF');
        $encoded = $BOM . json_encode(['foo' => 'bar']);

        $response = new Response($encoded);

        $this->assertEquals(['foo' => 'bar'], $response->json());
    }
}
