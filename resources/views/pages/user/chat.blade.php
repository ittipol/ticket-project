@extends('shared.main')
@section('content')

<div class="chat-section">
  <div id="message_display" class="chat-thread">

    <div class="typing-indicator">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>
    <div class="message-section message-me">
      <div class="avatar">
        <img src="/avatar?d=1">
      </div>
      <div class="message-box">I was thinking after lunch, I have a meeting in the morning</div>
    </div>

</div>

<div class="chat-footer-section">
  <input type="text" id="message_input" class="chat-input">
  <button id="send_btn" class="chat-send-btn">
    <i class="fa fa-send"></i>
  </button>
</div>

<script type="text/javascript" src="/assets/js/form/chat.js"></script>
<script type="text/javascript">
  $(document).ready(function(){
    const chat = new Chat(socket.socket,{!!$chat!!});
    chat.init();
  });
</script>

@stop