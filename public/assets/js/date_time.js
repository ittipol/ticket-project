class DateTime {

  constructor(){}

  // init() {}

  static now(getTime = true) {
    // let today = new Date();
    // let date = today.getFullYear()+'-'+(today.getMonth()+1)+'-'+today.getDate();
    // let time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
    // let dateTime = date+' '+time;
  }

  static ts() {
    return new Date().getTime();
  }

  static covertDateToSting(date) {
    let date = date.split('-');
    return date[2]+' '+DateTime.getMonthName(parseInt(date[1]))+' '+(date[0]+543);
  }

  // static covertTimeToSting(time) {}

  static covertDateTimeToSting(dateTime,includeSec = false) {
    dateTime = dateTime.split(' ');

    let date = dateTime[0].split('-');
    let time = dateTime[1].split(':');

    return date[2]+' '+DateTime.getMonthName(parseInt(date[1]))+' '+(parseInt(date[0])+543)+' '+parseInt(time[0])+':'+time[1];
  }

  static getMonthName(month) {
    let monthName = [
      'มกราคม',
      'กุมภาพันธ์',
      'มีนาคม',
      'เมษายน',
      'พฤษภาคม',
      'มิถุนายน',
      'กรกฎาคม',
      'สิงหาคม',
      'กันยายน',
      'ตุลาคม',
      'พฤศจิกายน',
      'ธันวาคม',
    ];

    return monthName[month-1];
  }

}