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
  {{Form::open(['method' => 'post', 'enctype' => 'multipart/form-data'])}}

    @include('component.form_error')

    <div class="row">

      <div class="col-md-8">

        <div class="form-group">
          <label class="form-control-label">หัวข้อ</label>
          <input type="text" class="form-control form-control-success" id="inputSuccess1">  
        </div>

        <div class="form-group">
          <label class="form-control-label">รายละเอีบด</label>
          <textarea class="form-control"></textarea>
        </div>

        <div class="form-group">
          <label class="form-control-label">สถานที่หนือตำแหน่งที่สามารถนำไปใช้ได้</label>
          <div class="input-group">
            <span class="input-group-addon" id="location-addon">
              <i class="fa fa-map-marker"></i>
            </span>
            <input type="text" class="form-control" placeholder="Username" aria-describedby="location-addon">
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label">วันสิ้นสุดการใช้งาน</label>
          <div class="input-group">
            <span class="input-group-addon" id="location-addon">
              <i class="fa fa-calendar"></i>
            </span>
            {{Form::text('date', null, array('id' => 'date', 'class' => 'form-control' ,'autocomplete' => 'off', 'readonly' => 'true'))}}
            <div class="floating-label-box" id="date-input-label"></div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label">ราคาของบัตร</label>
          <div class="input-group">
            <input type="text" class="form-control" aria-describedby="price-addon">
            <span class="input-group-addon" id="price-addon">บาท</span>
          </div>
        </div>

        <div class="form-group">
          <label class="form-control-label">ระบุส่วนลด (หากมี)</label>
          code here
        </div>

      </div>

      <div class="col-md-4">

        <div class="form-group">
          <label class="form-control-label">รูปภาพ</label>
          <div class="alert alert-info">
            <ul>
              <li>ไฟล์ใหญ่ได้ไม่เกิน 5 MB</li> 
              <li>รูปแบบไฟล์ JPG, PNG เท่านั้น</li> 
            </ul>
          </div>
          <div id="uploader">
            <div class="dz-message needsclick">
              คลิกที่นี่เพื่ออัพโหลด<br/>หรือ<br/>ลากรูปที่ต้องการและวางตรงนี้
            </div>
          </div>
        </div>

        <div class="dropzone" id="dropzone-previews"></div>

      </div>

    </div>

  {{Form::close()}}
</div>


<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    var myDropzone = new Dropzone('#uploader', { 
      url: "/upload/image",
      paramName: "image",
      maxFilesize: 5, // MB
      maxFiles: 10,
      uploadMultiple: true,
      parallelUploads: 3,
      previewsContainer: "#dropzone-previews",
      acceptedFiles: "image/jpeg,image/png",
      headers: {
        'x-csrf-token': $('[name="_token"]').val(),
      },   
    });

    Datepicker.initDatepicker();
    
  });
</script>

@stop