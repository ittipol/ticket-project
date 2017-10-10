@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #444;*/

    /*background: -moz-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
    background: -webkit-linear-gradient(-45deg, #183850 0, #183850 25%, #192C46 50%, #22254C 75%, #22254C 100%);
    background-repeat: no-repeat;
    background-attachment: fixed;*/
    
    background: #4CA1AF;
    background: -webkit-linear-gradient(to right, #C4E0E5, #4CA1AF);
    background: linear-gradient(to left, #C4E0E5, #4CA1AF);
  }
</style>

<div class="chat-section">
  <div id="message_display" class="chat-thread">

    <div class="typing-indicator">
      <span></span>
      <span></span>
      <span></span>
    </div>

    @for ($i = count($messages)-1; $i >= 0; $i--)
        <div class="message-section message-me">
          <div class="avatar">
            <img src="/avatar?d=1">
          </div>
          <div class="message-box">{{$messages[$i]->message}}</div>
        </div>
    @endfor

    @foreach($messages as $message)
      <!-- <div class="message-section message-me">
        <div class="avatar">
          <img src="/avatar?d=1">
        </div>
        <div class="message-box">{{$message->message}}</div>
      </div> -->
    @endforeach

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
    const chat = new Chat({!!$chat!!});
    chat.init();
  });
</script>

@stop