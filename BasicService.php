<?php

/**
 * Created by PhpStorm.
 * User: nikhilkuria
 * Date: 12/02/17
 * Time: 6:15 AM
 */

require('RequestMediator.php');

/**
 * Class BasicService
 * An abstract class which helps the NikeService implementations to make API calls
 */
abstract class BasicService
{

    /**
     * @param $url
     * @return RequestMediator
     * Used as a factory to get a POST Mediator
     */
    protected function getPostMediator($url){
        return RequestMediator::forPost($url);
    }

    /**
     * @param $url
     * @return RequestMediator
     * Used as a factory to get a GET Nediator
     */
    protected function getGetMediator($url){
        return RequestMediator::forGet($url);
    }

    /**
     * @param $url
     * @param $paramName
     * @param $paramValue
     * @param $firstParam
     * @return string
     * Used to add a single parameter to the $url request
     * Use $firstParam to specify if this is the first parameter
     */
    protected function addParam($url, $paramName, $paramValue, $firstParam){
        if($firstParam==true){
            $bindChar = '?';
        }else{
            $bindChar = '&';
        }

        $url =  $url
            .$bindChar
            .$paramName.'='
            .$paramValue;

        return $url;
    }

    /**
     * @param $url
     * @param $params
     * @return string
     * Used to add multiple params to the $url
     */
    protected function addParams($url, $params){
        $url = $url+'?';
        foreach ($params as $name => $value){
            $url = $url.$name.'='.$value.'&';
        }
        return substr($url,0,-1);
    }
}