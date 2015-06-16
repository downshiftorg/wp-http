<?php

/**
 * This is just a test-fixture stub of the real WP_Http
 * so we can mock it for unit testing purposes. #YOLO
 */
if (!class_exists('WP_Http')) {

class WP_Http
{
    public function get(){}
    public function post(){}
}

}
