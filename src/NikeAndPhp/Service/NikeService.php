<?php

namespace NikeAndPhp\Service {

    /**
     * Created by PhpStorm.
     * User: nikhilkuria
     * Date: 11/02/17
     * Time: 5:48 AM
     */

    /**
     * Interface NikeService
     * The contract for the nike+ services offered
     * To know more about the entire set of services offered by nike+
     * visit https://developer.nike.com/documentation/api-docs.html
     */
    interface NikeService
    {
        /**
         * @param $userName
         * @param $passWord
         * @return string
         * The logical entry point. Uses a login username and password
         */
        public function login($userName, $passWord) : string ;

        /**
         * @return array
         * Returns a summary of the user activites
         * Can be used to show a welcome message with some quick stats
         */
        public function getSummary() : array ;

        /**
         * @param $count
         * @param bool $summarizeActivity
         * @return array
         * Get the number of runs specified in the $count param
         * Nike returns a huge number of details for each runs
         * Most of which is undesired. Use $summarizeActivity to bring that down
         */
        public function getRuns($count, $summarizeActivity=false) : array ;
    }
}