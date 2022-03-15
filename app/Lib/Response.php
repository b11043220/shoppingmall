<?php

namespace App\Lib;

class Response
{
    static $ok = 200;
    static $serverErr = 500;
    static $vCodeErr = 300;
    static $mobileExist = 301;
    static $userNotExist = 302;
    static $passwordNotMatch = 303;
    static $cartQtyInvalid = 304;
    static $mobileNotExist = 305;

    /**
     * @param $status
     * @param string $message
     * @param array $data
     * @return array
     */
    static function output ($status, string $message='', array $data = [])
    {
        return [
            'status' => $status,
            'msg' => $message,
            'data' => $data
        ];
    }
}
