<?php

namespace DownShift\WordPress\Http;

class Response implements ResponseInterface
{
    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @param string|array $body
     * @param integer $statusCode
     * @throws \InvalidArgumentException
     */
    public function __construct($body = '', $statusCode = 200)
    {
        if (! $this->statusCodeValid($statusCode)) {
            throw new \InvalidArgumentException('Invalid status code');
        }

        if (is_array($body)) {
            $body = json_encode($body);
        }

        $this->body = $body;
        $this->statusCode = $statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
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

        return json_decode($this->removeUtf8Bom($body), true);
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

    /**
     * Remove UTF8 Byte-Order-Mark (BOM) which prevents json-decoding
     *
     * @param  string $text
     * @return string
     */
    protected function removeUtf8Bom($text)
    {
        $bom = pack('H*','EFBBBF');
        $text = preg_replace("/^$bom/", '', $text);
        return $text;
    }
}
