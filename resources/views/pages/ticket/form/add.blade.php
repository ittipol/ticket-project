@extends('shared.main')
@section('content')

<div class="image-cover" style="background-image: url(/assets/images/content_add2.jpg);">
  <div class="image-cover-content">
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1>บัตรคอนเสิร์ต ตั๋ว วอชเชอร์ และอื่นๆที่ไม่ได้ใช้แล้วสามารถนำมาขายได้ที่นี่</h1>
      </div>
    </div>
  </div>
</div>

<div class="container">

  <div class="margin-top-40 margin-bottom-20">
    <h4>เพิ่มรายการขาย</h4>
    <p>กรอกข้อมูลรายการของคุณให้ได้มากที่สุดเพื่อให้สินค้าของคุณมีรายละเอียดมากพอในการขาย</p>
  </div>
  {{Form::open(['id' => 'add_ticket_form', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}

    @include('component.form_error')

    <div class="row">

      <div class="col-md-8">

        <div class="form-group">
          <label class="form-control-label required">หัวข้อ</label>
          {{ Form::text('title', null, array(
            'class' => 'form-control',
            'autocomplete' => 'off'
          )) }}
        </div>

        <div class="form-group">
          <label class="form-control-label required">รายละเอียด</label>
          {{Form::textarea('description', null, array('class' => 'form-control'))}}
        </div>

        <div class="form-group">
          <label class="form-control-label required">สถานที่หรือตำแหน่งที่สามารถนำไปใช้ได้</label>
          <div class="input-group">
            <span class="input-group-addon" id="location-addon">
              <i class="fa fa-map-marker"></i>
            </span> 
            {{ Form::text('place_location', null, array(
              'class' => 'form-control',
              'autocomplete' => 'off',
              'aria-describedby' => 'location-addon'
            )) }}
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label class="form-control-label required">วันที่เริ่มใช้</label>
            <div class="input-group">
              <span class="input-group-addon" id="location-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {{Form::text('start_date', null, array('id' => 'start_date', 'class' => 'form-control' ,'autocomplete' => 'off', 'readonly' => 'true'))}}
            </div>
          </div>

          <div class="form-group col-md-6">
            <label class="form-control-label required">ใช้ได้ถึงวันที่</label>
            <div class="input-group">
              <span class="input-group-addon" id="location-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {{Form::text('expiration_date', null, array('id' => 'expiration_date', 'class' => 'form-control' ,'autocomplete' => 'off', 'readonly' => 'true'))}}
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label required">ราคาที่ต้องการขาย</label>
          <div class="input-group">
            {{ Form::text('price', null, array(
              'id' => 'price_input',
              'class' => 'form-control',
              'autocomplete' => 'off',
              'aria-describedby' => 'price-addon'
            )) }}
            <span class="input-group-addon" id="price-addon">บาท</span>
          </div>
        </div>

        <div class="row">
          <div class="form-group col-md-6">
            <label class="form-control-label">ราคาเดิมของบัตร</label>
            <div class="input-group">
              {{ Form::text('original_price', null, array(
                'id' => 'original_price_input',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'aria-describedby' => 'full-price-addon'
              )) }}
              <span class="input-group-addon" id="full-price-addon">บาท</span>
            </div>
          </div>

          <div class="form-group col-md-6">
            <label class="form-control-label">ส่วนลด</label>
            <div class="input-group">
              {{ Form::text('percent', 0, array(
                'id' => 'percent_input',
                'class' => 'form-control',
                'autocomplete' => 'off',
                'aria-describedby' => 'percent-addon',
                'disabled' => true
              )) }}
              <span class="input-group-addon" id="percent-addon">%</span>
            </div>
            <small>* จะคำนวณหลังจากกรอกราคาเดิมของบัตร</small>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label">แท็ก (ไม่ต้องใส่ # หน้าคำที่ป้อน)</label>
          <div id="_tags" class="tag"></div>
          <small>* แท็กจะมีผลโดยตรงต่อการค้นหา</small>
        </div>

      </div>

      <div class="col-md-4">

        <div class="form-group">
          <label class="form-control-label">รูปภาพ</label>
          <div class="alert alert-info">
            <ul class="m-0">
              <li>ไฟล์ใหญ่ได้ไม่เกิน 5 MB</li> 
              <li>รูปแบบไฟล์ JPG, PNG เท่านั้น</li> 
            </ul>
          </div>

          <div id="_image_group"></div>

        </div>
        
      </div>

      <div class="col-md-8 margin-top-30">
        {{Form::submit('เริ่มต้นการขาย', array('class' => 'btn btn-primary btn-block'))}}
      </div>
      
    </div>

  {{Form::close()}}

</div>

<div class="clearfix margin-top-100"></div>
<div class="clearfix margin-top-100"></div>

<script type="text/javascript" src="/assets/js/form/tagging.js"></script>
<script type="text/javascript" src="/assets/js/form/add-ticket-validation.js"></script>
<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>

<script type="text/javascript">

  class Ticket {

    constructor() {
      this.handle;
    }

    init() {
      this.bind();
    }

    bind() {

      let _this = this;

      $('#price_input').on('keyup',function(){
        _this.calDiscount();
      })

      $('#original_price_input').on('keyup',function(){
        _this.calDiscount();
      })

    }

    calDiscount() {

      clearTimeout(this.handle);

      if(
          (typeof $('#price_input').val() == 'undefined') || ($('#price_input').val() < 1) 
          ||
          (typeof $('#original_price_input').val() == 'undefined') || ($('#original_price_input').val() < 1)
        ) {
        return false;
      }

      if($('#price_input').val() - $('#original_price_input').val() > 0) {
        $('#percent_input').val(0);
        return false;
      }

      this.handle = setTimeout(function(){
        let percent = 100 - (($('#price_input').val() * 100) / $('#original_price_input').val());
        $('#percent_input').val(Math.round(percent,2));
      },300);

    }

  }

  $(document).ready(function(){

    const images = new UploadImage('#add_ticket_form','#_image_group','Ticket','photo',10);
    images.init();
    images.setImages();

    const ticket = new Ticket();
    ticket.init();

    const tagging = new Tagging();
    tagging.load();

    const startDate = new Datepicker('#start_date');
    startDate.init();

    const expirationDate = new Datepicker('#expiration_date');
    expirationDate.init();

    Validation.initValidation();

  });
</script>

@stop