<?php

namespace NetRivet\WordPress\Http;


class Response
{

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param string  $body
     * @param integer $statusCode
     * @throws \InvalidArgumentException
     */
    public function __construct($body = '', $statusCode = 200)
    {
        if (! $this->statusCodeValid($statusCode)) {
            throw new \InvalidArgumentException('Invalid status code');
        }

        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * Gets the response status code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Gets the body of the response
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Get json-decoded body
     *
     * @throws \UnexpectedValueException
     * @return array
     */
    public function json()
    {
        $json = $this->getBodyAsJson();

        if (!is_array($json)) {
            throw new \UnexpectedValueException('Body not json-encoded');
        }

        return $json;
    }

    /**
     * Is the response body json-encoded
     *
     * Empty body string is considered json and
     * will return an empty array from $this->json()
     *
     * @return boolean
     */
    public function isJson()
    {
        return is_array($this->getBodyAsJson());
    }

    /**
     * Retrieve a json-decoded array representation of the body content
     *
     * @return array|null
     */
    protected function getBodyAsJson()
    {
        $body = strval($this->getBody());

        if ('' === $body) {
            return [];
        }

        return json_decode($body, true);
    }

    /**
     * Determine validity of input status code
     *
     * @param  mixed $statusCode
     * @return bool
     */
    protected function statusCodeValid($statusCode)
    {
        if (!is_int($statusCode)) {
            return false;
        }

        return $statusCode >= 100 && $statusCode < 600;
    }
}
