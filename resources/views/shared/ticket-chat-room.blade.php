<div id="chat_modal" class="c-modal">
  <a class="close"></a>
  <div class="c-modal-inner">

    <a class="modal-close">
      <span aria-hidden="true">×</span>
    </a>

    <h5 class="f5"><i class="fa fa-comments" aria-hidden="true"></i>&nbsp;<strong>สอบถามรายละเอียดกับผู้ขาย</strong></h5>
      <textarea id="chat_message" class="modal-textarea show form-control w-100 mt3"></textarea>
      <button type="button" id="chat_submit_message_btn" class="btn btn-primary btn-block br0 mt3">ส่งข้อความ</button>
    </form>

  </div>

  <div class="sending-indicator">
    <div class="border one"></div>
    <div class="border two"></div>
    <div class="border three"></div>
    <div class="border four"></div>

    <div class="line one"></div>
    <div class="line two"></div>
    <div class="line three"></div>
  </div>

</div>

<script type="text/javascript" src="/assets/js/ticket-chat-room.js"></script>
<script type="text/javascript">
  $(document).ready(function () {
    const ticketChatRoom = new TicketChatRoom({{Auth::user()->id}},{{$ticketId}});
    ticketChatRoom.init();
  });
</script>