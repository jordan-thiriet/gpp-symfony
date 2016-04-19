<?php

namespace CorsBundle\Manager;

/**
 *
 * @copyright   2016
 * @author      jthiriet <thirietjordan@gmail.com>
 * Class ImageManager
 * @package CorsBundle\Manager
 */
class ImageManager
{


    public function base64toImg($path, $base64) {
        $decoded = base64_decode(substr($base64,22));
        file_put_contents($path, $decoded);
        return true;
    }

}