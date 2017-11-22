var moment = require('moment-timezone');

// console.log(moment().tz("Asia/Bangkok").format('YYYY-MM-DD HH:mm:ss'));
// console.log(moment().tz("Asia/Bangkok").unix());

module.exports = class DateTime {

  constructor(){}

  static now(format = false,subtract = 0) {

    // let ts = null;
    // if(subtract > 0) {
    //   ts = new Date().getTime()-subtract;
    // }else{
    //   ts = new Date().getTime();
    // }

    // if(format) {
    //   let d = new Date(ts);
    //   return d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()+' '+d.getHours()+':'+d.getMinutes()+':'+d.getSeconds();
    // }

    // return parseInt(ts/1000);

    if(format) {
      return moment().tz("Asia/Bangkok").format('YYYY-MM-DD HH:mm:ss');
    }

    let ts = moment().tz("Asia/Bangkok").unix();
    if(subtract > 0) {
      ts -= subtract;
    }

    return ts;
  }

  static covertDateToSting(date) {
    date = date.split('-');
    return date[2]+' '+DateTime.getMonthName(parseInt(date[1]))+' '+(date[0]+543);
  }

  static covertTimeToSting(dateTime) {
    dateTime = dateTime.split(' ');

    let time = dateTime[1].split(':');

    return parseInt(time[0])+':'+time[1];
  }

  static covertDateTimeToSting(dateTime,includeSec = false) {
    dateTime = dateTime.split(' ');

    let date = dateTime[0].split('-');
    let time = dateTime[1].split(':');

    return date[2]+' '+DateTime.getMonthName(parseInt(date[1]))+' '+(parseInt(date[0])+543)+' '+parseInt(time[0])+':'+time[1];
  }

  static dateTimeToTimestamp(dateTime) {

    dateTime = dateTime.split(' ');

    let date = dateTime[0].split('-');
    let time = dateTime[1].split(':');

    return new Date(parseInt(date[0]), (parseInt(date[1])-1), parseInt(date[2]), parseInt(time[0]), parseInt(time[1]), parseInt(time[2]), 0).getTime()/1000;
  }

  static dateToTimestamp(date) {
    let _date = date.split('-');
    return new Date(parseInt(_date[0]), (parseInt(_date[1])-1), parseInt(_date[2])).getTime()/1000;
  }

  static passingDate(dateTime,now) {

    let secs = now - this.dateTimeToTimestamp(dateTime);
    let mins = parseInt(Math.floor(secs / 60));
    let hours = parseInt(Math.floor(mins / 60));
    let days = parseInt(Math.floor(hours / 24));

    let passing = 'เมื่อสักครู่นี้';
    if(days == 0) {
      
      let passingSecs = secs % 60;
      let passingMins = mins % 60;
      let passingHours = hours % 24;

      if(passingHours != 0) {
        passing = passingHours+' ชั่วโมงที่แล้ว';
      }else if(passingMins != 0) {
        passing = passingMins+' นาทีที่แล้ว';
      }else if(passingSecs > 30) {
        passing = passingSecs+' วินาทีที่แล้ว';
      }else if(passingSecs > 10) {
        passing = 'ไม่กี่วินาทีที่แล้ว';
      }
    }else if(days == 1){
      passing = 'เมื่อวานนี้ เวลา '+DateTime.covertTimeToSting(dateTime);
    }else{
      passing = DateTime.covertDateTimeToSting(dateTime);
    }

    return passing;
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

// module.exports.DateTime