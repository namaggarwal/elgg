// We need an http server
var server = require('http').createServer(handler),
	io = require('socket.io').listen(server,{log:false});
//Count the number of visits to the page
var countVisit = 0;

//Create an http Server
function handler(req, res) {	
	console.log("request received");
	//Check if request is not for favicon
	if(req.url!="/favicon.ico"){
		//increment the counter
		countVisit++;
	}  
	//Start creating response
    res.writeHead(200, {'Content-Type': 'text/html'});
    //Get the page html
    var html = getPageHtml(); 
    //write html to response
    res.write(html);
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
  socket.guid =24;
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

	socket.on("notify",sendNotificationToAll);
}


function sendNotificationToAll(data){

	notifiers.broadcast.emit('newNotification',{link:data.link});

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
server.listen(1337, '0.0.0.0'); // Http server at port 1337 on localhost
//Log that server is running
console.log('Server running at http://127.0.0.1:1337/');
