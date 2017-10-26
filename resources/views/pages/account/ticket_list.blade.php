@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ddd;
  }

  .data-list {
    opacity: 0;
    transition: opacity .3s ease-out ;
  }

  .grid-item { width: 30%; margin: 1%; }

  @media (max-width: 1366px) {
    .grid-item { width: 47%; margin: 1.5%; }
  }

  @media (max-width: 480px) {
    .grid-item { width: 92%; margin: 4%; }
  }
</style>

<div class="container">

  @if(!empty($data))

  <div class="pt-5">
    <h5>รายการของคุณ</h5>
  </div>

  <div class="grid data-list">

    @foreach($data as $_value)
      <?php 
        $value = $_value->buildDataList();
      ?>

      <div class="grid-item">
        <div class="data-list-item">

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

              <div class="additional-data-section mt-2 mb-4 ph2">

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

          <div class="ticket-posting-detail p-2 text-center">
            <div class="f6"><i class="fa fa-pencil"></i>&nbsp;&nbsp;{{$value['created_at']}}</div>
          </div>

          @if($value['closing_option'] == 0)
          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a href="/ticket/edit/{{$value['id']}}"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;แก้ไข</a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);" data-t-id="{{$value['id']}}" data-t-title="{{$value['title']}}" data-t-closing-modal="1"><i class="fa fa-close" aria-hidden="true"></i>&nbsp;ปิดประกาศ</a>
            </li>
          </ul>
          @else
          <div class="tc pa2">
            ปิดประกาศนี้แล้ว
          </div>
          @endif

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

<script type="text/javascript" src="/assets/js/masonry.pkgd.min.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

    setTimeout(function(){
      $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true
      });

      $('.data-list').css('opacity','1');
    },300);

  });
</script>

@stop