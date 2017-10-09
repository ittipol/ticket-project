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
                    <div class="m-2">
                      <h5>{{$value['title']}}</h5>

                      <div class="pb-4">
                        <small><strong>ใช้ได้ถึง:</strong> {{$value['expiration_date']}}</small>
                        @if(!empty($value['place_location']))
                        &nbsp;&nbsp;&nbsp;<small><i class="fa fa-map-marker"></i> {{$value['place_location']}}</small>
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
                    <div class="price-section text-center">
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
                @if(!empty($value['image']))
                <li><a href="#">รูปภาพ</a></li>
                @endif
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