@extends('shared.main')
@section('content')

<style type="text/css">
  body {
    background-color: #fff;
  }
</style>

@include('shared.filter-leftside-nav')

<div class="container-fliud mb5 mb7-ns">
  <div class="main-panel">

    <div class="c-grid-layout clearfix">
      <div id="item_list_panel"></div>
    </div>

    <div class="pagination-btn clearfix">
      <div class="btn fr tr">
        <a id="load_next_btn" class="btn">แสดงถัดไป <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
      </div>
      <div class="btn fr">
        <a id="load_prev_btn" class="btn dn"><i class="fa fa-chevron-left" aria-hidden="true"></i> ก่อนหน้า</a>
      </div>
    </div>

  </div>
</div>

<div class="global-overlay"></div>
<div class="global-loading-indicator"></div>

<script type="text/javascript" src="/assets/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="/assets/js/form/form-datepicker.js"></script>
<script type="text/javascript" src="/assets/js/form/selecting-list.js"></script>
<script type="text/javascript" src="/assets/js/user_online.js"></script>

<script type="text/javascript">

  class TicketLoading {
    constructor(token) {
      this.token = token;
      this.data = {
        q: null,
        category: [],
        price_start: 0,
        price_end: 0,
        location: null,
        start_date: null,
        end_date: null,
        sort: 'post_n',
        page: 1,
      };
      this.handleTimeout = null;
    }

    init() {
      this.loading();
      this.bind();
    }

    bind() {
      let _this = this;

      $('#load_next_btn').on('click',function(e) {
        e.preventDefault();
        _this.loading('next');
      });

      $('#load_prev_btn').on('click',function(e) {
        e.preventDefault();
        _this.loading('prev');
      });

      $('#q').on('keyup',function(e) {

        let q = $(this).val();

        _this.data.q = q;

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){

          if(q != '') {
            _this.loading();
          }

        },500);
        
      });

      $('input[name="category[]"]').on('click',function(e) {

        let i = _this.arrayIndexOf(_this.data.category,$(this).val());

        if(i > -1) {
          _this.data.category.splice(i,1);
        }else {
          _this.data.category.push($(this).val());
        }

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          _this.loading();
        },500);
      });

      $('body').on('click','#selecting_location .list-item-label > a',function(e) {
        _this.data.location = $(this).data('id');

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          _this.loading();
        },500);
      });

      $('#price_start').on('keyup',function(e) {

        let price = $(this).val();

        _this.data.price_start = price;

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          if((price !== '') && (/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(price))) {
            _this.loading();
          }
        },500);

      });

      $('#price_end').on('keyup',function(e) {

        let price = $(this).val();

        _this.data.price_end = price;

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          if((price !== '') && (/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(price))) {
            _this.loading();
          }
        },500);

      });

      $('#start_date').on('change',function(e) {
        this.data.start_date = $(this).val();

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          _this.loading();
        },500);
      });

      $('#end_date').on('change',function(e) {
        this.data.end_date = $(this).val();

        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          _this.loading();
        },500);
      });

      $('input[name="sort"]').on('click',function(e) {

        _this.data.sort = $(this).val();
        
        clearTimeout(_this.handleTimeout);
        
        _this.handleTimeout = setTimeout(function(){
          _this.loading();
        },500);
      });
    }

    loading(action = null) {

      let _this = this;

      switch(action) {
        case 'next':
          this.data.page++;
        break;

        case 'prev':
          this.data.page--;
        break;

        default:
          this.data.page = 1;
      }

      let request = $.ajax({
        url: "/ticket-list",
        type: "GET",
        headers: {
          'x-csrf-token': this.token
        },
        data: this.data,
        dataType: 'json',
        // contentType: false,
        // cache: false,
        // processData:false,
        beforeSend: function( xhr ) {
          $('.pagination-btn').removeClass('db').addClass('dn');
          $('.global-overlay').addClass('show');
          $('.global-loading-indicator').addClass('show');
        },
        // mimeType:"multipart/form-data"
      });

      request.done(function (response, textStatus, jqXHR){

        $('#item_list_panel').html('');

        setTimeout(function(){
          $('#item_list_panel').html(response.html);
        },400);

        if(response.hasData) {

          if(_this.data.page == 1) {
            $('#load_prev_btn').removeClass('db').addClass('dn');
          }else {
            $('#load_prev_btn').removeClass('dn').addClass('db');
          }

          if(response.next) {
            $('#load_next_btn').removeClass('dn').addClass('db');
          }else {
            $('#load_next_btn').removeClass('db').addClass('dn');
          }

        }else {
          $('#load_next_btn').removeClass('db').addClass('dn');
          $('#load_prev_btn').removeClass('db').addClass('dn');
        }

        setTimeout(function(){
          $('.pagination-btn').removeClass('dn').addClass('db');
          $('.global-overlay').removeClass('show');
          $('.global-loading-indicator').removeClass('show');
        },800);

      });

      request.fail(function (jqXHR, textStatus, errorThrown){
        console.error(
            "The following error occurred: "+
            textStatus, errorThrown
        );
      });

    }

    arrayIndexOf(haystack, needle){
      for(var i = 0; i < haystack.length; ++i){
        if(haystack[i] == needle) {
          return i;
        }
      }
      return -1;
    }
  }

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

      $('#location_label').on('click',function(){

        if($(window).height() > 480) {
          $('.left-sidenav').css('overflow-y','hidden');
        }
        
      });

      $('#selecting_location').on('click','.close',function(){
        $('.left-sidenav').css('overflow-y','auto');
      });

      $('#selecting_location').on('click','.modal-close',function(){
        $('.left-sidenav').css('overflow-y','auto');
      });

      // Fixed Here
      // $('#ticket_filter_form').on('submit',function(){
        
      //   if(($('#start_date').val() !== '') && ($('#end_date').val() !== '')) {        
      //     if(DateTime.dateToTimestamp($('#start_date').val()) >= DateTime.dateToTimestamp($('#end_date').val())) {

      //       const snackbar = new Snackbar();
      //       snackbar.setTitle('ไม่อนุญาตให้กรอกวันที่เริ่มต้นมากกว่าหรือเท่ากับวันที่สิ้นสุด');
      //       snackbar.display();

      //       return false;
      //     }
      //   }

      //   let priceStart = $('#price_start').val().trim();
      //   let priceEnd = $('#price_end').val().trim();

      //   if((priceStart !== '') && (!/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(priceStart))) {
      //     const snackbar = new Snackbar();
      //     snackbar.setTitle('จำนวนราคาไม่ถูกต้อง');
      //     snackbar.display();

      //     return false;
      //   }else if((priceEnd !== '') && (!/^[0-9]{1,3}(?:,?[0-9]{3})*(?:\.[0-9]{2})?$/g.test(priceEnd))) {
      //     const snackbar = new Snackbar();
      //     snackbar.setTitle('จำนวนราคาไม่ถูกต้อง');
      //     snackbar.display();

      //     return false;
      //   }else if(((priceStart !== '') && (priceEnd !== '')) && (parseInt(priceStart) >= parseInt(priceEnd))) {
      //     const snackbar = new Snackbar();
      //     snackbar.setTitle('จำนวนราคาเริ่มต้นหรือสิ้นสุดไม่ถูกต้อง');
      //     snackbar.display();

      //     return false;
      //   }

      //   if(priceStart === '') {
      //     $('#price_start').removeAttr('name');
      //   }

      //   if(priceEnd === '') {
      //     $('#price_end').removeAttr('name');
      //   }

      //   if($('input[name="location"]').val() === '') {
      //     $('input[name="location"]').removeAttr('name');
      //   }

      //   if($('#start_date').val() === '') {
      //     $('#start_date').removeAttr('name');
      //   }

      //   if($('#end_date').val() === '') {
      //     $('#end_date').removeAttr('name');
      //   }

      //   if($('#q').val().trim() === '') {
      //     $('#q').removeAttr('name');
      //   }

      // });

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

    const _ticketLoading = new TicketLoading('{{ csrf_token() }}');
    _ticketLoading.init();

    const _ticketFilter = new TicketFilter();
    _ticketFilter.init();

    const locationList = new SelectingList('location','#selecting_location','#location_label');
    locationList.init();
    @if(empty($locationSearchingData))
      locationList.getData();
    @else
      locationList.setDataId({{$locationSearchingData['id']}});
      locationList.setDataPath({!!$locationSearchingData['path']!!});
      locationList.setSelectedLabel();
    @endif

    const date1 = new Datepicker('#start_date',true,true);
    date1.init();

    const date2 = new Datepicker('#end_date',true,true);
    date2.init();

    const _userOnline = new UserOnline();
    _userOnline.init();

  });
</script>

@stop