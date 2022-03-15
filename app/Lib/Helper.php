<?php

namespace App\Lib;

class Helper
{
    /**
     * @param $imagePath
     * @return string
     */
    static function imageLink($imagePath)
    {
        return  config('app.url').'/uploads/'.$imagePath;
    }

    static function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key=>$val) {
            if (is_numeric($val)) {
                $xml.="<".$key.">".$val."</".$key.">";
            } else {
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    static function XMLDataParse($data)
    {
        $xml = simplexml_load_string($data,NULL,LIBXML_NOCDATA);
        $array=json_decode(json_encode($xml),true);
        return $array;
    }

    static function createNoncestr( $length = 32 )
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
}
