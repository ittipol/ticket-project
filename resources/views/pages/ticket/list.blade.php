@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ccc;
  }
</style>

<div class="container margin-top-30">

  <div class="left-sidenav"></div>

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

            <h5 class="mx-2 my-3"><i class="fa fa-tag"></i>&nbsp;{{$value['title']}}</h5>

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

@stop