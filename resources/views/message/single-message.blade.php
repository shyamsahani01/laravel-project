@extends('layouts.frontend.app')
<link rel="stylesheet" href="{{asset('css/chat.css')}}">

@section('content')
<style>

/* User Cards */
.user-box {
    width: 110px;
    margin: auto;
    margin-bottom: 20px;
    
}

.user-box img {
    width: 100%;
    border-radius: 50%;
	padding: 3px;
	background: #fff;
	-webkit-box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    -moz-box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    -ms-box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
    box-shadow: 0px 5px 25px 0px rgba(0, 0, 0, 0.2);
}
.panel-primary {
    box-shadow: 0px 5px 25px 0px rgb(0 0 0 / 20%);
    border-color: #337ab7;
}
.profile-card-2 .card {
	position:relative;
}

.profile-card-2 .card .card-body {
	z-index:1;
}

.profile-card-2 .card::before {
    content: "";
    position: absolute;
    top: 0px;
    right: 0px;
    left: 0px;
	border-top-left-radius: .25rem;
    border-top-right-radius: .25rem;
    height: 112px;
    background-color: #e6e6e6;
}

.profile-card-2 .card.profile-primary::before {
	background-color: #008cff;
}
.profile-card-2 .card.profile-success::before {
	background-color: #15ca20;
}
.profile-card-2 .card.profile-danger::before {
	background-color: #fd3550;
}
.profile-card-2 .card.profile-warning::before {
	background-color: #ff9700;
}
.profile-card-2 .user-box {
	margin-top: 30px;
}

.profile-card-3 .user-fullimage {
	position:relative;
}

.profile-card-3 .user-fullimage .details{
	position: absolute;
    bottom: 0;
    left: 0px;
	width:100%;
}

.profile-card-4 .user-box {
    width: 110px;
    margin: auto;
    margin-bottom: 10px;
    margin-top: 0px;
}

.list-group {
    height: 189px;
}

.profile-card-4 .list-icon {
    display: table-cell;
    font-size: 30px;
    padding-right: 20px;
    vertical-align: middle;
    color: #223035;
}

.profile-card-4 .list-details {
	display: table-cell;
	vertical-align: middle;
	font-weight: 600;
    color: #223035;
    font-size: 15px;
    line-height: 15px;
}

.profile-card-4 .list-details small{
	display: table-cell;
	vertical-align: middle;
	font-size: 12px;
	font-weight: 400;
    color: #808080;
}

.top-icon.nav-tabs .nav-link i{
	margin: 0px;
	font-weight: 500;
	display: block;
    font-size: 20px;
    padding: 5px 0;
}

.card .tab-content{
	padding: 1rem 0 0 0;
}

.z-depth-3 {
    -webkit-box-shadow: 0 11px 7px 0 rgba(0,0,0,0.19),0 13px 25px 0 rgba(0,0,0,0.3);
    box-shadow: 0 11px 7px 0 rgba(0,0,0,0.19),0 13px 25px 0 rgba(0,0,0,0.3);
}
</style>
<div class="container formclasscust">
<div class="row">
@if(Session::has('message'))
          <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
        <div class="col-lg-4">
           <div class="profile-card-4 z-depth-3">
            <div class="card">
              <div class="card-body text-center bg-primary rounded-top">
               <div class="user-box">
                <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="user avatar">
              </div>
              <h5 class="mb-1 text-white">{{$message->users->name}}</h5>
              <h6 class="text-light">Vendor</h6>
             </div>
              <div class="card-body">
                <ul class="list-group shadow-none">
                <li class="list-group-item">
                  <div class="list-icon">
                    <i class="fa fa-phone-square"></i>
                  </div>
                  <div class="list-details">
                    <span>{{$message->users->mobile}}</span>
                    <small>Mobile Number</small>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="list-icon">
                    <i class="fa fa-envelope"></i>
                  </div>
                  <div class="list-details">
                    <span>{{$message->users->email}}</span>
                    <small>Email Address</small>
                  </div>
                </li>
                </ul>
               </div>
             </div>
           </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> <strong>Message</strong> :- {{$message->message }}
                </div>
            <div class="">
                <div class="panel-body">
                    <ul class="chat">
                        <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="{{asset('img/user.png')}}" alt="User Avatar" class="img-circle" />
                           </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{$message->users->name}}</strong> <small class="pull-right text-muted">
                                    <span class="glyphicon glyphicon-time"></span>{{$message->getTime($message->created_at)}}</small>
                                </div>
                                <p>
                                @if(!empty($message->replay_message))
                                    {!! $message->replay_message !!}
                                @else 
                                    No Replay 
                                @endif     
                                </p>
                            </div>
                        </li>
                        @if(!empty($messagereplys))
                            @foreach($messagereplys as $replay)
                                @if($replay->sender->role == 'superadmin' || $replay->sender->role == 'admin')
                                    <li class="right clearfix"><span class="chat-img pull-right">
                                        <img src="{{asset('img/admin.png')}}" alt="User Avatar" class="img-circle" />
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>
                                                {{$replay->getTime($replay->created_at)}}</small>
                                                <strong class="pull-right primary-font">{{ $replay->sender->name }}</strong>
                                            </div>
                                            <p>
                                                {!! $replay->message !!}
                                            </p>
                                        </div>
                                    </li>
                                @endif
                                @if($replay->reciver->role == 'superadmin' || $replay->reciver->role == 'admin')
                                    <li class="left clearfix">
                                        <span class="chat-img pull-left">
                                        <img src="{{asset('img/user.png')}}" alt="User Avatar" class="img-circle" />
                                        </span>
                                        <div class="chat-body clearfix">
                                            <div class="header">
                                                <strong class="primary-font">{{ $replay->sender->name }}</strong> <small class="pull-right text-muted">
                                                <span class="glyphicon glyphicon-time"></span> {{$replay->getTime($replay->created_at)}}</small>
                                            </div>
                                            <p>
                                            {!! $replay->message !!}   
                                            </p>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div class="panel-footer">
                  <form method="post" action="{{route('ChatSingleMessage')}}">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="message_id" value="{{$message->id}}">
                        <input id="btn-input" type="text" name="chat_message" class="form-control input-sm" required placeholder="Type your message here..." />
                        <span class="input-group-btn">
                            <button type="submit" class="btn btn-warning btn-sm" id="btn-chat">
                                Send</button>
                        </span>
                    </div>
                  </form>  
                </div>
            </div>
            </div>
        </div>
      </div>
      </div>
        
    </div>
</div>

@endsection



