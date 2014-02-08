<?php	
	//need to be logged in to see your feed
	gatekeeper();
	$host = $_SERVER['HTTP_HOST'];

	$html .= '<script type="text/javascript">';
	$html .= <<<EOT

		var node = (function(io){			
			var connect = function(namespace){				
				if(namespace == ''){

					return "Cannot connect to the socket IO";
				}
				var link = "http://$host:1337/"+namespace;
				var socket = io.connect(link);

				return socket;
			}

			return{
				connect:connect
			};

		})(io);	

EOT;
	$html .= '</script>';

	print $html;

?>	
