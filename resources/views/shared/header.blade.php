<header>
  <ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
      <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
      <nav class="gn-menu-wrapper">
        <div class="brand-s text-center">
          <h5 class="py-3 m-0">TicketEasys</h5>
        </div>

        <div class="gn-scroller">
          <ul class="gn-menu">
            <li class="gn-search-item">
              {{Form::open(['url' => 'ticket','method' => 'get', 'enctype' => 'multipart/form-data'])}}
              <input placeholder="ค้นหาบัตร" type="search" name="q" autocomplete="off" class="gn-search">
              {{Form::close()}}
              <a class="gn-icon fa-search"><span>ค้นหาบัตร</span></a>
            </li>
            <li><a href="/ticket" class="gn-icon fa-ticket">รายการขายบัตร</a></li>
            @if(Auth::check())
              <li>
                <a href="/account" class="gn-icon fa-user">{{Auth::user()->name}}</a>
                <ul class="gn-submenu">
                  <li><a href="/account/edit" class="gn-icon fa-pencil">แก้ไขโปรไฟล์</a></li>
                  <li><a href="/account/ticket" class="gn-icon fa-list">รายการขายของฉัน</a></li>
                  <li><a href="/logout" class="gn-icon fa-sign-out">ออกจากระบบ</a></li>
                </ul>
              </li>
            @else
              <li>
                <a class="gn-icon fa-user">บัญชี</a>
                <ul class="gn-submenu">
                  <li><a href="/login" class="gn-icon fa-sign-in">เข้าสู่ระบบ</a></li>
                  <li><a href="/subscribe" class="gn-icon fa-pencil">สร้างบัญชี</a></li>
                </ul>
              </li>
            @endif
          </ul>
        </div>
        
      </nav>
    </li>

    <li class="brand-l"><a href="/">TicketEasys</a></li>

    @if(Auth::check())

      <li class="dd-menu btn-hover">
        <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="avatar-frame pointer">
          <img src="/avatar?d=1">
        </a>
        <ul class="dropdown-menu">
          <li class="dd-link"><a href="/account/edit"><i class="fa fa-pencil"></i>&nbsp;&nbsp;แก้ไขโปรไฟล์</a></li>
          <li class="dd-link"><a href="/account/ticket"><i class="fa fa-list"></i>&nbsp;&nbsp;รายการขายของฉัน</a></li>
          <li class="dd-link"><a href="/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;ออกจากระบบ</a></li>
        </ul>
      </li>

      <li class="dd-menu static relative-ns btn-hover">
        <a id="message_notification" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="message-notification nav-icon pointer">
          <div id="message_notification_count" class="count-badge"></div>
          <i class="fa fa-comments"></i>
        </a>
        <ul class="dropdown-menu dd-message-notification">
          <h5 class="text-center">ข้อความ</h5>
          <div id="message_notification_list" class="message-notification-list"></div>
        </ul>
    </li>

    @else

      <li class="dd-menu btn-hover">
        <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="pointer">
          <i class="fa fa-user"></i>&nbsp;บัญชี
        </a>
        <ul class="dropdown-menu">
          <li class="dd-link"><a href="/login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;เข้าสู่ระบบ</a></li>
          <li class="dd-link"><a href="/subscribe"><i class="fa fa-pencil"></i>&nbsp;&nbsp;สร้างบัญชี</a></li>
        </ul>
      </li>

    @endif

      <li class="btn-hover">
        <a href="/ticket/new">
          <i class="fa fa-sticky-note" aria-hidden="true"></i>&nbsp;ขายบัตร
        </a>
      </li>
  </ul>
</header>