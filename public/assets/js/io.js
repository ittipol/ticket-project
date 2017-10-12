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
    // this.join(id+'.'+key);
    this.join(id+'.'+this.token);
  }

  join(chanel) {
    this.socket.emit('join', chanel);
  }

}