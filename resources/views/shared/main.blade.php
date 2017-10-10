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

    class Socket {

      constructor(socket){
        this.socket = socket;
      }

      online(id) {
        this.socket.emit('online', {
          userId: id
        })
      }

      socketEvents(){}

    }

    const socket = new Socket(io('http://localhost:9999'));

    @if(Auth::check())
      socket.online({{Auth::user()->id}})
    @endif

  </script>

</body>
</html>