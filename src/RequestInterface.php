<?php

namespace NetRivet\WordPress\Http;

use WP_Http;


interface RequestInterface
{
    /**
     * Send an http GET request
     *
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\ResponseInterface
     */
    public function get($uri, array $params = []);

    /**
     * Send an http POST request
     *
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\ResponseInterface
     */
    public function post($uri, array $params = []);

    /**
     * Send a json-encoded http POST request
     *
     * @param  string $uri
     * @param  array  $data
     * @return NetRivet\WordPress\Http\ResponseInterface
     */
    public function postJson($uri, array $data);

    /**
     * Send an http request
     *
     * @param  string $method
     * @param  string $uri
     * @param  array  $params
     * @return NetRivet\WordPress\Http\ResponseInterface
     */
    public function request($method, $uri, array $params = []);
}
