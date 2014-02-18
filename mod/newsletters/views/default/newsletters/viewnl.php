<?php
	
$html = "";

if(count($vars['news'])!=0){	

	//foreach ($vars['news'] as $key => $det) {

		$html .= '<div class="shownl">';
		$html .= '<div class="title"><h2>'.$vars['news']->title.'</h2></div><br><br>';
		$html .= '<div class="subtitle">Body:<br>'.$vars['news']->description.'</div>';
		$html .= '<div class="subtitle"> News Type: &nbsp;&nbsp;'.$vars['news']->newstype.'</div>';
		$html .= '<div class="date"><em>Posted on:</em>&nbsp;&nbsp;'.$vars['news']->date.'</div>';		
		$html .= '<div class="content">POSTID'.$vars['news']->postid.'</div>';
		$html .= '</div>';
	//}
}

print $html;

?>