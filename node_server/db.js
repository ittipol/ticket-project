const mysql = require('mysql');
const connection = mysql.createConnection({
    host     : '127.0.0.1',
    user     : 'root',
    password : '',
    database : 'ticket_db'
});

connection.connect(function(err) {
  if (err) throw err;
	console.log('DB connected');
});

module.exports = connection;