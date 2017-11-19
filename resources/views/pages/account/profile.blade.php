@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    background-color: #ededed;
  }
</style>

<div class="container">

  <div class="mv5">

    <div class="row">
      <div class="col-md-3">
        <div class="avatar avatar-display mx-auto">
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
            <i class="fa fa-list"></i>&nbsp;รายการของฉัน
          </a>
        </div>
      </div>
      <div class="col-md-9">
        <div class="bt b--silver pt-5">

          @if(!empty($data))

          <h5>รายการล่าสุดของฉัน</h5>
          <div class="row">
            @foreach($data as $_value)
       
              <?php 
                $value = $_value->buildDataList(90,true);
              ?>

              <div class="col-12 col-md-6 mb3">
                <div class="c-card c-card--to-edge">

                  <div class="c-card__flag">{{$value['category']}}</div>

                  <div class="c-card--inner">

                    <a href="/ticket/view/{{$value['id']}}" class="c-card__media Media__image Media__image--16-9 db">
                      @if(empty($value['image']))
                        <div class="c-card-no-image">
                          <img src="/assets/images/common/photos.png">
                        </div>
                      @else
                        <img class="{{$value['image']['formation']}}-image" src="{{$value['image']['_preview_url']}}">
                      @endif
                    </a>
                    <div class="c-card__primary-title">
                      <h2 class="title">
                        <a href="/ticket/view/{{$value['id']}}">{{$value['title']}}</a>
                        @if(!empty($value['description']))
                        &nbsp;<small>—&nbsp;&nbsp;{{$value['description']}}</small>
                        @endif
                      </h2>

                      @if($value['date_type'] == 0)
                        <div class="subtitle">
                          วันที่ <strong>ไม่ระบุ</strong>
                        </div>
                      @elseif($value['date_type'] == 1)
                        
                        @if(!empty($value['date_1']))
                        <div class="subtitle">
                          ใช้ได้ตั้งแต่ <strong>{{$value['date_1']}}</strong> - <strong>{{$value['date_2']}}</strong>
                        </div>
                        @else
                        <div class="subtitle">
                          ใช้ได้ถึงวันที่ <strong>{{$value['date_2']}}</strong>
                        </div>
                        @endif
                        
                      @elseif($value['date_type'] == 2)
                        <div class="subtitle">
                          วันที่แสดง <strong>{{$value['date_1']}}</strong>
                        </div>
                      @elseif($value['date_type'] == 3)
                        
                        @if(!empty($value['date_2']))
                        <div class="subtitle">
                          วันที่เดินทาง <strong>{{$value['date_1']}}</strong> วันที่กลับ <strong>{{$value['date_2']}}</strong>
                        </div>
                        @else
                        <div class="subtitle">
                          วันที่เดินทาง <strong>{{$value['date_1']}}</strong>
                        </div>
                        @endif

                      @endif

                    </div>

                    <div class="price-section c-card__price px-2 pt-0 pb-2">
                      <span class="price">{{$value['price']}}</span>
                      @if(!empty($value['original_price']))
                      <span class="original-price">{{$value['original_price']}}</span>
                      @endif
                      @if(!empty($value['save']))
                        <span class="price-saving-flag">-{{$value['save']}}</span>
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