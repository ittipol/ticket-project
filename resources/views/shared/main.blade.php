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

    class IO {

      constructor(socket){
        if(!IO.instance){

          this.socket = socket;
          this.token = Token.generateToken(8);

          IO.instance = this;
        }

        return IO.instance;
      }

      init(id) {
        this.join(id+'.'+this.token);
        this.online(id);
      }

      online(id) {
        this.socket.emit('online', {userId: id});
      }

      join(chanel) {
        this.socket.emit('join', chanel);
      }

      // socketEvents(){}

    }

    const _io = new IO(io('http://localhost:9999'));

    $(document).ready(function(){
      @if(Auth::check())
        _io.init({{Auth::user()->id}})
      @endif
    });

  </script>

</body>
</html>