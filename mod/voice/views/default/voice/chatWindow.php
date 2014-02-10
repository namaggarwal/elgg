<?php

	gatekeeper();

	$guid = get_loggedin_user()->guid;	
	$name = get_loggedin_user()->name;	
	$html="";	
	$room_name = get_input('room');
	$html .= '<script src="'.$CONFIG->url.'mod/voice/scripts/simplewebrtc.js" type="text/javascript"></script>';
	$html .= '<script type="text/javascript">';
	$html .= <<<EOT

	var webrtc = new SimpleWebRTC({
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

EOT;
					

	$html .= '</script>';
	
	$html .= '<div id="vidCont">';
	$html .= '<video height="300" id="localVideo"></video>';
    $html .= '<div id="remotesVideos"></div>';
    $html .= '</div>';    
    

print $html;

?>
