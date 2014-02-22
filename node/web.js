// We need an http server
var server = require('http').createServer(handler),
	io = require('socket.io').listen(server,{log:false}),
  os = require( 'os' )
  qs = require('querystring');
//Count the number of visits to the page
var countVisit = 0,
    localAddress = [],
    chatRooms = [];

//Create an http Server
function handler(req, res) {	
	
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
                res.write("SUCCESS");
              }
              
              break;

       case "/sendChat": //Start creating response

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
                        sendChat(post);
                        // use POST

                    });
                }
                
                res.writeHead(200, {'Content-Type': 'text/html'});                
                //write html to response
                res.write("sending chat to people");
              }
              
              break;

      default:
              res.writeHead(404, {'Content-Type': 'text/html'});
              res.write("The page you are looking for is not available");


  }
	
    //End the response (This sends response to client)
    res.end();
};



var chats = io.of('/chat').on('connection',onChatConnection);
var notifiers = io.of('/notify').on('connection',onNotifyConnection);
var chatNotify = io.of('/textmessage').on('connection',onTextConnection);

function onChatConnection(socket) {
  
  
  
  
  socket.on("sendMess",function(data){  	
  	socket.broadcast.emit('getMess',{'message':data.message});
  });

  socket.on("setGUID",function(data){
  	socket.guid = data.guid;
  	console.log("GUID Set");
  });

  socket.on("outgoingcall",function(data){
  
  	var personoffline = true;
  	 for(var i in chats["sockets"]){
  	 	if(chats["sockets"][i]["guid"] == data.guid){
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




function sendChat(data){

  // if such a room exists
  if(chatRooms[data.room] instanceof Object){
     if(chatRooms[data.room]["validID"].indexOf(""+data.myid)!=-1){
      var conn = chatRooms[data.room]["connectedID"];

        for(var i in conn){

          if(conn[i].id != data.myid){
            

            conn[i].socket.emit("newMessage",data);

          }

        }
     }
  }
}


function onTextConnection(socket){
  
    socket.on("setGUID",function(data){
      
      if(chatRooms[data.room] instanceof Object){        
        if(chatRooms[data.room]["validID"].indexOf(""+data.guid)!=-1){
          this.guid = data.guid;
          this.name = data.name;
          if(this.room instanceof Array){

            this.room.push(data.room);

          }else{
            this.room = [];
            this.room.push(data.room);
          }
          var myDet = [];          
          myDet.id = data.guid;
          myDet.name = data.name;
          myDet.socket = this;
          chatRooms[data.room]["connectedID"].push(myDet);
          var userid = [];
          var username = [];
          for(var i in chatRooms[data.room]["connectedID"]){
            userid.push(chatRooms[data.room]["connectedID"][i].id);
            username.push(chatRooms[data.room]["connectedID"][i].name);
          }
          this.emit("onlineList",{id:userid,name:username});
          newOnlineUser(data);
          //socket.emit("useronline",{id:data.guid,name:data.myname});
          

          this.on("disconnect",onTextDisConnection);
        }else{
          this.disconnect();
        }
      }else{
        this.disconnect();  
      }



    
    });



}


function newOnlineUser(data){


// if such a room exists
  if(chatRooms[data.room] instanceof Object){
     if(chatRooms[data.room]["validID"].indexOf(""+data.guid)!=-1){
      var conn = chatRooms[data.room]["connectedID"];

        for(var i in conn){

          if(conn[i].id != data.guid){
            conn[i].socket.emit("useronline",{id:data.guid,name:data.name});

          }

        }
     }
  }
}

function onTextDisConnection(data){  
  for(var i in this.room){
    var room = this.room[i];
    if(chatRooms[room] instanceof Object){        
        var chatroomconn = chatRooms[room]["connectedID"];
        if(chatroomconn.length == 1){
          delete chatRooms[room];  
        }else{
          for(var j in chatroomconn){            
            if(chatroomconn[j].id == this.guid){

              chatRooms[room]["connectedID"] = removeElementFromArr(chatRooms[room]["connectedID"],j);
              
            }else{
              chatroomconn[j].socket.emit("useroffline",{id:this.guid,name:this.name});  
            }
            
          }
        }
    }

  }

  

}


function removeElementFromArr(arr,pos){
  var newArr = [];
  var len = arr.length;
  for(var i=0;i<len;i++){
    if(i!=pos){
      newArr.push(arr[i])  
    }
    
  }

  return newArr;
}

/*function userOffline(){

// if such a room exists
  if(chatRooms[data.room] instanceof Object){
     if(chatRooms[data.room]["validID"].indexOf(""+data.myid)!=-1){
      var conn = chatRooms[data.room]["connectedID"];

        for(var i in conn){

          if(conn[i].id != data.myid){
            console.log(data);
            conn[i].socket.emit("useronline",{id:data.guid,name:data.myname});

          }

        }
     }
  }
}
*/

function notifyPeople(data){
 try{     
     data.fid = data.fid.split(",");     
     for(var i in notifiers["sockets"]){          
          if(data.fid.indexOf(""+notifiers["sockets"][i]["guid"]) != -1){
              notifiers["sockets"][i].emit("newNot",data);              
          }
      }
      
      if(data.notType == "textChat"){

        addRoomToChat(data);        
      }

 }catch(err) {

    console.log(err);
 }
 
}


function addRoomToChat(data){

  var otherData = JSON.parse(data.otherData);
  var roomName = otherData.roomName;
  if(!(roomName in chatRooms)){

    chatRooms[roomName] = [];
    chatRooms[roomName]["validID"] = data.fid;
    chatRooms[roomName]["validID"].push(data.myid);
    chatRooms[roomName]["connectedID"] = [];

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
