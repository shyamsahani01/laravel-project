@extends('layouts.frontend.app')
<link rel="stylesheet" href="{{asset('css/chat.css')}}">

@section('content')

<div class="container">
    <div class="row formclasscust">
        <div class="col-md-2">
        </div>
        <div class="col-md-8">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <span class="glyphicon glyphicon-comment"></span> Message To {{$user->name}}
                </div>
            <div class="">
                <div class="panel-body">
                    <ul class="chat">
                        @foreach($user->MessageGet as $message)
                        <li class="left clearfix"><span class="chat-img pull-left">
                            <img src="{{asset('img/admin.png')}}" alt="User Avatar" class="img-circle" />
                           </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <strong class="primary-font">{{auth()->user()->name}}</strong> <small class="pull-right text-muted">
                                        <span class="glyphicon glyphicon-time"></span>{{$message->getTime($message->created_at)}}</small>
                                </div>
                                <p>
                                   {!! $message->message !!}
                                </p>
                            </div>
                        </li>
                        <li class="right clearfix"><span class="chat-img pull-right">
                            <img src="{{asset('img/user.png')}}" alt="User Avatar" class="img-circle" />
                            </span>
                            <div class="chat-body clearfix">
                                <div class="header">
                                    <small class=" text-muted"><span class="glyphicon glyphicon-time"></span>
                                      {{$message->getTime($message->replay_time)}}</small>
                                    <strong class="pull-right primary-font">{{$user->name}}</strong>
                                </div>
                                @if(!empty($message->replay_message))
                                <p>
                                    {!! $message->replay_message !!}
                                </p>
                                @else 
                                <p>
                                    No Reply
                                </p>
                                @endif
                            </div>
                        </li>
                        @endforeach
                    </ul>
                </div>
                <div class="panel-footer">
                  <form method="post" action="{{route('ChatMessage')}}">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="user_id" value="{{$user->id}}">
                        <input id="btn-input" type="text" name="chat_message" class="form-control input-sm" placeholder="Type your message here..." />
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
        <div class="col-md-2">
        </div>
    </div>
</div>

@endsection



