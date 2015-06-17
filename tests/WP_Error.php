<?php

/**
 * This is just a test-fixture stub of the real WP_Error
 * so we can mock it for unit testing purposes. #YOLO
 */
if (!class_exists('WP_Error')) {

class WP_Error
{
    public function get_error_messages(){}
}

}
