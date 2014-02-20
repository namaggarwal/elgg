<?php
	
	gatekeeper();

	global $CONFIG;

	$guid = get_loggedin_user()->guid;
	$name = get_loggedin_user()->name;	
	$room_name   = "elgg_".$guid.time();
	$url = $CONFIG->url;

	$html = "";
	
	$html .= '<div id="inviteCont">';
	$html .= '<div class="inviteHead">';
	$html .= 'Select your friends and click on invite.';
	$html .= '</div>';
	$html .= '<div class="inviteFriendsCont">';
	foreach($vars['friends'] as $friend){ 
		//populate the send to box with a user's friends
		$html .= '<div class="text_name" data-value="'.$friend->guid.'">'.$friend->name .'</div>';		

		
	}
	$html .= '</div>';
	$html .= '<div class="inviteBtnCont">';
	$html .= '<input type="button" class="inviteBtn" value="Invite" />';
	$html .= '</div>';
	$html .= '</div>';

	$html .= '<script type="text/javascript">';

	$html .=<<<SCR

		$(document).ready(function(){

			attachEvents();

		});

		
		function attachEvents(){

			$(".text_name").on("click",selectName);
			$(".inviteBtn").on("click",sendInvite);
		}

		function selectName(event){
			var currObj  =$(this);
			if(currObj.hasClass("nameSelected")){
				currObj.removeClass("nameSelected");
			}else{
				currObj.addClass("nameSelected");
			}

		}

		function refreshPage(data){

			if(data!="SUCCESS"){
				$(".inviteHead").html("There was some error inviting your friends, you can try again ");
				$(".inviteFriendsCont").show();
				$(".inviteBtnCont").show();

			}else{

				window.location.replace("$url"+"pg/textchat/join/$room_name/$guid");
			}
				
		}

		function showError(data){

			$(".inviteHead").html("There was some error inviting your friends, you can try again ");
			$(".inviteFriendsCont").show();
			$(".inviteBtnCont").show();


		}

		function sendInvite(event){

			var slctdName = $(".text_name.nameSelected");

			if(slctdName.length == 0){
				alert("Please select atleast one friend to send the invite");
				return;
			}

			$(".inviteHead").html("Inviting your friends to chat... ");
			$(".inviteFriendsCont").hide();
			$(".inviteBtnCont").hide();

			var userId = [];

			slctdName.each(function(){

				userId.push($(this).attr("data-value"));
			});				


			var pData = {
				message : "$name invited for a group chat. Click here to join the chat.",
				link : "$CONFIG->url"+"pg/textchat/join/$room_name/$guid",
				notType: "textChat",
				otherData:{roomName:"$room_name"},
				success:refreshPage,
				error:showError
			};
			notifier.notifyUser(userId,pData);
		}




SCR;

	$html .= '</script>';

	print $html;

?>