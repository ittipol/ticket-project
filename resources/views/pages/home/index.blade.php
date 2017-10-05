@extends('shared.main')
@section('content')

<div class="infomation-wrapper">

  <div class="container">
    <div class="content-section text-center margin-bottom-80">
      <h1>ขายบัตรของคุณกับ TicketSnap!</h1>
      <h3 class="margin-bottom-20">ในที่สุดคุณก็สามารถขายตั๋วที่ไม่ได้ใช้ได้แล้ว</h3>
      <p class="margin-bottom-5">มีผู้คนอีกมากมายที่คุณไม่คาดคิดกำลังต้องบัตรงานแสดงจากคุณ</p>
      <p class="margin-bottom-5">TicketSnap เป็นเว็บไซต์ที่ให้คุณซื้อและขายบัตรงานแสดงต่าง ๆ ได้ด้วยตัวคุณเอง</p>
    </div>

    <div class="content-section text-center margin-bottom-80">

      <h3 class="margin-bottom-20">ค้นหาและขายบัตรของคุณตอนนี้</h3>
      
      <form>
        <div class="input-group w-60-l w-100-ns mx-auto">
          <input type="text" class="form-control" placeholder="ค้นหาบัตร">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div>
      </form>

      <!-- <div class="container">
        <div class="row">
          <div class="col-md-6 mb-3 mb-sm-0">
            <form>
              <div class="input-group">
                <input type="text" class="form-control" placeholder="ค้นหาบัตร">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="button">
                    <i class="fa fa-search"></i>
                  </button>
                </span>
              </div>
            </form>
          </div>
          <div class="col-md-6">
            <a class="btn btn-primary w-100" href="/ticket/new">
              <i class="fa fa-tag"></i>&nbsp;ขายบัตร
            </a>
          </div>
        </div>
      </div> -->

    </div>
  </div>

</div>

<div class="parallax-bg">
  <div class="container margin-top-60 margin-bottom-60">
    <div class="content-section text-center">
      <h1>เริ่มต้นขายบัตรของคุณกับเรา</h1>
      <p class="margin-bottom-20">มีผู้คนอีกมากมายที่คุณไม่คาดคิดกำลังต้องบัตรงานแสดงจากคุณ</p>
      <a class="btn btn-lg btn-primary" href="/ticket/new">
        <i class="fa fa-tag"></i>&nbsp;ขายบัตรของคุณตอนนี้
      </a>
    </div>
  </div>
</div>

@stop