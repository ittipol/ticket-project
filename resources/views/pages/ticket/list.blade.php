@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    background-color: #CFD8DC;
  }
</style>

@include('shared.filter-leftside-nav')

<div class="container-fliud mb5 mb7-ns">

  @if(!empty($taggings))
    <div class="main-panel">

      <div class="tags bg-near-white pa3 bb b--silver">

        <div class="mb3">แนะนำ</div>

        @foreach($taggings as $tag)
          <div class="md-chip">
            <div class="md-chip-icon">
              <i class="fa fa-tag"></i>
            </div>
            <a href="/ticket?q={{$tag['word']}}">{{$tag['word']}}</a>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  @if($data->currentPage() <= $data->lastPage())
  
  <div class="main-panel">

    <div class="c-grid-layout clearfix">
      @foreach($data as $_value)

      <?php 
        $value = $_value->buildDataList();
      ?>

      <div class="c-grid__col">
        <div class="c-card c-card--to-edge">

          <!-- <div class="c-card__header">
            <div class="c-card__avatar"><img src="/avatar/{{$value['created_by']}}?d=1"></div>
            <div class="c-card__title">
              <div class="title">{{$value['user']['name']}}</div>
              <div class="subtitle"><small>{{$value['created_at']}}</small></div>
            </div>
            <div class="c-card__date">
              <a href="/chat/s/{{$value['id']}}" class="btn seller-chat-btn">
                <div class="online_status_indicator_{{$value['created_by']}} online-status-indicator @if($value['user']['online']) is-online @endif"></div>
                <i class="fa fa-comments" aria-hidden="true"></i>
              </a>
            </div>
          </div> -->

          <div class="c-card__flag"><i class="fa fa-ticket" aria-hidden="true"></i> {{$value['category']}}</div>

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

    {{$data->links('shared.pagination', ['paginator' => $data])}}
    
  </div>

  @elseif($search)

    <div class="main-panel text-center mv5 pa3 pa0-ns white">
      <h3 class="dark-gray">ไม่พบรายการที่กำลังค้นหา</h3>
      <p class="dark-gray">โปรดลองค้นหาอีกครั้ง ด้วยคำที่แตกต่างหรือคำที่มีความหมายใกล้เคียง</p>
    </div>

  @else

    <div class="main-panel text-center mv5 pa3 pa0-ns  white">
      <h3 class="dark-gray">ยังไม่มีรายการขายบัตร</h3>
      <p class="dark-gray">บัตรคอนเสิร์ต ตั๋ว วอชเชอร์ และอื่นๆที่ไม่ได้ใช้แล้วสามารถนำมาขายได้ที่นี่</p>
      <a href="/ticket/new" class="pv2 ph4 mt3 btn btn-primary">
        ขายบัตรของคุณ
      </a>
    </div>

  @endif

</div>

<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/user_online.js"></script>

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