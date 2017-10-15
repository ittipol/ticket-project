<header>
  <ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
      <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
      <nav class="gn-menu-wrapper">
        <div class="brand-s text-center">
          <h5 class="py-3 m-0">TicketSnap</h5>
        </div>
        <div class="gn-scroller">
          <ul class="gn-menu">
            <li class="gn-search-item">
              <input placeholder="Search" type="search" class="gn-search">
              <a class="gn-icon fa-search"><span>Search</span></a>
            </li>
            <li><a href="/ticket" class="gn-icon fa-tags">รายการขายบัตร</a></li>
            <!-- <li><a href="/ticket/new" class="gn-icon fa-plus">เพิ่มรายการขาย</a></li> -->
            @if(Auth::check())
              <li>
                <a href="javascript:void(0);" class="gn-icon fa-user">{{Auth::user()->name}}</a>
                <ul class="gn-submenu">
                  <li><a href="/account/edit" class="gn-icon fa-pencil">แก้ไขโปรไฟล์</a></li>
                  <li><a href="/account/ticket" class="gn-icon fa-list">รายการขายของคุณ</a></li>
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

    <li class="brand-l"><a href="/">TicketSnap</a></li>

    @if(Auth::check())

    <li class="dd-menu btn-hover">
      <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="avatar-frame pointer">
        <img class="avatar" src="/avatar?d=1">
      </a>
      <ul class="dropdown-menu">
        <li class="dd-link"><a href="/account/edit"><i class="fa fa-pencil"></i>&nbsp;&nbsp;แก้ไขโปรไฟล์</a></li>
        <li class="dd-link"><a href="/account/ticket"><i class="fa fa-list"></i>&nbsp;&nbsp;รายการขายของคุณ</a></li>
        <li class="dd-link"><a href="/logout"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;ออกจากระบบ</a></li>
      </ul>
    </li>

    <li class="dd-menu static relative-ns btn-hover">
      <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="notification nav-icon pointer">
        <div class="count-badge"></div>
        <i class="fa fa-comments"></i>
      </a>

      <ul class="dropdown-menu dd-notification">
        <h5 class="p-3 text-center">ข้อความ</h5>

        <div class="notification-list">

          @for($i = 0; $i <= 10; $i++)
            <a href="" class="notification-list-item clearfix">
              <div class="notification-icon fl">
                <img class="avatar" src="/avatar?d=1">
              </div>
              <div class="notification-content fl">
                <p class="m-0">New Message!!!</p>
              </div>
            </a>
          @endFor

        </div>

      </ul>
    </li>

    <li class="btn-hover">
      <a href="/ticket/new">
        <i class="fa fa-plus"></i>&nbsp;เพิ่มรายการขาย
      </a>
    </li>

    @else
    <li class="dd-menu">
      <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="pointer">
        <i class="fa fa-user"></i>&nbsp;บัญชี
      </a>
      <ul class="dropdown-menu">
        <li class="dd-link"><a href="/login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;เข้าสู่ระบบ</a></li>
        <li class="dd-link"><a href="/subscribe"><i class="fa fa-pencil"></i>&nbsp;&nbsp;สร้างบัญชี</a></li>
      </ul>
    </li>
    @endif
  </ul>
</header>