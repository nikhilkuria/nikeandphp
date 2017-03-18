# nikeandphp

[![Build Status](https://travis-ci.org/nikhilkuria/nikeandphp.svg?branch=master)](https://travis-ci.org/nikhilkuria/nikeandphp)  [![Latest Stable Version](https://poser.pugx.org/nikhilkuria/nikeandphp/v/stable)](https://packagist.org/packages/nikhilkuria/nikeandphp)
nikeandphp is a php package used to retrive information from the Nike+ APIs. 
The library is hosted under Packagist
https://packagist.org/packages/nikhilkuria/nikeandphp

The APIs are generally closed and have a history of sudden changes.  If you feel anything broken or does not seem to work as it is supposed to, please raise a bug and we will have a look at it as soon as we can.

The prime interface which exposes the data from Nike+ is [NikeService](https://github.com/nikhilkuria/nikeandphp/blob/master/src/NikeAndPhp/Service/NikeService.php) 
Use the static factory method to get an instance of [NikeService](https://github.com/nikhilkuria/nikeandphp/blob/master/src/NikeAndPhp/Service/NikeService.php). The facory method expects the username and password of your Nike+ account. 

    $nikeService = BasicNikeService::createWithCredentials($userName,$passWord);
Once you have the [NikeService](https://github.com/nikhilkuria/nikeandphp/blob/master/src/NikeAndPhp/Service/NikeService.php), you can directly call the methods which are exposed.

* Get a summary of the acitivites
* Get the entire list of runs

### Get the summary
    
    $summary = $nikeService->getSummary();

This would give an object corresponding to the JSON

    {
      "links": [
        {
          "rel": "self",
          "href": "https://api.nike.com/v1/me/sport"
        },
        {
          "rel": "activities",
          "href": "https://api.nike.com/v1/me/sport/activities"
        }
      ],
      "experienceTypes": [
        "RUNNING"
      ],
      "summaries": [
        {
          "experienceType": "ALL",
          "records": [
            {
              "recordType": "LIFETIMEFUEL",
              "recordValue": "581652"
            }
          ]
        },
        {
          "experienceType": "RUNNING",
          "records": [
            {
              "recordType": "LIFETIMEFUEL",
              "recordValue": "585162"
            },
            {
              "recordType": "LEVEL",
              "recordValue": "11"
            },
            {
              "recordType": "LIFETIMEDISTANCE",
              "recordValue": "2267.7218332193397"
            },
            {
              "recordType": "LIFETIMEDURATION",
              "recordValue": "221:44:03.876"
            },
            {
              "recordType": "LIFETIMEAVERAGEPACE",
              "recordValue": "298571.4120103049"
            },
            {
              "recordType": "LONGESTRUNDISTANCE",
              "recordValue": "21.58303"
            }
          ]
        }
      ]
    }

### Get Runs

    $lastRecords = $nikeService->getRuns(10, true);
This takes in two params
* num of runs
* boolean to summarize the runs or not (defaults to false)

An unsummarized run request will return an object corresponding to the php object for this Json

    {
      "data": [
        {
          "links": [
            {
              "rel": "self",
              "href": "https://api.nike.com/v1/me/sport/activities/7320000000003216744510001903729471141578"
            }
          ],
          "activityId": "7320000000003216744510001903729471141578",
          "activityType": "RUN",
          "startTime": "2017-03-17T15:20:59Z",
          "activityTimeZone": "Asia/Kolkata",
          "status": "COMPLETE",
          "deviceType": "OTHER",
          "metricSummary": {
            "calories": "166",
            "fuel": "521",
            "distance": "2.026179075241089",
            "steps": "1853",
            "duration": "0:12:25.861"
          },
          "tags": [
            {
              "tagType": "LOCATION",
              "tagValue": "OUTDOORS"
            },
            {
              "tagType": "SHOES",
              "tagValue": "Nike Free 5.0"
            }
          ],
          "metrics": []
        }
      ],
      "paging": {
        "next": "/v1/me/sport/activities/RUNNING?count=1&access_token=qZDE3FwVxhDu6VPVY2ajcct0g35f&offset=2",
        "previous": null
      }
    }

