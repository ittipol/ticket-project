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
  <!-- <div class="chat-left-sidenav-header p-3">
    <h5 class="m-0">แชท</h5>
  </div> -->
  <div class="user-chat-list p-3">
    <div class="avatar-frame fl">
      <div class="online_status_indicator_{{$seller['id']}} online-status-indicator @if($seller['online']) is-online @endif"></div>
      <div class="avatar">
        @if(empty($seller['avatar']))
        <img src="/avatar?d=1">
        @else
        <img src="/avatar/{{$seller['avatar']}}?d=1">
        @endif
      </div>
    </div>
    <div class="online-name fl">{{$seller['name']}}</div>
  </div>
</div>

<div class="chat-section">

  <div class="typing-indicator">
    <span></span>
    <span></span>
    <span></span>
  </div>

  <div id="message_display" class="chat-thread clearfix">

  </div>

  <div class="chat-footer-section">
    <input type="text" id="message_input" class="chat-input">
    <button id="send_btn" class="chat-send-btn">
      <i class="fa fa-send"></i>
    </button>
  </div>
</div>

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