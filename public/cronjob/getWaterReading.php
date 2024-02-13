<?php



// $auto_start_date = date('Y-m-d', strtotime ( '-1 day' , time() ) );
// $auto_end_date = date('Y-m-d', time());


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://reports.pinkcityindia.com/api/energy/getwaterReading",
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
