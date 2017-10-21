@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    background-color: #ddd;
  }
</style>

<div class="container">

  <div class="mv5">

    <div class="row">
      <div class="col-md-3">
        <div class="avatar avatar-md mx-auto">
          <img src="/avatar?d=1&o=1">
        </div>
        <h5 class="text-center my-4">
          {{Auth::user()->name}}
        </h5>
        <div>
          <a href="/account/edit" class="btn btn-outline-primary db mx-auto w-100-ns mb-3">
            <i class="fa fa-pencil"></i>&nbsp;แก้ไขโปรไฟล์
          </a>
          <a href="/account/ticket" class="btn btn-outline-primary db mx-auto w-100-ns">
            <i class="fa fa-list"></i>&nbsp;รายการของคุณ
          </a>
        </div>
      </div>
      <div class="col-md-9">
        <div class="bt b--silver pt-5">

          @if(!empty($list))

          <h5>รายการล่าสุดของคุณ</h5>
          <div class="data-list">
            @foreach($list as $value)
              <div class="data-list-item mb-4">

                <div>
                  @if(!empty($value['image']))
                    <a href="/ticket/view/{{$value['id']}}" class="data-image">
                      <img src="{{$value['image']['_preview_url']}}">

                      @if($value['imageTotal'] > 1)
                      <div class="image-more">
                        {{$value['imageTotal']-1}}+<img src="/assets/images/common/photos.png">
                      </div>
                      @endif
                    </a>
                  @endif
                </div>

                <h5 class="mx-2 mt-3 mb-1">
                  <a class="title" href="/ticket/view/{{$value['id']}}">
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
                    <div class="additional-data-section mt-2 mb-4 ph2 ph0-ns">

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

              </div>
            @endforeach
          </div>

          <a href="/account/ticket" class="pa3 btn btn-primary btn-block">
            แสดงรายการทั้งหมด
          </a>

          @else
            <div class="text-center">
              <h3>ยังไม่มีรายการขายบัตรของคุณ</h3>
              <a href="/ticket/new" class="pv2 ph4 mt3 btn btn-primary">
                ขายบัตร
              </a>
            </div>
          @endif

        </div>
      </div>
    </div>

  </div>
</div>

@stop