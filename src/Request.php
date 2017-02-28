<?php

namespace NetRivet\WordPress\Http;

use WP_Http;

class Request implements RequestInterface
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
     * @param WP_Http $wpHttp
     */
    public function __construct(ResponseFactory $factory = null, WP_Http $wpHttp = null)
    {
        $this->factory = $factory ? $factory : new ResponseFactory();
        $this->wpHttp  = $wpHttp  ? $wpHttp  : new WP_Http();
    }

    /**
     * {@inheritdoc}
     */
    public function get($uri, array $params = [])
    {
        return $this->request('get', $uri, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function post($uri, array $params = [])
    {
        return $this->request('post', $uri, $params);
    }

    /**
     * {@inheritdoc}
     */
    public function postJson($uri, array $body, array $params = [])
    {
        $data = $this->wpHttp->post($uri, array_merge($params, [
            'headers' => [
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ],
            'body' => json_encode($body),
        ]));

        return $this->factory->create($data);
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri, array $params = [])
    {
        if (! method_exists($this->wpHttp, $method)) {
            $params['method'] = strtoupper($method);
            $method = 'request';
        }

        $data = call_user_func([$this->wpHttp, $method], $uri, $params);

        return $this->factory->create($data);
    }
}
