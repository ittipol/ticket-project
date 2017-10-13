<div class="fixed-header">
  <nav class="navbar navbar-toggleable-md bg-faded fixed-top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
        <i class="fa fa-bars" aria-hidden="true"></i>
      </span>
    </button>
    <a class="navbar-brand" href="/">TicketSnap</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="/ticket">ราการขาย</a>
        </li>
      </ul>
      <ul class="navbar-nav my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link d-inline-block" href="/ticket/new">
            <i class="fa fa-tag"></i>&nbsp;ลงขายบัตร
          </a>
        </li>
        @if(Auth::check())
          <li class="nav-item">
            <a class="nav-link d-inline-block" href="/notification">
              <i class="fa fa-bell-o" aria-hidden="true"></i>
            </a>
          </li>
          <li>
            <a class="nav-link d-inline-block user-profile" href="/account">
              <img src="/avatar?d=1">
            </a>
            <!-- <a class="nav-link d-inline-block" href="/logout">
              <i class="fa fa-sign-out" aria-hidden="true"></i>
            </a> -->
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link d-inline-block" href="/login">
              <i class="fa fa-user-o"></i>&nbsp;เข้าสู่ระบบ
            </a>
            /
            <a class="nav-link d-inline-block" href="/subscribe">สร้างบัญชี</a>
          </li>
        @endif
      </ul>
    </div>
  </nav>
</div>
