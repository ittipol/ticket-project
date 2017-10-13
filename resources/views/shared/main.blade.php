<!doctype html>
<html>
<head>
  <!-- Meta data -->
  @include('script.meta') 
  <!-- CSS & JS -->
  <!-- @include('script.analyticstracking') -->
  @include('script.script')
</head>
<body>

  <div id="fb-root"></div>
  <script>(function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.9&appId=227375124451364";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));</script>

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
      snackbar.setTitle('{{ Session::get("message.title") }}');
      // snackbar.setType('');
      snackbar.display();
  </script>
  @endif

  <script type="text/javascript">
    new gnMenu(document.getElementById('gn-menu'));
  </script>

</body>
</html>