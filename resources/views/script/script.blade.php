<?php
  $combine = false;
?>

<?php

  $jsFiles = array(
    'assets/js/jquery-3.2.1.min.js',
    'assets/js/jquery-ui.min.js',
    'assets/js/jquery.validate.min.js',
    'assets/js/bootstrap.min.js',
    'assets/js/dz/dropzone.min.js',
    'assets/js/token.js',
    'assets/js/common.js'
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
    'assets/css/bootstrap-reboot.css',
    'assets/css/bootstrap-grid.css',
    'assets/css/bootstrap.css',
    // 'assets/css/bootstrap-material-design.css',
    'assets/css/font-awesome.min.css',
    // 'assets/css/jquery-ui.min.css',
    'assets/css/ui/calendar.css',
    'assets/css/dz/dropzone.css',
    'assets/css/bootstrap.css',
    'assets/css/func.css',
    'assets/css/spacing.css',
    'assets/css/core.css',
    'assets/css/page/landing.css',
    'assets/css/page/login.css',
    'assets/css/page/register.css',
    'assets/css/form/tagging.css',
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
