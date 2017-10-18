@extends('shared.main')
@section('content')

<div class="container">

  <div class="margin-top-40 margin-bottom-20">
    <h4>แก้ไขโปรไฟล์</h4>
  </div>

  {{Form::model($data, ['id' => 'profile_edit_form', 'method' => 'PATCH', 'enctype' => 'multipart/form-data'])}}

    @include('component.form_error')

    <div class="row">

      <div class="col-md-8">

        <div class="form-group">
          <label class="form-control-label">รูปภาพโปรไฟล์</label>
          <div class="alert alert-info">
            <ul class="m-0">
              <li>ไฟล์ใหญ่ได้ไม่เกิน 5 MB</li> 
              <li>รูปแบบไฟล์ JPG, PNG เท่านั้น</li> 
            </ul>
          </div>

          <div id="_profile_image"></div>

        </div>

        <div class="form-group">
          <label class="form-control-label required">ชื่อ นามสกุล</label>
          {{ Form::text('name', null, array(
            'class' => 'form-control',
            'autocomplete' => 'off'
          )) }}
        </div>

      </div>

      <div class="col-md-8 margin-top-30">
        {{Form::submit('บันทึก', array('class' => 'btn btn-primary btn-block'))}}
      </div>

    </div>

  {{Form::close()}}

</div>

<script type="text/javascript">
  
  $(document).ready(function(){
    const images = new UploadImage('#profile_edit_form','#_profile_image','User','avatar',1);
    images.init();
    images.setImages({!!$profileImage!!});
  });

</script>

@stop