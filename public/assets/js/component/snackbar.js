class Snackbar {
  
  constructor() {
    if(!Snackbar.instance){
      this.title = '';
      this.desc = '';
      this.type = 'info';
      this.layout = 'small';
      this.handle = null;
      this.delay = 5000;
      this.alwaysVisible = false;
      this.allowedClose = true;
      Snackbar.instance = this;
    }

    return Snackbar.instance;
  }

  load() {
    this.bind();
  }

  bind() {

    let _this = this;

    $('#snackbar_close').on('click', function(){
      $('#snackbar').stop().fadeOut(220)
    });

  }

  createNotification() {

    let html = '';
    // html += '<div id="snackbar" class="snackbar {{type}} {{layout}}">';
    // html += '<div class="notification-bottom-inner">';
    // html += '<div class="message">';
    // html += '<div class="title">{{title}}</div>';
    // html += '<p class="description">{{desc}}</p>';
    // html += '</div>';
    // html += '</div>';
    // if(this.allowedClose){
    //   html += '<div id="snackbar_close" class="close-btn">×</div>';
    // }
    // html += '</div>';

    html += '<div id="snackbar" class="snackbar">{{title}}</div>';

    html = html.replace('{{title}}',this.title);
    // html = html.replace('{{desc}}',this.desc);
    // html = html.replace('{{type}}',this.type);
    // html = html.replace('{{layout}}',this.layout);

    return html;

  }

  display() {

    $('#snackbar').remove(); 
    $('body').append(this.createNotification());

    setTimeout(function(){
      $('#snackbar').css({bottom:50,opacity:1});
    },200);

    if(!this.alwaysVisible) {
      clearTimeout(this.handle);

      // this.handle = setTimeout(function(){
      //   $('#snackbar').css({bottom:-140,opacity:0});
      // },this.delay);
    }
    
  }

  hideNotificationBox(obj) {

    if($(obj).is(':checked')) {
      $('#snackbar').stop().css({
        bottom: 0,
        opacity: 0
      });
    }else{
      $('#snackbar').stop().css({
        bottom: 50,
        opacity: 1
      });
    }

  }

  setTitle(title) {
    this.title = title;     
  }

  setDesc(desc) {
    this.desc = desc;     
  }

  setType(type) {
    this.type = type;     
  }

  setDelay(delay) {
    this.delay = delay;
  }

  setLayout(layout) {
    this.layout = layout;
  }

  setVisible(visible) {
    this.alwaysVisible = visible;
  }

}