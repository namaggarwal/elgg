<?php
	gatekeeper();

	$guid = hash('md5',get_loggedin_user()->guid);
	$name = get_loggedin_user()->name;	
	$room_name   = "elgg_".$guid.time();
	$link  = $CONFIG->url."pg/voice/join/".$room_name;	
	$html  =  '';
	$html .= '<div id="voice_input_cont">';
	$html .= '<div id="voice_message"></div>';	
	$html .= '<div id="voice_select_cont">';
	$html .= '<div class="font14">';
	$html .= 'Click a name to call';
	$html .= '</div>';
	$html .= '<div id="voice_myf">';
	foreach($vars['friends'] as $friend){ 
		//populate the send to box with a user's friends
		//$html .= '<div value="'.$friend->guid.'">' . $friend->name . '</div>';
		$html .= '<div class="voice_f_name" data-value="'.hash('md5',$friend->guid).'">'.$friend->name .'</div>';
		
	}
	$html .= '</div>';
	$html .= '</div>';	
	$html .= '<input type="submit" value="Stop" id="voice_stop" />';
	$html .= '</div>';
	$html .= '<script type="text/javascript">';
	$html .= <<<EOD
	//Maintaining locality

	var callingid= 0,
		callname = '',
		calltimeout;
	$(document).ready(function(){

		$(".voice_f_name").bind('click',makeacall);
		$("#voice_stop").bind('click',manstopcall);
		chatSocket.on("acceptcall",onCallAccepted);
		chatSocket.on("rejectcall",onCallRejected);
	});
	
	var manstopcall = function(event){

		if(callingid != 0){
			clearTimeout(calltimeout);
			callStatus = "DISCONNECTED";
			$("#voice_message").html("").removeClass("font24").removeClass("colorRed");
			chatSocket.emit("stopcall",{"guid":callingid,"friendid":"$guid"});
			$("#voice_stop").hide();
			$("#voice_select_cont").show();
			callingid = 0;
			callname = '';

		}
	}

	var stopcall = function(event){

		if(callingid != 0){
			clearTimeout(calltimeout);
			callStatus = "DISCONNECTED";
			$("#voice_message").html("We got no response from "+callname).removeClass("font24").addClass("colorRed");
			chatSocket.emit("stopcall",{"guid":callingid,"friendid":"$guid"});
			$("#voice_stop").hide();
			$("#voice_select_cont").show();
			callingid = 0;
			callname = '';

		}
	}

	var makeacall = function(event){
			
			if(callStatus != 'DISCONNECTED'){
				alert("You are already trying to call a  person");
				return false;
			}

			//Set Global Vars
			callStatus = 'CALLING';			
			callingid= $(this).attr("data-value");
			callname = $(this).html();
			$("#voice_stop").show();
			$("#voice_select_cont").hide();
			$("#voice_message").html("Calling "+callname+" ... ").addClass("font24").removeClass("colorRed");
			chatSocket.emit("outgoingcall",{"guid":callingid,"link":"$link"+"/"+callingid+"/"+"$guid","name":"$name","friendid":"$guid"});
			calltimeout=setTimeout(stopcall,20000);

	};

	var onCallAccepted = function(data){
		if(callStatus == "CALLING"){
			callStatus = "CONNECTED";
			$("#voice_stop").hide();
			$("#voice_message").html("Connecting with "+callname+" ... ");
			window.location.replace("$link"+"/$guid/"+callingid+"/call");
		}				    		

	};

	var onCallRejected = function(data){
		
		$("#voice_select_cont").show();
		$("#voice_stop").hide();
		$("#voice_message").html(callname+" seems busy to take up your call.").removeClass("font24").addClass("colorRed");
		clearTimeout(calltimeout);
		callingid= 0;
		callingname= '';
		callStatus = "DISCONNECTED";
	};



EOD;
	$html .= '</script>';
print $html;

?>