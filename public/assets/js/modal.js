class ModalDialog {
  
  constructor() {
    if(!ModalDialog.instance){
      this.obj = [];
      ModalDialog.instance = this;
    }

    return ModalDialog.instance;
  }

  init() {
    this.bind();
  }

  bind() {

    let _this = this;

    $('body').on('click','[data-toggle="modal"]',function(e){
      e.preventDefault();

      _this.show($(this).data('c-modal-target'));
    });

    $('body').on('click','.c-modal > .close',function(){
      _this.close();
    });

    $('body').on('click','.c-modal .modal-close',function(){
      _this.close();
    });

  }

  show(target) {
    this.obj.push(target);

    if(this.obj.length === 1) {
      $('body').addClass('overflow-y-hidden');
    }
    $(target).addClass('show');
  }

  close() {

    if(this.obj.length > 0) {
      let elem = this.obj.pop();

      if(this.obj.length === 0) {
        $('body').removeClass('overflow-y-hidden');
      }
      
      $(elem).removeClass('show');
    }
    
  }

  closeAll() {
    this.obj = [];

    $('.c-modal').removeClass('show');
    $('body').removeClass('overflow-y-hidden');
  }

  create(title,message,type = 'popup') {

    let id = 'modal_'+Token.generateToken(7);

    let style = '';
    switch(type) {
      case 'full':
        style = 'w-100 h-100';
      break;

      case 'paper':
        style = 'w-100 w-70-ns h-100';
      break;

    }

    let html = `
    <div id="${id}" class="c-modal">
      <a class="close"></a>
      <div class="c-modal-inner ${style}">

        <a class="modal-close">
          <span aria-hidden="true">&times;</span>
        </a>

        <h4 class="item-title f4 f3-ns mb-3 mb4-ns">${title}</h4>

        ${message}

      </div>
    </div>
    `;

    $('body').append(html);

    return '#'+id;

  }

}