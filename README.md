# EasyParcel
A PHP wrapper for EasyParcel API. EasyParcel Marketplace API Documentation v2.0.0 will be needed for detailed reference on what to pass into the methods.

## Dependencies
1. PHP 5.4.0+ (short array syntax)
2. cURL

## Usage
1. Incude the file in the code
2. Instantiate EasyParcel object, and pass API and authentication keys into the constructor
3. Call useDemo() method if you want to use demo account
4. Call other provided methods as needed

## Example
### Code
The code below is for checking shipment rates.

```php
<?php
// Include the file
require 'EasyParcel.php';

// Define your API & authentication keys
$api_key = 'something';
$auth_key = 'something';

// Instantiate EasyParcel object
$easyparcel = new apih\EasyParcel\EasyParcel($api_key, $auth_key);

// Call this method if you want to use demo account
$easyparcel->useDemo(); 

// Data that should be passed into the method
$bulk = [
	[
		'pick_code' => '17000',
		'pick_state' => 'Kelantan',
		'pick_country' => 'MY',
		'send_code' => '53100',
		'send_state' => 'Kuala Lumpur',
		'send_country' => 'MY',
		'weight' => '0.5'
	]
];

// Call checkRate() method
$response = $easyparcel->checkRate($bulk);

// Display the response
echo json_encode($response);
?>
```
### Output
Sample output based on above code.

```json
{  
  "api_status":"Success",
  "error_code":"0",
  "error_remark":"",
  "result":[  
    {  
      "status":"Success",
      "remarks":"",
      "rates":[  
        {  
          "service_id":"EP-CS0I",
          "service_name":"Next Day Delivery Service",
          "service_type":"document",
          "courier_id":"EP-CR0A",
          "courier_name":"Poslaju",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/POS0006_POS_Laju_LOGO_ID_CMYK_140514.jpg",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 2 working day(s)",
          "price":"7.80",
          "dropoff_point":[  

          ]
        },
        {  
          "service_id":"EP-CS0F",
          "service_name":"Next Day Delivery Service",
          "service_type":"parcel",
          "courier_id":"EP-CR0A",
          "courier_name":"Poslaju",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/POS0006_POS_Laju_LOGO_ID_CMYK_140514.jpg",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 2 working day(s)",
          "price":"7.80",
          "dropoff_point":[  

          ]
        },
        {  
          "service_id":"EP-CS0N",
          "service_name":"Next Day Delivery Service",
          "service_type":"document",
          "courier_id":"EP-CR05",
          "courier_name":"Skynet",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/SKYNET-EXPRESS.png",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 1 working day(s)",
          "price":"7.80",
          "dropoff_point":[  
            {  
              "point_id":"SKYNET_AKH",
              "point_name":"SKYNET AYER KEROH",
              "point_contact":"62316898",
              "point_addr1":"SKYNET WORLDWIDE (MELAKA) SDN BHD",
              "point_addr2":"653-O, Jalan Delima 3,",
              "point_addr3":"Taman Bukit Melaka",
              "point_addr4":"",
              "point_postcode":"75450",
              "point_city":"Bukit Beruang",
              "point_state":"mlk",
              "price":0
            }
          ]
        },
        {  
          "service_id":"EP-CS0W",
          "service_name":"Next Day Delivery Service",
          "service_type":"parcel",
          "courier_id":"EP-CR05",
          "courier_name":"Skynet",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/SKYNET-EXPRESS.png",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 1 working day(s)",
          "price":"7.80",
          "dropoff_point":[  
            {  
              "point_id":"SKYNET_AKH",
              "point_name":"SKYNET AYER KEROH",
              "point_contact":"62316898",
              "point_addr1":"SKYNET WORLDWIDE (MELAKA) SDN BHD",
              "point_addr2":"653-O, Jalan Delima 3,",
              "point_addr3":"Taman Bukit Melaka",
              "point_addr4":"",
              "point_postcode":"75450",
              "point_city":"Bukit Beruang",
              "point_state":"mlk",
              "price":0
            }
          ]
        },
        {  
          "service_id":"EP-CS0E",
          "service_name":"Next Day Delivery Service",
          "service_type":"document",
          "courier_id":"EP-CR0M",
          "courier_name":"Nationwide",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/Nationwide-Express-logo.jpg",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 1 working day(s)",
          "price":"7.80",
          "dropoff_point":[  

          ]
        },
        {  
          "service_id":"EP-CS04",
          "service_name":"Next Day Delivery Service",
          "service_type":"parcel",
          "courier_id":"EP-CR0M",
          "courier_name":"Nationwide",
          "courier_logo":"http:\/\/cp.easyparcel.my\/v1\/include\/theme_1\/source\/img\/logo\/Nationwide-Express-logo.jpg",
          "scheduled_start_date":"2017-06-23 Friday",
          "pickup_date":"2017-06-22",
          "delivery":"Estimated 1 working day(s)",
          "price":"7.80",
          "dropoff_point":[  

          ]
        }
      ],
      "pgeon_point":{  
        "Sender_point":[  

        ],
        "Receiver_point":[  

        ]
      }
    }
  ]
}
```

## License
This library may be freely distributed and is licensed under the MIT license.
