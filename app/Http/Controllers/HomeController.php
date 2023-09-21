<?php

namespace App\Http\Controllers;

use App\Library\Helper;
use App\Models\MessageReplay;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\SendMessage;
use App\Models\User;
use App\Models\erp\Employee;
use App\Notifications\AdminNotifation;
use App\Notifications\UserChatNotifation;
use App\Notifications\UserNotifation;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Notification;
use Session;
Use DB;

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

      // print_r("hello");
      // die;

        // $tables = DB::connection('demonext')->select('Show Tables');
        // dd($tables);
        // foreach($tables as $table){
        //     echo "<pre>";
        //     print_r($table);
        // }
        // exit;
        if (auth()->check()) {
            //$this->middleware('auth');
            if (auth()->user()->role == 'admin' && auth()->user()->email_verified_at == '') {
                //dd('hello');
                Session::flash('message', 'Your Account Is Not Active Please Contact Administrator.!');
                Session::flash('alert-class', 'alert-danger');
                auth()->logout();
                return redirect('/login');
            }
            if (auth()->user()->status == 0) {
                //dd('hello');
                Session::flash('message', 'Your Account Is Disabled. Please Contact Administrator.!');
                Session::flash('alert-class', 'alert-danger');
                auth()->logout();
                return redirect('/login');
            }
            Helper::LoginIpandTime($request->getClientIp());
            $users = User::where('role', '!=', 'admin')->where('role', '!=', 'superadmin')->orderBy('name', 'asc')->get();
            $products = Product::get();
            $categorys = ProductCategory::get();
            $title = 'Dashboard';
            return view('admin.dashboard', compact('users', 'products', 'categorys', 'title'));
        } else {
            return redirect('/login');
        }
    }

    public function vendorList(Request $request)
    {
        if (auth()->check()) {
            //$this->middleware('auth');
            if (auth()->user()->role == 'admin' && auth()->user()->email_verified_at == '') {
                //dd('hello');
                Session::flash('message', 'Your Account Is Not Active Please Contact Administrator.!');
                Session::flash('alert-class', 'alert-danger');
                auth()->logout();
                return redirect('/login');
            }

            Helper::LoginIpandTime($request->getClientIp());
            $users = User::where('role', '!=', 'admin')->where('role', '!=', 'superadmin')->orderBy('name', 'asc')->get();
            $products = Product::get();
            $categorys = ProductCategory::get();
            $title = 'Vendor List';
            return view('admin.vendorlist', compact('users', 'products', 'categorys', 'title'));
            // return view('home',compact('users','products','categorys'));
        } else {
            return redirect('/login');
        }
    }

    public function adminUser(Request $request)
    {


        Helper::LoginIpandTime($request->getClientIp());
        // $users = User::where('role', '!=','user')->where('role', '!=','superadmin')->orderBy('id', 'desc')->get();
        $users = User::orderBy('id', 'desc')->get();
        $title = 'Admin User List';
        return view('admin.adminuser', compact('users', 'title'));
    }

    public function UserStatusUpdate($id)
    {
        $user = User::FindOrFail($id);
        $user->email_verified_at = Carbon::now();
        $user->save();
        Session::flash('message', 'User Activeted Successfully.!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function deleteUser($id)
    {
        $user = User::FindOrFail($id);
        $user->delete();
        Session::flash('message', 'User Deleted Successfully.!');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function logOut()
    {
        if (Auth::Check()) {
            auth()->logout();
        }
        return redirect('/');
    }

    public function messageSend(Request $request)
    {
        //  dd(implode(',',$request->extra_ids));
        $data = json_encode($request->ids);
        $tokenunique = Str::random(10);
        if (!empty($request->ids)) {
            foreach ($request->ids as $id) {
                $userdata = User::FindOrFail($id);
                $message = new SendMessage();
                $message->message = $request->get('editor1');
                $message->user_id = $id;
                $message->token = Str::random(10);
                $message->token_number = $tokenunique;
                $message->created_by = auth()->user()->id;
                $message->save();
                Notification::send($userdata, new UserNotifation($message, $userdata));
                if (!empty($userdata->seondary_email)) {
                    Notification::route('mail', 'testuservendor2@mailinator.com')
                        ->notify(new UserNotifation($message, $userdata));
                }

                $productdata = Helper::SaveProductData($request->all(), $message->id);

                $this->sendMessage($userdata->mobile, $message->token);
            }
            Session::flash('message', 'Message Send Successfully Selected Records.!');
            Session::flash('alert-class', 'alert-success');
        } else {
            Session::flash('message', 'Please Selectr At Least One Record.!');
            Session::flash('alert-class', 'alert-danger');
        }
        return redirect()->back();

    }

    public function MessageReplay($token)
    {
        $tkn = str_replace(".", "", $token);

        $message = SendMessage::where('token', $tkn)->where('status', '0')->whereNull('replay_time')->first();
        $products = Product::get();
        $datas = Helper::GetProducts($message->id);
        //  dd($datas);
        if (!empty($message)) {
            return view('message_replay', compact('message', 'products', 'datas'));
        } else {
            abort(404);
        }
    }

    public function messageReplayStore(Request $request)
    {
        $messagereplay = SendMessage::FindOrFail($request->messageid);

        $replayproduct = Helper::ReplayProduct($request->all());
        //  dd($replayproduct);
        $userdata = User::where('id', $messagereplay->user_id)->first();
        $admindata = User::where('id', $messagereplay->created_by)->first();
        $messagereplay->replay_message = $request->message;
        $messagereplay->status = '1';
        $messagereplay->replay_time = Carbon::now();
        $messagereplay->save();
        $admindata->notify(new AdminNotifation($messagereplay, $userdata));
        return redirect('/thankyou');
    }

    public function Thankyou()
    {
        return view('thanku');
    }

    public function ViewMessage($id)
    {
        $user = User::FindOrFail($id);
        $notifactionread = Helper::readNotifaction($user->id);
        return view('view_message', compact('user'));
    }

    public function ChatMessage(Request $request)
    {
        $userdata = User::FindOrFail($request->user_id);
        $message = new SendMessage();
        $message->message = $request->get('chat_message');
        $message->user_id = $request->user_id;
        $message->token = Str::random(32);
        $message->save();
        Notification::send($userdata, new UserNotifation($message, $userdata));
        Session::flash('message', 'Message Send Sussfully !');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }

    public function sendMessage($number, $token)
    {
        $mobile = '91' . $number;
        $message = 'Please review your request on https://vendorportal.pinkcityindia.com/messagereply/' . $token . '.';
        // dd($message);
        $response = Http::get('https://http.myvfirst.com/smpp/sendsms', [
            'username' => 'jewelhttp',
            'password' => 'jewel12345',
            'to' => $mobile,
            'from' => 'PJHVPM',
            'text' => $message,
        ]);
        $statusCode = $response->getStatusCode();
        $content = $response->getBody();

        return $statusCode;
    }

    /**
     * New Page For All Message
     */
    public function allMessage()
    {
        if (auth()->user()->role == 'superadmin') {
            $messages = SendMessage::orderBy('created_at', 'desc')->groupBy('token_number')->get();
            //dd($messages);
        } else {
            $messages = SendMessage::orderBy('created_at', 'desc')->groupBy('token_number')->where('created_by', auth()->user()->id)->OrderBy('created_by', 'DESC')->get();
        }
        return view('message.all_message', compact('messages'));
    }

    /**
     * View Messages
     */
    public function viewMessageReply(Request $request, $token)
    {

        $query = SendMessage::where('token_number', $token);
        if (!empty($request->get('stone'))) {
            $stone = $request->get('stone');
            $stonedata = Helper::getData($stone, '0');
            // dd($stonedata);
            $query = $query->whereIn('id', $stonedata);
        }
        if (!empty($request->get('shape'))) {
            $shape = $request->get('shape');
            $shapedata = Helper::getData($shape, '2');
            $query = $query->whereIn('id', $shapedata);
        }
        if (!empty($request->get('size'))) {
            $size = $request->get('size');
            $sizedata = Helper::getData($size, '3');
            $query = $query->whereIn('id', $sizedata);
        }
        if (!empty($request->get('pricect'))) {
            $pricect = $request->get('pricect');
            $pricectdata = Helper::getData($pricect, '4');
            $query = $query->whereIn('id', $pricectdata);
        }
        if (!empty($request->get('quality'))) {
            $quality = $request->get('quality');
            $qualitydata = Helper::getData($quality, '5');
            $query = $query->whereIn('id', $qualitydata);
        }

        $messages = $query->get();
        $products = Product::get();
        $msg = SendMessage::where('token_number', $token)->first();
        $requestdata = $request->all();
        return view('message.view_message', compact('messages', 'products', 'msg', 'requestdata'));
    }

    public function addMore(Request $request)
    {
        $addmore = $request->get('id');
        $products = Product::get();
        $categorys = ProductCategory::get();
        $html = view('addmore', compact('products', 'categorys', 'addmore'))->render();
        return response()->json(array('success' => true, 'html' => $html));

    }

    public function viewMessageSingle($id)
    {
        $message = SendMessage::FindOrFail($id);
        $messagereplys = MessageReplay::where('message_id', $id)->get();
        return view('message.single-message', compact('message', 'messagereplys'));
    }

    public function ChatSingleMessage(Request $request)
    {
        //   dd($request->all());
        $message = SendMessage::FindOrFail($request->message_id);
        $userdata = User::FindOrFail($message->user_id);
        $messagereplay = new MessageReplay();
        $messagereplay->message_id = $request->message_id;
        $messagereplay->sender_id = auth()->user()->id;
        $messagereplay->receiver_id = $message->user_id;
        $messagereplay->message = $request->chat_message;
        $messagereplay->save();

        Notification::send($userdata, new UserChatNotifation($messagereplay, $userdata));
        Session::flash('message', 'Message Send Sussfully !');
        Session::flash('alert-class', 'alert-success');
        return redirect()->back();
    }


    public function EmployyeCheck(){
        $apiURL = 'https://login.windows.net/common/oauth2/token';
        $postInput = [
            'client_id' => 'Hardik',
            'username' => 'pankaj.kumar@jewelalliance.onmicrosoft.com',
            'password' => 'Pank#14312312',
            'grant_type' => 'password',
            'scope' => 'openid'
        ];

        $headers = [
            'X-header' => 'value'
        ];

        $response = Http::withHeaders($headers)->post($apiURL, $postInput);

        $statusCode = $response->status();
        $responseBody = json_decode($response->getBody(), true);

        dd($responseBody);

        $curlPostToken = curl_init();
        curl_setopt_array($curlPostToken, array(

        CURLOPT_URL => "https://login.windows.net/common/oauth2/token",

        CURLOPT_RETURNTRANSFER => true,

        CURLOPT_ENCODING => "",

        CURLOPT_MAXREDIRS => 10,

        CURLOPT_TIMEOUT => 30,

        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,

        CURLOPT_CUSTOMREQUEST => "POST",

        CURLOPT_POSTFIELDS => array(

        grant_type => 'password',

        scope => 'openid',

        resource => 'https://analysis.windows.net/powerbi/api',

        client_id => '', // Registered App ApplicationID

        username => '', // for example john.doe@yourdomain.com

        password => '' // Azure password for above user

        )

        ));

        $tokenResponse = curl_exec($curlPostToken);

        $tokenError = curl_error($curlPostToken);
        dd($tokenError);
        curl_close($curlPostToken);


    }

}
