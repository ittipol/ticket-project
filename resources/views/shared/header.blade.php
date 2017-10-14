<header>
  <ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
      <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
      <nav class="gn-menu-wrapper">
        <div class="gn-scroller">

          <!-- <div class="brand-s text-center">
            <h5 class="py-3 m-0"></h5>
          </div> -->

          <ul class="gn-menu">
            <li class="gn-search-item">
              <input placeholder="Search" type="search" class="gn-search">
              <a class="gn-icon fa-search"><span>Search</span></a>
            </li>
            <li><a href="/ticket" class="gn-icon fa-tags">รายการขายบัตร</a></li>
            <li><a href="/ticket/new" class="gn-icon fa-plus">เพิ่มรายการขาย</a></li>
            @if(Auth::check())
              <li>
                <a href="javascript:void(0);" class="gn-icon fa-user">{{Auth::user()->name}}</a>
                <ul class="gn-submenu">
                  <li><a href="/account/edit" class="gn-icon fa-pencil">แก้ไชโปรไฟล์</a></li>
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
    <li>
      <div class="avatar-frame pointer">
        <img class="avatar" src="/avatar?d=1">
      </div>
    </li>
    <li class="notification">
      <a href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="notification pointer">
        <div class="header-badge"></div>
        <i class="fa fa-comments"></i>
      </a>

      <ul class="dropdown-menu notify-drop">
        <div class="notify-drop-title">
          <p>แจ้งเตือน</p>
        </div>

        <div class="drop-content">
          


          <div class="clearfix">
            <div class="w-30 fl">
              <div class="notify-img">
                <img src="http://placehold.it/45x45" alt="">
              </div>
            </div>
            <div class="w-70 fl">
              <p class="time">Şimdi</p>
            </div>
          </div>

        </div>
 
      </ul>
    </li>
    @else
    <li>
      <a>
        <i class="fa fa-user"></i>&nbsp;บัญชี
      </a>
    </li>
    @endif
  </ul>
</header>