@extends('shared.main')
@section('content')

<div class="clearfix margin-top-100"></div>

<div class="container">
  <div class="row">

    <div class="col-md-8">

      <h3>{{$data['title']}}</h3>
      <p>{!!$data['description']!!}</p>

      <hr>

      <div class="additional-data-section mb-4">

        @if($data['date_type'] == 1)
          
          @if(!empty($data['date_1']))
          <div class="additional-item">
            <i class="fa fa-calendar"></i> ใช้ได้ตั้งแต่ {{$data['date_1']}} ถึง {{$data['date_2']}}
          </div>
          @else
          <div class="additional-item">
            <i class="fa fa-calendar"></i> ใช้ได้ถึงวันที่ {{$data['date_2']}}
          </div>
          @endif
          
        @elseif($data['date_type'] == 2)
          <div class="additional-item">
            <i class="fa fa-calendar"></i> วันที่แสดง {{$data['date_2']}}
          </div>
        @elseif($data['date_type'] == 3)
          <div class="additional-item">
            <i class="fa fa-calendar"></i> วันที่เดินทาง {{$data['date_2']}}
          </div>
        @endif

        @if(!empty($data['place_location']))
          <div class="additional-item">
            <i class="fa fa-map-marker"></i> {{$data['place_location']}}
          </div>
        @endif

      </div>

      @if(!empty($data['tags']))
      <div class="tags mx-2 mb-4">
        @foreach($data['tags'] as $tag)
          <div class="md-chip">
            <div class="md-chip-icon">
              <i class="fa fa-tag"></i>
            </div>
            {{$tag['word']}}
          </div>
        @endforeach
      </div>
      @endif

      @if(!empty($data['save']))
        <div class="price-saving-flag">-{{$data['save']}}</div>
      @endif

      <div class="price-section py-2">
        <span class="price fs-46">{{$data['price']}}</span>
        @if(!empty($data['original_price']))
        <span class="original-price">{{$data['original_price']}}</span>
        @endif
      </div>

      <hr>

      <div class="image-gallery-section p-2 bg-moon-gray">
        <div class="n2">
        @foreach($data['images'] as $image)
          <a href="{{$image['_url']}}" data-ngThumb="{{$image['_preview_url']}}"></a>
        @endforeach
        </div>
      </div>

    </div>

    <div class="col-md-4">
      <div class="seller-section">
        <div class="pv2 pv2-ns ph3 ph2-ns clearfix">
          <div class="avatar-frame fl">
            <div id="online_status_indicator" class="online-status-indicator"></div>
            <div class="avatar">
              @if(empty($seller->avatar))
              <img src="/avatar?d=1">
              @else
              <img src="/avatar/{{$seller->avatar}}?d=1">
              @endif
            </div>
          </div>
          <div class="online-status fl">{{$seller->name}}</div>
        </div>
        <div class="chat-section">
          <div class="pa2 pa2-ns">
            <a href="/chat/{{$ticketId}}" class="btn btn-primary btn-block br0">
              <i class="fa fa-comments" aria-hidden="true"></i> คุยกับผู้ขาย
            </a>
          </div>
        </div>
      </div>

      <div class="contact-section">
        <div class="clearfix p-3">
          <h5 class="mt-1 pb-2"><i class="fa fa-address-book" aria-hidden="true"></i>&nbsp;ช่องทางการติดต่อผู้ขาย</h5>
          {!!$data['contact']!!}
        </div>
        
      </div>
    </div>

  </div>
</div>

<div class="clearfix margin-top-200"></div>

<script type="text/javascript">
  $(document).ready(function () {
    $(".n2").nanogallery2({
      thumbnailHeight:  150,
      thumbnailWidth:   'auto',
      thumbnailBorderVertical: 0,
      thumbnailBorderHorizontal: 0,
      thumbnailGutterWidth: 4,
      galleryDisplayMode: 'rows',
      thumbnailAlignment: 'left',
      // thumbnailDisplayTransition: 'flipUp',
      // thumbnailLabel: { hideIcons: true },
      slideshowAutoStart: false,
      viewerToolbar: { display: false },
      touchAnimation: false,
    });

    const _userOnline = new UserOnline({{$data['created_by']}});
    _userOnline.init();

    // setInterval(function(){
    //   _io.socket.emit('check-user-online', {userId: 1});
    // },1000);

  });
</script>

@stop