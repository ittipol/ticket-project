<?php
  $combine = false;
?>

<?php

  $jsFiles = array(
    'assets/js/socket.io.js',
    'assets/js/jquery-3.2.1.min.js',
    'assets/js/bootstrap.min.js',
    'assets/js/modernizr.custom.js',
    'assets/lib/moment/moment.js',
    // 'assets/lib/moment/moment-timezone.js',

    'assets/lib/header/js/classie.js',
    'assets/lib/header/js/gnmenu.js',

    'assets/js/token.js',
    'assets/js/io.js',
    'assets/js/user.js',
    'assets/js/date_time.js',
    'assets/js/common.js',
    'assets/js/component/snackbar.js',
  );

  if($combine){
    $code = '';
    foreach ($jsFiles as $js) {
      $code .= file_get_contents($js);
    }

    $_js = JSMin::minify($code);

    if(!file_exists(public_path().'/js/8fcf1793a14f7d35.js') || (strlen($_js) != filesize(public_path().'/js/8fcf1793a14f7d35.js'))){
      file_put_contents('js/8fcf1793a14f7d35.js', $_js);
    }
  }
  
?>

@if($combine)
<script type="text/javascript" src="{{ URL::asset('js/8fcf1793a14f7d35.js') }}"></script>
@endif

@if(!$combine)
@foreach ($jsFiles as $js)
  <script type="text/javascript" src="/{{$js}}"></script>
@endforeach
@endif


<?php

  $cssFiles = array(
    // 'assets/css/bootstrap-reboot.min.css',
    'assets/css/bootstrap-grid.min.css',
    'assets/css/bootstrap.min.css',
    'assets/css/font-awesome.min.css',
    'assets/css/bootstrap-slider.min.css',
    'assets/css/func.css',
    'assets/css/spacing.css',

    'assets/lib/header/css/normalize.css',
    'assets/lib/header/css/component.css',

    'assets/lib/ig/photoswipe.css',
    'assets/lib/ig/default-skin/default-skin.css',

    // 'assets/lib/notification/css/ns-default.css',
    // 'assets/lib/notification/css/ns-style-attached.css',
    // 'assets/lib/notification/css/ns-style-bar.css',
    // 'assets/lib/notification/css/ns-style-growl.css',
    // 'assets/lib/notification/css/ns-style-other.css',

    'assets/css/ui/pagination.css',
    'assets/css/ui/calendar.css',
    'assets/css/ui/navbar.css',
    'assets/css/ui/md-chip.css',
    'assets/css/ui/snackbar.css',
    'assets/css/ui/chat.css',
    'assets/css/ui/dropdown-menu.css',
    'assets/css/ui/card.css',
    'assets/css/page/landing.css',
    'assets/css/page/login.css',
    'assets/css/page/register.css',
    'assets/css/page/account.css',
    'assets/css/page/ticket.css',
    'assets/css/form/tagging.css',
    'assets/css/core.css',
  );

  if($combine){
    $code = '';
    foreach ($cssFiles as $css) {
      $code .= file_get_contents($css);
    }

    $_css = CSSMin::minify($code);

    if(!file_exists(public_path().'/css/a590bf3e950e330b.css') || (strlen($_css) != filesize(public_path().'/css/a590bf3e950e330b.css'))){
      file_put_contents('css/a590bf3e950e330b.css', $_css);
    }
  }

?>

@if($combine)
<link rel="stylesheet" href="{{ URL::asset('css/a590bf3e950e330b.css') }}" />
@endif

@if(!$combine)
@foreach ($cssFiles as $css)
  <link rel="stylesheet" href="/{{$css}}" />
@endforeach
@endif
