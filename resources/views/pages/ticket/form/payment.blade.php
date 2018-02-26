@extends('shared.main')
@section('content')

<div class="ticket-add-image-cover tc">
  <div class="jumbotron jumbotron-fluid mb0">
    <div class="container">
      <h1>ชำระเงิน</h1>
    </div>
  </div>
</div>

<div class="payment-form-container">

  {{Form::open(['id' => 'payment_form', 'method' => 'post', 'enctype' => 'multipart/form-data'])}}

    <div class="mt4">
      @include('component.form_error')
    </div>

    <div class="margin-top-40 margin-bottom-20">
      <h4>สั่งซื้อ</h4>
    </div>

    <div>
      <h5>{{$data['title']}}</h5> 
    </div>

    <div class="price-section py-2">
      <small>ราคา</small>
      <span class="price">{{$data['price']}}</span>
      @if(!empty($data['original_price']))
      <span class="original-price">{{$data['original_price']}}</span>
      @endif
    </div>

    <div class="alert alert-info">
      เราจะไม่เก็บข้อมูลบัตรเครดิตหรืออะไรทั้งสิ้น โดยไม่ได้รับอนุญาตจากคุณ <br>
      ข้อมูลทั้งหมดที่คุณกรอกมาจะถูกส่งผ่านการเชื่อมต่อที่ปลอดภัย แบบ SSL คุณจึงมั่นใจได้ในความปลอดภัยของข้อมูล 
    </div>

    <div class="form-group">
      <label class="form-control-label required">ชื่อผู้ถือบัตร</label>
      {{ Form::text('holder_name', null, array(
        'id' => 'holder_name',
        'class' => 'form-control',
        'autocomplete' => 'off'
      )) }}
    </div>

    <div class="form-group">
      <label class="form-control-label required">หมายเลขบัตร</label>
      <div class="input-group">
        <div class="input-group-addon">
          <img id="credit_card_image" src="/assets/images/credit_card/card.png" class="displayed">
        </div>
        {{ Form::text('card_number', null, array(
          'id' => 'card_number',
          'class' => 'form-control',
          'autocomplete' => 'off',
          'placeholder' => '---- ---- ---- ----'
        )) }}
      </div>
    </div>

    <div class="form-group">
      <label class="form-control-label required">CVC <a href="javascript:void(0);" data-toggle="modal" data-target="#cvc_modal">คืออะไร</a></label>
      {{ Form::text('cvc', null, array(
        'id' => 'cvc',
        'class' => 'form-control',
        'autocomplete' => 'off',
        'placeholder' => 'CVC'
      )) }}
    </div>

    <div class="form-group">
      <label class="form-control-label required">วันหมดอายุ</label>
      {{ Form::text('card_expire', null, array(
        'id' => 'card_expire',
        'class' => 'form-control',
        'autocomplete' => 'off',
        'placeholder' => 'MM / YY'
      )) }}
    </div>

    <input type="hidden" name="omise_token">

    {{Form::submit('สั่งซื้อ', array('class' => 'btn btn-primary btn-block'))}}

  {{Form::close()}}

</div>

<div class="modal fade" id="cvc_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 id="myModalLabel1" class="modal-title">CVC คืออะไร</h4>
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
      </div>
      <div class="modal-body">
        รหัสยืนยันบัตรหรือ CVC เป็นรหัสพิเศษที่พิมพ์อยู่บนบัตรเดบิตหรือบัตรเครดิตของคุณ <br><br>
        สำหรับบัตรอเมริกันเอ็กซ์เพรส CVC จะปรากฏเป็นรหัส 4 หลักที่แยกต่างหากพิมพ์อยู่บนด้านหน้าของบัตรของคุณ ส่วนบัตรอื่น ๆ ทั้งหมด (Visa, Master Card, บัตรของธนาคารอื่น ๆ ) จะเป็นตัวเลขสามหลักที่พิมพ์อยู่ถัดจากแถบลายเซ็นด้านหลังของบัตรของคุณ โปรดสังเกตว่ารหัส CVC จะไม่นูน (ต่างจากหมายเลขบัตร หลักด้านหน้า) <br><br>
        CVC จะไม่ได้ถูกพิมพ์บนใบเสร็จรับเงินใด ๆ ด้วยเหตุนี้มันจึงไม่เป็นที่ทราบหรือพบเห็นโดยบุคคลอื่นที่ไม่ใช่เจ้าของบัตรที่แท้จริง <br><br>
        กรอกรหัส CVC เพื่อยืนยันว่าคุณคือผู้ถือบัตรสำหรับการทำรายการในครั้งนี้และเพื่อหลีกเลี่ยงบุคคลอื่นที่ไม่ใช่คุณไม่ให้สามารถทำการซื้อสินค้าโดยใช้หมายเลขบัตรของคุณได้ <br><br>
        *** โปรดสังเกตว่าชื่อของรหัสนี้อาจเรียกแตกต่างกันไปตามบริษัทผู้ออกบัตร เช่น Card Verification Value (CVV), the Card Security Code หรือ the Personal Security Code ซึ่งทั้งหมดนี้เป็นข้อมูลแบบเดียวกัน
      </div>
      <div class="modal-footer">
        <button data-dismiss="modal" class="btn" type="button">ปิด</button>
      </div>
    </div>
  </div>
</div>

<div class="clearfix margin-top-200"></div>

<script src="/assets/js/jquery.payform.min.js"></script>
<script type="text/javascript" src="/assets/js/form/credit-card-validation.js"></script>

<script type="text/javascript" src="/assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/js/form/payment-form-validation.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
    Validation.initValidation();
  });
</script>

@stop