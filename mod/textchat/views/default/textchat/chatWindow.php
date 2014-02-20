<?php

	gatekeeper();

	global $CONFIG;

	$mfid = get_input("mfid");
	$guid = get_loggedin_user()->guid;
	$name = get_loggedin_user()->name;
	$room = get_input("room");

	if($mfid != $guid){
		$friend = get_entity($mfid);
		if(!$friend->isFriend()){
			return false;
		}
	}

	$url = $CONFIG->url;
	$html ="";
	$html .= '<div id="textWinCont" >';
	$html .= '<div id="textchats">';	
	$html .= '</div>';
	$html .= '<div id="textonlineusers">';
	$html .= '<div class="onlineUserHead">';
	$html .= 'Online Users';
	$html .= '</div>';
	$html .= '<div class="onlineUserCont">';
	$html .= '</div>';
	$html .= '</div>';
	$html .= '<div class="clearfloat"></div>';
	$html .= '<div id="textinputcont">';
	$html .= '<textarea id="txtMess" rows="2">';
	$html .= '</textarea>';
	$html .= '<span id="sendChat">SEND</span>';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<script type="text/javascript">';
	$html .=<<<EOT

	var chatNode,
		room = "$room",
		textChatCont,
		onlineUserCont;

	$(document).ready(function(){

		chatNode = node.connect("textmessage");
		chatNode.emit("setGUID",{"guid":$guid,"room":"$room","name":"$name"});		
		chatNode.on("newMessage",onNewMessage);
		chatNode.on("onlineList",createOnlineList);
		chatNode.on("useronline",addUserToList);
		chatNode.on("useroffline",removeUserfromList);
		$("#sendChat").on("click",sendMessageToServer);
		$("#txtMess").on("keyup",sendMessageIfEnter);
		textChatCont= $("#textchats");
		onlineUserCont = $(".onlineUserCont");
	});
	
	function sendMessageIfEnter(event){

		if(event.keyCode == 13 && !event.ctrlKey){
			sendMessageToServer(event);
			return false;			
		}
	}

	function createOnlineList(data){		
		$(".onlineUserCont").html('');
		for(var i in data.id){
			addUserToList({id:data.id[i],name:data.name[i]});
		}
	}

	function addUserToList(data){
		
		var str = '<div class="onlineUser" data-id="'+data.id+'">';
		str +=data.name;
		str +='</div>';

		onlineUserCont.append(str);

		str  = '<div class="textinfo">';
		str += data.name+" joined the chat.";
		str += '<div';

		textChatCont.append(str);

	}

	function removeUserfromList(data){

		onlineUserCont.find("div[data-id='"+data.id+"']").remove();

		str  = '<div class="textinfo">';
		str += data.name+" left the chat.";
		str += '<div';

		textChatCont.append(str);

	}

	function sendMessageToServer(event){

		var mess = $.trim($("#txtMess").val());

		if(mess==""){
			return;
		}

		$("#txtMess").val('');
		$.ajax({

			url:"$url"+"/pg/textchat/send",
			type:"POST",
			data:{guid:$guid,room:"$room",message:mess},
			success:function(data){
				textChatCont.append(createMessage("Me",mess));
			},
			error:function(err){
				console.log("Error sending last message"+err);
			}


		});

	}

	function onNewMessage(data){

		textChatCont.append(createMessage(data.name,data.message));
	}

	function createMessage(name,message){

		var str  = '<div class="txtMsgCont">';	
		str += '<div class="txtMsgSend">';
		str += name
		str += '</div>';
		str += '<div class="txtMsg">';	
		str += ': '+message;
		str += '</div>';
		str += '</div>';		
		return str;


	}

EOT;
	$html .= '</script>';

	print $html;

?>
