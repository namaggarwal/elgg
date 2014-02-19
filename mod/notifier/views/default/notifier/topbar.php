<?php	
	//need to be logged in to see your feed
	gatekeeper();	
	$guid = get_loggedin_user()->guid;
	$baseUrl = $CONFIG->url;
	$html  = '<script type="text/javascript">';
	$html .= <<<EOT

	var notifier  = (function(){

		var notify,
			myid,
			options = {};

		// Set delay -1 to let it remain
		options.delay = 6000;		
		options.onNewNotification = function(data){

			var str = '<div class="notification">';
			str += '<div class="closeNot">X</div>';
			str += '<div class="notMess">'+data.message+'</div>';
			str += '</div>';



			var not = $(str);
			if(data.link){
				var anc = '<a class="notLink" href="'+data.link+'"></a>';
				not.append(anc);
			}

			$("#notCont").append(not);
			not.fadeIn();

			if(data.delay){

				if(data.delay != -1){

					setTimeout(function(){
						not.fadeOut(function(){
							$(this).remove();
						});
					},data.delay);

				}
			}else{

				setTimeout(function(){
					not.fadeOut(function(){
						$(this).remove();
					});
				},options.delay);
			}

		};



		var init = function(node,guid){
			
			if(!node || !guid){
				throw "Cannot initialize the notifier";
				return;
			}
			myid = guid;
			notify = node.connect("notify");
			notify.emit("setGUID",{"guid":myid});
			notify.on("newNot",options.onNewNotification);
			$("#notCont").on("click",".closeNot",closeNotification);
		},

		closeNotification = function(event){			
			$(this).closest(".notification").remove();
		},

		notifyUser = function(recid,postData){
			
			if(!notify){
				throw "Cannot notify without initialising";
				return;
			}

			$.ajax({

				url:"$baseUrl"+"pg/notifier",
				type:"POST",
				data:{"myid":myid,"fid":recid,"message":postData.message,"link":postData.link,"delay":postData.delay,"callback":postData.callback,"otherData":postData.otherData},
				success:function(data){					
				},
				error:function(err){

				}

			});



		};

		return {
			init:init,
			notifyUser:notifyUser
		}

	})(node);
	
	$(document).ready(function(){
		notifier.init(node,$guid);
	/*	var pData = {
			message : "I am the best",
			link : "http://google.com"			
		};
	notifier.notifyUser("2",pData);*/

	});
	

EOT;
	$html .= '</script>';

	print $html;

?>	
