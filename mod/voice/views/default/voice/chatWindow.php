<?php

	gatekeeper();

	//$guid = hash("md5",get_loggedin_user()->guid);
	$guid = get_loggedin_user()->guid;

	$name = get_loggedin_user()->name;
	$html ="";	
	$room_name = get_input('room');
	//$html .= '<script src="'.$CONFIG->url.'mod/voice/scripts/simplewebrtc.js" type="text/javascript"></script>';
	$html .= '<script type="text/javascript" src="'.$CONFIG->url.'/mod/voice/scripts/peer.min.js"></script>';
	$html .= '<script type="text/javascript">';
	$html .=<<<STR
	navigator.getMedia = ( navigator.getUserMedia ||
                       	navigator.webkitGetUserMedia ||
                       	navigator.mozGetUserMedia ||
                       	navigator.msGetUserMedia);
var peer = new Peer("$guid",{host:window.location.host,port:8888});
STR;
	//$html .= <<<EOT

	/*var webrtc = new SimpleWebRTC({
	// the id/element dom element that will hold "our" video
	localVideoEl: 'localVideo',
	// the id/element dom element that will hold remote videos
	remoteVideosEl: 'remotesVideos',
	// immediately ask for camera access
	autoRequestMedia: true
	});		
	// we have to wait until it's ready
	webrtc.on('readyToCall', function () {
	  // you can name it anything
	  webrtc.joinRoom('$room_name');
	});
*/

	

//EOT;
	
	switch(get_input('actype')){

		case "call":
					$perId = get_input("perid");
					$html .=<<<EOT

					$(document).ready(function(){

						
						
						navigator.getMedia (

						   // constraints
						   {
						      video: true,
						      audio: true
						   },

						   // successCallback
						   function(localMediaStream) {
						   mediaStream = localMediaStream;					   	
						      setTimeout(makeCall,4000);
						      var video = document.getElementById("localVideo");
      						  video.src = window.URL.createObjectURL(localMediaStream);

						   },

						   // errorCallback
						   function(err) {
						   	console.log(err);
						    alert("The following error occured: " + err);
						   }

						);

						function makeCall(){
								console.log("Call Made");
						      	var call = peer.call("$perId", mediaStream);
						      	call.on('stream',function(stream){
					      			var video = document.getElementById("remoteVideo");
      								video.src = window.URL.createObjectURL(stream); 
						      	});
						}
		
					});

			
EOT;
break;
			case 'answer':
				$html .=<<<STR1

				$(document).ready(function(){
											
						navigator.getMedia (

						   // constraints
						   {
						      video: true,
						      audio: true
						   },

						   // successCallback
						   function(localMediaStream) {						   	
						   	mediaStream = localMediaStream;
						      setOnCall();
						      var video = document.getElementById("localVideo");
      						  video.src = window.URL.createObjectURL(localMediaStream);

						   },

						   // errorCallback
						   function(err) {
						   	console.log(err);
						    alert("The following error occured: " + err);
						   }

						);

						function setOnCall(){
						    peer.on('call', function(call) {
			  				// Answer the call, providing our mediaStream
								
			      				console.log("Call Answered");
								  // Answer the call, providing our mediaStream
								  call.answer(mediaStream);
								  call.on('stream', function(stream) {
									var video = document.getElementById("remoteVideo");
			      					video.src = window.URL.createObjectURL(stream); 				 //call.answer(mediaStream);
								  // `stream` is the MediaStream of the remote peer.
								  // Here you'd add it to an HTML video/canvas element.
								});
								

								

							});
						}
		
					});

STR1;

	}
	
					

	$html .= '</script>';
	
	$html .= '<div id="vidCont">';
	$html .= '<video height="300" id="localVideo" autoplay></video>';
    $html .= '<video id="remoteVideo" autoplay></video>';
    $html .= '</div>';    
    

print $html;

?>
