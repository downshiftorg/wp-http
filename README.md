# WordPress Http Request/Response [![Build Status](https://travis-ci.org/netrivet/wp-http.svg?branch=master)](https://travis-ci.org/netrivet/wp-http)

Provides a consistent, object-oriented API for making HTTP requests and receiving responses in the WordPress ecosystem. Provides a thin wrapper around the `WP_Http` class and then normalizes the return values of the internal `WP_Http::request` method to return a Psr7-ish, Guzzle-ish, modern-ish `Response` object, which does not exist in WordPress.

## Usage

```php
<?php

use NetRivet\WordPress\Http\Request;

$request  = new Request();
$response = $request->get('http://api.yolo.com/status');

$response->getStatusCode(); // (int)    200
$response->getBody();       // (string) '{"msg": "You only live once!"}'
$response->json();          // (array)  ['msg' => 'You only live once!']
```

You can also send post requests with `x-www-form-urlencoded` data like so:

```php
$request->post('http://api.yolo.com/neckbeard', ['foo' => 'bar']);
```

It also provides a convenience method for posting json data, setting the appropriate Content-Type headers for you and json_encoding the data passed:

```php
$request->postJson('http://api.yolo.com/neckbeard', [
    'foo' => 'bar',
    'jim' => 'jam',
]);
```

## Installation

Install the latest version with

```
$ composer require netrivet/wp-http
```

## Tests

```
$ vendor/bin/phpunit
```
