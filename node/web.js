// We need an http server
var server = require('http').createServer(handler),
	io = require('socket.io').listen(server,{log:false}),
  os = require( 'os' )
  qs = require('querystring');
//Count the number of visits to the page
var countVisit = 0,
    localAddress = [];

//Create an http Server
function handler(req, res) {	
	console.log("request received");
	//Check if request is not for favicon
	if(req.url!="/favicon.ico"){
		//increment the counter
		countVisit++;
	}  
  switch(req.url){

      case "/": //Start creating response
                res.writeHead(200, {'Content-Type': 'text/html'});
                //Get the page html
                var html = getPageHtml(); 
                //write html to response
                res.write(html);
                break;
      case "/notifyforme": //Start creating response

              var reqAddress = req.connection.remoteAddress;
              if(localAddress.indexOf(reqAddress) == -1){

                res.writeHead(401, {'Content-Type': 'text/html'});                
                //write html to response
                res.write("You are not authorized for this request.");

              }else{

                 if (req.method == 'POST') {
                    var body = '';
                    req.on('data', function (data) {
                        body += data;
                    });
                    req.on('end', function () {

                        var post = qs.parse(body);
                        notifyPeople(post);
                        // use POST

                    });
                }
                
                res.writeHead(200, {'Content-Type': 'text/html'});                
                //write html to response
                res.write("notifying people");
              }
              
              break;

      default:
              res.writeHead(404, {'Content-Type': 'text/html'});
              res.write("The page you are looking for is not available");


  }
	
    //End the response (This sends response to client)
    res.end();
};

var chatConnections = [];

var chats = io.of('/chat').on('connection',onChatConnection);
var notifiers = io.of('/notify').on('connection',onNotifyConnection);

function onChatConnection(socket) {
  
  console.log("Connected");
  chatConnections[socket.id] = [];
  chatConnections[socket.id].status = "Connected";
  socket.on("sendMess",function(data){  	
  	socket.broadcast.emit('getMess',{'message':data.message});
  });

  socket.on("setGUID",function(data){
  	socket.guid = data.guid;
  	console.log("GUID Set");
  });

  socket.on("outgoingcall",function(data){
  	console.log("Incoming call received");
  	var personoffline = true;
  	 for(var i in chats["sockets"]){
  	 	if(chats["sockets"][i]["guid"] == data.guid){
  	 		console.log("Sending Response");
  	 		chats["sockets"][i].emit("incomingcall",{name:data.name,link:data.link,guid:data.friendid});
  	 		personoffline = false;
  	 		break;
  	 	}
  	 }

  	 if(personoffline){
  	 	//Do something here
  	 }

  });

  socket.on("callaccepted",function(data){
  	console.log("Call Accept received");
  	 for(var i in chats["sockets"]){
  	 	if(chats["sockets"][i]["guid"] == data.friendid){
  	 		console.log("Sending call accept response");
  	 		chats["sockets"][i].emit("acceptcall");
  	 		break;
  	 	}
  	 }

  });

  socket.on("callrejected",function(data){  	
  	 for(var i in chats["sockets"]){
  	 	if(chats["sockets"][i]["guid"] == data.friendid){
  	 		chats["sockets"][i].emit("rejectcall");
  	 	}
  	 }

  });

  socket.on("stopcall",function(data){    
     for(var i in chats["sockets"]){
      if(chats["sockets"][i]["guid"] == data.guid){
        chats["sockets"][i].emit("stopcall",{friendid:data.friendid});
      }
     }

  });

}


function onNotifyConnection(socket){

	socket.on("setGUID",function(data){
    socket.guid = data.guid;
    console.log("GUID Set for notification");
  });


}

function notifyPeople(data){
 for(var i in notifiers["sockets"]){
      if(notifiers["sockets"][i]["guid"] == data.fid){
        notifiers["sockets"][i].emit("newNot",data);
        console.log("Here");
      }
  }
}


//Function to get basic html page 
var getPageHtml = function(){ 
	var html="";
	html = "<html>";
	html += "<head>";
	html += "</head>";
	html += "<body>";
	html += "<div>";
	html += "You are visitor number "+countVisit;
	html += "</div>";
	html += "</body>";
	html += "</html>";

	return html;
};

// set the local addresses array
var networkInterfaces = os.networkInterfaces();
for(var i in networkInterfaces){
  for(var j in networkInterfaces[i]){
    localAddress.push(networkInterfaces[i][j].address);
  }
}

server.listen(1337, '0.0.0.0'); // Http server at port 1337 on localhost
//Log that server is running
console.log('Server running at http://127.0.0.1:1337/');
