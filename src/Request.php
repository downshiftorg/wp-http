<?php

namespace NetRivet\WordPress\Http;

use WP_Http;


class Request
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
     * @param ResponseFactory $factory
     * @param WP_Http         $wpHttp
     */
    public function __construct(ResponseFactory $factory = null, WP_Http $wpHttp = null)
    {
        $this->factory = $factory ? $factory : new ResponseFactory();
        $this->wpHttp  = $wpHttp  ? $wpHttp  : new WP_Http();
    }

    /**
     * Send an http GET request
     *
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\Response
     */
    public function get($uri, array $params = [])
    {
        return $this->request('get', $uri, $params);
    }

    /**
     * Send an http POST request
     *
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\Response
     */
    public function post($uri, array $params = [])
    {
        return $this->request('post', $uri, $params);
    }

    /**
     * Send a json-encoded http POST request
     *
     * @param  string $uri
     * @param  array  $data
     * @return NetRivet\WordPress\Http\Response
     */
    public function postJson($uri, array $data)
    {
        $data = $this->wpHttp->post($uri, [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($data),
        ]);

        return $this->factory->create($data);
    }

    /**
     * Send an http request
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\Response
     */
    public function request($method, $uri, array $params = [])
    {
        $data = call_user_func([$this->wpHttp, $method], $uri, $params);

        return $this->factory->create($data);
    }
}
