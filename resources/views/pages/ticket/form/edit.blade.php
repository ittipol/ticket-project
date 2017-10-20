@extends('shared.main')
@section('content')

<div class="container">

  <div class="margin-top-40 margin-bottom-20">
    <h4>แก้ไขรายการ</h4>
  </div>

  {{Form::model($data, ['id' => 'add_ticket_form', 'method' => 'PATCH', 'enctype' => 'multipart/form-data'])}}

    @include('component.form_error')

    <div class="row">

      <div class="col-md-8">

        <div class="form-group">
          <label class="form-control-label required">ประเภทบัตร</label>
          <div class="row">
            @foreach($categories as $key => $category)
            <div class="col-6 col-md-4">
              <div class="c-input">
                {{Form::radio('TicketToCategory[ticket_category_id]', $category->id, false, array('id' => 'cat'.$key))}}
                <label for="cat{{$key}}">
                  {{$category->name}}
                </label>
              </div>
            </div>
            @endforeach
          </div>
        </div>

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
          <label class="form-control-label">วันที่การใช้งาน</label>
          {{ Form::select('date_type', $dateType, null, array('id' => 'date_type_select', 'class' => 'form-control')) }}
        </div>

        <div class="row">
          <div id="date_1" class="form-group col-md-6">
            <label class="form-control-label">วันที่เริ่มใช้</label>
            <div class="input-group">
              <span class="input-group-addon" id="location-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {{Form::text('date_1', null, array('id' => 'date_input_1', 'class' => 'form-control' ,'autocomplete' => 'off', 'readonly' => 'true'))}}
            </div>
          </div>

          <div id="date_2" class="form-group col-md-6">
            <label class="form-control-label required">ใช้ได้ถึง</label>
            <div class="input-group">
              <span class="input-group-addon" id="location-addon">
                <i class="fa fa-calendar"></i>
              </span>
              {{Form::text('date_2', null, array('id' => 'date_input_2', 'class' => 'form-control' ,'autocomplete' => 'off', 'readonly' => 'true'))}}
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label">สถานที่หรือตำแหน่งที่สามารถนำไปใช้ได้</label>
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

        <div class="form-group">
          <label class="form-control-label">แท็ก (ไม่ต้องใส่ # หน้าคำที่ป้อน)</label>
          <div id="_tags" class="tag"></div>
          <small>* แท็กจะมีผลโดยตรงต่อการค้นหา</small>
        </div>

        <div class="form-group">
          <label class="form-control-label required">ช่องทางการติดต่อผู้ขาย (หมายเลขโทรศัพท์ อีเมล Line ID หรืออื่นๆ)</label>
          {{Form::textarea('contact', null, array('class' => 'form-control'))}}
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

          <div id="_image_group" class="upload-image"></div>

        </div>
        
      </div>

      <div class="col-md-8 margin-top-30">
        {{Form::submit('เริ่มต้นการขาย', array('class' => 'btn btn-primary btn-block'))}}
      </div>
      
    </div>

  {{Form::close()}}

</div>

<div class="clearfix margin-top-200"></div>

<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>

<script type="text/javascript" src="/assets/js/form/upload_image.js"></script>
<script type="text/javascript" src="/assets/js/form/tagging.js"></script>
<script type="text/javascript" src="/assets/js/form/ticket-validation.js"></script>
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

      $('#date_type_select').on('change',function(){
        

        let type = $(this).val();

        $('#date_input_1').val('');
        $('#date_input_2').val('');

        switch(type) {

          case '1':
              $('#date_1').css('display','block');
              $('#date_2').removeClass('col-12').addClass('col-md-6');
              $('#date_2 > label').removeClass('col-12').text('ใช้ได้ถึง');
              break;
          case '2':
                $('#date_1').css('display','none');
                $('#date_2').addClass('col-12').removeClass('col-md-6');
                $('#date_2 > label').text('วันที่แสดง');
              break;
          case '3':
              $('#date_1').css('display','none');
              $('#date_2').addClass('col-12').removeClass('col-md-6');
              $('#date_2 > label').text('วันที่เดินทาง');
              break;

        }

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
    images.setImages({!!$images!!});

    const ticket = new Ticket();
    ticket.init();

    const tagging = new Tagging();
    tagging.init();
    tagging.setTags({!!$taggings!!});

    const date1 = new Datepicker('#date_input_1');
    date1.init();

    const date2 = new Datepicker('#date_input_2');
    date2.init();

    Validation.initValidation();

  });
</script>

@stop