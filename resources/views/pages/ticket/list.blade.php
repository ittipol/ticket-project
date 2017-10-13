@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ccc;
  }

  .grid-item { width: 32.666666666666666666666666666667%; margin: 0.3333333333333333333333333333333%; }

  @media (max-width: 1024px) {
    .grid-item { width: 49%; margin: 0.5%; }
  }

  @media (max-width: 480px) {
    .grid-item { width: 92%; margin: 4% 4%; }
  }
</style>

<div class="container-fliud margin-top-20">

  <!-- <div class="left-sidenav">
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
  </div> -->

  <div class="grid data-list">
    @foreach($list as $value)
    <div class="grid-item">
      <div class="data-list-item">

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

        <div class="main-data-section w-100 clearfix">

          <h5 class="mx-2 my-3">
            <a href="/ticket/view/{{$value['id']}}">
              {{$value['title']}}
            </a>
          </h5>

          <div class="w-100 w-50-ns fn fl-ns">

            @if(!empty($value['save']))
              <div class="price-saving-flag dib">-{{$value['save']}}</div>
            @endif

            <div class="price-section p-2">
              <span class="price">{{$value['price']}}</span>
              @if(!empty($value['original_price']))
              <span class="original-price">{{$value['original_price']}}</span>
              @endif
            </div>

          </div>

          <div class="w-100 w-50-ns fn fl-ns">

            <div class="additional-data-section mb-4">

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

            <div class="seller-section text-center">
              <a href="/chat/{{$value['id']}}" class="btn seller-chat-btn">
                <div class="online_status_indicator_{{$value['created_by']}} online-status-indicator @if($value['user']['online']) is-online @endif"></div>
                <i class="fa fa-comments" aria-hidden="true"></i> คุยกับผู้ขาย
              </a>
            </div>   
          </div>

        </div>
      
      </div>
    </div>
    @endforeach
  </div>

  <div class="main-panel">

    <!-- <a href="" class="btn btn-primary btn-block br0 mb-4">
      สร้างรายการขายใหม่
    </a> -->

    <!-- <div class="data-list">

      @foreach($list as $value)
        
          <div class="data-list-item">

            <div class="main-data-section w-100 clearfix">

              <h5 class="mx-2 my-3">
                <a href="/ticket/view/{{$value['id']}}">
                  {{$value['title']}}
                </a>
              </h5>

              <div class="w-100 w-50-ns fn fl-ns">

                @if(!empty($value['save']))
                  <div class="price-saving-flag dib">-{{$value['save']}}</div>
                @endif

                <div class="price-section p-2">
                  <span class="price">{{$value['price']}}</span>
                  @if(!empty($value['original_price']))
                  <span class="original-price">{{$value['original_price']}}</span>
                  @endif
                </div>

              </div>

              <div class="w-100 w-50-ns fn fl-ns">

                <div class="additional-data-section mb-4">

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

    </div> -->

  </div>

</div>

<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>

<script type="text/javascript">
  // $('.left-sidenav').css({
  //   left: $('.main-panel').offset().left - 300
  // });
</script>

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

    const _userOnline = new UserOnline();
    _userOnline.init();

    $('.grid').masonry({
      // options
      itemSelector: '.grid-item',
      percentPosition: true
    });

  });
</script>

@stop