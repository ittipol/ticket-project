@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    /*background-color: #607D8B;*/
    background-color: #CFD8DC;
  }

  .data-list {
    opacity: 0;
    transition: opacity .25s ease-out ;
  }

  .grid-item { width: 23%; margin: 1%; }

  @media (max-width: 1366px) {
    .grid-item { width: 47%; margin: 1.5%; }
  }

  @media (max-width: 480px) {
    .grid-item { width: 92%; margin: 4%; }
  }
</style>

@include('shared.filter-leftside-nav')

<div class="container-fliud margin-top-10 margin-bottom-200">

  @if($data->currentPage() <= $data->lastPage())
  <div class="grid data-list main-panel">
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
        
        @if(Auth::guest() || (Auth::check() && (Auth::user()->id != $value['created_by'])))
        
          <div class="w-100 seller-section text-center">
            <a href="/chat/s/{{$value['id']}}" class="btn seller-chat-btn">
              <div class="online_status_indicator_{{$value['created_by']}} online-status-indicator @if($value['user']['online']) is-online @endif"></div>
              <i class="fa fa-comments" aria-hidden="true"></i> คุยกับผู้ขาย
            </a>
          </div>
     
        @else

          <div class="ticket-posting-detail p-2 text-center">
            <div class="f6"><i class="fa fa-pencil"></i>&nbsp;&nbsp;รายการของคุณ</div>
          </div>

          <ul class="nav nav-tabs">

            <li class="nav-item">
              <a href="/ticket/edit/{{$value['id']}}"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;แก้ไข</a>
            </li>
            <li class="nav-item">
              <a href="javascript:void(0);" data-t-id="{{$value['id']}}" data-t-title="{{$value['title']}}" data-t-closing-modal="1"><i class="fa fa-close" aria-hidden="true"></i>&nbsp;ปิดประกาศ</a>
            </li>
          </ul>

        @endif

      </div>
    </div>
    @endforeach
  </div>

  <div class="main-panel">
    {{$data->links('shared.pagination', ['paginator' => $data])}}
  </div>

  @elseif($search)

    <div class="main-panel text-center mv5 pa3 pa0-ns white">
      <h3>ไม่พบรายการที่กำลังค้นหา</h3>
      <p>โปรดลองค้นหาอีกครั้ง ด้วยคำที่แตกต่างหรือคำที่มีความหมายใกล้เคียง</p>
    </div>

  @else

    <div class="main-panel text-center mv5 pa3 pa0-ns  white">
      <h3>ยังไม่มีรายการขายบัตร</h3>
      <p>บัตรคอนเสิร์ต ตั๋ว วอชเชอร์ และอื่นๆที่ไม่ได้ใช้แล้วสามารถนำมาขายได้ที่นี่</p>
      <a href="/ticket/new" class="pv2 ph4 mt3 btn btn-primary">
        ขายบัตรของคุณ
      </a>
    </div>

  @endif

</div>

<div class="clearfix margin-top-200"></div>

@include('shared.ticket-closing-modal')

<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="/assets/js/user_online.js"></script>
<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>

<script type="text/javascript">

  class TicketFilter {

    constructor() {}

    init() {
      this.bind();
      this.layout();
    }

    bind() {

      let _this = this;

      $('#fiter_panel_toggle').on('click', function() {
        $('#fiter_panel_toggle').attr('disabled',true);
        $('body').css('overflow-y','hidden');
        $('.left-sidenav').addClass('show');
      });

      $('.left-sidenav > button.close').on('click',function(){
        $('#fiter_panel_toggle').attr('disabled',false);
        $('body').css('overflow-y','auto');
        $('.left-sidenav').removeClass('show');
      });

      $('#ticket_filter_form').on('submit',function(){
        
        if(($('#start_date').val() !== '') && ($('#end_date').val() !== '')) {        
          if(DateTime.dateToTimestamp($('#start_date').val()) >= DateTime.dateToTimestamp($('#end_date').val())) {

            const snackbar = new Snackbar();
            snackbar.setTitle('ไม่อนุญาตให้กรอกวันที่เริ่มต้นมากกว่าหรือเท่ากับวันที่สิ้นสุด');
            snackbar.display();

            return false;
          }
        }

        let priceStart = $('#price_start').val().trim();
        let priceEnd = $('#price_end').val().trim();


        if((priceStart !== '') && (!/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(priceStart))) {
          const snackbar = new Snackbar();
          snackbar.setTitle('จำนวนราคาไม่ถูกต้อง');
          snackbar.display();

          return false;
        }else if((priceEnd !== '') && (!/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(priceEnd))) {
          const snackbar = new Snackbar();
          snackbar.setTitle('จำนวนราคาไม่ถูกต้อง');
          snackbar.display();

          return false;
        }else if(((priceStart !== '') && (priceEnd !== '')) && (parseInt(priceStart) >= parseInt(priceEnd))) {
          const snackbar = new Snackbar();
          snackbar.setTitle('จำนวนราคาเริ่มต้นหรือสิ้นสุดไม่ถูกต้อง');
          snackbar.display();

          return false;
        }

        if(priceStart === '') {
          $('#price_start').removeAttr('name');
        }

        if(priceEnd === '') {
          $('#price_end').removeAttr('name');
        }

        if($('#start_date').val() === '') {
          $('#start_date').removeAttr('name');
        }

        if($('#end_date').val() === '') {
          $('#end_date').removeAttr('name');
        }

        if($('#q').val().trim() === '') {
          $('#q').removeAttr('name');
        }

      });

      $(window).resize(function(){
        _this.layout();
      });

    }

    layout() {

      let wH = window.innerHeight;
      // let wW = window.innerWidth;
      let navbarH = 60;

      $('.left-sidenav').css({
        'height': (wH-navbarH)+'px',
        // 'top': navbarH+'px'
      });

    }

  }

  $(document).ready(function(){

    setTimeout(function(){
      $('.grid').masonry({
        itemSelector: '.grid-item',
        percentPosition: true
      });

      $('.data-list').css('opacity','1');
    },200);

    const _ticketFilter = new TicketFilter();
    _ticketFilter.init();

    const date1 = new Datepicker('#start_date',true,true);
    date1.init();

    const date2 = new Datepicker('#end_date',true,true);
    date2.init();

    const _userOnline = new UserOnline();
    _userOnline.init();

  });
</script>

@stop