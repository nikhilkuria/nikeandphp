<?php
/**
 * Created by PhpStorm.
 * User: nikhilkuria
 * Date: 25/02/17
 * Time: 9:10 AM
 */

require "vendor/autoload.php";

use NikeAndPhp\Service\BasicNikeService;

$handle = fopen("php://stdin","r");

$nikeService = BasicNikeService::create();

print("Please login to Nike + \n");
print("User Name : ");
$userName = trim(fgets($handle));
print("Password : ");
$passWord = trim(fgets($handle));
$nikeService = BasicNikeService::createWithCredentials($userName,$passWord);
$summary = $nikeService->getSummary();
print("Connected to Nike+\n");
print("-------------------\n");
$records = $summary["summaries"][1]["records"];
$totalDistance = round($records[2]["recordValue"],1);
$totalTime = explode(":",$records[3]["recordValue"]);
print("You have run a total distance of {$totalDistance} kms in {$totalTime[0]} hours, {$totalTime[1]} minutes, and {$totalTime[2]} seconds\n\n");

print("Fetching the last 10 activities...");
$lastRecords = $nikeService->getRuns(10, true);
$index = 0;
foreach ($lastRecords as $record){
    print("\n");
    print("[{$index}] ");
    print("{$record['distance']} km run on {$record['startDate']} in {$record['duration']}");
    $index++;
}