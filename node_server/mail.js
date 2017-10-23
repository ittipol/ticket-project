var mailer = require("nodemailer");

console.log('sending....');
var smtp = {
  host: 'mail.charityth.com', //set to your host name or ip
  port: 587, //25, 465, 587 depend on your 
  secure: true, // use SSL
  auth: {
    user: 'admin@charityth.com', //user account
    pass: 'qqww1q2w' //user password
  }
};
var smtpTransport = mailer.createTransport(smtp);

var mail = {
   from: 'admin@charityth.com',
   to: 'k.m.ittipol@gmail.com',
   subject: 'Sending Email using Node.js',
   text: 'That was easy!'
}

smtpTransport.sendMail(mail, function(error, response){

  console.log(error);

   smtpTransport.close();
   if(error){
      //error handler
      console.log('send error...');
   }else{
      //success handler 
      console.log('send email success');
   }
});