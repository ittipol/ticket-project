@extends('shared.main')
@section('content')

<style type="text/css">
  body {

    overflow: hidden;
    /*background-color: #444;*/

    /*background: -moz-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
    background: -webkit-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;*/
    
    /*background: #4CA1AF;
    background: -webkit-linear-gradient(to right, #C4E0E5, #4CA1AF);
    background: linear-gradient(to left, #C4E0E5, #4CA1AF);*/
  
    /*background: #134E5E;
    background: -webkit-linear-gradient(to right, #71B280, #134E5E); 
    background: linear-gradient(to right, #71B280, #134E5E);*/

    /*background: #606c88;
    background: -webkit-linear-gradient(to right, #3f4c6b, #606c88);
    background: linear-gradient(to right, #3f4c6b, #606c88);*/
  }
</style>

<div class="chat-left-sidenav">
  <div class="user-chat-list p-3">
    @foreach($users as $user)
      <div class="clearfix mb-2">
        <div class="avatar-frame fl">
          <div class="online_status_indicator_{{$user['id']}} online-status-indicator @if($user['online']) is-online @endif"></div>
          <div class="avatar">
            <img src="/avatar/{{$user['id']}}?d=1">
          </div>
        </div>
        <div class="online-name fl">{{$user['name']}}</div>
      </div>
    @endforeach
  </div>
</div>

<div class="chat-section">

  <div class="chat-title text-center">
    @foreach($users as $user)
      <div class="online_status_indicator_{{$user['id']}} online-status-indicator @if($user['online']) is-online @endif"></div>
    @endforeach
    <a href="/ticket/view/{{$ticket->id}}"><i class="fa fa-ticket"></i>&nbsp;&nbsp;{{$ticket->title}}</a>
  </div>

  <div class="typing-indicator">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <div id="message_display" class="chat-thread clearfix"></div>

  <div class="chat-footer-section">
    <input type="text" id="message_input" class="chat-input">
    <button id="send_btn" class="chat-send-btn">
      <i class="fa fa-send"></i>
    </button>
  </div>
</div>

<script type="text/javascript" src="/assets/js/user_online.js"></script>
<script type="text/javascript" src="/assets/js/form/chat.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    const _chat = new Chat({!!$chat!!});
    _chat.init();

    const _userOnline = new UserOnline();
    _userOnline.init();
  });
</script>

@stop