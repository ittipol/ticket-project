<!doctype html>
<html>
<head>
  <!-- Meta data -->
  @include('script.meta') 
  <!-- ################# -->
  @include('shared.tracking')
  <!-- CSS & JS -->
  @include('script.script')

  @include('shared.adsense')

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

  @if(Session::has('popup-feature'))
    @include('shared.feature')
  @endif

  @if(Session::has('message.title'))
  <script type="text/javascript">
      const snackbar = new Snackbar();
      snackbar.setTitle('{!!Session::get("message.title")!!}');
      // snackbar.setType('');
      snackbar.display();
  </script>
  @endif

  <script type="text/javascript">

    const _modal = new ModalDialog();
    _modal.init();

    new gnMenu(document.getElementById('gn-menu'));
  </script>

</body>
</html>