@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    background-color: #ddd;
  }
</style>

<div class="container">

  @if($data->currentPage() <= $data->lastPage())

  <div class="pt5 pb3">
    <h5>ประกาศที่เกี่ยวกับ {{$hashtag}}</h5>
  </div>

  <div class="row">

    @foreach($data as $_value)

      <?php $value = $_value->buildDataList(80,true); ?>

      <div class="col-12 col-md-6 col-lg-4 mb3">
        <div class="c-card c-card--to-edge">

          <!-- <div class="c-card__flag"><i class="fa fa-ticket" aria-hidden="true"></i> {{$value['category']}}</div> -->

          <div class="c-card--inner">

            <a href="/ticket/view/{{$value['id']}}" class="c-card__media Media__image Media__image--16-9 db">
              @if(empty($value['image']))
                <div class="c-card__no-image">
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
                  วันที่ใช้งาน <strong>ไม่ระบุ</strong>
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

            <div class="c-card__header">
              <!-- <div class="c-card__avatar"><img src="/avatar/{{$value['created_by']}}?d=1"></div> -->
              <div class="c-card__title">
                <div class="title"><!-- {{$value['user']['name']}} -->
                  <i class="fa fa-ticket" aria-hidden="true"></i> <strong>{{$value['category']}}</strong>
                </div>
                <div class="subtitle"><small>ประกาศเมื่อ {{$value['created_at']}}</small></div>
              </div>
              <!-- <div class="c-card__date">
                <a href="/chat/s/{{$value['id']}}" class="btn seller-chat-btn">
                  <div class="online_status_indicator_{{$value['created_by']}} online-status-indicator @if($value['user']['online']) is-online @endif"></div>
                  <i class="fa fa-comments" aria-hidden="true"></i>
                </a>
              </div> -->
            </div>

          </div>
        </div>
      </div>
    @endforeach
  </div>

  {{$data->links('shared.pagination', ['paginator' => $data])}}

  @else

    <div class="text-center mv5 pa3 pa0-ns ">
      <h3>ไม่พบประกาศที่เกี่ยวกับ {{$hashtag}}</h3>
      <a href="/ticket" class="pv2 ph4 mt3 btn btn-primary">
        รายการขายบัตร
      </a>
    </div>

  @endif

</div>

<div class="clearfix margin-top-200"></div>

@include('shared.ticket-closing-modal')

@include('shared.rich-card')

@stop