<?php

namespace App\Imports;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
     
       
        $mobiles = explode(',',$row['mobile']);
        $emails = explode(',',$row['email']);
        $p_number = '';
        $s_number = '';
        $p_email = '';
        $s_email = '';
        if(!empty($mobiles[0])){
        	$p_number = $mobiles[0];
        }
        if(!empty($mobiles[1])){
        	$s_number = $mobiles[1];
        }
        if(!empty($emails[0])){
        	$p_email = $emails[0];
        }
        if(!empty($emails[1])){
        	$s_email = $emails[1];
        }
       
        return new User([
            'name'  => $row['name'],
            'email' => $p_email,
            'seondary_email' =>$s_email,
            'mobile'=> $p_number,
            'seondary_number'=> $s_number,
            'password'=> Hash::make('Test@123'),
            'firm_name' => $row['firm_name'],
        ]);
        
    }
}
