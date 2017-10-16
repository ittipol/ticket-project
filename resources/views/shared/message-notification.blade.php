<ul class="dropdown-menu dd-message-notification">
  <h5 class="p-3 text-center">ข้อความ</h5>
  <div class="message-notification-list">
    @for($i = 0; $i <= 10; $i++)
      <a href="" class="message-notification-list-item clearfix">
        <div class="message-notification-icon fl">
          <img class="avatar" src="/avatar?d=1">
        </div>
        <div class="message-notification-content fl">
          <p class="m-0">New Message!!!</p>
        </div>
      </a>
    @endFor
  </div>
</ul>