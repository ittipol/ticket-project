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
        
        <div class="row">
          <div class="col-md-6 main-data-section">
            <div class="main-data-inner">
              @if(!empty($value['images']))
                <div class="data-image">
                  <img src="{{$value['images'][0]['_url']}}">

                  <div class="image-more">
                    5+<img src="/assets/images/common/photos.png">
                  </div>
                </div>
              @endif

              <div class="m-2">
                <h5>{{$value['title']}}</h5>

                <div class="pb-4">
                  <small><strong>ใช้ได้ถึง:</strong> {{$value['expiration_date']}}</small>
                </div>

                @if(!empty($value['tags']))
                <div class="tags pb-2">
                  @foreach($value['tags'] as $tag)
                    <div class="md-chip">
                      {{$tag['word']}}
                    </div>
                  @endforeach
                </div>
                @endif
              </div>

            </div>

            <ul class="nav nav-tabs nav-justified">
              <li class="active"><a href="#">รูปภาพ</a></li>
              <li><a href="#">รายละเอียด</a></li>
              <li><a href="#">ติดต่อ</a></li>
            </ul>
          </div>

          <!-- <div class="col-md-2">
            <div class="additional-data-section m-2">
              SELLER
            </div>
          </div> -->

          <div class="col-md-6">
            <div>
              <div class="price-section m-0 m-md-2 text-center">
                @if(!empty($value['original_price']))
                <div class="original-price">{{$value['original_price']}}</div>
                @endif
                <div class="price">{{$value['price']}}</div>
              </div>

              <div class="action-section m-2">
                <a class="btn btn-primary btn-block margin-top-10" href="">
                  ดูเพิ่มเติม
                </a>
                <a class="btn btn-primary btn-block margin-top-10" href="">
                  <i class="fa fa-comment"></i>&nbsp;&nbsp;คุยกับผู้ขาย
                </a>
              </div>
            </div>
          </div>
        </div>

        @if(!empty($value['save']))
          <div class="price-saving-flag">-{{$value['save']}}</div>
        @endif

      </div>
    @endforeach

  </div>

</div>

@stop