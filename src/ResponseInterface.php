<?php

namespace NetRivet\WordPress\Http;


interface ResponseInterface
{

    /**
     * Gets the response status code
     *
     * @return int
     */
    public function getStatusCode();

    /**
     * Gets the body of the response
     *
     * @return string
     */
    public function getBody();

    /**
     * Get json-decoded body
     *
     * @throws \UnexpectedValueException
     * @return array
     */
    public function json();

    /**
     * Is the response body json-encoded
     *
     * Empty body string is considered json and
     * will return an empty array from $this->json()
     *
     * @return boolean
     */
    public function isJson();
}
