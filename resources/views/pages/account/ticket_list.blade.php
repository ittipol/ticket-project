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
    <h5>รายการของฉัน</h5>
  </div>

  <div class="row">

    @foreach($data as $_value)

      <?php $value = $_value->buildDataList(80,true); ?>

      <div class="col-12 col-md-6 col-lg-4 mb3">
        <div class="c-card c-card--to-edge">

          <div class="c-card__flag">{{$value['category']}}</div>
          
          <div class="c-card--inner">
          
            <a href="/ticket/view/{{$value['id']}}" class="c-card__media Media__image Media__image--16-9 Media__image--bg db">
              @if(empty($value['image']))
                <div class="c-card__no-image">
                  <img src="/assets/images/common/photos.png">
                </div>
              @else
                <div class="image__frame {{$value['image']['formation']}}-image" style="background-image: url({{$value['image']['_preview_url']}})"></div>
              @endif
            </a>
            
            <div class="c-card__primary-title">
              <!-- <div class="c-card__media Media__image--one-right"><img src="" alt=""></div> -->
              <h2 class="title">
                <a href="/ticket/view/{{$value['id']}}">{{$value['title']}}</a>
                @if(!empty($value['description']))
                &nbsp;<small>—&nbsp;&nbsp;{{$value['description']}}</small>
                @endif
              </h2>
              
            </div>

            @if($value['pullingPost']['allow'])
            <div class="c-card__actions clearfix tc">
              <a class="c-btn c-btn__primary w-100 ma0 br0 db" href="/ticket/pull/{{$value['id']}}"><i class="fa fa-retweet"></i> เลื่อนประกาศขึ้นสู่ตำแหน่งบน</a>
            </div>
            @else
            <div class="c-card__notice">
              <small>จะสามารถเลื่อนประกาศได้ในอีก <strong>{{$value['pullingPost']['daysLeft']}}</strong></small>
            </div>
            @endif

            <div class="c-card__actions pb2 tc clearfix">
              <a class="c-btn c-btn__secondary w-50 fl ma0 br0 db" href="/ticket/edit/{{$value['id']}}"><i class="fa fa-pencil"></i> แก้ไข</a>
              <a class="c-btn w-50 fl ma0 br0 db" href="javascript:void(0);" data-t-id="{{$value['id']}}" data-t-title="{{$value['title']}}" data-t-closing-modal="1"><i class="fa fa-times"></i> ปิดประกาศ</a>
            </div>
          </div>
        
        </div>
      </div>
    @endforeach
  </div>

  {{$data->links('shared.pagination', ['paginator' => $data])}}

  @else

    <div class="text-center mv5 pa3 pa0-ns ">
      <h3>ยังไม่มีรายการขายบัตรของคุณ</h3>
      <a href="/ticket/new" class="pv2 ph4 mt3 btn btn-primary">
        ขายบัตร
      </a>
    </div>

  @endif

</div>

<div class="clearfix margin-top-200"></div>

@include('shared.ticket-closing-modal')

@stop