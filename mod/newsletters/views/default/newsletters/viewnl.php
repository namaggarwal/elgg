<?php
	
$html = "";

if(is_array($vars['news']) && count($vars['news'])!=0){	
	foreach ($vars['news'] as $key => $det) {

	//foreach ($vars['news'] as $key => $det) {

		$html .= '<div class="shownl">';
		$html .= '<div class="title"><h2>'.$det->title.'</h2></div><br><br>';
		$html .= '<div class="subtitle">Body:<br>'.$det->description.'</div>';
		$html .= '<div class="subtitle"> News Type: &nbsp;&nbsp;'.$det->newstype.'</div>';
		$html .= '<div class="date"><em>Posted on:</em>&nbsp;&nbsp;'.$det->date.'</div>';		
		$html .= '<div class="content">Post ID :'.$det->postid.'</div>';
		$html .= '</div>';
	}
}

print $html;

?>