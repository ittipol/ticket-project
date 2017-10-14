@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ccc;
  }

  .grid-item { width: 32.5%; margin: 0.4%; }

  @media (max-width: 1024px) {
    .grid-item { width: 49%; margin: 0.5%; }
  }

  @media (max-width: 480px) {
    .grid-item { width: 92%; margin: 4%; }
  }
</style>

<div class="container-fliud margin-top-10 margin-bottom-200">

  <div class="left-sidenav">
    <div class="p-3">

      <div class="mb-3">
        <h4 class="my-2">ค้นหา</h4>
        <input type="text" class="w-100 p-2" placeholder="ชื่อบัตร, สถานที่, คำค้นอื่นๆ">
      </div>

      <div class="mb-3">
        <h4 class="my-2">ราคา</h4>
        <div class="mb-2 clearfix">
          <small class="fl"><strong id="price_range_min">1</strong>&nbsp;บาท</small>
          <small class="fr"><strong id="price_range_max">50000</strong>&nbsp;บาท</small>
        </div>
        <div class="price-range text-center">
          <input id="price_range_slider" data-slider-id='price_range' type="text" data-slider-min="1" data-slider-max="50000" data-slider-step="5" data-slider-value="[1,50000]"/>
        </div>
      </div>

      <div class="mb-3">
        <h4 class="my-2">วันที่</h4>
        <div class="input-group">
          <span class="input-group-addon" id="location-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {{Form::text('date_1', null, array(
          'id' => 'date_input_1', 
          'class' => 'form-control w-100 p-2', 
          'placeholder' => 'เริ่มต้น',
          'autocomplete' => 'off', 
          'readonly' => 'true'))}}
        </div>

        <div class="input-group">
          <span class="input-group-addon" id="location-addon">
            <i class="fa fa-calendar"></i>
          </span>
          {{Form::text('date_2', null, array('id' => 'date_input_2', 'class' => 'form-control w-100 p-2', 'placeholder' => 'ถึง', 'autocomplete' => 'off', 'readonly' => 'true'))}}
        </div>
      </div>      

      <div class="text-center mt-2">
        <button type="button" class="btn btn-primary btn-block br0">ค้นหา</button>
      </div>

    </div>
  </div>

  <div class="grid data-list main-panel">
    @foreach($list as $value)
    <div class="grid-item">
      <div class="data-list-item">

        <div>
          @if(!empty($value['image']))
            <div class="data-image">
              <img src="{{$value['image']['_preview_url']}}">

              @if($value['imageTotal'] > 1)
              <div class="image-more">
                {{$value['imageTotal']-1}}+<img src="/assets/images/common/photos.png">
              </div>
              @endif
            </div>
          @endif
        </div>

        <h5 class="mx-2 mt-3 mb-0">
          <a href="/ticket/view/{{$value['id']}}">
            {{$value['title']}}
          </a>
        </h5>

        <div class="main-data-section clearfix">

          <div class="w-100 w-50-ns fn fl-ns">

            @if(!empty($value['save']))
              <div class="price-saving-flag dib mt-3">-{{$value['save']}}</div>
            @endif

            <div class="price-section px-2 pt-0 pb-2">
              <span class="price">{{$value['price']}}</span>
              @if(!empty($value['original_price']))
              <span class="original-price">{{$value['original_price']}}</span>
              @endif
            </div>

          </div>

          <div class="w-100 w-50-ns fn fl-ns">

            <div class="additional-data-section mt-2 mb-4">

              @if($value['date_type'] == 1)
                
                @if(!empty($value['date_1']))
                <div class="additional-item">
                  <i class="fa fa-calendar"></i>&nbsp;ใช้ได้ตั้งแต่ {{$value['date_1']}} ถึง {{$value['date_2']}}
                </div>
                @else
                <div class="additional-item">
                  <i class="fa fa-calendar"></i>&nbsp;ใช้ได้ถึงวันที่ {{$value['date_2']}}
                </div>
                @endif
                
              @elseif($value['date_type'] == 2)
                <div class="additional-item">
                  <i class="fa fa-calendar"></i>&nbsp;วันที่แสดง {{$value['date_2']}}
                </div>
              @elseif($value['date_type'] == 3)
                <div class="additional-item">
                  <i class="fa fa-calendar"></i>&nbsp;วันที่เดินทาง {{$value['date_2']}}
                </div>
              @endif

              @if(!empty($value['place_location']))
                <div class="additional-item">
                  <i class="fa fa-map-marker"></i>&nbsp;สถานที่ {{$value['place_location']}}
                </div>
              @endif

            </div>

          </div>

        </div>
        
        <div class="w-100">
          <div class="seller-section text-center">
            <a href="/chat/{{$value['id']}}" class="btn seller-chat-btn">
              <div class="online_status_indicator_{{$value['created_by']}} online-status-indicator @if($value['user']['online']) is-online @endif"></div>
              <i class="fa fa-comments" aria-hidden="true"></i> คุยกับผู้ขาย
            </a>
          </div>
        </div>

      </div>
    </div>
    @endforeach
  </div>

</div>

<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>


<script type="text/javascript">

  class Ticket {

    constructor() {}

    init() {

      $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true
      });

      this.bind();
      this.layout();
    }

    bind() {

      $("#price_range_slider").slider();

      $("#price_range").on('click', function() {

        let val = $("#price_range_slider").val();
        val = val.split(',');

        $("#price_range_min").text(val[0]);
        $("#price_range_max").text(val[1]);
      });

      $("#price_range_slider").on("slide", function(e) {
        $("#price_range_min").text(e.value[0]);
        $("#price_range_max").text(e.value[1]);
      });

      $(window).resize(function(){
        _this.layout();
      });

    }

    layout() {

      let wH = window.innerHeight;
      // let wW = window.innerWidth;
      let navbarH = 60;

      $('.left-sidenav').css({
        'height': (wH-navbarH)+'px',
        // 'top': navbarH+'px'
      });

    }

  }

  $(document).ready(function(){

    const _ticket = new Ticket();
    _ticket.init();

    const date1 = new Datepicker('#date_input_1');
    date1.init();

    const date2 = new Datepicker('#date_input_2');
    date2.init();

    const _userOnline = new UserOnline();
    _userOnline.init();

  });
</script>

@stop