<div class="fixed-header">
  <nav class="navbar navbar-toggleable-md bg-faded fixed-top">
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon">
      </span>
    </button>
    <a class="navbar-brand" href="#">TicketSnap</a>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="/">หน้าแรก <span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/ticket">ราการขาย</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/chat">แชท</a>
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
            <a class="nav-link d-inline-block" href="/logout">
              </i>&nbsp;ออกจากระบบ
            </a>
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
