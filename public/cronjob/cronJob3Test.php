<?php

$auto_start_date = "2023-01-01";


for ($i=0; $i <3 ; $i++) {


$auto_end_date = date('Y-m-d', strtotime ( '+1 day' , strtotime($auto_start_date) ) );
// $auto_end_date = date('Y-m-d', time());


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://reports.pinkcityindia.com/api/attendance/getEmployeeAttendance?start_date=$auto_start_date&end_date=$auto_end_date&bypass=yes",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$auto_start_date = $auto_end_date;

// code...
}
