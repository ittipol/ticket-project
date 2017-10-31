var mailer = require("nodemailer");

// console.log('hhhhhhhhhhhhhhhhhhhhhh....');
var smtp = {
  host: '103.13.228.35', //set to your host name or ip
  port: 465, //25, 465, 587 depend on your 
  secure: true, // use SSL
  auth: {
    user: 'admin', //user account
    pass: 'as2w3e4r' //user password
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