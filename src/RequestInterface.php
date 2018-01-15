<?php

namespace DownShift\WordPress\Http;

use WP_Http;

interface RequestInterface
{
    /**
     * Send an http GET request
     *
     * @param string $uri
     * @param array $params
     * @return ResponseInterface
     */
    public function get($uri, array $params = []);

    /**
     * Send an http POST request
     *
     * @param string $uri
     * @param array $params
     * @return ResponseInterface
     */
    public function post($uri, array $params = []);

    /**
     * Send a json-encoded http POST request
     *
     * @param string $uri
     * @param array $body
     * @param array $params
     * @return ResponseInterface
     */
    public function postJson($uri, array $body, array $params = []);

    /**
     * Send an http request
     *
     * @param string $method
     * @param string $uri
     * @param array $params
     * @return ResponseInterface
     */
    public function request($method, $uri, array $params = []);
}
