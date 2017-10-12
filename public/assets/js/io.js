class IO {

  constructor(socket){
    if(!IO.instance){

      this.socket = socket;
      this.token = Token.generateToken(8);

      IO.instance = this;
    }

    return IO.instance;
  }

  init(id,key) {
    this.join(id+'.'+this.token);
    this.join(id+'.'+key);
    this.online(id);
  }

  online(id) {
    this.socket.emit('online', {userId: id});
  }

  // disconnected() {
  //   this.socket.on('disconnected', function(){});
  // }

  join(chanel) {
    this.socket.emit('join', chanel);
  }

  // socketEvents(){}

}