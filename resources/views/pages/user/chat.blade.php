@extends('shared.main')
@section('content')

<style type="text/css">
  body {
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

    background: #606c88;  /* fallback for old browsers */
    background: -webkit-linear-gradient(to right, #3f4c6b, #606c88);  /* Chrome 10-25, Safari 5.1-6 */
    background: linear-gradient(to right, #3f4c6b, #606c88); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */


  }
</style>

<div class="chat-section">
  <div id="message_display" class="chat-thread">

    <div class="typing-indicator">
      <span></span>
      <span></span>
      <span></span>
    </div>

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