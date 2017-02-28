<?php

namespace NikeAndPhp\Service {


    /**
     * Created by PhpStorm.
     * User: nikhilkuria
     * Date: 11/02/17
     * Time: 5:52 AM
     */

    define("LOGIN","https://developer.nike.com/services/login");
    define("SUMMARY","https://api.nike.com/v1/me/sport");
    define("ACTIVITIES", "https://api.nike.com/v1/me/sport/activities/running");

    require('NikeService.php');
    require('BasicService.php');

    /**
     * Class BasicNikeService
     * The Basic and Simple implementation of NikeService
     */
    class BasicNikeService extends BasicService implements NikeService
    {
        private $accessToken;
        private $expires_in;
        private $loginTime;
        /**
         * @param $userName
         * @param $passWord
         * @return string
         * Since Nike+ does not encourage devs to access their APIs,
         * The access token has to be fetched the hard way
         * This should be called before any other API calls can be made
         * Pass $username and $password and this generates $accessToken
         */
        public function login($userName, $passWord) : string
        {
            $mediator = $this->getPostMediator(LOGIN);
            $params = array();
            $params['username'] = $userName;
            $params['password'] = $passWord;

            $response = $mediator->call($params);
            $responseDecoded = json_decode($response,true);
            $this->accessToken = $responseDecoded["access_token"];
            $this->expires_in = $responseDecoded["expires_in"];
            $this->loginTime = microtime();
            return $this->accessToken;
        }

        /**
         * @return array
         * Returns the summary of the user activities
         * This uses the API https://api.nike.com/v1/me/sport
         */
        public function getSummary() : array
        {
            $mediator = $this->getGetMediator($this->addTokenParam(SUMMARY));
            $response = $mediator->call(array());
            $responseDecoded = json_decode($response, true);
            return $responseDecoded;
        }

        /**
         * @param $count
         * @param bool $summarizeActivity
         * @return array
         * Returns the list of runs with count specified in $count
         * $summarizeActivity can be used to get a summary of the activities
         * This uses the API https://developer.nike.com/documentation/api-docs/activity-services/list-activities-by-experience-type.html
         */
        public function getRuns($count, $summarizeActivity=false): array
        {
            $url = $this->addTokenParam(ACTIVITIES);
            if($count!=-1){
                $url = $this->addParam($url, 'count', '10', false);
            }
            $mediator = $this->getGetMediator($url);
            $response = $mediator->call(array());
            $responseDecoded = json_decode($response, true);
            $activities = $summarizeActivity ? $this->summarizeActivities($responseDecoded) : $responseDecoded;
            return $activities;
        }

        /**
         * @param $responseDecoded
         * @return array
         * Used to generate a summary of a specific run
         * The followint properties are extracted
         * -activityId
         * -distance
         * -duration
         * -startTime
         * -startDate
         */
        private function summarizeActivities($responseDecoded){
            $activities = array();
            foreach ($responseDecoded["data"] as $fullActivity){
                $metricSummary = $fullActivity["metricSummary"];

                $activityId = $fullActivity["activityId"];
                $distance = round($metricSummary["distance"],2);
                $duration = $metricSummary["duration"];
                $time = explode("T",$fullActivity["startTime"]);
                $startDate = $time[0];
                $startTime = $time[1];

                $activity["activityId"] = $activityId;
                $activity["distance"] = $distance;
                $activity["duration"] = $duration;
                $activity["startTime"] = $startTime;
                $activity["startDate"] = $startDate;

                $activities[] = $activity;
            }
            return $activities;
        }

        private function addTokenParam($url){
            return $this->addParam($url, 'access_token', $this->accessToken, true);
        }

        /**
         * @param $userName
         * @param $passWord
         * @return BasicNikeService
         * A factory method to create an instance using $userName and $passWord
         * This is the recommended way to use BasicNikeService
         */
        public static function createWithCredentials($userName, $passWord){
            $nikeService = new BasicNikeService();
            $nikeService->login($userName,$passWord);
            return $nikeService;
        }

        public static function create(){
            return new BasicNikeService();
        }
    }
}