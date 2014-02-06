<?php
	
$html = "";
if(is_array($vars['ann']) && count($vars['ann'])!=0){	
	foreach ($vars['ann'] as $key => $det) {

		$html .= '<div id="ann-show-cont">';
		$html .= '<div class="title"><h2>'.$det->title.'</h2></div>';
		$html .= '<div class="subtitle">'.$det->description.'</div>';
		$html .= '<div class="date">Posted on - '.date("D, d M Y \a\\t h:i:s a",$det->time_created).'</div>';		
		$html .= '<div class="content">'.get_metadata_byname($det->guid,"annContent")->value.'</div>';
		$html .= '</div>';

	}
}

print $html;

?>
