<header>
  <ul id="gn-menu" class="gn-menu-main">
    <li class="gn-trigger">
      <a class="gn-icon gn-icon-menu"><span>Menu</span></a>
      <nav class="gn-menu-wrapper">
        <div class="gn-scroller">
          <ul class="gn-menu">
            <li class="gn-search-item">
              <input placeholder="Search" type="search" class="gn-search">
              <a class="gn-icon fa-search"><span>Search</span></a>
            </li>
            <li><a href="/ticket" class="gn-icon fa-tags">รายการขายบัตร</a></li>
            <li><a href="/ticket/new" class="gn-icon fa-plus">เพิ่มรายการขาย</a></li>
            @if(Auth::check())
              <li>
                <a class="gn-icon fa-user">{{Auth::user()->name}}</a>
                <ul class="gn-submenu">
                  <li><a href="/account/edit" class="gn-icon fa-pencil">แก้ไชโปรไฟล์</a></li>
                  <li><a href="/account/ticket" class="gn-icon fa-list">รายการขายของคุณ</a></li>
                  <li><a href="/logout" class="gn-icon fa-sign-out">ออกจากระบบ</a></li>
                </ul>
              </li>
            @else
              <li>
                <a class="gn-icon fa-lock">บัชชี</a>
                <ul class="gn-submenu">
                  <li><a href="/login" class="gn-icon fa-pencil">เข้าสู่ระบบ</a></li>
                  <li><a href="/register" class="gn-icon fa-list">สร้างบัญชี</a></li>
                </ul>
              </li>
            @endif
            <!-- <li>
              <a class="gn-icon fa-heart">Help</a>
              <ul class="gn-submenu">
                <li><a class="gn-icon fa-user">ติดต่อเรา</a></li>
                <li><a class="gn-icon fa-user">นโยบาย</a></li>
              </ul>
            </li> -->
          </ul>
        </div>
      </nav>
    </li>
    <li><a href="/">TicketSnap</a></li>
    <li>
      <a href="/ticket"><span><i class="fa fa-comments"></i></span></a>
    </li>
  </ul>
</header>