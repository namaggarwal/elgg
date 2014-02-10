<?php	
	//need to be logged in to see your feed
	gatekeeper();
	$guid = get_loggedin_user()->guid;

	/*$html .= '<div id="voice_calling">';
	$html .= '<div><span id="voice-name"></span><span> is calling you.</span></div>';
	$html .= '<div><span><a id="voice-link" href="#">Click Here</a></span><span>to answer</span>';
	$html .= '</div>';*/

	$html .= '<script type="text/javascript">';
    $html .= <<<EOT
    	
    	var chatSocket,
    		incomingid = 0,
    		incomingtimeout,
    		callStatus = 'DISCONNECTED';

    	$(document).ready(function(){

    		chatSocket = node.connect("chat");
			chatSocket.emit("setGUID",{"guid":$guid});
			chatSocket.on("incomingcall",onIncomingCall);			
			chatSocket.on("stopcall",onStopCall);			
    	});

		function onStopCall(data){
			if(incomingid==data.friendid){
				$("#voice_calling").remove();
				callStatus = "DISCONNECTED";
				incomingid = 0;	
			}

		}

		function onIncomingCall(data){
			//one call at a time
			if(callStatus!="DISCONNECTED"){
				rejectCall(data.guid);
				return;
			}

			var str = '';
			str  = '<div id="voice_calling">';
			str += '<div><span id="voice-name"></span><span> is calling you.</span></div>';
			str += '<div id="btnVoice"><span id="voice-accept">Accept</span><span id="voice-reject">Reject</span></div>';
			str += '</div>';

			var callDiv = $(str);
			incomingid = data.guid;
			callDiv.find("#voice-name").html(data.name);
			callDiv.find("#voice-accept").bind("click",function(){				
				chatSocket.emit("callaccepted",{"friendid":data.guid});
				window.location.replace(data.link);
				callStatus = "CONNECTED";
			});

			callDiv.find("#voice-reject").bind("click",function(){
				rejectCall(data.guid);
			});

			$("body").append(callDiv);

			setTimeout(rejectCall,10000);

			//do something here			
			callStatus = "CALLING";
		}

		function rejectCall(){

			chatSocket.emit("callrejected",{"friendid":incomingid});			
			$("#voice_calling").remove();
			callStatus = "DISCONNECTED";
			incomingid = 0;
		}
EOT;

	$html .= '</script>';

	print $html;
?>	
	<a href="<?php echo $vars['url']; ?>pg/voice/" class="voiceLink">Voice</a>	

