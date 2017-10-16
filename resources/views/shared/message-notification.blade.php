<ul class="dropdown-menu dd-message-notification">
  <h5 class="p-3 text-center">ข้อความ</h5>
  <div class="message-notification-list">
    @foreach($_messageNotifications as $value)
      <a href="" class="message-notification-list-item clearfix">
        <div class="message-notification-icon fl">
          <img class="avatar" src="/avatar/{{$value['user_id']}}?d=1">
        </div>
        <div class="message-notification-content fl">
          <div><strong>username</strong></div>
          <div>New Message!!!</div>
        </div>
      </a>
    @endForeach
  </div>
</ul>