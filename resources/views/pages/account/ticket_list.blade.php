@extends('shared.main')
@section('content')

<div class="container">

  @foreach($data as $_value)
    <?php 
      $value = $_value->buildDataList();
    ?>

    <div class="list-h clearfix">

      <div class="w-100 w-60-ns fn fl-ns">

        <h5 class="p-2 mt-2 mb-0">
          <a class="title" href="/ticket/view/{{$value['id']}}">
            {{$value['title']}}
          </a>
        </h5>

        <div class="price-section px-2 pt-0 pb-2">
          <span class="price">{{$value['price']}}</span>
          @if(!empty($value['original_price']))
          <span class="original-price">{{$value['original_price']}}</span>
          @endif
        </div>

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

      <div class="w-100 w-40-ns fn fl-ns">
        <div class="px-3 py-2 mt-3 ba bg-washed-red b--light-red">
          <div class="dark-red"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;&nbsp;ยกเลิกรายการของคุณ</div>
          <small>ยกเลิกรายการของคณเมื่อ <strong>ขายสินค้านี้แล้ว</strong>  หรือหากต้องการ <strong>ลบรายการ</strong></small>

          <div>
            <a href="" class="btn btn-link px-0 py-2">ขายสินค้านี้แล้ว</a>
            <a href="" class="btn btn-link">ลบรายการ</a>
          </div>
        </div>
      </div>
    </div>

  @endforeach

  {{$data->links('shared.pagination', ['paginator' => $data])}}

</div>

@stop