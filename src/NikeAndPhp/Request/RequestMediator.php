<?php

namespace NikeAndPhp\Request {

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    define("POST","POST");
    define("GET","GET");

    /**
     * Class RequestMediator
     * A helper used to make HTTP Calls
     * This uses curl to make the calls
     * http://php.net/manual/en/book.curl.php
     */
    class RequestMediator{

        private $url;
        private $httpMethod;
        private $params = array();
        private $logger;

        /**
         * RequestMediator constructor.
         * @param $url
         * @param $httpMethod
         * RequestMediator can be constructed for the HTTP verb GET or POST
         * Recommendation to use the static methods to create an instance.
         */
        public function __construct($url, $httpMethod){
            $this->logger = new Logger('name');
            $this->logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));
            $this->logger->info("Constructing Mediator for {$httpMethod} requests on {$url}");
            $this->url = $url;
            $this->httpMethod = $httpMethod;
        }

        /**
         * @param $params
         * @return mixed
         * The method actually making the call
         * Returns the response without any decoration
         */
        public function call($params){
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,$this->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            if($this->httpMethod==POST){
                $this->setPostParams($params,$ch);
            }

            $server_output = curl_exec ($ch);
            curl_close ($ch);
            return $server_output;
        }

        /**
         * @param $params
         * @param $ch
         * In case of post request, used to set the post params
         */
        private function setPostParams($params, &$ch){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$params);
        }

        /**
         * @param $url
         * @return RequestMediator
         * Used to create an instance of RequestMediator capable of handling POST requests
         */
        public static function forPost($url){
            return new RequestMediator($url, POST);
        }

        /**
         * @param $url
         * @return RequestMediator
         * Used to create an instance of RequestMediator capable of handling GET requests
         */
        public static function forGet($url){
            return new RequestMediator($url, GET);
        }

    }
}
