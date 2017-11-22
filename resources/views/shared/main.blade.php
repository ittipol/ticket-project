<!doctype html>
<html>
<head>
  @if(env('APP_ENV') == 'production')
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109089944-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-109089944-1');
  </script>
  <!-- Facebook Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '100993027009703');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=100993027009703&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Facebook Pixel Code -->
  @endif
  <!-- Meta data -->
  @include('script.meta') 
  <!-- CSS & JS -->
  @include('script.script')
</head>
<body>

  <script>
    window.fbAsyncInit = function() {
      FB.init({
        appId      : '{{env("FB_APP_ID")}}',
        xfbml      : true,
        version    : '{{env("GRAPH_VERSION")}}'
      });
      FB.AppEvents.logPageView();
    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "//connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));
  </script>

  @include('shared.header')

  @yield('content')

  <script type="text/javascript">

    // var _socket = io('{{env('SOCKET_URL')}}');
    // _socket.on('connect', function(){
    //   console.log('_connect');
    // });
    // _socket.on('event', function(data){
    //   console.log('_event');
    // });
    // _socket.on('disconnect', function(){
    //   console.log('_disconnect');
    // });

    const _io = new IO(io('{{env('SOCKET_URL')}}'));

    $(document).ready(function(){
      @if(Auth::check())
        _io.init({{Auth::user()->id}},'{{Auth::user()->user_key}}')

        const _user = new User({{Auth::user()->id}});
        _user.init();

      @endif
    });

  </script>

  @if(Session::has('message.title'))
  <script type="text/javascript">
      const snackbar = new Snackbar();
      snackbar.setTitle('{!!Session::get("message.title")!!}');
      // snackbar.setType('');
      snackbar.display();
  </script>
  @endif

  <script type="text/javascript">
    new gnMenu(document.getElementById('gn-menu'));
  </script>

</body>
</html>