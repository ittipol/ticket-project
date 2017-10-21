@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #445268;*/
    background-color: #ddd;
  }

  .grid-item { width: 32%; margin: 0.5%; }

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

          <div class="ticket-posting-detail p-2 text-center">
            <div class="f6"><i class="fa fa-pencil"></i>&nbsp;&nbsp;{{$value['created_at']}}</div>
          </div>

          <ul class="nav nav-tabs">

            <li class="nav-item">
              <a href="/ticket/edit/{{$value['id']}}">แก้ไข</a>
            </li>
            <li class="nav-item">
              <a href="#target-content" data-t-id="{{$value['id']}}" data-t-title="" class="ticket-close">ปิดประกาศ</a>
            </li>
          </ul>

        </div>

      </div>

    @endforeach
  </div>

  {{$data->links('shared.pagination', ['paginator' => $data])}}

  @else

    <div class="text-center mv5">
      <h3>ยังไม่มีรายการขายบัตรของคุณ</h3>
      <a href="/ticket/new" class="pv2 ph4 mt3 btn btn-primary">
        ขายบัตร
      </a>
    </div>

  @endif

</div>

<div class="clearfix margin-top-200"></div>

<!-- <div class="c-modal"></div> -->

<!-- <a href="#target-content" id="button">Open CSS Modal via <code>:target</code></a> -->

<div class="close-option-modal" id="target-content">
  <a href="#" class="close"></a>
  <div id="target-inner">

    <a href="#modal-close" title="Close" class="modal-close">
      <span aria-hidden="true">&times;</span>
    </a>

    <h2>ปิดประกาศ</h2>
    <p>title</p>

    <div>
      <div class="md-radio">
        <input id="close_option_1" class="close-option" type="radio" value="1" name="close_option" checked>
        <label for="close_option_1">ขายสินค้านี้แล้ว</label>
      </div>
      <div class="md-radio">
        <input id="close_option_2" class="close-option" type="radio" value="2" name="close_option">
        <label for="close_option_2">ยกเลิกการขาย</label>
      </div>
      <div class="md-radio">
        <input id="close_option_3" class="close-option" type="radio" value="3" name="close_option">
        <label for="close_option_3"><input id="close_option_message" class="form-control close-option-message w-80" autocomplete="off" name="title" type="text" placeholder="อื่นๆ" disabled></label>
      </div>
    </div>

    <button type="button" class="btn btn-primary btn-block br0">ตกลง</button>
    
  </div>
</div>

<script type="text/javascript" src="/assets/js/masonry.pkgd.min.js"></script>

<script type="text/javascript">

  class TicketClose {

    constructor() {}

    init() {
      this.bind();
    }

    bind() {

      $('.ticket-close').on('click',function(){
        
        // modal popup

        // set title

      });

      $('.close-option').on('click',function(){
        
        console.log($(this).val());

        switch($(this).val()) {

          case '1':
            document.getElementById('close_option_message').setAttribute('disabled','disabled');
          break;

          case '2':
            document.getElementById('close_option_message').setAttribute('disabled','disabled');
          break;

          case '3':
            document.getElementById('close_option_message').removeAttribute('disabled');
            document.getElementById('close_option_message').focus()
          break;

        }

      });

    }

  }

  $(document).ready(function(){

    $('.grid').masonry({
      itemSelector: '.grid-item',
      percentPosition: true
    });

    const _ticketClose = new TicketClose();
    _ticketClose.init();

  });
</script>

@stop