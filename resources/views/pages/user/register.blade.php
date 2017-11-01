@extends('shared.main')
@section('content')

<div class="container margin-top-30 margin-bottom-30">
  <h5 class="text-center">สร้างบัญชีส่วนตัวฟรีเพื่อใช้ TicketEasys อย่างเต็มรูปแบบ!</h5>
  <p class="text-center">ด้วยบัญชีส่วนตัวคุณสามารถประกาศขายและแชร์รายการที่คุณสนใจกับเพื่อนแลครอบครัวได้ทันที</p> 
</div>

{{Form::open(['id' => 'register_form', 'class' => 'user-form', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}

<div class="register-page">

  @include('component.form_error')

  <h5 class="text-center">สร้างบัญชีส่วนตัว</h5>

  <div class="margin-top-30">

    <div class="form-group">
      {{ Form::text('name', null, array(
        'class' => 'form-control rounded-right',
        'placeholder' => 'ชื่อ นามสกุล',
        'autocomplete' => 'off'
      )) }}
    </div>

    <div class="form-group">
      <input type="text" name="email" class="form-control rounded-right" placeholder="อีเมล" autocomplete="off">
    </div>

    <div class="form-group">
      <input type="password" name="password" id="password_field" class="form-control rounded-right" placeholder="รหัสผ่าน (อย่างน้อย 4 อักขระ)">
    </div>

    <div class="form-group">      
      <input type="password" name="password_confirmation" class="form-control rounded-right" placeholder="ป้อนรหัสผ่านอีกครั้ง">
    </div>

    {{Form::submit('สร้างบัญชี', array('class' => 'btn btn-primary btn-block'))}}

  </div>

  <hr class="margin-top-40 margin-bottom-30">

  <h5 class="text-center">สร้างบัญชีด้วย Social Network</h5>     

  <div class="social-login margin-top-20">     
    <a href="javascript:void(0);" id="fb_login_btn" class="btn rounded btn-block btn-facebook margin-bottom-10">           
      <i class="fa fa-facebook"></i> สร้างบัญชีด้วย Facebook         
    </a>  
  </div>

  <div class="text-center margin-top-60">
    มีบัญชีอยู่แล้ว? <a href="{{URL::to('login')}}">เข้าสู่ระบบ</a>
  </div>

</div>

{{Form::close()}}

<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/form/register-validation.js"></script>

<script type="text/javascript">

  $(document).ready(function(){
    Validation.initValidation();

    $('#fb_login_btn').on('click',function(e){
      FB.login(function(response) {
        if (response.authResponse) {
          window.location.href = "/facebook/login?code="+response.authResponse.accessToken;
        }
      }, {scope: 'email,public_profile'});
    });
  });

</script>

@stop