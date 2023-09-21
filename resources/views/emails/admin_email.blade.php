@extends('emails.mail_template')
@section('content')
<tr>
    <td style="text-align:left; padding:10px 0px 20px 20px; border-bottom:1px solid #e1e1e1;" bgcolor="#f9f9f9">
        <div style="margin:20px auto 10px; font-size:16px;"><h4 style="text-transform: capitalize;"><b>Hi Admin,</b></h4></div>
        <div style="margin:20px auto 10px; font-size:16px;">You Have New Notifaction For Replay Message<span style="color : #043278;">{{env('APP_NAME')}} </div>
      
        <div style="margin:20px auto 10px;"> 
        <p style="margin:10px auto 10px;">Name :- {{$user->name}}</p>
        <p style="margin:10px auto 10px;">Email :- {{$user->email}}</p>
        <p style="margin:10px auto 10px;">Mobile Number :- {{$user->mobile}}</p>
        <p style="margin:10px auto 10px;">Message :- {!! $messagedata->message !!}</p>
        <p style="margin:10px auto 10px;">Replay Message :- {!! $messagedata->replay_message !!}</p>
        </div>
       
    </td>
</tr>
@endsection
