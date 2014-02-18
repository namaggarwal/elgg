<?php	


$html = "";
$html .= '<script type="text/javascript">';
$html .=<<<EOT
	var notifySocket;
	$(document).ready(function(){
		notifySocket = node.connect("notify");
		notifySocket.on("newNotification",onNewNotification);

	});

function onNewNotification(data){
		alert('Hello');
        //window.open(link, "popupWindow", "width=600, height=400, scrollbars=yes");
}

EOT;
$html .= '</script>';


print $html;
	
?>	

<a href="<?php echo $vars['url']; ?>pg/newsletters/" class="newsletterslink">Newsletter</a>


