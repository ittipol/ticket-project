@extends('shared.main')
@section('content')

{{Form::open(['id' => 'login_form', 'class' => 'user-form', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}

<div class="login-page margin-top-60">

  @include('component.form_error')
  
  <h5 class="text-center">ล็อคอินด้วยอีเมล์</h5>   

  <div class="margin-top-30">
    <div class="form-group">
      <input type="text" name="email" class="form-control" placeholder="อีเมล">
    </div>

    <div class="form-group">
      <input type="password" name="password" class="form-control" placeholder="รหัสผ่าน">
    </div>

    <label class="margin-bottom-5">
      <div>
        <label class="control control--checkbox mb-2">
          จดจำการเข้าสู่ระบบ
          <input type="checkbox" name="remember_me" >
          <div class="control__indicator"></div>
        </label>
      </div>
    </label>

    {{Form::submit('เข้าสู่ระบบ', array('class' => 'btn btn-primary btn-block'))}}
  </div>

  <hr class="margin-top-40 margin-bottom-30">

  <h5 class="text-center">ล็อคอินด้วย Social Network</h5>     

  <div class="social-login margin-top-20">     
    <a href="javascript:void(0);" id="fb_login_btn" class="btn rounded btn-block btn-facebook margin-bottom-10">           
      <i class="fa fa-facebook"></i> เข้าสู่ระบบด้วย Facebook         
    </a>  
  </div>

  <div class="text-center margin-top-60">
    ไม่ได้มีบัญชี? <a href="{{URL::to('subscribe')}}">สร้างบัญชี</a>
  </div>

</div>

{{Form::close()}}

<div class="clearfix margin-top-200"></div>

<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/form/login-validation.js"></script>

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