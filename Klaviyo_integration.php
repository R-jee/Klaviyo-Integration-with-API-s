<?php

$url = "https://a.klaviyo.com/api/v2/list/LIST_or_Segment_ID/members?api_key=**********************************";


//Gets the IP Address from the visitor
$PublicIP = $_SERVER['REMOTE_ADDR'];
//Uses ipinfo.io to get the location of the IP Address, you can use another site but it will probably have a different implementation
$json     = file_get_contents("http://ipinfo.io/$PublicIP/geo");
//Breaks down the JSON object into an array
$json     = json_decode($json, true);
//This variable is the visitor's county
$country  = $json['country'];
//This variable is the visitor's region
$region   = $json['region'];
//This variable is the visitor's city
$city     = $json['city'];
//This variable is the visitor's postal
$postal     = $json['postal'];
//This variable is the visitor's timezone
$timezone     = $json['timezone'];

$client_address = $region .", ".$city .", ". $country ." ". $postal;

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

/*
    {
        "object": "person",
        "id": "PERSON_ID",
        "$address1": "",
        "$address2": "",
        "$city": "Mount Vernon",
        "$country": "United States",
        "$latitude": "",
        "$longitude": "",
        "$region": "Virginia",
        "$zip": "22121",
        "$email": "george.washington@klaviyo.com",
        "$title": "President",
        "$phone_number": "+13239169023",
        "$organization": "U.S. Government",
        "$first_name": "George",
        "$last_name": "Washington",
        "$timezone": "US/Eastern",
        "$id": "CUSTOM_ID",
        "created": "2021-11-04 09:06:13",
        "updated": "2021-11-23 11:21:03"
    }
*/



$data = '{
     "profiles": [  
        {
            "first_name": "Rjee",
            "last_name": "RUMY",
            "email": "rjee4631@klaviyo.com",
            "phone_number": "+13239169023",
            "address1": "'. $client_address .'",
            "city" : "'. $city .'",
            "country" : "'. $country .'",
            "region" : "'. $region .'",
            "zip" : "'. $postal .'",
            "timezone": "'. $timezone .'",
            "push_tokens": ["PUSH_TOKEN_1"]
            
        }
     ]
}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
var_dump($resp);

?>

