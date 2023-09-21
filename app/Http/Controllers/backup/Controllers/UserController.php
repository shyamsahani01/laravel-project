<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UsersImport;
use App\Imports\UnitImport;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Exports\UsersExport;
use Session;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImportExport()
    {
       return view('file-import');
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileImport(Request $request)
    {
     // dd($request->all());
    	$validated = $request->validate([
          'file' => 'required|mimes:csv,xlsx,xls,odt,ods',
        ],[
          'file.required' => 'File Is required',
         ]);
         Excel::import(new UnitImport, $request->file('file')->store('temp'));
      //  Excel::import(new UsersImport, $request->file('file')->store('temp'));
        Session::flash('message', 'User Data import Successfully.!');
        Session::flash('alert-class', 'alert-success');
        return back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function fileExport()
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx');
    }



    public function addUser(){
      return  view('admin.users.add_user',['title'=>'Add User']);
       //return  view('users.add_user');
    }


    public function StoreUser(Request $request){
    // print_r($request->status);
    // die;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->status = $request->status == 'on' ? 1 : 0;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        if($request->status == 1){
          $user->email_verified_at = Carbon::now();
        }
        $user->save();
      Session::flash('message', 'User Add  Successfully.!');
      Session::flash('alert-class', 'alert-success');
      return redirect('/');
    }

    public function editUser($id){
      if(auth()->user()->role == 'superadmin'){
       $user= User::FindOrFail($id);
       $title = 'Edit User';
       return  view('admin.users.edit_user',compact('user','title'));
      }else{
        return redirect()->back();
      }
    }


    public function UpdateUser(Request $request){
      // print_r($request->status);
      // die;

      $user = User::FindOrFail($request->id);

      $user->name = $request->name;
      $user->email = $request->email;
      $user->mobile = $request->mobile;
      $user->role = $request->role;
      $user->status = $request->status == 'on' ? 1 : 0;
      if(!empty($request->password)){
      $user->password = Hash::make($request->password);
      }
      $user->save();
      Session::flash('message', 'User Updated  Successfully.!');
      Session::flash('alert-class', 'alert-success');
      return redirect('/adminusers');
    }

    public function deleteUser($id){
      $user = User::FindOrFail($id);
      $user->delete();
      Session::flash('message', 'User Deleted  Successfully.!');
      Session::flash('alert-class', 'alert-success');
      return redirect('/');
    }
}
