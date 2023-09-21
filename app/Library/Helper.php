<?php
namespace App\Library;
use Image;
use Illuminate\Http\Request;
use App\Models\ProductData;
use App\Models\ProductCategory;
use App\Models\Notification;
use App\Models\erp\SalesItem;
use App\Models\erp\Employee;
use App\Models\erp\Attendance;
use App\Models\erp\SalesOrder;
use App\Models\erp\PurchaseOrder;
use App\Models\erp\PurchaseItem;
use App\Models\SendMessage;
use Carbon\Carbon;
use Auth;
class Helper {

	public static function uploadImage($filename, $uploadpath) {
		$image = $filename->getClientOriginalName();
        $destination = public_path() . '/uploads'.$uploadpath;
        $filename->move($destination, $image);
		return $image;
	}



	public static function getTime($created_at)
	{
		return Carbon::createFromFormat('Y-m-d H:i:s', $created_at)->diffForHumans();
		// $creation_time = \Carbon\Carbon::parse($created_at);
		// $now = \Carbon\Carbon::now();
		//$creation_time = $created_at->diffForHumans();
		//return $creation_time;
	}


	public static function GetNotifaction($id){
         $notifactions = auth()->user()->unreadNotifications;
         $data = [];
         foreach($notifactions as $notify){
         	if($notify->data['sender_id'] == $id){
         	   $data [] = $notify->data['sender_id'];
            }
         }
         return count($data);

	}

	public static function readNotifaction($id){
        $notifactions = auth()->user()->unreadNotifications;
        $data = [];
        foreach($notifactions as $notify){
         	if($notify->data['sender_id'] == $id){
         	   $notify->read_at = Carbon::now();
         	   $notify->save();
            }
         }

	}

	public static function livewireUplodeImage($filename, $uplodepath) {

		$image = $filename->getClientOriginalName();
        $destination = public_path() . '/uploads'.$uplodepath;
        $filename->move($destination, $image);
		return $image;
	}

	public static function VendorData($token){
		$tkn = str_replace(".", "", $token);
		$message = SendMessage::where('token',$tkn)->first();
		return $message->users->name;
	}

	public static function SaveProductData($request,$messageid){

        $pids = json_encode($request['p_ids']);
        $cidsarray = $request['extra_ids'];

		foreach($cidsarray as $array){
            $arr = array_values($array);
			//print_r($arr[0]);
            if(!empty($arr[0])){
				$cdatas = json_encode($arr);
				$productsave = new ProductData();
				$productsave->p_id = $pids;
				$productsave->c_id = $cdatas;
				$productsave->message_id = $messageid;
				$productsave->save();
            }
           // return $productsave;
		}
		//exit;
	}

	public static function GetProducts($message_id){
		$pdatas = ProductData::where('message_id',$message_id)->get();
		$parrays = [];
		$pqtys = [];
		foreach($pdatas as $key=> $npdata){
		    $pids = json_decode($npdata->p_id);
            $cids = json_decode($npdata->c_id);
			$cids []= null;
			$cids []= null;
			$cids []= null;
			$parrays []= array_combine($pids,$cids);
			$pqtys [] = $parrays[$key]['7'];
			unset($parrays[$key]['8'],$parrays[$key]['9'],$parrays[$key]['10']);
		}

		return ['pdatas' => $parrays,'pqtys'=>$pqtys];
		//$message->message_id

	}

	public static function getProductName($id){
	//	dd($id);
		$pdata = ProductCategory::where('id',$id)->value('name');
		//dd($pdata);
        return $pdata;
	}

	public static function ReplayProduct($request){
		//dd($request['available']);
	   $i = 0;
		$productdatas = ProductData::where('message_id',$request['messageid'])->get();
		foreach($productdatas as $key => $pdata){
			$updatdata = json_decode($pdata->c_id);
				if($key == $i++){
					array_push($updatdata,$request['available'][$key]);
					array_push($updatdata,$request['price'][$key]);
					array_push($updatdata,$request['remark'][$key]);
				}
			$cdataupdate = json_encode($updatdata);
			$pdata->c_id =  $cdataupdate;
			$pdata->reply_time = Carbon::now();
		   $pdata->save();
		}
		//exit;
	}

	public static function ProductCategory($slug,$message_id){
		   $productsdatas = ProductData::where('message_id',$message_id)->get();
		   $cids = [];
		   foreach($productsdatas as $key => $data){
			 $cids  = json_decode($data->c_id);
			 unset($cids[6]);
			 $check [] = array_merge($cids);
		    }
			$all_arrays = $check;
			$merged = [];
			for ($i = 0; $i < count($check); $i++) {
				$arr = $all_arrays[$i];
				$x = count($arr);
				for ($j=0; $j < $x; $j++) {
				 $merged[$arr[$j]] = 1;
				}
			}
		   $res = array_keys($merged);
		   $data = ProductCategory::where('type',$slug)->wherein('id',$res)->get();
		   return $data;
	}



	public static function SearchData($query){
          $datas = ProductData::get();
		  $msgid = [];
		  $shapid = [];
		  $sizeid = [];
		  $pricectid = [];
		  $qualityid = [];
		  foreach($datas as $data){
			/**Stone Data Search */
			if($query['stone']){
				$stone = json_decode($data->c_id)['0'];
				$stonedata = explode(',',$stone);
				if(in_array($query['stone'],$stonedata)){
					$msgid[] = $data->message_id;
				}
			}
			/**Shape Data Search */
			if($query['shape']){
				$shape = json_decode($data->c_id)['2'];
				$shapedata = explode(',',$shape);
				if(in_array($query['shape'],$shapedata)){
					$shapid[] = $data->message_id;
				}
			}

			/**Size Data Search */
			if($query['size']){
				$size = json_decode($data->c_id)['3'];
				$sizedata = explode(',',$size);
				if(in_array($query['size'],$sizedata)){
					$sizeid[] = $data->message_id;

				}
			}
			/**pricect Data Search */
			if($query['pricect']){
				$pricect = json_decode($data->c_id)['4'];
				$pricectdata = explode(',',$pricect);
				if(in_array($query['pricect'],$pricectdata)){
					$pricectid[] = $data->message_id;
				}
			}
			/**pricect Data Search */
			if($query['quality']){
				$quality = json_decode($data->c_id)['5'];
				$qualitydata = explode(',',$quality);
				if(in_array($query['quality'],$qualitydata)){
					$qualityid[] = $data->message_id;
				}
			}

		  }
		  // exit;
		  $balnk = [];
		  $data = [$msgid,$shapid,$sizeid,$pricectid,$qualityid];
		  $aray1 =  array_merge($msgid,$shapid);
		  $aray2 =  array_merge($sizeid,$pricectid);
		  $test  =  array_merge($aray1,$aray2);
		  $final =  array_merge($test,$qualityid);
		  $ids = array_unique($final);

		  return $ids;


	}


	public static function getData($data,$type){
		$Productdatas = ProductData::get();
		$msgid = [];
		if(!empty($data)){
			foreach($Productdatas as $pdata){
				$cdata = json_decode($pdata->c_id)[$type];
				$alldata = explode(',',$cdata);
				//echo "<pre>";

				if(in_array($data,$alldata)){
					$msgid[] = $pdata->message_id;
					//print_r($pdata->message_id);
				}
			}
	    }
		return $msgid;
	}

	public static function getAllProductData($request,$messageid){
		//dd($request);
		$alldatas = ProductData::where('message_id',$messageid)->get();

		if(!empty($request)){
			$searchquery = ProductData::where('message_id',$messageid);
			$secrchid = [];
			$query = ProductData::OrderBy('id','DESC');
			foreach($alldatas as $all){
				$sdata = json_decode($all->c_id);
				if(!empty($request['stone'])){
					if($request['stone'] == $sdata[0]){
						$query = $query->Orwhere('id',$all->id);
						$secrchid [] = $all->id;
					}
				}
				if(!empty($request['shape'])){
					if($request['shape'] == $sdata[2]){
						$secrchid [] = $all->id;
						$query = $query->where('id',$all->id);
					}
				}
				if(!empty($request['size'])){
					if($request['size'] == $sdata[3]){
						$query = $query->where('id',$all->id);
						$secrchid [] = $all->id;
					}
				}
				if(!empty($request['pricect'])){
					if($request['pricect'] == $sdata[4]){
						$query = $query->where('id',$all->id);
						$secrchid [] = $all->id;
					}
				}
				if(!empty($request['quality'])){
					if($request['quality'] == $sdata[5]){
						$query = $query->where('id',$all->id);
						$secrchid [] = $all->id;
					}
				}
			}
		    $alldatas = $query->get();

		}
		return $alldatas;
	}


	public static function getAllProducts($data){

		//$request->get('pricect');
		$cdata = $data;

		unset($cdata[4],$cdata[5],$cdata[6],$cdata[7],$cdata[8],$cdata[9]);

		//dd($cdata);
		$categoryget = ProductCategory::whereIn('id',$cdata)->get();
		foreach($categoryget as $key=> $cat){
			$cdata[$key] = $cat->name;
		}
		//dd($categoryget);
		if(empty($data[7]) || empty($data[8]) || empty($data[9])){
		 $cdata [4] = $data[4];
		 $cdata [5] = $data[5];
		 $cdata [6] = $data[6];
		 $cdata [7] = '<strong> Awaiting </strong>';
		 $cdata [8] = '<strong> Awaiting </strong>';
		 $cdata [9] = '<strong> Awaiting </strong>';
		}else{
		  $cdata [4] = $data[4];
		  $cdata [5] = $data[5];
		  $cdata [6] = $data[6];
		  $cdata [7] = $data[7];
		  $cdata [8] = $data[8];
		  $cdata [9] = $data[9];
		}
       return $cdata;
	}


	public static function ErpnextStockLedger($data,$type){


		$headers = array(
            "X-Custom-Header: value",
            "Authorization: token e439301f9d117aa:55ddfcac33666ea",
        );
        $company = str_replace(' ','+',$data['companyName']);
		$itemGroup = $data['itemGroup'];

		if($type == 'purchase'){
			$url = 'https://erp.pinkcityindia.com/api/resource/Purchase%20Order?fields=["*"]';

		}elseif($type == 'stock'){
            $url = 'https://erp.pinkcityindia.com/api/method/frappe.desk.query_report.run?report_name=Stock+Ledger&filters={"company":"'.$company.'","from_date":"'.$data['start_date'].'","to_date":"'.$data['end_date'].'","item_group":"'.$itemGroup.'"}';
		}elseif($type == 'sales'){
            $url = 'https://erp.pinkcityindia.com/api/resource/Sales%20Order?fields=["*"]';
		}

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //for debug only!
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
		//dd($resp);
        $arr = json_decode($resp, true);
		//dd($arr);
        $resultArr = [];
		if($type == 'purchase'){
			foreach ($arr as $value) {
					$resultArr[]   = $value;
			}
	    }elseif($type == 'stock'){
			foreach ($arr as $value) {
				foreach ($value['result'] as $result) {
					$resultArr[]   = $result;
				}
			}
		}elseif($type == 'sales'){
			foreach ($arr as $value) {
				$resultArr[]   = $value;
		    }
		}
		return $resultArr;
	}


	public static function SalesItem($itemcode,$start,$end){
		$query = SalesOrder::OrderBy('name','DESC');
		if(!empty($start) && !empty($end)){
			$query->whereBetween('creation',[$start, $end]);
		}
		$salesorder = $query->pluck('name');
		$salesitem = SalesItem::whereIn('parent',$salesorder)->where('item_code',$itemcode)->whereBetween('creation',[$start, $end])->get();
		// dd($salesitem);
		$totalqty = 0;
		$name = '';
		 	foreach($salesitem as $item){
		 		$totalqty += $item->qty;
				$name = $item->parent;
		    }

        return ['total'=>$totalqty,'name'=>$name];
	}


	public static function PurchaseItem($itemcode,$start,$end){
		$query = PurchaseOrder::OrderBy('name','DESC');
		if(!empty($start) && !empty($end)){
			$query->whereBetween('creation',[$start, $end]);
		}
		$purchaseorder = $query->pluck('name');

		$purchaseitem = PurchaseItem::whereIn('parent',$purchaseorder)->where('item_code',$itemcode)->whereBetween('creation',[$start, $end])->get();
		// dd($purchaseitem);
		$totalqty = 0;
		$name = '';
		 	foreach($purchaseitem as $item){
		 		$totalqty += $item->qty;
				$name = $item->parent;
		    }
		 //dd($name);
        return ['total'=>$totalqty,'name'=>$name];
	}


	public static function AttendnceCheckin($data){
		// $check = Employee::where('employee_number',$data['employee_field_value'])
		// 									->orWhere('employee_number_new',$data['employee_field_value'])
		// 									->first();
		// return 0;
		// die("hi338#");
		$check = Employee::where('attendance_device_id',$data['employee_field_value'])->first();

		if(!empty($check)){
			// con
		 //dd($check);
		 // print_r($check);
		 // return;
		 // die;


		$headers = array(
            "X-Custom-Header: value",
            // "Authorization: token " .getenv("ERP_TOKEN"),
            "Authorization: token 8df39ff6e216a4b:4f0295ed14f70b9",
        );
        $url = 'https://erp.pinkcityindia.com/api/method/erpnext.hr.doctype.employee_checkin.employee_checkin.add_log_based_on_employee_field';
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);

        curl_close($curl);

				echo "<br>hi77<br>";
				print_r($response);
				// print_r($headers);
				// echo "<br>hi77#<br>";
				// print_r(getenv("ERP_TOKEN"));
				echo "<br>hi77<br>";
				// die;

				// dd($response);
        }
	}

	public static function AutoAttendnceCheckin($userids){
		$starttime = '2021-12-09 09:30:00';
		$oudate   = '2021-12-09 18:00:00';
		foreach($userids as $id){
			//print_r($id);
			$deviceidin = mt_rand(100000, 999999);
			$datain = [
				'employee_field_value' => $id,
				'log_type' => 'OUT',
				'timestamp'   => $oudate.'.000000',
				'device_id'   => $deviceidin
			];
			$headers = array(
				"X-Custom-Header: value",
				"Authorization: token e439301f9d117aa:55ddfcac33666ea",
			);
			$url = 'https://10.200.20.160/api/method/erpnext.hr.doctype.employee_checkin.employee_checkin.add_log_based_on_employee_field';
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $datain);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			$response = curl_exec($curl);
			$records  = json_decode($response);
			print_r($response);
		}


        //dd($response);
	}



	public static function LoginIpandTime($ip){
		 $saveip = Auth::user();
         $saveip->user_ip = $ip;
         $saveip->last_login_time = Carbon::now()->toDateTimeString();
         $saveip->save();

	}

	public static function outmissindata($employee,$startrdate,$enddate){
            $checkindata = Attendance::where('employee',$employee)->WhereDate('time',[$startrdate,$enddate])->get();
            return $checkindata;
	}

	public static function CHeckOverTime($employee,$startrdate,$enddate){
		$checkindata = Attendance::where('employee',$employee)->WhereDate('time',[$startrdate,$enddate])->get();

		return $checkindata;
	}

	public static function Emplopyeedata($userid,$filters = null){
		 $data = Employee::where('employee_number',$userid)->first();

		 return $data;
	}


	public static function CheckinData(){
		$filters = ['start_date' => request()->start_date,'end_date'=> request()->end_date];

		if(!empty($filters['start_date']) && !empty($filters['end_date'])){
			$data = ['startdate' => $filters['start_date'] .' '.'05:00:00','enddate' => $filters['end_date'] .' '.'11:59:00'];
		  }else{
			$data = ['startdate' => Carbon::now()->startOfMonth()->todatetimestring(),'enddate' => Carbon::now()->todatetimestring()];
		}
		ini_set('max_execution_time', '1000000');
		$headers = array("X-Custom-Header: value");
		$url = 'http://183.87.222.69:8090/api/attendance';
		$enddate = date('Y-m-d H:i:s');
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		$records  = json_decode($response);
		return $records;
    }


	public static function getMonthCheckin($id){
		$filters = ['start_date' => request()->start_date,'end_date'=> request()->end_date];

		if(!empty($filters['start_date']) && !empty($filters['end_date'])){
			$data = ['startdate' => $filters['start_date'] .' '.'05:00:00','enddate' => $filters['end_date'] .' '.'11:59:00'];
		  }else{
			$data = ['startdate' => Carbon::now()->startOfMonth()->todatetimestring(),'enddate' => Carbon::now()->todatetimestring()];
		}
		ini_set('max_execution_time', '1000000');
		$headers = array("X-Custom-Header: value");
		$url = 'http://183.87.222.69:8090/api/attendance';
		$enddate = date('Y-m-d H:i:s');
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS,http_build_query($data));
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($curl);
		$records  = json_decode($response);
		dd($records);
		return $records;

	}

	public static function EmployeeData($userid){
		//$employee = Employee::where('employee_number',$userid)->first();
		$employee = Employee::where('attendance_device_id',$userid)->select('employee_name','employee','company','default_shift','department')->first();

		if(!empty($employee)){
			return $employee;
		}else{
			$employee = '';
			return $employee;
		}

	}
}
?>
