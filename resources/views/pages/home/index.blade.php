@extends('shared.main')
@section('content')

<div class="infomation-wrapper">
  <div class="container">
    <div class="content-section tc margin-bottom-80">
      <h1>ขายบัตรของคุณกับ TicketSnap!</h1>
      <h3 class="margin-bottom-20">ในที่สุดคุณก็สามารถขายตั๋วที่ไม่ได้ใช้ได้แล้ว</h3>
      <p class="margin-bottom-5">มีผู้คนอีกมากมายที่คุณไม่คาดคิดกำลังต้องบัตรงานแสดงจากคุณ</p>
      <p class="margin-bottom-5">TicketSnap เป็นเว็บไซต์ที่ให้คุณซื้อและขายบัตรงานแสดงต่าง ๆ ได้ด้วยตัวคุณเอง</p>
    </div>

    <div class="content-section tc margin-bottom-80">
      <h3 class="margin-bottom-20">ค้นหาและขายบัตรของคุณตอนนี้</h3>
      
      {{Form::open(['url' => 'ticket','method' => 'get', 'enctype' => 'multipart/form-data'])}}
        <div class="input-group w-60-l w-100-ns mx-auto">
          <input type="text" class="form-control" placeholder="ค้นหาบัตร" autocomplete="off">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>
      {{Form::close()}}

    </div>
  </div>
</div>

<div class="parallax-bg">
  <div class="container margin-top-60 margin-bottom-60">
    <div class="content-section tl">
      <h1 class="dark-gray mb-3">เริ่มต้นขายบัตรของคุณ</h1>
      <p class="dark-gray margin-bottom-20">บัตรคอนเสิร์ต ตั๋ว วอชเชอร์ และอื่นๆที่ไม่ได้ใช้แล้วสามารถนำมาขายได้ที่นี่</p>
      <a class="btn btn-lg btn-primary" href="/ticket/new">
        ขายบัตรของคุณตอนนี้
      </a>
    </div>
  </div>
</div>

<div class="parallax-bg">
  <div class="container margin-top-60 margin-bottom-60">
    <div class="content-section tr">
      <h1 class="dark-gray mb-3">เลือกซื้อและค้นหาบัตร</h1>
      <p class="dark-gray margin-bottom-20">เลือกซื้อบัตรตามที่คุณต้องการ นอกจากนี้มีการแบ่งหมวดหมู่ออกเป็น 15 หมวดหมู่เพื่อง่ายต่อการเข้าถึงและค้นหา</p>
      <a class="btn btn-lg btn-primary" href="/ticket/new">
        แสดงรายการขายบัตร
      </a>
    </div>
  </div>
</div>

<div class="container information-grid margin-top-60 margin-bottom-60">
  <div class="row">
    <div class="col-md-4 tc">
      <i class="fa fa-ticket db fs-100 mb-3" aria-hidden="true"></i>
      <h5>ลงขายบัตรของคุณเพียงไม่กี่ขั้นตอน</h5>
      <p>ลงขายบัตรบนเว็บไซต์ของเราโดยคุณเป็นผู้ตั้งราคา และข้อมูลอื่นๆที่คุณต้องการ</p>
    </div>
    <div class="col-md-4 tc">
      <i class="fa fa-users db fs-100 mb-3" aria-hidden="true"></i>
      <h5>เลือกซื้อบัตรแลสอบถามผู้ขายก่อนการซื้อ</h5>
      <p>เรามีระบบที่ให้คุยได้พูดคุยกับผู้ขายได้ทันที เพื่อให้เกิความแน่ใจในการซื้อ</p>
    </div>
    <div class="col-md-4 tc">
      <i class="fa fa-comments db fs-100 mb-3" aria-hidden="true"></i>
      <h5>ผู้ซื้อทั่วประเทศ</h5>
      <p>มีผู้ซื้อทั่วประเทศกำลังค้นหาและต้องการบัตรจากคุณอยู่</p>
    </div>
  </div>
</div>

<footer></footer>

@stop