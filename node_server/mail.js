var mailer = require("nodemailer");

console.log('hhhhhhhhhhhhhhhhhhhhhh....');
var smtp = {
  host: '127.0.0.1', //set to your host name or ip
  port: 587, //25, 465, 587 depend on your 
  secure: true, // use SSL
  auth: {
    user: 'admin@charityth.com', //user account
    pass: '1111' //user password
  }
};

console.log(smtp);

var smtpTransport = mailer.createTransport(smtp);

var mail = {
   // from: 'admin@charityth.com',
   to: 'k.m.ittipol@gmail.com',
   subject: 'Sending Email using Node.js',
   text: 'That was easy!'
}

smtpTransport.sendMail(mail, function(error, response){

  console.log('xxxxxxxxxxxxxxxxxxxxx....');
  console.log(error);

   // smtpTransport.close();
   // if(error){
   //    //error handler
   //    console.log('send error...');
   // }else{
   //    //success handler 
   //    console.log('send email success');
   // }
});