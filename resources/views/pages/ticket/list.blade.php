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

    <div class="row">
    @foreach($list as $value)
      
        <div class="data-list-item">
          
          <div class="row">
            <div class="col-12 main-data-section">
              <div class="main-data-inner">
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

                <div class="row">
                  <div class="col-md-8">
                    <div class="m-2 mt-3">
                      <h5>{{$value['title']}}</h5>

                      <div class="additional-data-section pb-4">

                        @if($value['date_type'] == 1)
                          @if(!empty($value['date_1']))
                          <small><i class="fa fa-calendar"></i> วันที่เริ่มใช้ {{$value['date_1']}}</small>
                          <small>ใช้ได้ถึงวันที่ {{$value['date_2']}}</small>
                          @else
                          <small><i class="fa fa-calendar"></i> ใช้ได้ถึงวันที่ {{$value['date_2']}}</small>
                          @endif
                          
                        @elseif($value['date_type'] == 2)</small>
                          <small><i class="fa fa-calendar"></i> วันที่แสดง {{$value['date_2']}}
                        @elseif($value['date_type'] == 3)</small>
                          <small><i class="fa fa-calendar"></i> วันที่เดินทาง {{$value['date_2']}}
                        @endif

                        @if(!empty($value['place_location']))
                        <small><i class="fa fa-map-marker"></i> {{$value['place_location']}}</small>
                        @endif
                      </div>

                      @if(!empty($value['tags']))
                      <div class="tags pb-2">
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
                  </div>

                  <div class="col-md-4">
                    <div class="price-section my-2 text-center">
                      @if(!empty($value['original_price']))
                      <div class="original-price">{{$value['original_price']}}</div>
                      @endif
                      <div class="price">{{$value['price']}}</div>
                    </div>
                    <!-- <div class="action-section m-2">
                      <a class="btn btn-primary btn-block margin-top-10" href="">
                        ดูเพิ่มเติม
                      </a>
                      <a class="btn btn-primary btn-block margin-top-10" href="">
                        <i class="fa fa-comment"></i>&nbsp;&nbsp;คุยกับผู้ขาย
                      </a>
                    </div> -->
                  </div>
                </div>

               <!--  <div class="price-section text-center">
                  @if(!empty($value['original_price']))
                  <div class="original-price">{{$value['original_price']}}</div>
                  @endif
                  <div class="price">{{$value['price']}}</div>
                </div> -->

              </div>

              <ul class="nav nav-tabs">
                <li><a href="#">เพิ่มเติม</a></li>
                <li><a href="#">รายละเอียด</a></li>
                <li><a href="#">ติดต่อ</a></li>
              </ul>
            </div>

            <div class="col-12">
 
                <!-- <div class="price-section text-center">
                  @if(!empty($value['original_price']))
                  <div class="original-price">{{$value['original_price']}}</div>
                  @endif
                  <div class="price">{{$value['price']}}</div>
                </div> -->

                <!-- <div class="action-section m-2">
                  <a class="btn btn-primary btn-block margin-top-10" href="">
                    ดูเพิ่มเติม
                  </a>
                  <a class="btn btn-primary btn-block margin-top-10" href="">
                    <i class="fa fa-comment"></i>&nbsp;&nbsp;คุยกับผู้ขาย
                  </a>
                </div> -->
 
            </div>

          </div>

          @if(!empty($value['save']))
            <div class="price-saving-flag">-{{$value['save']}}</div>
          @endif

        </div>

    @endforeach
    </div>

  </div>

</div>

@stop