<?php

namespace NetRivet\WordPress\Http;

use WP_Error;

class ResponseFactory
{
    /**
     * Create a Response object from mixed WP_Http::request return values
     *
     * @param  mixed $input
     * @return Response
     */
    public function create($input)
    {
        if (is_array($input)) {
            return $this->createFromArray($input);
        }

        if ($input instanceof WP_Error) {
            return $this->createFromWpError($input);
        }

        return new Response('', 500);
    }

    /**
     * Create Response object from array
     *
     * When all is well with WP_HTTP::request, it returns an
     * associative array structured in a certain way. Here we
     * convert that convention into a Response object.
     *
     * @param  array  $data
     * @return Response
     */
    protected function createFromArray(array $data)
    {
        if (!isset($data['response']) || !isset($data['response']['code'])) {
            return new Response('', 500);
        }

        $body = isset($data['body']) ? strval($data['body']) : '';
        $statusCode = (int) $data['response']['code'];

        return new Response($body, $statusCode);
    }

    /**
     * Create Response object from WP_Error instance
     *
     * When WordPress encounters an error with an http
     * request, it returns an instance of WP_Error. Here
     * we normalize that return value into a 500 Response
     * with error messages
     *
     * @param  WP_Error $error
     * @return Response
     */
    protected function createFromWpError(WP_Error $error)
    {
        return new Response(join("\n", $error->get_error_messages()), 500);
    }
}
