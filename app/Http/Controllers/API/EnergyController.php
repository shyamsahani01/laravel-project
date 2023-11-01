<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Library\Helper;
use Illuminate\Support\Facades\File;

define("Water_API_KEY", "IK0U5CB07VQ9M9TM");


class EnergyController extends Controller
{

    public function __construct()
    {
      $this->localdesignDB = DB::connection('localdesign');
    }

     public function getwaterReading(Request $request){

       // $url = 'https://api.thingspeak.com/channels/2118130/status.json?api_key=';
       $url = 'https://api.thingspeak.com/channels/2118130/feeds.json?api_key=';
       $url .= Water_API_KEY;
       $url .= "&results=2000";

       $curl = curl_init();

       curl_setopt_array($curl, array(
         CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => '',
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => true,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_SSL_VERIFYHOST => false,
         CURLOPT_SSL_VERIFYPEER => false,
         CURLOPT_CUSTOMREQUEST => 'GET',
         CURLOPT_HTTPHEADER => array(
           'X-Custom-Header: value',
           'Cookie: full_name=Guest; sid=Guest; system_user=no; user_id=Guest; user_image='
         ),
       ));

       $response = curl_exec($curl);

       $water_data = json_decode($response);

       print_r("<pre>");
       // print_r($water_data);

       if(isset($water_data->feeds)){
           if(is_array($water_data->feeds) ) {
               $result = $water_data->feeds;
               print_r("<br>hi11<br>");
               print_r($result);

               for($i=0; $i<count($result); $i++) {
                // if(isset($result[$i]->field1)) {
                  if($result[$i]->field1 > 0 || $result[$i]->field2 > 0 || $result[$i]->field3 > 0 ||$result[$i]->field4 > 0 ||$result[$i]->field5 > 0 ||$result[$i]->field6 > 0  ) {
                    $this->localdesignDB->table('water')
                                        // ->upsert([
                                        //       "entry_id"=>$result[$i]->entry_id,
                                        //       "entry_time"=>$result[$i]->created_at,
                                        //       "feild_1"=>$result[$i]->field1,
                                        //       "feild_2"=>$result[$i]->field2,
                                        //       // "status"=>$result[$i]->status,
                                        //     ],
                                        //     // ["entry_id", "entry_time"],
                                        //     ["entry_id", ],
                                        //     ["feild_1", "feild_2", "status"]

                                          //   ->updateOrInsert([
                                          //         "entry_id"=>$result[$i]->entry_id,
                                          //         "entry_time"=>$result[$i]->created_at,
                                          //         // "status"=>$result[$i]->status,
                                          //       ],
                                          //       [
                                          //         "entry_id"=>$result[$i]->entry_id,
                                          //         "entry_time"=>$result[$i]->created_at,
                                          //         "feild_1"=>$result[$i]->field1,
                                          //         "feild_2"=>$result[$i]->field2,
                                          //         // "status"=>$result[$i]->status,
                                          //       ]
                                          // );
                                            ->updateOrInsert([
                                                      "entry_id"=>$result[$i]->entry_id,
                                                      "entry_time"=>$result[$i]->created_at,
                                                      // "feild_1"=>isset($result[$i]->feild_1) ? $result[$i]->feild_1 : NULL,
                                                      // "feild_2"=>isset($result[$i]->feild_2) ? $result[$i]->feild_2 : NULL,
                                                      // "status"=>$result[$i]->status,
                                                ],
                                                [
                                                  "entry_id"=>$result[$i]->entry_id,
                                                  "entry_time"=>$result[$i]->created_at,
                                                  "feild_1"=>$result[$i]->field1,
                                                  "feild_2"=>$result[$i]->field2,
                                                  "feild_3"=>isset($result[$i]->field3) ? $result[$i]->field3 : NULL,
                                                  "feild_4"=>isset($result[$i]->field4) ? $result[$i]->field4 : NULL,
                                                  "feild_5"=>isset($result[$i]->field5) ? $result[$i]->field5 : NULL,
                                                  "entry_date_time"=>date("Y-m-d h:i:s", strtotime($result[$i]->created_at)),
                                                  // "status"=>$result[$i]->status,
                                                ]
                                          );
                  }
                // }
                // if(isset($result[$i]->field2)) {
                //   if($result[$i]->field2 > 0) {
                    // $this->localdesignDB->table('water')
                    //                       //   ->updateOrInsert([
                    //                       //         "entry_id"=>$result[$i]->entry_id,
                    //                       //         "entry_time"=>$result[$i]->created_at,
                    //                       //         // "status"=>$result[$i]->status,
                    //                       //       ],
                    //                       //       [
                    //                       //         "entry_id"=>$result[$i]->entry_id,
                    //                       //         "entry_time"=>$result[$i]->created_at,
                    //                       //         "feild_1"=>$result[$i]->field1,
                    //                       //         "feild_2"=>$result[$i]->field2,
                    //                       //         // "status"=>$result[$i]->status,
                    //                       //       ]
                    //                       // );
                    //                         ->updateOrInsert([
                    //                               "entry_id"=>$result[$i]->entry_id,
                    //                               "entry_time"=>$result[$i]->created_at,
                    //                               // "feild_1"=>isset($result[$i]->feild_1) ? $result[$i]->feild_1 : NULL,
                    //                               // "feild_2"=>isset($result[$i]->feild_2) ? $result[$i]->feild_2 : NULL,
                    //                               // "status"=>$result[$i]->status,
                    //                             ],
                    //                             [
                    //                               "entry_id"=>$result[$i]->entry_id,
                    //                               "entry_time"=>$result[$i]->created_at,
                    //                               "feild_1"=>$result[$i]->field1,
                    //                               "feild_2"=>$result[$i]->field2,
                    //                               "feild_3"=>isset($result[$i]->field3) ? $result[$i]->field3 : NULL,
                    //                               "feild_4"=>isset($result[$i]->field4) ? $result[$i]->field4 : NULL,
                    //                               "feild_5"=>isset($result[$i]->field5) ? $result[$i]->field5 : NULL,
                    //                               "entry_date_time"=>date("Y-m-d h:i:s", strtotime($result[$i]->created_at)),
                    //                               // "status"=>$result[$i]->status,
                    //                             ]
                    //                       );
                //   }
                // }
               }
             }
           }


    }


}
