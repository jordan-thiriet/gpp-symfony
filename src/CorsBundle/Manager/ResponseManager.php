<?php

namespace CorsBundle\Manager;

/**
 * Class ResponseManager
 * @package CorsBundle\Manager
 */
class ResponseManager {

    public function response($status, $data) {
        $res = array();
        $res['status'] = $status;
        $res['data'] = $data;
        return $res;
    }

}