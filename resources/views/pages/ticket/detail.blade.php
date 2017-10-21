@extends('shared.main')
@section('content')

<div class="clearfix margin-top-100"></div>

<div class="container">
  <div class="row">

    <div class="col-md-8">
      <h3>{{$data['title']}}</h3>
      <div class="text-left">
        <small><strong>แชร์</strong></small>
        <a class="btn btn-facebook btn-share" href="https://www.facebook.com/sharer/sharer.php?u={{Request::fullUrl()}}" target="_blank">
          <i class="fa fa-facebook"></i>
        </a>
        <a class="btn btn-twitter btn-share" href="https://twitter.com/intent/tweet?url={{Request::fullUrl()}}&amp;text={{$data['title']}}" target="_blank">
          <i class="fa fa-twitter"></i>
        </a>
        <a class="btn btn-googleplus btn-share" href="https://plus.google.com/share?url={{Request::fullUrl()}}" target="_blank">
          <i class="fa fa-google-plus"></i>
        </a>
      </div>  
    </div>

    <div class="col-md-4">
    </div>

    <div class="col-md-8">

      <p class="ticket-detail-section pa2 pt2-ns pa0-ns mb-3">{!!$data['description']!!}</p>

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

      @include('shared.ig')

      @if(Auth::guest() || (Auth::check() && (Auth::user()->id != $data['created_by'])))
      <div class="quick-chat-section px-2 py-3">
        <h5>
          <i class="fa fa-comments" aria-hidden="true"></i>&nbsp;<small>สอบถามผู้ขาย</small>
        </h5>
        <div>
          <a href="" class="btn btn-primary br4 pa2 ph3-ns mb2 mr2-ns w-100 w-auto-ns">ต้องการสั่งซื้อสินค้านี้?</a>
          <a href="" class="btn btn-primary br4 pa2 ph3-ns mb2 mr2-ns w-100 w-auto-ns">ยังมีของอยู่ไหม?</a>
          <a href="" class="btn btn-primary br4 pa2 ph3-ns mb2 mr2-ns w-100 w-auto-ns">ใช้งานได้ที่ไหนบ้าง?</a>
          <a href="" class="btn btn-primary br4 pa2 ph3-ns mb2 mr2-ns w-100 w-auto-ns">จัดส่งสินค้ายังไง?</a>
        </div>
      </div>
      @endif

    </div>

    <div class="col-md-4">

      @if(!empty($data['save']))
        <div class="price-saving-flag">-{{$data['save']}}</div>
      @endif

      <div class="price-section py-2">
        <span class="price">{{$data['price']}}</span>
        @if(!empty($data['original_price']))
        <span class="original-price">{{$data['original_price']}}</span>
        @endif
      </div>

      <div class="additional-data-section mt-2 mb-4">
        @if($data['date_type'] == 1)
          
          @if(!empty($data['date_1']))
          <div class="additional-item">
            <i class="fa fa-calendar"></i>&nbsp;ใช้ได้ตั้งแต่ {{$data['date_1']}} ถึง {{$data['date_2']}}
          </div>
          @else
          <div class="additional-item">
            <i class="fa fa-calendar"></i>&nbsp;ใช้ได้ถึงวันที่ {{$data['date_2']}}
          </div>
          @endif
          
        @elseif($data['date_type'] == 2)
          <div class="additional-item">
            <i class="fa fa-calendar"></i>&nbsp;วันที่แสดง {{$data['date_2']}}
          </div>
        @elseif($data['date_type'] == 3)
          <div class="additional-item">
            <i class="fa fa-calendar"></i>&nbsp;วันที่เดินทาง {{$data['date_2']}}
          </div>
        @endif

        @if(!empty($data['place_location']))
          <div class="additional-item">
            <i class="fa fa-map-marker"></i>&nbsp;สถานที่ {{$data['place_location']}}
          </div>
        @endif
      </div>

      @if(Auth::guest() || (Auth::check() && (Auth::user()->id != $data['created_by'])))

      <div class="seller-section content-fixed-bottom">
        <div class="pt3 pb2 pv2-ns ph3 ph2-ns clearfix">
          <div class="avatar-frame fl">       
            <div class="avatar">
              <img src="/avatar/{{$data['created_by']}}?d=1">
            </div>
          </div>
          <div class="online-name fl">
            <div>{{$seller['name']}}</div>
            <div class="online_status_indicator_{{$data['created_by']}} online-status-indicator @if($seller['online']) is-online @endif"></div>
            @if($seller['online'])
              <small class="dark-gray ml-4">ออนไลน์อยู่</small>
            @else
              <small class="dark-gray ml-4">{{$seller['last_active']}}</small>
            @endif
          </div>
        </div>
        <div class="pa2 pa2-ns">
          <a href="/chat/s/{{$ticketId}}" class="btn btn-primary btn-block br0">
            <i class="fa fa-comments" aria-hidden="true"></i> คุยกับผู้ขาย
          </a>
        </div>
      </div>

      <div class="contact-section pa2 pa0-ns mt-3 mt-2-ns bt">
        <div class="clearfix pa0 pa3-ns">
          <h5 class="mt-1 pb-2">
            <i class="fa fa-address-book" aria-hidden="true"></i>
            &nbsp;ช่องทางสำหรับติดต่อผู้ขาย
          </h5>
          {!!$data['contact']!!}
        </div>
      </div>

      @else

      <div class="action-section content-fixed-bottom ph2 pv3 pa0-ns mt-2">
        <a href="javascript:void(0);" data-t-id="{{$data['id']}}" data-t-title="{{$data['title']}}" class="btn btn-primary btn-block br0 ticket-close">
          <i class="fa fa-pencil" aria-hidden="true"></i> ปิดประกาศ
        </a>
        <small>ปิดประกาศของคุณเมื่อ <strong>ขายสินค้านี้แล้ว</strong> หรือหากต้องการ <strong>ยกเลิกรายการ</strong></small>
      </div>

      @endif
      
    </div>

  </div>
</div>

<div class="clearfix margin-top-200"></div>

@if(Auth::check() && (Auth::user()->id == $data['created_by']))
@include('shared.ticket-closing-modal')
@endif

<script type="text/javascript" src="/assets/js/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="/assets/js/user_online.js"></script>
<script type="text/javascript" src="/assets/lib/ig/photoswipe.min.js"></script>
<script type="text/javascript" src="/assets/lib/ig/photoswipe-ui-default.min.js"></script>

<script type="text/javascript">

  $(document).ready(function () {

    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements 
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for(var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes 
                if(figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };



                if(figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML; 
                }

                if(linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                } 

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if(!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if(childNodes[i].nodeType !== 1) { 
                    continue; 
                }

                if(childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if(index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe( index, clickedGallery );
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
            params = {};

            if(hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');  
                if(pair.length < 2) {
                    continue;
                }           
                params[pair[0]] = pair[1];
            }

            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect(); 

                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if(fromURL) {
                if(options.galleryPIDs) {
                    // parse real index when custom PIDs are used 
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if( isNaN(options.index) ) {
                return;
            }

            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll( gallerySelector );

        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };

    // execute above function
    initPhotoSwipeFromDOM('.i-gallery');

    setTimeout(function(){
      $('.i-gallery').masonry({
        itemSelector: '.grid-item',
        percentPosition: true
      });
    },150);

    const _userOnline = new UserOnline();
    _userOnline.init();
    _userOnline.check({{$data['created_by']}});

  });
</script>

@stop