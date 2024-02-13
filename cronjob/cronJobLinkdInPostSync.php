<?php



$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.sociablekit.com/api/sync-requests/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => ["embed_id"=> "161549", "type" => 2],
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer Bearer 200357|ZTw9SwgysTYtqMOXdPBEUK6d9Q2Wh7twV9PhR8qQ',
    // 'Cookie: laravel_session=UpSECCcrjTLGnCpdo6hkKSoh5ynFPc4RwS06I6qc'
  ),
));

$response = curl_exec($curl);

print_r("<pre>");
print_r("<br>hi11<br>");
print_r($response);

curl_close($curl);
// echo $response;
