@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ccc;
  }

  #price_range .slider-selection {
    /*height: 4px;*/
    background: #EF9A9A;
  }

  #price_range .slider-handle {
    background-color: red !important;
    background-image: none;
  }

  #price_range.slider-horizontal {
    width: 90%;
  }

  #price_range.slider-horizontal .slider-track {
    background-color: #000 !important;
  }

  #price_range_slider {
    opacity: 0;
    position: absolute;
    z-index: -1;
  }
</style>

<div class="container margin-top-30">

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
        <button type="button" class="btn btn-success btn-block br0">ค้นหา</button>
      </div>

    </div>
  </div>

  <div class="data-list">

    @foreach($list as $value)
      
        <div class="data-list-item">

          <!-- <div class="alert alert-danger m-0 text-center" role="alert">
            <strong>ขายแล้ว</strong>
          </div> -->

          <div class="clearfix">

            <div class="w-100">
              @if(!empty($value['image']))
                <div class="data-image">
                  <img src="{{$value['image']['_url']}}">

                  @if($value['imageTotal'] > 1)
                  <div class="image-more">
                    {{$value['imageTotal']-1}}+<img src="/assets/images/common/photos.png">
                  </div>
                  @endif
                </div>
              @endif
            </div>

          </div>

          <div class="main-data-section w-100 clearfix">

            <h5 class="mx-2 my-3">{{$value['title']}}</h5>

            <div class="w-100 w-70-ns fn fl-ns">

              <div class="additional-data-section mb-4">

                @if($value['date_type'] == 1)
                  
                  @if(!empty($value['date_1']))
                  <div class="additional-item">
                    <small><i class="fa fa-calendar"></i> ใช้ได้ตั้งแต่ {{$value['date_1']}} ถึง {{$value['date_2']}}</small>
                  </div>
                  @else
                  <div class="additional-item">
                    <small><i class="fa fa-calendar"></i> ใช้ได้ถึงวันที่ {{$value['date_2']}}</small>
                  </div>
                  @endif
                  
                @elseif($value['date_type'] == 2)</small>
                  <div class="additional-item">
                    <small><i class="fa fa-calendar"></i> วันที่แสดง {{$value['date_2']}}
                  </div>
                @elseif($value['date_type'] == 3)</small>
                  <div class="additional-item">
                    <small><i class="fa fa-calendar"></i> วันที่เดินทาง {{$value['date_2']}}
                  </div>
                @endif

                @if(!empty($value['place_location']))
                  <div class="additional-item">
                    <small><i class="fa fa-map-marker"></i> {{$value['place_location']}}</small>
                  </div>
                @endif

              </div>

              @if(!empty($value['tags']))
              <div class="tags mx-2 mb-4">
                @foreach($value['tags'] as $tag)
                  <div class="md-chip">
                    <div class="md-chip-icon">
                      <i class="fa fa-tag"></i>
                    </div>
                    {{$tag['word']}}
                  </div>
                @endforeach
              </div>
              @endif
            </div>

            <div class="w-100 w-30-ns fn fl-ns">

              @if(!empty($value['save']))
                <div class="price-saving-flag">-{{$value['save']}}</div>
              @endif

              <div class="price-section py-2 text-center">
                @if(!empty($value['original_price']))
                <div class="original-price">{{$value['original_price']}}</div>
                @endif
                <div class="price">{{$value['price']}}</div>
              </div>
            </div>

          </div>

          <ul class="nav nav-tabs">
            <li><a href="#">เพิ่มเติม</a></li>
            <li><a href="#">รายละเอียด</a></li>
            <li><a href="#">ติดต่อ</a></li>
          </ul>          

        </div>

    @endforeach

  </div>

</div>

<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>

<script type="text/javascript">
  $(document).ready(function(){
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

    const date1 = new Datepicker('#date_input_1');
    date1.init();

    const date2 = new Datepicker('#date_input_2');
    date2.init();

  });
</script>

@stop