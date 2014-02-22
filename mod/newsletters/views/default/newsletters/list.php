<link href="realtime-notifications/src/lib/gritter/css/jquery.gritter.css"rel="stylesheet" type="text/css" />
<?php
	
	gatekeeper();

	$html = "";
	$html .= '<div id="newslettercontent">';

	if(isadminloggedin()){
		$html .= '<a class="createnlbutton" href="'.$CONFIG->url.'pg/newsletters/create">Create a Newsletter</a>';	
	}
	// print('<pre>');
	// print_r($vars['news']);
	// print('</pre>');

	if (is_array($vars['news']) && count($vars['news'])!=0) {
		foreach ($vars['news'] as $guid => $det) {
			$html .= '<div class="listentry">';
			$html .= '<h3>NL'.$det["GUID"].':&nbsp;&nbsp;'.$det["TITLE"].'</h3>';
			$html .= '<p><b>Posted on:&nbsp;&nbsp;</b>'.date("D, d M Y h:i:s a",$det["DATE"]);
			$html .= '<br><b>Newsletter type:&nbsp;&nbsp;</b>' .$det["NEWSTYPE"];
			$html .= '<br><b>Content:&nbsp;&nbsp;</b><br>'.$det["DESC"].'</p>';
			$html .= '<a href="'.$det["LINK"].'">Link</a>';
			$html .= '</div>';
		}
	 }

	 else{
	 	$html .= '<div class="no-news">No Newsletters yet!</div>';
	 }

	$html .= '</div>';
	print $html;
?>

<script type="text/javascript" src="<?php echo $CONFIG->wwwroot; ?>/mod/newsletters/js/list.js"></script>
